<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function getAllClients()
    {
        $allClients = DB::table('users')->select('*')->where('type', 'client');
        return $allClients;
    }
}
