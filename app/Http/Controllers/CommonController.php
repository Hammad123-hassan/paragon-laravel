<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    public static function checkPermission()
    {
        $user = auth()->user();
        if($user->HasRole('Super Admin')) 
        {
            return ['yes', 'no'];
        }
        else
        {
            return ['no'];
        }
    }
}
