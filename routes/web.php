<?php

use Asaa\Http\Request;
use Asaa\Http\Response;
use Asaa\Routing\Route;

Route::get('/', fn (Request $request) => Response::text("Asaa Framework"));
Route::get('/form', fn (Request $request) => view("form"));