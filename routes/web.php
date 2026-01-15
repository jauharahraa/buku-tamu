<?php

use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;
use App\Models\Guest;

Route::get('/success', function () {
    return view('success');
})->name('guest.success');
Route::get('/', function () {
    return view('welcome');
});

// Route untuk simpan data
Route::post('/guest', [GuestController::class, 'store'])->name('guest.store');