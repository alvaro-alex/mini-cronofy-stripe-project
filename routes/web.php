<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
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
