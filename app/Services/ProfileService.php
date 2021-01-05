<?php

namespace App\Services;

use Illuminate\Http\Request;

class ProfileService
{
    public function index()
    {
        dd('profile page');
        return view('home');
    }
}
