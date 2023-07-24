<?php

return [
    /**
     * Método de almacenamiento de sesiones
     * 
     * Esta opción especifica el método de almacenamiento que se utilizará para las sesiones de la aplicación.
     * El valor por defecto es 'native', lo que significa que las sesiones se almacenarán en el almacenamiento predeterminado de PHP.
     * Puedes personalizar esta opción utilizando la variable de entorno SESSION_STORAGE para utilizar otros métodos de almacenamiento, como bases de datos u otros sistemas de almacenamiento.
     */
    'storage' => env('SESSION_STORAGE', 'native'),

    /**
     * Entorno de la aplicación
     * 
     * Esta opción especifica el entorno de la aplicación, como desarrollo, producción, etc.
     * El valor por defecto es 'dev', pero se puede sobrescribir utilizando la variable de entorno APP_ENV.
     */
    'env' => env('APP_ENV', 'dev'),

    /**
     * URL de la aplicación
     * 
     * Esta opción especifica la URL base de la aplicación.
     * El valor por defecto es 'localhost:8181', pero se puede sobrescribir utilizando la variable de entorno APP_URL.
     */
    'url' => env('APP_URL', 'localhost:8080'),
];
