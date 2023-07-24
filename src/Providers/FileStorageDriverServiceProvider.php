<?php

namespace Asaa\Providers;

use Asaa\App;
use Asaa\Storage\Drivers\DiskFileStorage;

class FileStorageDriverServiceProvider
{
    public function registerServices()
    {
        match (config("storage.driver", "disk")) {
            "disk" => singleton(
                FileStorageDriver::class,
                fn () => new DiskFileStorage(
                    App::$root . "/storage",
                    "storage",
                    config("app.url")
                )
            ),
        };
    }
}
