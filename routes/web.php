<?php

use App\Http\Controllers\CreateUser;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

// Client auth
Route::get('/client-login', function () {
    return view('/client/login');
});
Route::get('/create-user', [CreateUser::class, 'register']);
