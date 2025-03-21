<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\MessageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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

    public function deposit(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return "Failed to retrieve data!";
        }

        $incomingRequest = $request->validate([
            'depositAmount' => ['required'],
            'description' => ['required']
        ]);

        // Query the DB
        $lastBalance = DB::table('transactions')->select('balance_after')->where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
        $previousBalance = $lastBalance ? $lastBalance->balance_after : 0;
        $newBalance = $incomingRequest['depositAmount'] + $previousBalance;

        try {
            $makeDeposit = DB::table('transactions')->insert([
                'user_id' => $user->id,
                'type' => 'deposit',
                'amount' => $incomingRequest['depositAmount'],
                'balance_after' => $newBalance,
                'account_no' => $user->account_no,
                'status' => 'successful',
                'recipient_id' => $user->id,
                'reference' => $this->generateReference(),
                'description' => $incomingRequest['description']
            ]);

            if ($makeDeposit) {
                MessageService::flash('success', 'Deposit was successful');
                return view('/client/deposit');
            } else {
                return MessageService::flash('error', 'Failed to make the Deposit');
            }
        } catch (\Exception $error) {
            // Log the exception for debugging
            Log::error('Deposit failed: ' . $error->getMessage());
            return MessageService::flash('error', 'An unexpected error occurred.');
        }
    }

    public function withdrawal(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return "Failed to validate the user!!!";
        }

        $incomingRequest = $request->validate([
            'withdrawAmount' => ['required']
        ]);
        $incomingRequest['withdrawAmount'] = htmlspecialchars($incomingRequest['withdrawAmount']);

        // Query the DB
        $currentBalance = DB::table('transactions')->select('balance_after')->where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
        $availableBalance = $currentBalance ? $currentBalance->balance_after : 0;

        if ($availableBalance > $incomingRequest['withdrawAmount']) {

            $newBalance = $availableBalance - $incomingRequest['withdrawAmount'];

            try {
                $makeWithdrawal = DB::table('transactions')->insert([
                    'user_id' => $user->id,
                    'type' => 'withdrawal',
                    'amount' => $incomingRequest['withdrawAmount'],
                    'balance_after' => $newBalance,
                    'status' => 'successful',
                    'recipient_id' => $user->id,
                    'reference' => $this->generateReference(),
                    'description' => 'withdrawal was successful'
                ]);

                if ($makeWithdrawal) {
                    MessageService::flash('success', 'Withdrawal was successful...');
                    return redirect('/withdrawal');
                } else {
                    MessageService::flash('error', 'Withdrawal Failed!!!');
                    return redirect('/withdrawal');
                }
            } catch (\Exception $error) {
                Log::error('Deposit failed: ' . $error->getMessage());
                MessageService::flash('error', 'An unexpected error occurred.');
                return redirect('/withdrawal');
            }
        } else {
            MessageService::flash('error', 'Insufficient Fund!!!');
            return redirect('/withdrawal');
        }
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
