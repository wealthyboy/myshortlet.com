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

        $user = UserTracking::updateOrInsert(
            ['session_id' => $sessionId, 'page_url' => $path],
            [
                'user_id' => optional(auth()->user())->id,
                'visited_at' => now(),
                'apartment_id' => $bookingId,
                'action' => 'abandoned',
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
                'code' => $input['code'],
                'phone_number' => $input['phone_number'],
                'currency' => $input['currency'],
                'total' => $input['total'],
                'property_id' => $input['property_id'],
                'coupon' => $input['coupon'],
                'original_amount' => $input['original_amount'],
            ]
        );

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
