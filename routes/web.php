<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CronofyController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth

Route::get('login', [LoginController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [LoginController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [LoginController::class, 'destroy'])
    ->name('logout');

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('auth');

Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');

// Cronofy

Route::get('/auth/cronofy', [CronofyController::class, 'redirectToCronofy'])
    ->name('auth.cronofy')
    ->middleware('auth');

Route::get('/auth/cronofy/callback', [CronofyController::class, 'handleCallback'])
    ->name('auth.cronofy.callback')
    ->middleware('auth');

Route::get('/cronofy/calendars', [CronofyController::class, 'showCalendars'])
    ->name('cronofy.calendars')
    ->middleware('auth');

// Stripe

Route::get('/stripe/subscription', [StripeController::class, 'showSubscription'])
    ->name('stripe.subscription')
    ->middleware('auth');

Route::get('/stripe/createcustomer', [StripeController::class, 'createCustomer'])
    ->name('stripe.createcustomer')
    ->middleware('auth');
