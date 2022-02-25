<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnvVariableController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.envVariable.index');
    }

    public function update(Request $request)
    {
        dd($request);
    }
}
