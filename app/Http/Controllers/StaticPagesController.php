<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaticPagesController extends Controller
{
    //
    public function home()
    {
        $feeds=[];
        if (Auth::check()) {
            $feeds=Auth::user()->feed()->paginate(10);
        }
        return view('static_pages.home',compact('feeds'));
    }

    public function help()
    {
        return view('static_pages.help');
    }

    public function about()
    {
        return view('static_pages.about');
    }
}
