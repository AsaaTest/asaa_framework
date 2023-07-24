<?php

use App\Controllers\ContactController;
use App\Controllers\HomeController;
use Asaa\Auth\Auth;
use Asaa\Routing\Route;


Auth::routes();

Route::get('/', fn () => redirect('/home'));
Route::get('/home', [HomeController::class, 'show']);

Route::get('/contacts', [ContactController::class, 'index']);
Route::get('/contacts/create', [ContactController::class, 'create']);
Route::post('/contacts', [ContactController::class, 'store']);
Route::get('/contacts/edit/{contact}', [ContactController::class, 'edit']);
Route::post('/contacts/edit/{contact}', [ContactController::class, 'update']);
Route::get('/contacts/delete/{contact}', [ContactController::class, 'destroy']);

