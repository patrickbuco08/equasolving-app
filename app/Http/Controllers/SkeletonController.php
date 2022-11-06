<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SkeletonController extends Controller
{
    public function nickname()
    {
        return view('user-interface.skeleton.set-nickname');
    }
}
