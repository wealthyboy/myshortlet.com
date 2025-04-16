<?php

namespace App\Http\Controllers\AbandonedCart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserTracking;


class AbandonedCartsController extends Controller
{




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sessionId = session()->getId();
        $input = $request->payload;
        $sessionId = session()->getId();
        $bookingId = $input['booking_ids'];
        $bookingId = array_shift($bookingId);
        $path = $input['page_url'];

        $user = UserTracking::updateOrCreate(
            ['session_id' => $sessionId, 'page_url' => $path],
            [
                'user_id' => optional(auth()->user())->id,
                'visited_at' => now(),
                'apartment_id' => $bookingId,
                'action' => 'abandoned',
                'first_name' => data_get($input, 'first_name'),
                'last_name' => data_get($input, 'last_name'),
                'email' => data_get($input, 'email'),
                'code' => data_get($input, 'code'),
                'phone_number' => data_get($input, 'phone_number'),
                'currency' => data_get($input, 'currency'),
                'total' => data_get($input, 'total'),
                'property_id' => data_get($input, 'property_id'),
                'coupon' => data_get($input, 'coupon'),
                'original_amount' => data_get($input, 'original_amount'),
            ]
        );

        \App\Jobs\SendAbandonedBookingNotifications::dispatch()->delay(now()->addMinute(30));
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
