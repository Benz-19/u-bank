<?php

namespace App\Services;

use App\Http\Controllers\Controller;

class MessageService extends Controller
{
    public static function flash($type, $message)
    {
        session()->flash($type, $message);
    }
}
