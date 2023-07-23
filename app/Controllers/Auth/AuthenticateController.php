<?php

namespace App\Controllers\Auth;

use App\Models\User;
use Asaa\Http\Request;
use Asaa\Crypto\Hasher;
use Asaa\Http\Controller;

class AuthenticateController extends Controller
{

    public function register(){
        return view('auth/register');
    }

    public function store(Request $request, Hasher $hasher){
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' =>'required'
        ]);
    
        if($data['password'] !== $data['confirm_password']){
            return back()->withErrors(["confirm_password" => ["confirm" => "Passwords do not match"]]);
        }
    
        $data["password"] = $hasher->hash($data["password"]);
    
        $user = User::create($data);
    
        $user->login();
    
        return redirect('/');
    }

    public function index(){
        return view('auth/login');
    }

    public function login(Request $request){
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        $user = User::firstWhere('email', $data["email"]);
    
        if(is_null($user) || !app(Hasher::class)->verify($data["password"], $user->password)){
            return back()->withErrors(["email" => ["email" => "Credentials do not match"]]);
        }
    
        $user->login();
    
        return redirect("/");
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
}
