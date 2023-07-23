<?php

namespace Asaa\Providers;

use Asaa\Database\Drivers\DatabaseDriver;
use Asaa\Database\Drivers\PdoDriver;

class DatabaseDriverServiceProvider implements ServiceProvider
{
    public function registerServices()
    {
        match(config("database.connection", "mysql")) {
            "mysql", "pgsql" => singleton(DatabaseDriver::class, PdoDriver::class)
        };
    }
}
