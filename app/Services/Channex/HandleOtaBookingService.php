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
     * Handle NEW or MODIFIED OTA booking
     */
    public function handle(array $payload): void
    {
        $payload = $this->normalizePayloadShape($payload);
        $payload = $this->resolvePayloadFromFeedFallback($payload);
        $payload = $this->resolvePayloadFromRevision($payload);

        // A repeated property notification can arrive after another worker has
        // already pulled and acknowledged the only pending revision. That is a
        // successful no-op, not a malformed booking that should be retried.
        if (data_get($payload, '_channex_no_pending_revision') === true) {
            logger()->info('Channex booking notification ignored; no pending revision remains in the feed', [
                'property_id' => data_get($payload, 'property_id') ?? data_get($payload, 'property.id'),
            ]);
            return;
        }

        DB::transaction(function () use ($payload) {
            $externalId = $this->resolveExternalBookingId($payload);
            if (! $externalId) {
                app(CertificationLogService::class)->log(
                    'booking_webhook',
                    'failed',
                    'test_11_booking_ack',
                    null,
                    null,
                    [],
                    $payload,
                    null,
                    'Missing external booking ID for upsert'
                );

                throw new \RuntimeException('Missing external booking ID for upsert.');
            }

            /**
             * 2️⃣ Create or find Guest
             */
            $guest = GuestUser::firstOrCreate(
                [
                    'email' => data_get($payload, 'customer.mail')],
                [
                    'name' => data_get($payload, 'customer.name'),
                    'last_name' => data_get($payload, 'customer.surname'),
                    'phone_number' => data_get($payload, 'customer.phone'),
                ]
            );

            /**
             * 3️⃣ Create User Reservation (Booking Header)
             */
            $channexPropertyId = data_get($payload, 'property_id')
                ?? data_get($payload, 'property.id');
            $property = Property::where('channex_property_id', $channexPropertyId)->first();

            if (! $property) {
                throw new \RuntimeException("No local property mapping for Channex property {$channexPropertyId}.");
            }

            $userReservation = UserReservation::firstOrNew([
                'external_id' => $externalId,
            ]);

            if ($this->isAlreadyProcessed($userReservation, $payload)) {
                logger()->info('Channex booking revision already processed; duplicate delivery ignored', [
                    'revision_id' => $this->resolveRevisionId($payload),
                    'external_id' => $externalId,
                ]);
                return;
            }

            $userReservation->guest_user_id = $guest->id;
            $userReservation->property_id = $property->id;
            $userReservation->currency = data_get($payload, 'currency');
            $userReservation->total = data_get($payload, 'amount', data_get($payload, 'total_price', 0));
            $userReservation->payment_type = 'ota';
            $userReservation->coming_from = 'ota';
            $userReservation->ota_name = data_get($payload, 'ota_name', 'unknown');
            $userReservation->external_id = $externalId;
            $userReservation->status = data_get($payload, 'status', 'confirmed');
            $userReservation->channex_last_revision_id = $this->resolveRevisionId($payload);
            $userReservation->channex_last_revision_at = data_get($payload, 'inserted_at');
            $userReservation->save();

            // For booking.modified, replace previous room lines with latest revision snapshot.
            Reservation::where('user_reservation_id', $userReservation->id)->delete();

            /**
             * 4️⃣ Create Reservation Items (Apartments)
             */
            foreach ((array) data_get($payload, 'rooms', []) as $room) {

                $apartment = Apartment::where(
                    'channex_room_type_id',
                    data_get($room, 'room_type_id')
                )->first();

                if (!$apartment) {
                    continue;
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

            /**
             * 5️⃣ OTA Confirmation Email (NO invoice, NO payment)
             */
            if ($userReservation->wasRecentlyCreated) {
                try {
                    Mail::to($guest->email)->send(
                        new OtaReservationNotification($userReservation)
                    );
                } catch (\Throwable $e) {
                    logger()->warning('OTA confirmation email could not be sent', [
                        'reservation_id' => $userReservation->id,
                        'external_id' => $externalId,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            $this->acknowledgeRevision($payload, (int) $userReservation->property_id);
        });
    }

    /**
     * Handle OTA cancellation
     */
    public function cancel(array $payload): void
    {
        $payload = $this->normalizePayloadShape($payload);
        $payload = $this->resolvePayloadFromFeedFallback($payload, 'cancelled');
        $payload = $this->resolvePayloadFromRevision($payload);

        if (data_get($payload, '_channex_no_pending_revision') === true) {
            logger()->info('Channex cancellation notification ignored; no pending revision remains in the feed', [
                'property_id' => data_get($payload, 'property_id') ?? data_get($payload, 'property.id'),
            ]);
            return;
        }

        DB::transaction(function () use ($payload) {
            $externalId = $this->resolveExternalBookingId($payload);
            $reservation = UserReservation::where('external_id', $externalId)->first();

            if (!$reservation) {
                throw new \RuntimeException('Cannot cancel OTA booking because the local reservation was not found.');
            }

            if ($this->isAlreadyProcessed($reservation, $payload)) {
                logger()->info('Channex cancellation revision already processed; duplicate delivery ignored', [
                    'revision_id' => $this->resolveRevisionId($payload),
                    'external_id' => $externalId,
                ]);
                return;
            }

            $reservation->update([
                'status' => 'cancelled',
                'channex_last_revision_id' => $this->resolveRevisionId($payload),
                'channex_last_revision_at' => data_get($payload, 'inserted_at'),
            ]);

            // Keep the local update and the acknowledgment retryable together. If
            // acknowledgment fails, the transaction rolls back and the job retry
            // can safely process and acknowledge the revision again.
            $this->acknowledgeRevision($payload, (int) $reservation->property_id);
        });
    }

    protected function resolvePayloadFromRevision(array $payload): array
    {
        // The revisions feed already returns the complete revision. Fetching the
        // same ID again is both redundant and contrary to pull-once/ack-once flow.
        if (data_get($payload, '_channex_revision_loaded') === true) {
            return $payload;
        }

        $revisionId = data_get($payload, 'booking_revision_id')
            ?? data_get($payload, 'revision_id')
            ?? data_get($payload, 'booking.revision_id')
            ?? data_get($payload, 'booking_revision.id');

        if (! $revisionId) {
            return $payload;
        }

        $revisionResponse = app(BookingRevisionService::class)->fetch((string) $revisionId);
        if (! is_array($revisionResponse)) {
            return $payload;
        }

        $revisionData = data_get($revisionResponse, 'data.attributes')
            ?? data_get($revisionResponse, 'data')
            ?? [];

        if (! is_array($revisionData) || empty($revisionData)) {
            return $payload;
        }

        $merged = array_replace_recursive($payload, $revisionData);
        $merged['booking_revision_id'] = $revisionId;
        $merged['_channex_revision_loaded'] = true;
        $merged['_channex_revision_source'] = 'id';

        return $merged;
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

    protected function resolvePayloadFromFeedFallback(array $payload, ?string $expectedStatus = null): array
    {
        $hasRevisionId = ! empty(
            data_get($payload, 'booking_revision_id')
            ?? data_get($payload, 'revision_id')
            ?? data_get($payload, 'booking.revision_id')
            ?? data_get($payload, 'booking_revision.id')
        );

        $hasExternalId = ! empty($this->resolveExternalBookingId($payload));

        if ($hasRevisionId && $hasExternalId) {
            return $payload;
        }

        $propertyId = data_get($payload, 'property_id') ?? data_get($payload, 'property.id');
        if (! $propertyId) {
            return $payload;
        }

        $feedResponse = app(BookingRevisionService::class)->fetchFeed((string) $propertyId);

        // A failed request must remain retryable. Only a valid, empty feed means
        // a duplicate notification whose revision was already acknowledged.
        if (! is_array($feedResponse)) {
            return $payload;
        }

        $feedRows = (array) data_get($feedResponse, 'data', []);
        if (empty($feedRows)) {
            $payload['_channex_no_pending_revision'] = true;
            return $payload;
        }

        $expectedStatus = $expectedStatus ? strtolower($expectedStatus) : null;
        $expectedUniqueId = (string) data_get($payload, 'unique_id', '');
        $expectedOtaCode = (string) data_get($payload, 'ota_reservation_code', '');

        $selected = null;

        foreach ($feedRows as $row) {
            $attrs = (array) data_get($row, 'attributes', []);
            if (empty($attrs)) {
                continue;
            }

            $rowStatus = strtolower((string) data_get($attrs, 'status', ''));
            if ($expectedStatus !== null && $rowStatus !== $expectedStatus) {
                continue;
            }

            if ($expectedUniqueId !== '' && (string) data_get($attrs, 'unique_id', '') !== $expectedUniqueId) {
                continue;
            }

            if ($expectedOtaCode !== '' && (string) data_get($attrs, 'ota_reservation_code', '') !== $expectedOtaCode) {
                continue;
            }

            $selected = $row;
            break;
        }

        if (! is_array($selected)) {
            $payload['_channex_no_pending_revision'] = true;
            return $payload;
        }

        $selectedAttributes = (array) data_get($selected, 'attributes', []);
        $selectedRevisionId = (string) (data_get($selected, 'id') ?? data_get($selectedAttributes, 'id') ?? '');

        if ($selectedRevisionId === '') {
            return $payload;
        }

        $merged = array_replace_recursive($payload, $selectedAttributes);
        $merged['booking_revision_id'] = $selectedRevisionId;
        $merged['_channex_revision_loaded'] = true;
        $merged['_channex_revision_source'] = 'feed';

        logger()->info('Channex webhook payload recovered from revisions feed', [
            'property_id' => $propertyId,
            'revision_id' => $selectedRevisionId,
            'expected_status' => $expectedStatus,
        ]);

        return $merged;
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
                $payload,
                null,
                'Missing booking revision ID for acknowledge'
            );

            return;
        }

        $response = app(BookingRevisionService::class)->acknowledge((string) $revisionId);

        app(CertificationLogService::class)->log(
            'booking_webhook',
            $response ? 'success' : 'failed',
            'test_11_booking_ack',
            $propertyId,
            null,
            [],
            $payload,
            $response,
            $response ? null : 'Acknowledge call failed for booking revision'
        );

        if (! $response) {
            throw new \RuntimeException("Channex booking revision {$revisionId} could not be acknowledged.");
        }
    }
}
