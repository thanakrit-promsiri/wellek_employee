<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainMenuController extends Controller
{
    public function main()
    {
        return view('main_menu');
    }
}
