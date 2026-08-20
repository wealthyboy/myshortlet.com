<?php

namespace App\Services\Channex;

use App\Models\UserReservation;
use App\Models\Reservation;
use App\Models\Apartment;
use App\Models\GuestUser;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtaReservationNotification;

class HandleOtaBookingService
{
    /**
     * Treat the webhook as a property-level trigger. Pull the ordered feed one
     * time, persist every returned revision, and acknowledge each only after
     * its local database transaction commits.
     */
    public function processFeed(array $triggerPayload): int
    {
        $triggerPayload = $this->normalizePayloadShape($triggerPayload);
        $propertyId = data_get($triggerPayload, 'property_id')
            ?? data_get($triggerPayload, 'property.id');

        if (! $propertyId) {
            throw new \RuntimeException('Missing Channex property ID for booking feed pull.');
        }

        $feedResponse = app(BookingRevisionService::class)->fetchFeed((string) $propertyId);
        if (! is_array($feedResponse)) {
            throw new \RuntimeException("Could not pull the Channex booking feed for property {$propertyId}.");
        }

        $rows = (array) data_get($feedResponse, 'data', []);
        $processed = 0;

        foreach ($rows as $row) {
            $payload = $this->payloadFromFeedRow((array) $row, (string) $propertyId);
            $this->processFeedRevision($payload);

            $processed++;
        }

        logger()->info('Channex booking feed processed', [
            'property_id' => $propertyId,
            'revision_count' => $processed,
        ]);

        return $processed;
    }

    protected function processFeedRevision(array $payload): void
    {
        if ($this->isCancellationPayload($payload)) {
            $this->cancel($payload);
            return;
        }

        $this->handle($payload);
    }

    /**
     * Handle NEW or MODIFIED OTA booking
     */
    public function handle(array $payload): void
    {
        $payload = $this->normalizePayloadShape($payload);

        if ($this->isCancellationPayload($payload)) {
            $this->cancel($payload);
            return;
        }

        $result = DB::transaction(function () use ($payload) {
            $externalId = $this->resolveExternalBookingId($payload);
            if (! $externalId) {
                app(CertificationLogService::class)->log(
                    'booking_webhook',
                    'failed',
                    'test_11_booking_ack',
                    null,
                    null,
                    [],
                    $this->certificationPayload($payload),
                    null,
                    'Missing external booking ID for upsert'
                );

                throw new \RuntimeException('Missing external booking ID for upsert.');
            }

            $channexPropertyId = data_get($payload, 'property_id')
                ?? data_get($payload, 'property.id');
            $property = Property::where('channex_property_id', $channexPropertyId)->first();

            if (! $property) {
                throw new \RuntimeException("No local property mapping for Channex property {$channexPropertyId}.");
            }

            $guestDetails = $this->guestDetails($payload, $externalId);
            $guest = GuestUser::firstOrCreate(
                ['email' => $guestDetails['email']],
                [
                    'name' => $guestDetails['name'],
                    'last_name' => $guestDetails['last_name'],
                    'phone_number' => $guestDetails['phone_number'],
                ]
            );

            $userReservation = UserReservation::firstOrNew([
                'property_id' => $property->id,
                'external_id' => $externalId,
            ]);

            if ($this->isAlreadyProcessed($userReservation, $payload)) {
                logger()->info('Channex booking revision already processed; duplicate delivery ignored', [
                    'revision_id' => $this->resolveRevisionId($payload),
                    'external_id' => $externalId,
                ]);

                return [
                    'property_id' => (int) $property->id,
                    'send_email' => false,
                    'guest' => null,
                    'reservation' => null,
                    'external_id' => $externalId,
                ];
            }

            $userReservation->guest_user_id = $guest->id;
            $userReservation->property_id = $property->id;
            $userReservation->currency = data_get($payload, 'currency');
            $userReservation->total = data_get($payload, 'amount', data_get($payload, 'total_price', 0));
            $userReservation->payment_type = 'ota';
            $userReservation->coming_from = 'ota';
            $userReservation->ota_name = data_get($payload, 'ota_name', 'unknown');
            $userReservation->external_id = $externalId;
            $this->markReservationActive($userReservation, $payload);
            $userReservation->channex_last_revision_id = $this->resolveRevisionId($payload);
            $userReservation->channex_last_revision_at = data_get($payload, 'inserted_at');
            $userReservation->save();

            // For booking.modified, replace previous room lines with latest revision snapshot.
            $this->deleteExistingReservationLines($userReservation);

            /**
             * 4️⃣ Create Reservation Items (Apartments)
             */
            $rooms = (array) data_get($payload, 'rooms', []);
            if (empty($rooms)) {
                throw new \RuntimeException('Cannot acknowledge Channex booking because it contains no rooms.');
            }

            foreach ($rooms as $room) {

                $apartment = Apartment::query()
                    ->where('property_id', $property->id)
                    ->where('channex_room_type_id', data_get($room, 'room_type_id'))
                    ->first();

                if (!$apartment) {
                    throw new \RuntimeException(
                        'Cannot acknowledge Channex booking because room type '
                        . (string) data_get($room, 'room_type_id', '(missing)')
                        . ' is not mapped locally.'
                    );
                }

                Reservation::create([
                    'user_reservation_id' => $userReservation->id,
                    'apartment_id' => $apartment->id,
                    'quantity' => 1,
                    'price' => array_sum((array) data_get($room, 'days', [])),
                    'rate' => 1,
                    'property_id' => $apartment->property_id,
                    'checkin' => data_get($room, 'checkin_date', data_get($payload, 'arrival_date')),
                    'checkout' => data_get($room, 'checkout_date', data_get($payload, 'departure_date')),
                    'length_of_stay' => Carbon::parse(
                        data_get($room, 'checkin_date', data_get($payload, 'arrival_date'))
                    )->diffInDays(
                        data_get($room, 'checkout_date', data_get($payload, 'departure_date'))
                    ),
                ]);
            }

            return [
                'property_id' => (int) $userReservation->property_id,
                'send_email' => $userReservation->wasRecentlyCreated && $guestDetails['can_email'],
                'guest' => $guest,
                'reservation' => $userReservation,
                'external_id' => $externalId,
            ];
        });

        // The booking is now committed locally. Only now is it safe to remove
        // this revision from Channex's feed.
        $this->acknowledgeRevision($payload, $result['property_id']);

        if ($result['send_email']) {
            try {
                Mail::to($result['guest']->email)->send(
                    new OtaReservationNotification($result['reservation'])
                );
            } catch (\Throwable $e) {
                logger()->warning('OTA confirmation email could not be sent', [
                    'reservation_id' => $result['reservation']->id,
                    'external_id' => $result['external_id'],
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Delete room lines as models so ReservationObserver::deleted can restore
     * Channex availability for dates removed by a booking modification.
     */
    protected function deleteExistingReservationLines(UserReservation $userReservation): void
    {
        Reservation::query()
            ->where('user_reservation_id', $userReservation->id)
            ->get()
            ->each
            ->delete();
    }

    protected function markReservationActive(UserReservation $userReservation, array $payload): void
    {
        $userReservation->status = data_get($payload, 'status', 'confirmed');
        $userReservation->is_cancelled = false;
    }

    /**
     * Handle OTA cancellation
     */
    public function cancel(array $payload): void
    {
        $payload = $this->normalizePayloadShape($payload);

        $externalId = $this->resolveExternalBookingId($payload);
        if (! $externalId) {
            throw new \RuntimeException('Missing external booking ID for cancellation.');
        }

        $channexPropertyId = data_get($payload, 'property_id')
            ?? data_get($payload, 'property.id');
        $property = Property::where('channex_property_id', $channexPropertyId)->first();
        if (! $property) {
            throw new \RuntimeException("No local property mapping for Channex property {$channexPropertyId}.");
        }

        $propertyId = DB::transaction(function () use ($payload, $externalId, $property) {
            $reservation = UserReservation::query()
                ->where('property_id', $property->id)
                ->where('external_id', $externalId)
                ->first();

            if (!$reservation) {
                // A cancellation is idempotent: if the local booking is
                // already absent, the desired local state has been reached.
                // Persist that fact before ACK so this revision cannot poison
                // the feed and block later bookings indefinitely.
                $this->recordAbsentCancellation($payload, $externalId, $property);

                return (int) $property->id;
            }

            if ($this->isAlreadyProcessed($reservation, $payload)) {
                logger()->info('Channex cancellation revision already processed; duplicate delivery ignored', [
                    'revision_id' => $this->resolveRevisionId($payload),
                    'external_id' => $externalId,
                ]);

                return (int) $property->id;
            }

            $reservation->status = 'cancelled';
            $reservation->is_cancelled = true;
            $reservation->channex_last_revision_id = $this->resolveRevisionId($payload);
            $reservation->channex_last_revision_at = data_get($payload, 'inserted_at');
            $reservation->save();

            return (int) $reservation->property_id;
        });

        $this->acknowledgeRevision($payload, $propertyId);
    }

    protected function recordAbsentCancellation(
        array $payload,
        string $externalId,
        Property $property
    ): void {
        app(CertificationLogService::class)->log(
            'booking_webhook',
            'success',
            'booking_cancellation_absent',
            (int) $property->id,
            null,
            [],
            $this->certificationPayload($payload),
            ['local_state' => 'already_absent'],
            "Cancellation recorded for absent local OTA booking {$externalId}"
        );

        logger()->info('Channex cancellation recorded; local reservation was already absent', [
            'property_id' => $property->id,
            'revision_id' => $this->resolveRevisionId($payload),
            'external_id' => $externalId,
        ]);
    }

    protected function resolveExternalBookingId(array $payload): ?string
    {
        $externalId = data_get($payload, 'booking_id')
            ?? data_get($payload, 'booking.id')
            ?? data_get($payload, 'reservation_id')
            ?? data_get($payload, 'id');

        if (! $externalId) {
            return null;
        }

        return (string) $externalId;
    }

    protected function resolveRevisionId(array $payload): ?string
    {
        $revisionId = data_get($payload, 'booking_revision_id')
            ?? data_get($payload, 'revision_id')
            ?? data_get($payload, 'booking.revision_id')
            ?? data_get($payload, 'booking_revision.id');

        return $revisionId ? (string) $revisionId : null;
    }

    protected function isAlreadyProcessed(UserReservation $reservation, array $payload): bool
    {
        if (! $reservation->exists) {
            return false;
        }

        $revisionId = $this->resolveRevisionId($payload);
        if ($revisionId && $reservation->channex_last_revision_id === $revisionId) {
            return true;
        }

        $insertedAt = data_get($payload, 'inserted_at');
        if (! $insertedAt || ! $reservation->channex_last_revision_at) {
            return false;
        }

        return Carbon::parse($insertedAt)->lte($reservation->channex_last_revision_at);
    }

    protected function payloadFromFeedRow(array $row, string $propertyId): array
    {
        $revisionId = (string) data_get($row, 'id', '');
        $attributes = (array) data_get($row, 'attributes', []);

        if ($revisionId === '' || empty($attributes)) {
            throw new \RuntimeException('Channex returned an invalid booking revision feed row.');
        }

        if (! data_get($attributes, 'property_id')) {
            $attributes['property_id'] = $propertyId;
        }

        $attributes['booking_revision_id'] = $revisionId;

        return $attributes;
    }

    protected function normalizePayloadShape(array $payload): array
    {
        if (is_array(data_get($payload, 'data.attributes'))) {
            return (array) data_get($payload, 'data.attributes', []);
        }

        if (is_array(data_get($payload, 'attributes'))) {
            return (array) data_get($payload, 'attributes', []);
        }

        return $payload;
    }

    protected function acknowledgeRevision(array $payload, ?int $propertyId = null): void
    {
        $revisionId = data_get($payload, 'booking_revision_id')
            ?? data_get($payload, 'revision_id')
            ?? data_get($payload, 'booking.revision_id')
            ?? data_get($payload, 'booking_revision.id');

        if (! $revisionId) {
            $id = (string) data_get($payload, 'id', '');
            $bookingId = (string) data_get($payload, 'booking_id', '');

            if ($id !== '' && ($bookingId === '' || $id !== $bookingId)) {
                $revisionId = $id;
            }
        }

        if (! $revisionId) {
            app(CertificationLogService::class)->log(
                'booking_webhook',
                'failed',
                'test_11_booking_ack',
                $propertyId,
                null,
                [],
                $this->certificationPayload($payload),
                null,
                'Missing booking revision ID for acknowledge'
            );

            throw new \RuntimeException('Missing booking revision ID for acknowledge.');
        }

        $response = app(BookingRevisionService::class)->acknowledge((string) $revisionId);

        app(CertificationLogService::class)->log(
            'booking_webhook',
            $response ? 'success' : 'failed',
            'test_11_booking_ack',
            $propertyId,
            null,
            [],
            $this->certificationPayload($payload),
            $response,
            $response ? null : 'Acknowledge call failed for booking revision'
        );

        if (! $response) {
            throw new \RuntimeException("Channex booking revision {$revisionId} could not be acknowledged.");
        }
    }

    protected function certificationPayload(array $payload): array
    {
        return [
            'booking_revision_id' => $this->resolveRevisionId($payload),
            'booking_id' => $this->resolveExternalBookingId($payload),
            'property_id' => data_get($payload, 'property_id') ?? data_get($payload, 'property.id'),
            'unique_id' => data_get($payload, 'unique_id'),
            'ota_reservation_code' => data_get($payload, 'ota_reservation_code'),
            'ota_name' => data_get($payload, 'ota_name'),
            'status' => data_get($payload, 'status'),
            'arrival_date' => data_get($payload, 'arrival_date'),
            'departure_date' => data_get($payload, 'departure_date'),
            'amount' => data_get($payload, 'amount'),
            'currency' => data_get($payload, 'currency'),
            'room_type_ids' => collect((array) data_get($payload, 'rooms', []))
                ->pluck('room_type_id')
                ->filter()
                ->values()
                ->all(),
        ];
    }

    protected function guestDetails(array $payload, string $externalId): array
    {
        $email = trim((string) data_get($payload, 'customer.mail', ''));
        $canEmail = filter_var($email, FILTER_VALIDATE_EMAIL) !== false;

        if (! $canEmail) {
            $email = 'channex-' . substr(hash('sha256', $externalId), 0, 32) . '@invalid.local';
        }

        return [
            'email' => $email,
            'name' => trim((string) data_get($payload, 'customer.name', '')) ?: 'OTA Guest',
            'last_name' => trim((string) data_get($payload, 'customer.surname', '')),
            'phone_number' => data_get($payload, 'customer.phone'),
            'can_email' => $canEmail,
        ];
    }

    protected function isCancellationPayload(array $payload): bool
    {
        return in_array(
            strtolower(trim((string) data_get($payload, 'status', ''))),
            ['cancelled', 'canceled'],
            true
        );
    }
}
