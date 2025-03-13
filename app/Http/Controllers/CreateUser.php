<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\MessageService;
use Illuminate\Support\Facades\Auth;

class CreateUser extends Controller
{
    public function register(Request $request)
    {
        $incomingRequest = $request->validate([
            'name' => ['required', 'min:3', 'max:100',],
            'email' => ['required', 'min:3', 'max:100', 'email', 'unique:users,email'],
            'password' => ['required', 'min:3', 'max:100']
        ]);

        $incomingRequest['password'] = bcrypt($incomingRequest['password']);

        $user = User::create($incomingRequest);

        if ($user) {
            // Auth::login($user); // Log in user
            MessageService::flash('success', 'Account was created successfully!');
            return view('/auth/createUser');
        } else {
            MessageService::flash('error', 'Error, failed to create your account!');
            return redirect()->back();
        }
    }
}
