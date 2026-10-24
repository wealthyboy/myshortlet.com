<?php

namespace App\Http\Controllers\Integration;

use App\Http\Controllers\Controller;
use App\Services\ChannexPro\ReceiveChannelReservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChannexProReservationController extends Controller
{
    public function store(Request $request, ReceiveChannelReservation $receiver): JsonResponse
    {
        $expected = trim((string) config('services.channexpro.shared_token'));
        if ($expected === '' || ! config('services.channexpro.reservations_enabled')) {
            return response()->json(['message' => 'Channel reservation receiving is not configured or enabled.'], 503);
        }
        $provided = trim((string) $request->bearerToken());
        if ($provided === '' || ! hash_equals($expected, $provided)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data = $request->validate([
            'schema' => 'required|in:channexpro.channel-reservation.v1',
            'revision_id' => 'required|uuid', 'revision_at' => 'required|date', 'booking_id' => 'required|uuid',
            'property_id' => 'required|integer|min:1', 'reference' => 'required|string|max:255',
            'ota_name' => 'required|string|max:100', 'status' => 'required|in:new,modified,cancelled',
            'currency' => 'required|regex:/^[A-Z]{3}$/', 'amount' => 'required|numeric|min:0',
            'check_in' => 'required|date_format:Y-m-d', 'check_out' => 'required|date_format:Y-m-d|after:check_in',
            'guest' => 'required|array', 'guest.first_name' => 'nullable|string|max:150',
            'guest.last_name' => 'nullable|string|max:150', 'guest.email' => 'nullable|email|max:191',
            'guest.phone' => 'nullable|string|max:80',
            'rooms' => ($request->input('status') === 'cancelled' ? 'present|array' : 'required|array|min:1').'|max:100',
            'rooms.*.room_type_id' => 'required|integer|min:1', 'rooms.*.rate_plan_id' => 'required|string|max:255',
            'rooms.*.quantity' => 'required|integer|min:1|max:100',
            'rooms.*.amount' => 'required|numeric|min:0',
            'rooms.*.check_in' => 'required|date_format:Y-m-d',
            'rooms.*.check_out' => 'required|date_format:Y-m-d|after:rooms.*.check_in',
        ]);

        return response()->json($receiver->receive($data))->header('Cache-Control', 'no-store');
    }
}
