<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\MessageService;
use Illuminate\Support\Facades\Auth;

/** @var \Illuminate\Contracts\Auth\Factory $auth */


class UserController extends Controller
{

    public function register(Request $request)
    {
        $incomingRequest = $request->validate([
            'name' => ['required', 'min:3', 'max:100',],
            'email' => ['required', 'min:3', 'max:100', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:3', 'max:100'],
            'role' => ['required', 'in:admin, client']
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
            if (auth()->attempt(['email' => $incomingRequest['email'], 'password' => $incomingRequest['password']])) {
                $request->session()->regenerate();

                $user = Auth::user(); //Get the authenticated user
                $request->session()->put('role', $user->role); //store the role

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
        $role = Auth::user()->role;
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect("/{$role}-login");
    }
}
