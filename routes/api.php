<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/channex/verify-reservation', 'Admin\Channex\LiveVerificationController@reservationOptions')
    ->middleware('throttle:10,1');
Route::post('/channex/verify-reservation', 'Admin\Channex\LiveVerificationController@reservation')
    ->middleware('throttle:5,1');



Route::get('/mapping_details', function (\Illuminate\Http\Request $request) {

    // Optional API key validation (recommended)
    \Log::info('Channex Changes Payload', $request->all());

    $apiKey =
        $request->header('api_key')
        ?? $request->header('api-key');

    if ($apiKey && $apiKey !== config('services.channex.key')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    return response()->json([
        "hotel_code" => "AVENUE-MONTAIGNE",
        "room_types" => [
            [
                "id" => "APT-1",
                "name" => "Apartment 1"
            ],
            [
                "id" => "APT-2",
                "name" => "Apartment 2"
            ]
        ],
        "rate_plans" => [
            [
                "id" => "STD",
                "name" => "Standard Rate"
            ]
        ]
    ], 200);
});


Route::get('/test_connection', function (\Illuminate\Http\Request $request) {

    \Log::info('Channex TEST_CONNECTION hit', [
        'query' => $request->query(),
        'headers' => $request->headers->all(),
    ]);

    if ($request->query('hotel_code') !== 'AVENUE-MONTAIGNE') {
        return response()->json(['success' => false], 404);
    }

    return response()->json(['success' => true], 200);
});


Route::post('/changes', function (\Illuminate\Http\Request $request) {

    $apiKey =
        $request->header('api_key')
        ?? $request->header('api-key');

    if ($apiKey && $apiKey !== config('services.channex.key')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Log payload for now (very important during testing)
    \Log::info('Channex Changes Payload', $request->all());

    return response()->json([
        "success" => true
    ], 200);
});



Route::post('/mapping_details', function (\Illuminate\Http\Request $request) {

    // Optional API key validation (recommended)
    \Log::info('Channex Changes Payload', $request->all());

    $apiKey =
        $request->header('api_key')
        ?? $request->header('api-key');

    if ($apiKey && $apiKey !== config('services.channex.key')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    return response()->json([
        "hotel_code" => "AVENUE-MONTAIGNE",
        "room_types" => [
            [
                "id" => "APT-1",
                "name" => "Apartment 1"
            ],
            [
                "id" => "APT-2",
                "name" => "Apartment 2"
            ]
        ],
        "rate_plans" => [
            [
                "id" => "STD",
                "name" => "Standard Rate"
            ]
        ]
    ], 200);
});


Route::post('/test_connection', function (\Illuminate\Http\Request $request) {
    \Log::info('Channex Changes Payload', $request->all());

    $apiKey =
        $request->header('api_key')
        ?? $request->header('api-key');

    if ($apiKey && $apiKey !== config('services.channex.key')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Channex sends ?hotel_code=XXXX
    if ($request->query('hotel_code') !== 'AVENUE-MONTAIGNE') {
        return response()->json(['success' => false], 404);
    }

    return response()->json([
        "success" => true
    ], 200);
});


Route::post('/changes', function (\Illuminate\Http\Request $request) {

    $apiKey =
        $request->header('api_key')
        ?? $request->header('api-key');

    if ($apiKey && $apiKey !== config('services.channex.key')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Log payload for now (very important during testing)
    \Log::info('Channex Changes Payload', $request->all());

    return response()->json([
        "success" => true
    ], 200);
});



Route::get('/flights', function () {
    return response()->json([
        'data' => json_decode(file_get_contents(storage_path('app/demo/flights.json')), true),
    ]);
});

Route::get('/hotels', function () {
    return response()->json([
        'data' => json_decode(file_get_contents(storage_path('app/demo/hotels.json')), true),
    ]);
});

Route::post('/bookings', function (Request $request) {
    $booking = $request->validate([
        'listing_id' => ['required', 'string'],
        'name' => ['required', 'string', 'max:120'],
        'email' => ['required', 'email'],
        'phone' => ['required', 'string', 'max:40'],
        'amount' => ['required', 'numeric', 'min:1'],
        'airline' => ['required', 'string', 'max:120'],
        'airline_code' => ['nullable', 'string', 'max:10'],
        'route' => ['required', 'string', 'max:80'],
        'departure_date' => ['required', 'string', 'max:40'],
        'return_date' => ['required', 'string', 'max:40'],
        'departure_time' => ['nullable', 'string', 'max:20'],
        'arrival_time' => ['nullable', 'string', 'max:20'],
        'duration' => ['nullable', 'string', 'max:30'],
        'stops' => ['nullable', 'string', 'max:30'],
        'travelers' => ['required', 'string', 'max:80'],
        'cabin_class' => ['required', 'string', 'max:40'],
        'passport_country' => ['required', 'string', 'max:80'],
        'payment_method' => ['required', 'string', 'max:80'],
        'billing_city' => ['required', 'string', 'max:80'],
        'protection' => ['required', 'boolean'],
    ]);

    $reference = 'KAR-' . Str::upper(Str::random(8));
    $amount = 'NGN ' . number_format((float) $booking['amount'], 2);
    $protection = $booking['protection'] ? 'Included' : 'Not selected';
    $airlineCode = $booking['airline_code'] ? " ({$booking['airline_code']})" : '';

    Mail::send(
        'emails.booking-receipt',
        compact('booking', 'reference', 'amount', 'protection', 'airlineCode'),
        fn ($message) => $message
            ->from(config('mail.from.address'), 'Karossy Travels')
            ->to($booking['email'])
            ->subject("Your Karossy booking is confirmed — {$reference}")
    );

    return response()->json([
        'message' => 'Demo payment approved and receipt sent.',
        'data' => [
            'reference' => $reference,
            'status' => 'paid',
            'receipt_email' => $booking['email'],
            'itinerary' => [
                'airline' => $booking['airline'],
                'route' => $booking['route'],
                'departure_date' => $booking['departure_date'],
                'return_date' => $booking['return_date'],
                'travelers' => $booking['travelers'],
                'amount' => $booking['amount'],
            ],
        ],
    ], 201);
});
