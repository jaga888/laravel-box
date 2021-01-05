<?php

namespace App\Services;

use Illuminate\Http\Request;

class HomeService
{
    public function index()
    {
        dd('home page');
        return view('home');
    }
}
