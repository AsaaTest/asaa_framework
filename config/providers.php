<?php

return [
    /**
     * Proveedores de servicios para el arranque (boot) de la aplicación
     * 
     * Esta opción especifica una lista de clases de proveedores de servicios que se ejecutarán durante el arranque (boot) de la aplicación.
     * Los proveedores de servicios se utilizan para configurar y registrar diversos servicios y funcionalidades en la aplicación.
     * Estos proveedores se ejecutarán en el arranque de la aplicación, generalmente al iniciar el servidor web.
     * Puedes agregar o quitar proveedores de servicios aquí según las necesidades de tu aplicación.
     */
    'boot' => [
        \Asaa\Providers\ServerServiceProvider::class,
        \Asaa\Providers\SessionStorageServiceProvider::class,
        \Asaa\Providers\DatabaseDriverServiceProvider::class,
        \Asaa\Providers\ViewServiceProvider::class,
        \Asaa\Providers\AuthenticatorServiceProvider::class,
        \Asaa\Providers\HasherServiceProvider::class,
        \Asaa\Providers\FileStorageDriverServiceProvider::class
    ],

    /**
     * Proveedores de servicios para tiempo de ejecución (runtime) de la aplicación
     * 
     * Esta opción especifica una lista de clases de proveedores de servicios que se ejecutarán durante el tiempo de ejecución (runtime) de la aplicación.
     * Los proveedores de servicios se utilizan para configurar y registrar diversos servicios y funcionalidades en la aplicación.
     * Estos proveedores se ejecutarán en el tiempo de ejecución de la aplicación, generalmente cuando se realiza una solicitud HTTP.
     * Puedes agregar o quitar proveedores de servicios aquí según las necesidades de tu aplicación.
     */
    'runtime' => [
        App\Providers\RuleServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        loadModuleProviders(),
        App\Providers\AppServiceProvider::class
    ],

    /**
     * Proveedores de servicios para comandos de línea de comandos (CLI)
     * 
     * Esta opción especifica una lista de clases de proveedores de servicios que se ejecutarán cuando se utilicen comandos de línea de comandos (CLI).
     * Los proveedores de servicios se utilizan para configurar y registrar diversos servicios y funcionalidades en la aplicación.
     * Estos proveedores se ejecutarán cuando se ejecuten comandos de línea de comandos, lo que te permite tener configuraciones específicas para comandos.
     * Puedes agregar o quitar proveedores de servicios aquí según las necesidades de tu aplicación.
     */
    'cli' => [
        \Asaa\Providers\DatabaseDriverServiceProvider::class
    ]
];
