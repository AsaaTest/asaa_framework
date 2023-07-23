<?php

namespace Asaa\Providers;

use Asaa\Session\PhpNativeSessionStorage;
use Asaa\Session\SessionStorage;

class SessionStorageServiceProvider implements ServiceProvider
{
    public function registerServices()
    {
        match(config("session.storage", "native")) {
            "native" => singleton(SessionStorage::class, PhpNativeSessionStorage::class)
        };
    }
}
