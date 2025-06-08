<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('getUser')) {
    function getUser()
    {
        return Auth::guard('admin')->check() ? Auth::guard('admin')->user() : Auth::guard('web')->user();
    }
}

if (!function_exists('getUserId')) {
    function getUserId()
    {
        return Auth::guard('admin')->check() ? Auth::guard('admin')->id() : Auth::guard('web')->id();
    }
}
