<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});


Route::get('/client-login', function () {
    return view('/client/login');
});
