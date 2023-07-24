<?php

return [
    /**
     * Conexión de base de datos
     * 
     * Esta opción especifica el tipo de conexión de base de datos que se utilizará para la aplicación.
     * El valor por defecto es 'mysql', lo que indica que se utilizará una conexión de base de datos MySQL.
     * Puedes personalizar esta opción utilizando la variable de entorno DB_CONNECTION para utilizar otras conexiones, como PostgreSQL, SQLite, etc.
     */
    'connection' => env('DB_CONNECTION', 'mysql'),

    /**
     * Host de la base de datos
     * 
     * Esta opción especifica el host donde se encuentra la base de datos.
     * El valor por defecto es 'localhost', pero se puede sobrescribir utilizando la variable de entorno DB_HOST.
     */
    'host' => env('DB_HOST', 'localhost'),

    /**
     * Puerto de la base de datos
     * 
     * Esta opción especifica el puerto utilizado para la conexión de base de datos.
     * El valor por defecto es '3306', pero se puede sobrescribir utilizando la variable de entorno DB_PORT.
     */
    'port' => env('DB_PORT', '3306'),

    /**
     * Nombre de la base de datos
     * 
     * Esta opción especifica el nombre de la base de datos que se utilizará en la conexión.
     * El valor por defecto es 'asaa', pero se puede sobrescribir utilizando la variable de entorno DB_DATABASE.
     */
    'database' => env('DB_DATABASE', 'asaa'),

    /**
     * Nombre de usuario de la base de datos
     * 
     * Esta opción especifica el nombre de usuario utilizado para autenticarse en la base de datos.
     * El valor por defecto es 'root', pero se puede sobrescribir utilizando la variable de entorno DB_USERNAME.
     */
    'username' => env('DB_USERNAME', 'root'),

    /**
     * Contraseña de la base de datos
     * 
     * Esta opción especifica la contraseña utilizada para autenticarse en la base de datos.
     * El valor por defecto es una cadena vacía, pero se puede sobrescribir utilizando la variable de entorno DB_PASSWORD.
     */
    'password' => env('DB_PASSWORD', ''),
];
