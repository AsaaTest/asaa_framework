<?php

return [
    'boot' => [
        \Asaa\Providers\ServerServiceProvider::class,
        \Asaa\Providers\SessionStorageServiceProvider::class,
        \Asaa\Providers\DatabaseDriverServiceProvider::class,
        \Asaa\Providers\ViewServiceProvider::class         
    ],
    'runtime' =>[

    ]
];