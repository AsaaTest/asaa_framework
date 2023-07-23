<?php

namespace Asaa\Auth;

use Asaa\Auth\Authenticators\Authenticator;

class Auth
{
    public static function user(): ?Authenticator
    {
        return app(Authenticator::class)->resolve();
    }

    public static function isGuest(): bool
    {
        return is_null(self::user());
    }
}
