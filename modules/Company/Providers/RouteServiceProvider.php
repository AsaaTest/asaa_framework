<?php

namespace Modules\Company\Providers;

use Asaa\App;
use Asaa\Routing\Route;
use Asaa\Providers\ServiceProvider;

class RouteServiceProvider implements ServiceProvider
{
    public function registerServices()
    {
        Route::load(App::$root . "/modules/Company/routes");
    }
}
