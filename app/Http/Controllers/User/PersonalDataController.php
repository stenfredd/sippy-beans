<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class PersonalDataController extends Controller
{
    public function index()
    {
		return view('user.personal_data');
    }
}
