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

        $userTransactions = DB::table('transactions')->where('user_id', $user->id)->get();
        return $userTransactions;
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

        $makeDeposit = DB::table('transactions')->insert([]);
    }
    public function withdrawal()
    {
        return $this->generateReference();
    }

    public function filterDate()
    {
        $transactionMonths = []; //months the user carried out a transaction
        $months = [
            "01" => "January",
            "02" => "February",
            "03" => "March",
            "04" => "April",
            "05" => "May",
            "06" => "June",
            "07" => "July",
            "08" => "August",
            "09" => "September",
            "10" => "October",
            "11" => "November",
            "12" => "December"
        ];

        $user = Auth::user();

        $userTransactionsMonths = DB::table('transactions')
            ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, DAY(created_at) as day'))
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($userTransactionsMonths as $usrTransMonth) {
            $monthNumber = sprintf("%02d", $usrTransMonth->month); // Format month as two-digit string
            $yearNumber = sprintf("%04d", $usrTransMonth->year);
            $dayNumber = sprintf("%02d", $usrTransMonth->day);
            if (array_key_exists($monthNumber, $months)) {
                $transactionMonths[] =  $months[$monthNumber] . " " . $dayNumber . "," . $yearNumber;
            }
        }

        return $transactionMonths;
    }

    protected function generateReference()
    {
        $prefix = 'TXN';
        $datePart = date('YmdHis');
        $stringPart = strtoupper(Str::random(8));
        return $prefix . "-" . $datePart . "-" . $stringPart;
    }
}
