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

    public function editClient($id, Request $request)
    {
        if (!Auth::check()) {

            return redirect('/');
        }

        $incomingRequest = $request->validate([
            'name' => ['required'],
            'email' => ['required'],
            'accountNo' => [''] ?? null
        ]);

        $incomingRequest['name'] = htmlspecialchars($incomingRequest['name']);

        $admin = Auth::user();
        $client = DB::table('users')->select('*')->where('id', $id)->first();

        $updateClient = DB::table('users')
            ->where('id', $id)
            ->update([
                'name' => $incomingRequest['name'],
                'email' => $incomingRequest['email'],
                'account_no' => $incomingRequest['accountNo']
            ]);

        if ($updateClient === 1) {
            MessageService::flash('success', 'Client Details were updated successfully...');
            return view('admin.editClient', [
                'adminName' => $admin->name,
                'adminId' => $admin->id,
                'name' => $client->name,
                'email' => $client->email,
                'accountNo' => $client->account_no,
                'id' => $id,
            ]);
        } else {
            return redirect()->back();
        }
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
