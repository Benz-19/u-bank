<?php

use App\Http\Controllers\CreateUser;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

// Client Authentication
Route::get('/client-login', function () {
    return view('/client/login');
});
Route::get('/create-user', function () {
    return view('/auth/createUser');
});
Route::post('/register-user', [CreateUser::class, 'register']);
Route::post('/login-user', [UserController::class, 'loginUser']);
Route::get('/dashbpard', function () {
    return view('client/dashboard');
});
