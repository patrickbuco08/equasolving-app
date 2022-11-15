<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function store(Request $request)
    {
        auth()->logout();
        return redirect()->route('home');
    }

    public function ajaxLogout(Request $request)
    {
        sleep(1);
        auth()->logout();
        return response()->json("success!", 201);
    }
}
