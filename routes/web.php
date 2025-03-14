<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

// User Auth
Route::get('/create-user', function () {
    return view('/auth/createUser');
});
Route::post('/register-user', [UserController::class, 'register']);

// Client Authentication
Route::get('/client-login', function () {
    return view('/client/login');
});
Route::post('/login-user', [UserController::class, 'loginUser']);
Route::get('/client/dashboard', function () {
    return view('client/dashboard');
});


// Admin Authentication
Route::get('/admin-login', function () {
    return view('admin/login');
});
Route::get('/admin/dashboard', function () {
    return view('admin/dashboard');
});
