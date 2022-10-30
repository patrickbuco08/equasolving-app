<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassicController extends Controller
{
    public function index()
    {
        return view('user-interface.skeleton.classic');
    }
}
