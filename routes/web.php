<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth', function () {
  return view('auth'); // This will return the auth.blade.php view
});

Route::get('/registerdata', function() {
  return view('registerdata');
});