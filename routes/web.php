<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\InvitationController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/user/dashboard', [ColocationController::class, 'index'])->name('user.dashboard');
    Route::post('createColocation', [ColocationController::class, 'create'])->name('createColocation');
    Route::post('/invitationBymail', [InvitationController::class, 'sendEmail'])->name('invitationBymail');
    
});


Route::get('/accept-invitation', [InvitationController::class, 'show'])->name('accept-invitation');
Route::post('/accept-invitation', [InvitationController::class, 'accept'])->name('accept-invitation');
Route::post('/refuse-invitation', [InvitationController::class, 'refuse'])->name('refuse-invitation');



Route::middleware('auth')->group(function () {
    Route::get('/administrateur/dashboard', function () {
        return view('administrateur.dashboard'); 
    })->name('administrateur.dashboard');
});



Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
