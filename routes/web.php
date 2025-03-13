<?php

use App\Http\Controllers\CreateUser;
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
