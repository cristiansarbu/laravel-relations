<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// UserController routing
Route::controller(UserController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('users/{user}/events/{event}/book', 'bookEvent');

    Route::get('user/{user}', 'show');
    Route::get('user/{user}/address', 'show_address');
    Route::get('user/{user}/events', 'listEvents');
});

// AddressController routing
Route::controller(AddressController::class)->group(function() {
    Route::post('address', 'store');
    Route::get('address/{address}', 'show');
    Route::get('address/{address}/user', 'show_user');
});

// EventController routing
Route::controller(EventController::class)->group(function() {
    Route::post('event', 'store');
    Route::get('event/{event}/users', 'listUsers');
});

// EventTypeController routing
Route::controller(EventTypeController::class)->group(function() {
    Route::get('type/{type}', 'listEvents');
});

