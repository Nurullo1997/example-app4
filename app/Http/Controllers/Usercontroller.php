<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class Usercontroller extends Controller
{
    public function index(Request $request)
    {
        dd($request);
        return "Bu userlarni royxati";
    }

    public function show($user)
    {
        return view('users.show')-> with('name', 'Nuruulo')->with('familya', 'Jakbaraliyev')->with('raqami', $user);
    }

    public function ishgaTush()
    {
        return view('users.ishga')->with('ismi', 'Doston')->with('familyasi', 'Axmedov')->with('yili', '1990');   
    }
}
