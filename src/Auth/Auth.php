<?php

namespace Asaa\Auth;

use Asaa\Routing\Route;
use Asaa\Auth\Authenticators\Authenticator;
use App\Controllers\Auth\AuthenticateController;

class Auth
{
    public static function user(): ?Authenticatable
    {
        return app(Authenticator::class)->resolve();
    }

    public static function isGuest(): bool
    {
        return is_null(self::user());
    }

    public static function routes()
    {
        Route::get('/register', [AuthenticateController::class, 'register']);
        Route::post('/register', [AuthenticateController::class, 'store']);
        Route::get('/login', [AuthenticateController::class, 'index']);
        Route::post('/login', [AuthenticateController::class, 'login']);
        Route::get('/logout', [AuthenticateController::class, 'logout']);
    }
}
