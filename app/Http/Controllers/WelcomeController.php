<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function show()
    {
        $loggedUser = auth()->user()->name;
        return view('welcome')->with('loggedUser', $loggedUser);
    }
}