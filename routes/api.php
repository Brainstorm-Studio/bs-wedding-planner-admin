<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\WeddingController;

Route::get('/wedding/{slug}', [WeddingController::class, 'getWeddingBySlug']);
Route::get('/guests/{slug}', [GuestController::class, 'getGuestsByWedding']);
Route::get('/search-guest/{slug}/{phone}', [GuestController::class, 'getGuestByWeddingAndPhone']);
Route::post('/update-guest', [GuestController::class, 'updateGuest']);
Route::get('/countries', [CountryController::class, 'getCountries']);
