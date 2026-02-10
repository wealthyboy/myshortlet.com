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
        DB::transaction(function () use ($payload) {

            /**
             * 1️⃣ Prevent duplicates (idempotency)
             */
            $externalId = data_get($payload, 'id');

            $existing = UserReservation::where('external_id', $externalId)->first();
            if ($existing) {
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
            $userReservation = UserReservation::create([
                'guest_user_id' => $guest->id,
                'property_id'   => data_get($payload, 'property_id'),
                'currency' => data_get($payload, 'currency'),
                'total' => data_get($payload, 'total_price', 0),
                'payment_type'  => 'ota',
                'coming_from' => 'ota',
                'ota_name' => data_get($payload, 'ota_name', 'unknown'),
                'external_id' => $externalId,
                'status' => data_get($payload, 'status', 'confirmed'),
            ]);

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
                    'checkin' => data_get($payload, 'arrival_date'),
                    'checkout' => data_get($payload, 'departure_date'),
                    'length_of_stay' => Carbon::parse(
                        data_get($payload, 'arrival_date')
                    )->diffInDays(
                        data_get($payload, 'departure_date')
                    ),
                ]);
            }

            /**
             * 5️⃣ OTA Confirmation Email (NO invoice, NO payment)
             */
            Mail::to($guest->email)->send(
                new OtaReservationNotification($userReservation)
            );
        });
    }

    /**
     * Handle OTA cancellation
     */
    public function cancel(array $payload): void
    {
        $reservation = UserReservation::where(
            'external_id',
            data_get($payload, 'id')
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
    }
}
