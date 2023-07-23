<?php

namespace Asaa\Providers;

use Asaa\View\View;
use Asaa\View\AsaaEngine;

class ViewServiceProvider implements ServiceProvider
{
    public function registerServices()
    {
        match(config("view.engine", "asaa")) {
            "asaa" => singleton(View::class, fn () => new AsaaEngine(config("view.path")))
        };
    }
}
