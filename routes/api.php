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
    Route::get('users', 'index');
});

// AddressController routing
Route::controller(AddressController::class)->group(function() {
    Route::post('address', 'store');
    Route::get('address/{address}', 'show');
    Route::get('address/{address}/user', 'show_user');
    Route::get('addresses', 'index');
});

// EventController routing
Route::controller(EventController::class)->group(function() {
    Route::post('event', 'store');
    Route::get('event/{event}/users', 'listUsers');
    Route::get('events', 'index');
    Route::get('event/{event}', 'show');
});

// EventTypeController routing
Route::controller(EventTypeController::class)->group(function() {
    Route::get('types', 'index');
    Route::get('type/{type}', 'listEvents');
    Route::post('type', 'store');
});

