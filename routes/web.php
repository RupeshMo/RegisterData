<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\RecordController;

Route::get('/', function () {
    return view('welcome');
});

// Registration Routes
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');

// Login Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [AuthController::class, 'login'])->name('login');

// Logout Route
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Apply the 'auth' middleware to protect the route for authenticated users
Route::middleware('auth')->get('/registerdata', function () {
    return view('registerdata');
})->name('registerdata');  // Give the route a name

// Apply 'auth' middleware to protect record submission route for authenticated users
Route::middleware('auth')->post('/submit-record', [RecordController::class, 'submitRecord'])->name('submit.record');
