<?php

use App\Models\User;
use Asaa\Crypto\Hasher;
use Asaa\Http\Request;
use Asaa\Http\Response;
use Asaa\Routing\Route;

Route::get('/', fn ($request) => Response::text(auth()->name));
Route::get('/form', fn ($request) => view("form"));
Route::get('/register', fn ($request) => view("auth/register"));
Route::post('/register', function (Request $request) {
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

    User::create($data);

    $user = User::firstWhere('email', $data['email']);

    $user->login();

    return redirect('/');
});