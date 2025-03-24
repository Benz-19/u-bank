<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function getAllClients()
    {
        $allClients = DB::table('users')->select('*')->where('role', 'client')->get();
        return $allClients;
    }

    public function getClientTransaction($id)
    {
        $admin = Auth::user();
        $client = DB::table('users')->select('*')->where('id', $id)->get();
        $clientTransaction = DB::table('transactions')->select('*')->where('user_id', $id)->orderBy('created_at', 'desc')->get();
        // dd($clientTransaction);
        return view('admin.userTransaction', [
            'adminName' => $admin->name,
            'adminId' => $admin->id,
            'clientTransaction' => $clientTransaction,
            'clientName' => $client[0]->name,
            'clientAccNo' => $client[0]->account_no
        ]);
    }
}
