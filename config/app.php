<?php

return [
    /**
     * Nombre de la aplicación
     * 
     * El valor por defecto es 'asaa', pero se puede sobrescribir utilizando la variable de entorno APP_NAME.
     */
    'name' => env('APP_NAME', 'asaa'),

    /**
     * Entorno de la aplicación
     * 
     * El valor por defecto es 'dev', pero se puede sobrescribir utilizando la variable de entorno APP_ENV.
     */
    'env' => env('APP_ENV', 'dev'),

    /**
     * URL de la aplicación
     * 
     * El valor por defecto es 'localhost:8181', pero se puede sobrescribir utilizando la variable de entorno APP_URL.
     */
    'url' => env('APP_URL', 'localhost:8181'),
];
