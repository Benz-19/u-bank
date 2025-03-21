<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;


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
Route::middleware(['PreventBackHistory'])->group(function () {
    // Client Authentication
    Route::get('/client-login', function () {
        return view('client.login');
    });

    Route::get('/client/dashboard', function () {

        if (Auth::check()) {
            $transactionController = new TransactionController();
            $userTransactions = $transactionController->getAllTransactions();
            $currentBalance = $transactionController->currentBalance();
            $filterDate = $transactionController->filterDate();
            // dd($filterDate);
            return view(
                'client.dashboard',
                [
                    'currentBalance' => $currentBalance,
                    'userTransactions' => $userTransactions,
                    'transactionDate' => $filterDate
                ]
            );
        }
        return redirect('/');
    });

    // Admin Authentication
    Route::get('/admin-login', function () {
        return view('admin.login');
    });

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});
