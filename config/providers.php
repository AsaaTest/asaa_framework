<?php

return [
    'boot' => [
        \Asaa\Providers\ServerServiceProvider::class,
        \Asaa\Providers\SessionStorageServiceProvider::class,
        \Asaa\Providers\DatabaseDriverServiceProvider::class,
        \Asaa\Providers\ViewServiceProvider::class,
        \Asaa\Providers\AuthenticatorServiceProvider::class,
        \Asaa\Providers\HasherServiceProvider::class,
        \Asaa\Providers\FileStorageDriverServiceProvider::class        
    ],
    'runtime' =>[
        App\Providers\RuleServiceProvider::class,
        App\Providers\RouteServiceProvider::class
    ],
    'cli' =>[
        \Asaa\Providers\DatabaseDriverServiceProvider::class
    ]
];