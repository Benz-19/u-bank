<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('landing');
});

// User Authentication Routes
Route::get('/create-user', function () {
    return view('auth.createUser');
});
Route::post('/register-user', [UserController::class, 'register']);
Route::post('/login-user', [UserController::class, 'loginUser']);
Route::get('/logout', [UserController::class, 'logoutUser']);


// Middleware to prevent back history after logout
Route::middleware(['PreventBackhistory'])->group(function () {
    // Client Authentication
    Route::get('/client-login', function () {
        return view('client.login');
    });

    Route::get('/client/dashboard', function () {
        if (session('user_id')) {
            return view('client.dashboard');
        } else {
            return view('/');
        }
    });

    // Admin Authentication
    Route::get('/admin-login', function () {
        return view('admin.login');
    });

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});
