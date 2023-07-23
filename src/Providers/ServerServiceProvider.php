<?php

namespace Asaa\Providers;

use Asaa\Server\PhpNativeServer;
use Asaa\Server\Server;

class ServerServiceProvider implements ServiceProvider
{
    public function registerServices()
    {
        singleton(Server::class, PhpNativeServer::class);
    }
}
