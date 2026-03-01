<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\expensesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdministrateurController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

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
    Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::post('/user/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::post('/user/profile/password', [ProfileController::class, 'updatePassword'])->name('user.profile.password');
    Route::post('/colocation/quitter', [ColocationController::class, 'quitter'])->name('colocation.quitter');
    Route::post('/colocation/cancel', [ColocationController::class, 'cancel'])->name('colocation.cancel');
    Route::delete('/membership/{membership}', [ColocationController::class, 'destroy'])->name('membership.remove');
    
});


Route::get('/accept-invitation', [InvitationController::class, 'show'])->name('accept-invitation');
Route::post('/accept-invitation', [InvitationController::class, 'accept'])->name('accept-invitation');
Route::post('/refuse-invitation', [InvitationController::class, 'refuse'])->name('refuse-invitation');



Route::middleware('auth')->group(function () {
    Route::get('/administrateur/dashboard', [AdministrateurController::class, 'dashboard'])->name('administrateur.dashboard');
    Route::post('/administrateur/ban/{userId}', [AdministrateurController::class, 'banUser'])->name('administrateur.ban');
    Route::post('/administrateur/unban/{userId}', [AdministrateurController::class, 'unbanUser'])->name('administrateur.unban');
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
