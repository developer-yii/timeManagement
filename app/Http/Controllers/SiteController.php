<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        return view('index');
    }

    public function faq(Request $request)
    {
        return view('faq');
    }

    public function help()
    {
        return view('help');
    }
}
