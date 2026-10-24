<?php

namespace App\Services\ChannexPro;

use App\Models\Apartment;
use App\Models\GuestUser;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\UserReservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReceiveChannelReservation
{
    public function receive(array $data): array
    {
        // The bridge explicitly refreshes ARI after commit. Suppress model events
        // here to avoid echoing intermediate deleted/recreated room lines back to it.
        return Reservation::withoutEvents(fn () => UserReservation::withoutEvents(fn () =>
            DB::transaction(function () use ($data) {
                $property = Property::whereKey($data['property_id'])->where('allow', true)->lockForUpdate()->firstOrFail();
                $hash = hash('sha256', json_encode($data, JSON_UNESCAPED_SLASHES));
                $receipt = DB::table('channexpro_booking_receipts')->where('revision_id', $data['revision_id'])->first();
                if ($receipt) {
                    abort_unless((int) $receipt->property_id === (int) $property->id
                        && hash_equals($receipt->payload_hash, $hash), 409, 'Revision identity was reused with different data.');

                    return json_decode($receipt->response, true);
                }

                foreach ($data['rooms'] as $line) {
                    if (! Apartment::whereKey($line['room_type_id'])->where('property_id', $property->id)->exists()) {
                        throw ValidationException::withMessages(['rooms' => 'A room does not belong to the supplied property.']);
                    }
                    $nights = Carbon::parse($line['check_in'])->diffInDays(Carbon::parse($line['check_out']));
                    if ($nights > 730) {
                        throw ValidationException::withMessages(['rooms' => 'Room stays are limited to 730 nights.']);
                    }
                }

                // Use the same booking identity as the legacy OTA importer, scoped
                // to this local property; never create a second copy of that stay.
                $header = UserReservation::withTrashed()->where('property_id', $property->id)
                    ->where('external_id', $data['booking_id'])->lockForUpdate()->first();
                $lastAt = data_get($header ? $header->pricing_snapshot : null, 'channexpro.revision_at');
                if (! $lastAt && $header && $header->channex_last_revision_at) {
                    $lastAt = $header->channex_last_revision_at;
                }
                $stale = $lastAt && Carbon::parse($lastAt)->gt(Carbon::parse($data['revision_at']));
                $sameRevision = $header && $header->channex_last_revision_id === $data['revision_id'];
                $affected = [];
                if (! $stale && ! $sameRevision) {
                    $header = $header ?: new UserReservation();
                    $oldRooms = $header->exists ? $header->reservations()->get() : collect();
                    foreach ($oldRooms as $line) {
                        $affected[] = $this->window($property->id, $line->checkin, $line->checkout);
                    }
                    $guest = $header->guest_user ?: new GuestUser();
                    $guest->fill([
                        'name' => ($data['guest']['first_name'] ?? '') ?: 'Guest',
                        'last_name' => ($data['guest']['last_name'] ?? '') ?: '',
                        'email' => ($data['guest']['email'] ?? '') ?: 'ota-'.$data['booking_id'].'@guests.invalid',
                        'phone_number' => $data['guest']['phone'] ?? null,
                    ])->save();
                    $snapshot = $header->pricing_snapshot ?: [];
                    $snapshot['channexpro'] = [
                        'booking_id' => $data['booking_id'], 'revision_id' => $data['revision_id'],
                        'revision_at' => $data['revision_at'], 'reference' => $data['reference'],
                        'ota_name' => $data['ota_name'],
                    ];
                    $header->fill([
                        'property_id' => $property->id, 'guest_user_id' => $guest->id,
                        'external_id' => $data['booking_id'], 'invoice' => $header->invoice ?: $data['reference'],
                        'coming_from' => 'ota', 'payment_type' => 'ota', 'ota_name' => $data['ota_name'],
                        'currency' => $data['currency'], 'currency_code' => $data['currency'],
                        'total' => $data['amount'], 'original_amount' => $data['amount'],
                        'status' => $data['status'] === 'cancelled' ? 'cancelled' : 'confirmed',
                        'channex_last_revision_id' => $data['revision_id'],
                        'channex_last_revision_at' => $data['revision_at'], 'pricing_snapshot' => $snapshot,
                    ]);
                    // This is a reservation import, not payment verification or guest check-in.
                    $header->is_cancelled = $data['status'] === 'cancelled';
                    $header->checkin = $data['check_in'];
                    $header->checkout = $data['check_out'];
                    if ($header->trashed()) {
                        $header->restore();
                    }
                    $header->save();

                    // Soft-delete only this booking's old room lines. Other stays
                    // and manual blocks continue to determine sellable capacity.
                    foreach ($oldRooms as $line) {
                        $line->delete();
                    }
                    if ($data['status'] !== 'cancelled') {
                        foreach ($data['rooms'] as $line) {
                            $nights = Carbon::parse($line['check_in'])->diffInDays(Carbon::parse($line['check_out']));
                            Reservation::create([
                                'user_reservation_id' => $header->id, 'property_id' => $property->id,
                                'apartment_id' => $line['room_type_id'], 'quantity' => $line['quantity'],
                                'checkin' => $line['check_in'], 'checkout' => $line['check_out'], 'length_of_stay' => $nights,
                                'price' => round((float) $line['amount'] / $nights / $line['quantity'], 2),
                                'currency' => $data['currency'], 'currency_code' => $data['currency'], 'rate' => 1,
                                'pricing_snapshot' => ['currency_code' => $data['currency'], 'nights' => $nights,
                                    'accommodation_total' => (float) $line['amount'], 'source' => 'channexpro'],
                            ]);
                            $affected[] = $this->window($property->id, $line['check_in'], $line['check_out']);
                        }
                    }
                }
                if (! $stale && $affected === []) {
                    $affected[] = $this->window($property->id, $data['check_in'], $data['check_out']);
                }
                $result = [
                    'received' => true, 'revision_id' => $data['revision_id'], 'stale' => (bool) $stale,
                    'affected' => array_values(array_unique($affected, SORT_REGULAR)),
                ];
                DB::table('channexpro_booking_receipts')->insert([
                    'property_id' => $property->id, 'revision_id' => $data['revision_id'], 'booking_id' => $data['booking_id'],
                    'payload_hash' => $hash, 'response' => json_encode($result), 'created_at' => now(), 'updated_at' => now(),
                ]);

                return $result;
            })
        ));
    }

    private function window(int $propertyId, $from, $checkout): array
    {
        return ['property_id' => (string) $propertyId, 'from' => Carbon::parse($from)->toDateString(),
            'to' => Carbon::parse($checkout)->subDay()->toDateString()];
    }
}
