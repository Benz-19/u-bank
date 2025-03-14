<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function loginUser(Request $request)
    {
        $incomingRequest = $request->validate([
            'email' => ['required', 'min:3', 'max:100'],
            'password' => ['required', 'min:3', 'max:100']
        ]);

        if (empty($incomingRequest['email']) && empty($incomingRequest['password'])) {
            MessageService::flash('error', 'Ensure to fill all fields!!!');
        } else {
            if (auth()->attempt(['email' => $incomingRequest['email'], 'password' => $incomingRequest['password']])) {
                $request->session()->regenerate();
                return redirect('/client/dashboard');
            }
        }
        MessageService::flash('error', 'Something went wrong!!!');
    }
}
