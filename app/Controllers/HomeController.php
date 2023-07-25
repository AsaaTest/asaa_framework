<?php

namespace App\Controllers;

use App\Models\User;
use Asaa\Http\Controller;

class HomeController extends Controller {
    public function show(){
        return view('home');
    }  
}