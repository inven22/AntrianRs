<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class layouts extends Controller
{
    public function index(){
        return view('antrian.baris');
    }
}
