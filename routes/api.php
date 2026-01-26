<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
