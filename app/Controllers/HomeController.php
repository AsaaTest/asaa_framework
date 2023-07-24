<?php

namespace App\Controllers;

use Asaa\Http\Controller;

class HomeController extends Controller {
    public function show(){
        return view('home');
    }
}