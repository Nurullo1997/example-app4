<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PageController extends Controller
{
    public function main()
    {
        return view('main');
    }

    public function about()
    {
        return view('about');

    }

    public function service()
    {
        return view('service');

    }

    public function projects()
    {
        return view('projects');

    }

    public function contact()
    {
        return view('contact');

    }
    
}
