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
        // get the user transactions
        $userTransactions = DB::table('transactions')->where('user_id', $user->id)->get();

        return $userTransactions;
    }

    public function currentBalance()
    {
        $user = Auth::user();
        if (!$user) {
            return "Failed to retrieve data!";
        }

        $userLatestTransactions_id = DB::table('transactions')->select('current_balance')->where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
        $balance = $userLatestTransactions_id === null ? 0 : $userLatestTransactions_id->current_balance;
        return  $balance;
    }

    public function deposit(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return "Failed to retrieve data!";
        }

        if (!$user->account_no) {
            MessageService::flash('error', 'You don\'t have an account number in order to perform any transation');
            MessageService::flash('error', 'Go back to the dashboard to genrate one...');
            return view('client.deposit');
        }

        $incomingRequest = $request->validate([
            'depositAmount' => ['required'],
            'description' => ['required']
        ]);

        // Query the DB
        $lastBalance = DB::table('transactions')->select('previous_balance')->where('user_id', $user->id)->orderBy('created_at', 'desc')->first();

        $previousBalance = $lastBalance ? $lastBalance->previous_balance : 0;
        $newBalance = $incomingRequest['depositAmount'] + $previousBalance;
        // dd($previousBalance);
        try {
            $makeDeposit = DB::table('transactions')->insert([
                'user_id' => $user->id,
                'type' => 'deposit',
                'amount' => $incomingRequest['depositAmount'],
                'previous_balance' => $previousBalance,
                'current_balance' => $newBalance,
                'senderAcc_no' => $user->account_no,
                'recipientAcc_no' => $user->account_no,
                'status' => 'successful',
                'recipient_id' => $user->id,
                'reference' => $this->generateReference(),
                'description' => $incomingRequest['description']
            ]);

            if ($makeDeposit) {
                MessageService::flash('success', 'Deposit was successful');
                return redirect('/deposit');
            } else {
                MessageService::flash('error', 'Failed to make the Deposit');
                return redirect('/deposit');
            }
        } catch (\Exception $error) {
            // Log the exception for debugging
            Log::error('Deposit failed: ' . $error->getMessage());
            MessageService::flash('error', 'An unexpected error occurred.');
            return redirect('/deposit');
        }
    }

    public function withdrawal(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return "Failed to validate the user!!!";
        }

        if (!$user->account_no) {
            MessageService::flash('error', 'You don\'t have an account number in order to perform any transation');
            MessageService::flash('error', 'Go back to the dashboard to genrate one...');
            return view('client.deposit');
        }

        $incomingRequest = $request->validate([
            'withdrawAmount' => ['required']
        ]);

        // Query the DB
        $currentBalance = DB::table('transactions')->select('current_balance')->where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
        $availableBalance = $currentBalance ? $currentBalance->current_balance : 0;

        if ($availableBalance >= $incomingRequest['withdrawAmount']) {

            $newBalance = $availableBalance - $incomingRequest['withdrawAmount'];

            try {
                $makeWithdrawal = DB::table('transactions')->insert([
                    'user_id' => $user->id,
                    'type' => 'withdrawal',
                    'amount' => $incomingRequest['withdrawAmount'],
                    'previous_balance' => $availableBalance,
                    'current_balance' => $newBalance,
                    'senderAcc_no' => $user->account_no,
                    'recipientAcc_no' => $user->account_no,
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

    public function transfer(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return "Failed to validate the user!!!";
        }

        if (!$user->account_no) {
            MessageService::flash('error', 'You don\'t have an account number in order to perform any transation');
            MessageService::flash('error', 'Go back to the dashboard to genrate one...');
            return view('client.deposit');
        }

        $incomingRequest = $request->validate([
            'transferAmount' => ['required'],
            'recipientAccount_no' => ['required', 'max:8'],
            'description' => ['required']
        ]);

        $incomingRequest['description'] = htmlspecialchars($incomingRequest['description']);

        $userBalance = $this->currentBalance();
        $availableBalance = $userBalance ? $userBalance : 0;
        if ($availableBalance <= $incomingRequest['transferAmount']) {
            MessageService::flash('error', 'Transfer Failed due to insufficent Funds!!!');
            return  redirect('/transfer');
        }

        // dd($newBalance);
        try {
            $newBalance = $availableBalance - $incomingRequest['transferAmount'];
            // Obtain the recipient ID
            $recipient = DB::table('users')
                ->select('id', 'account_no')
                ->where('account_no', $incomingRequest['recipientAccount_no'])
                ->first();

            if (!$recipient) {
                return redirect()->back()->with('error', 'Recipient Account wasn\'t found.');
            }

            $referenceId = $this->generateReference();
            // Sender
            $senderTransfer = DB::table('transactions')->insert([
                'user_id' => $user->id,
                'type' => 'transfer',
                'amount' => $incomingRequest['transferAmount'],
                'previous_balance' => $availableBalance,
                'current_balance' => $newBalance,
                'senderAcc_no' => $user->account_no,
                'recipientAcc_no' => $incomingRequest['recipientAccount_no'],
                'status' => 'successful',
                'recipient_id' => $recipient->id,
                'reference' => $referenceId,
                'description' => $incomingRequest['description']
            ]);

            // Recipient
            $recipientPrevBalance = DB::table('transactions')
                ->select('current_balance')
                ->where('user_id', $recipient->id)
                ->orderBy('created_at', 'desc')
                ->first();

            // If recipient has no previous transactions, set balance to 0
            $recipientPrevBalance = $recipientPrevBalance ? $recipientPrevBalance->current_balance : 0;

            $RecipientNewBalance = $recipientPrevBalance + $incomingRequest['transferAmount'];

            $recipientTransfer = DB::table('transactions')->insert([
                'user_id' => $recipient->id,
                'type' => 'payment',
                'amount' => $incomingRequest['transferAmount'],
                'previous_balance' => $recipientPrevBalance,  // This is now always valid
                'current_balance' => $RecipientNewBalance,
                'senderAcc_no' => $user->account_no,
                'recipientAcc_no' => $incomingRequest['recipientAccount_no'],
                'status' => 'successful',
                'recipient_id' => $recipient->id,
                'reference' => $this->generateReference(),
                'description' => 'payment Received'
            ]);


            if ($senderTransfer && $recipientTransfer) {
                MessageService::flash('success', 'Transfer was carried out Successfully...');
                return redirect('/transfer');
            } else {
                MessageService::flash('error', 'Transfer Failed!!!');
                return redirect('/transfer');
            }
        } catch (\Exception $error) {
            Log::error('Deposit failed: ' . $error->getMessage());
            MessageService::flash('error', 'An unexpected error occurred.');
            return redirect('/transfer');
        }
    }

    public function filterDate()
    {
        $transactionMonths = [];
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
            ->where('senderAcc_no', $user->account_no)
            ->orWhere('recipientAcc_no', $user->account_no)
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($userTransactionsMonths as $UTM) {
            $monthNumber = sprintf("%02d", $UTM->month);
            $yearNumber = sprintf("%04d", $UTM->year);
            $dayNumber = sprintf("%02d", $UTM->day);
            if (array_key_exists($monthNumber, $months)) {
                $transactionMonths[] = $months[$monthNumber] . " " . $dayNumber . "," . $yearNumber;
            }
        }

        return $transactionMonths;
    }
    public function generateReference()
    {
        $prefix = 'TXN';
        $datePart = date('YmdHis');
        $stringPart = strtoupper(Str::random(8));
        return $prefix . "-" . $datePart . "-" . $stringPart;
    }
}
