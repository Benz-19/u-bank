<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreateUser extends Controller
{
    public function register(Request $request)
    {
        $incomingRequest = $request->validate([
            'name' => ['required', 'min:3', 'max:100',],
            'email' => ['required', 'min:3', 'max:100', 'email'],
            'password' => ['required', 'min:3', 'max:100', 'password']
        ]);

        $incomingRequest['password'] = bcrypt($incomingRequest['password']);

        $user = User::create($incomingRequest);
        auth()->login($user);
        return redirect('/');
    }
}
