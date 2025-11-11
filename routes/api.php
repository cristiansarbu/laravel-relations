<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// UserController routing
Route::controller(UserController::class)->group(function(){
    Route::get('user/{user}', 'show');
    Route::get('user/{user}/address', 'show_address');
    Route::get('user/{user}/events', 'listEvents');
    Route::get('users', 'index');

    Route::post('register', 'register');
    Route::post('users/{user}/events/{event}/book', 'bookEvent');
});

// AddressController routing
Route::controller(AddressController::class)->group(function() {
    Route::get('address/{address}', 'show');
    Route::get('address/{address}/user', 'show_user');
    Route::get('addresses', 'index');

    Route::post('address', 'store');
});

// EventController routing
Route::controller(EventController::class)->group(function() {
    Route::get('event/{event}/users', 'listUsers');
    Route::get('events', 'index');
    Route::get('event/{event}', 'show');

    Route::post('event', 'store');
});

// EventTypeController routing
Route::controller(EventTypeController::class)->group(function() {
    Route::get('types', 'index');
    Route::get('type/{type}/events', 'listEvents');
    Route::get('type/{type}', 'show');

    Route::post('type', 'store');
});
