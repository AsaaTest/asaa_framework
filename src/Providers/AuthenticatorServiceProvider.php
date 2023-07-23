<?php

namespace Asaa\Providers;

use Asaa\Auth\Authenticators\Authenticator;
use Asaa\Auth\Authenticators\SessionAuthenticator;

class AuthenticatorServiceProvider implements ServiceProvider
{
    public function registerServices()
    {
        match(config("auth.method", "session")) {
            "session" => singleton(Authenticator::class, SessionAuthenticator::class)
        };
    }
}
