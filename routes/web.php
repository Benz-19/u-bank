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
            $userName = strtoupper(Auth::user()->name);
            $accountNumber = Auth::user()->account_no;
            // dd($filterDate);
            return view(
                'client.dashboard',
                [
                    'currentBalance' => $currentBalance,
                    'userTransactions' => $userTransactions,
                    'transactionDate' => $filterDate,
                    'userName' => $userName,
                    'accountNumber' => $accountNumber
                ]
            );
        }
        return redirect('/');
    });

    // generate Account Number
    Route::post('/generateAccountNumber', [UserController::class, 'generateAccountNumber']);
    Route::get('/generateAccountNumber', function () {
        if (Auth::check()) {
            $transactionController = new TransactionController();
            $userTransactions = $transactionController->getAllTransactions();
            $currentBalance = $transactionController->currentBalance();
            $filterDate = $transactionController->filterDate();
            $userName = strtoupper(Auth::user()->name);
            $accountNumber = Auth::user()->account_no;
            return view('client.dashboard', [
                'currentBalance' => $currentBalance,
                'userTransactions' => $userTransactions,
                'transactionDate' => $filterDate,
                'userName' => $userName,
                'accountNumber' => $accountNumber
            ]);
        }
        return redirect('/');
    });

    // Client Transactions
    //deposit
    Route::post('/deposit', [TransactionController::class, 'deposit']);
    Route::get('/deposit', function () {
        $transactionController = new TransactionController();
        $availableBalance = $transactionController->currentBalance();
        return view('client.deposit', ['availableBalance' => $availableBalance]);
    });

    //withdrawal
    Route::post('/withdrawal', [TransactionController::class, 'withdrawal']);
    Route::get('/withdrawal', function () {

        if (Auth::check()) {
            $transactionController = new TransactionController();
            $availableBalance = $transactionController->currentBalance();
            return view('client.withdrawal', ['availableBalance' => $availableBalance]);
        }

        return redirect('/');
    });

    //Transfer
    Route::post('/transfer', [TransactionController::class, 'transfer']);
    Route::get('/transfer', function () {
        $transactionController = new TransactionController();
        $currentBalance = $transactionController->currentBalance();
        return view('client.transfer', ["availableBalance" => $currentBalance]);
    });



    // Admin Authentication
    Route::get('/admin-login', function () {
        return view('admin.login');
    });

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});
