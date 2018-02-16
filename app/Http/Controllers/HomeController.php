<?php

namespace Manticore\Http\Controllers;

use Illuminate\Http\Request;

use Manticore\Http\Requests;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
}
