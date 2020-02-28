<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function landing()
    {
        $configItems=Config::all();

        return view('landing')->with(["configs"=>$configItems]);
    }

}
