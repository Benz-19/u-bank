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

    public function currentBalance()
    {
        $userTransactions = DB::table('transactions')->get();
        $user = Auth::user();
        if (!$user) {
            return "Failed";
        }

        $userTransactions = DB::table('transactions')->where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
        if ($userTransactions) {
            return $userTransactions->balance_after;
        } else {
            return 0;
        }
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
