<?php

namespace App\Http\Controllers\AbandonedCart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserTracking;


class AbandonedCartsController extends Controller
{


    public function update(Request $request, $id)
    {
        $sessionId = session()->getId();
        $input = $request->all();
        $path = $input['page_url'];

        $user = UserTracking::updateOrCreate(
            ['id' => $id],
            [
                'user_id' => optional(auth()->user())->id,
                'visited_at' => now(),
                'apartment_id' => data_get($input, 'apartment_id'),
                'ip_address' => $request->ip(),
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
                'country' => session('country_name'),
                'original_amount' => data_get($input, 'original_amount'),
            ]
        );

        \App\Jobs\SendAbandonedBookingNotifications::dispatch()->delay(now()->addMinute(1));
        return response()->json($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sessionId = session()->getId();
        $input = $request->all();
        $sessionId = session()->getId();

        $path = $input['page_url'];

        $user = UserTracking::updateOrCreate(
            ['session_id' => $sessionId, 'page_url' => $path],
            [
                'user_id' => optional(auth()->user())->id,
                'visited_at' => now(),
                'apartment_id' => data_get($input, 'apartment_id'),
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
