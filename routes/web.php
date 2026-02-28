<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\expensesController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/user/dashboard', [ColocationController::class, 'index'])->name('user.dashboard');
    Route::post('createColocation', [ColocationController::class, 'create'])->name('createColocation');
    Route::post('/invitationBymail', [InvitationController::class, 'sendEmail'])->name('invitationBymail');
    Route::post('/joinColocation', [ColocationController::class, 'join'])->name('colocation.join');
    Route::get('/user/expenses', [expensesController::class, 'index'])->name('user.expenses');
    Route::get('/user/payments', [PaymentController::class, 'index'])->name('user.payments');
    Route::post('/user/payments/{payment}/mark-paid', [PaymentController::class, 'markPaid'])->name('payments.markPaid');
    Route::post('/addCategory', [expensesController::class, 'addCategory'])->name('addCategory');
    Route::post('/addExpense', [expensesController::class, 'addExpense'])->name('addExpense');
    
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
