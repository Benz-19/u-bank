<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\MessageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

/** @var \Illuminate\Contracts\Auth\Factory $auth */

class UserController extends Controller
{
    public $role;
    public function register(Request $request)
    {
        $incomingRequest = $request->validate([
            'name' => ['required', 'min:3', 'max:100',],
            'email' => ['required', 'min:3', 'max:100', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:3', 'max:100'],
            'role' => ['required', 'in:client, admin']
        ]);

        $incomingRequest['password'] = bcrypt($incomingRequest['password']);

        $user = User::create($incomingRequest);

        if ($user) {
            MessageService::flash('success', 'Account was created successfully!');
            return view('/auth/createUser');
        } else {
            MessageService::flash('error', 'Error, failed to create your account!');
            return redirect()->back()->withInput(); // Redirect back with input
        }
    }

    public function loginUser(Request $request)
    {
        $incomingRequest = $request->validate([
            'email' => ['required', 'min:3', 'max:100'],
            'password' => ['required', 'min:3', 'max:100']
        ]);

        if (empty($incomingRequest['email']) && empty($incomingRequest['password'])) {
            MessageService::flash('error', 'Ensure to fill all fields!!!');
        } else {
            if (Auth::attempt(['email' => $incomingRequest['email'], 'password' => $incomingRequest['password']])) {
                $request->session()->regenerate();

                $user = Auth::user(); //Get the authenticated user
                $request->session()->put('role', $user->role); //store the role
                $request->session()->put('user_id', $user->id); //user id

                if ($user->role === 'admin') {
                    return redirect('/admin/dashboard'); //admin redirect
                } elseif ($user->role === 'client') {
                    return redirect('/client/dashboard'); //client redirect
                } else {
                    return redirect('/');
                }
            } else {
                MessageService::flash('error', 'Something went wrong.');
                MessageService::flash('error', 'Failed to authenticate user...');
            }
        }
        MessageService::flash('error', 'Something went wrong!!!');
    }

    public function logoutUser()
    {
        $role = session('role');
        Auth::logout();
        session()->flush();
        session()->invalidate();
        session()->regenerateToken();
        if ($role) {
            return redirect("/{$role}-login")->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Sat,  01 Jan 2000 00:00:00 GMT',
            ]);
        }
        return redirect('/');
    }

    public function generateAccountNumber(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/');
        }

        // search for the user
        $hasAccNo = Auth::user()->account_no !== null ? true : false;

        if ($hasAccNo) {
            MessageService::flash('error', 'You Already have an account!!!');
            return redirect('/generateAccountNumber');
        }

        // return "yes";
        $newAccNo = rand(10000000, 99999999);

        try {

            $affectedRows  = DB::table('users')
                ->where('id', $user->id)
                ->update(['account_no' => $newAccNo]);

            if ($affectedRows > 0) {
                MessageService::flash('success', "Account number created successfully... Your number {$newAccNo}");
                return redirect('/generateAccountNumber');
            } else {
                MessageService::flash('error', "Failed to create an Account number!!!");
                return redirect('/generateAccountNumber');
            }
        } catch (\Exception $error) {
            Log::error('Deposit failed: ' . $error->getMessage());
            MessageService::flash('error', 'An unexpected error occurred.');
            return redirect('/generateAccountNumber');
        }
    }
}
