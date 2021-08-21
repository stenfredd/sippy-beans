<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Str;

class NewPasswordController extends Controller
{

    public function index()
    {
		return view('auth.passwords.newpassword');
    }
}
