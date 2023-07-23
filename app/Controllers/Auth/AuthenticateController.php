<?php

namespace App\Controllers\Auth;

use App\Models\User;
use Asaa\Http\Request;
use Asaa\Crypto\Hasher;
use Asaa\Http\Controller;

class AuthenticateController extends Controller
{

    public function create(Request $request){
        return view('auth/register');
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' =>'required'
        ]);
    
        if($data['password'] !== $data['confirm_password']){
            return back()->withErrors(["confirm_password" => ["confirm" => "Passwords do not match"]]);
        }
    
        $data["password"] =app(Hasher::class)->hash($data["password"]);
    
        $user = User::create($data);
    
        $user->login();
    
        return redirect('/');
    }
}
