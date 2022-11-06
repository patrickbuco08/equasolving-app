<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PvpController extends Controller
{
    public function setMatch(Request $request)
    {
        sleep(10);
        return $request->all();
    }
}
