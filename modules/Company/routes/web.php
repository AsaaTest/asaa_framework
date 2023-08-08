<?php

use Asaa\Routing\Route;

Route::get('/module', fn () => view('company/views/modulo', ['e' => 'hola']));

