<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DefaultController extends Controller
{
    public function userProfile()
    {
        return view('user-interface.user-profile');
    }

    public function matchHistory()
    {
        return view('user-interface.match-history');
    }

    public function settings()
    {
        return view('user-interface.settings');
    }

    public function classic()
    {
        return view('user-interface.classic');
    }

    public function pvp()
    {
        return view('user-interface.pvp');
    }

}
