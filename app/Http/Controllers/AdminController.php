<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MessageService;
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
        if (!$admin) {
            redirect()->back();
        }
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

    public function deleteClient($id)
    {
        // Ensure the admin is authenticated
        if (!Auth::check()) {
            return redirect()->back();
        }

        $admin = Auth::user();
        $getAllClients = $this->getAllClients();

        // Check if the user exists before attempting to delete
        $client = DB::table('users')->where('id', $id)->first();
        if (!$client) {
            MessageService::flash('error', 'User not found!');
            return view('admin.dashboard', [
                'adminName' => $admin->name,
                'adminId' => $admin->id,
                'getAllClients' => $getAllClients
            ]);
        }

        // Delete transactions associated with the user
        DB::table('transactions')->where('user_id', $id)->delete();

        // Delete the client from the users table
        $deleted = DB::table('users')->where('id', $id)->delete();

        if ($deleted) {
            MessageService::flash('success', 'User was deleted successfully...');
        } else {
            MessageService::flash('error', 'Failed to delete the user!!!');
        }

        return redirect()->back();
    }
}
