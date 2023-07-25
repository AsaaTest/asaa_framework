<?php

namespace App\Controllers;

use App\Models\User;
use Asaa\Http\Controller;

class HomeController extends Controller {
    public function show(){
        return view('home');
    }

    public function view(User $user){
        d($user);
        return json($user->toArray());
    }
       
}