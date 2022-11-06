<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SkeletonController extends Controller
{
    public function nickname()
    {
        return view('user-interface.skeleton.set-nickname');
    }

    public function classic()
    {
        return view('user-interface.skeleton.classic');
    }
    public function home()
    {
        return view('user-interface.skeleton.home');
    }
}
