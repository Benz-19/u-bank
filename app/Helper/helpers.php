<?php

if (!function_exists('flashMessage')) {
    function flashMessage($type, $message)
    {
        session()->flash($type, $message);
    }
}
