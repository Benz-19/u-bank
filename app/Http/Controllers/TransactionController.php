<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    //
    protected $currentBalance;

    public function getAllTransactions()
    {
        $user = Auth::user();
        if (!$user) {
            return "Failed to retrieve data!";
        }

        $userTransaction = DB::table('transactions')->get();
        return $userTransaction;
    }

    public function currentBalance()
    {
        $user = Auth::user();
        if (!$user) {
            return "Failed to retrieve data!";
        }

        $userLatestTransactions = DB::table('transactions')->where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
        if ($userLatestTransactions) {
            return $userLatestTransactions->balance_after;
        } else {
            return 0;
        }
    }

    public function deposit($depositAmount)
    {
        $user = Auth::user();
        if (!$user) {
            return "Failed to retrieve data!";
        }

        // $userLatestTransactions = DB::table('transactions')->where('')
    }
    public function withdrawal()
    {
        return $this->generateReference();
    }

    protected function generateReference()
    {
        $prefix = 'TXN';
        $datePart = date('YmdHis');
        $stringPart = strtoupper(Str::random(8));
        return $prefix . "-" . $datePart . "-" . $stringPart;
    }
}
