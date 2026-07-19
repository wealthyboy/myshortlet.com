<?php

namespace App\Services\Channex;

use App\Models\UserReservation;
use App\Models\Reservation;
use App\Models\Apartment;
use App\Models\GuestUser;
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

                return;
            }

            /**
             * 2️⃣ Create or find Guest
             */
            $guest = GuestUser::firstOrCreate(
                ['email' => data_get($payload, 'customer.mail')],
                [
                    'name'         => data_get($payload, 'customer.name'),
                    'last_name'    => data_get($payload, 'customer.surname'),
                    'phone_number' => data_get($payload, 'customer.phone'),
                ]
            );

            /**
             * 3️⃣ Create User Reservation (Booking Header)
             */
            $bookingPropertyId = data_get($payload, 'property_id')
                ?? data_get($payload, 'property.id');

            $userReservation = UserReservation::firstOrNew([
                'external_id' => $externalId,
            ]);

            $userReservation->guest_user_id = $guest->id;
            $userReservation->property_id = $bookingPropertyId;
            $userReservation->currency = data_get($payload, 'currency');
            $userReservation->total = data_get($payload, 'amount', data_get($payload, 'total_price', 0));
            $userReservation->payment_type = 'ota';
            $userReservation->coming_from = 'ota';
            $userReservation->ota_name = data_get($payload, 'ota_name', 'unknown');
            $userReservation->external_id = $externalId;
            $userReservation->status = data_get($payload, 'status', 'confirmed');
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
                Mail::to($guest->email)->send(
                    new OtaReservationNotification($userReservation)
                );
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

        $reservation = UserReservation::where(
            'external_id',
            $this->resolveExternalBookingId($payload)
        )->first();

        if (!$reservation) {
            return;
        }

        $reservation->update([
            'status' => 'cancelled',
        ]);

        /**
         * Availability restore
         * (Only needed if you disabled Channex auto-restore)
         */
        app(BookingAvailabilityRestoreService::class)
            ->sync($reservation);

        $this->acknowledgeRevision($payload, (int) $reservation->property_id);
    }

    protected function resolvePayloadFromRevision(array $payload): array
    {
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
        $feedRows = (array) data_get($feedResponse, 'data', []);
        if (empty($feedRows)) {
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
            return $payload;
        }

        $selectedAttributes = (array) data_get($selected, 'attributes', []);
        $selectedRevisionId = (string) (data_get($selected, 'id') ?? data_get($selectedAttributes, 'id') ?? '');

        if ($selectedRevisionId === '') {
            return $payload;
        }

        $merged = array_replace_recursive($payload, $selectedAttributes);
        $merged['booking_revision_id'] = $selectedRevisionId;

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
    }
}
