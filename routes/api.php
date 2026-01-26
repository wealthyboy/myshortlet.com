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

Route::get('/mapping_details', function () {
    return response()->json([
        "hotel_code" => "AVENUE-MONTAIGNE",
        "room_types" => [
            ["id" => "APT-1", "name" => "Apartment 1"],
            ["id" => "APT-2", "name" => "Apartment 2"]
        ],
        "rate_plans" => [
            ["id" => "STD", "name" => "Standard Rate"]
        ]
    ]);
});
