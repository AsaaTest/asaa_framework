<?php

return [
    /**
     * Controlador de almacenamiento de archivos
     * 
     * Esta opción especifica el controlador de almacenamiento de archivos que se utilizará para la aplicación.
     * El valor por defecto es 'disk', lo que indica que se utilizará el controlador de almacenamiento de archivos predeterminado.
     * Puedes personalizar esta opción utilizando la variable de entorno FILE_STORAGE para utilizar otros controladores de almacenamiento, como S3, FTP, etc.
     */
    'driver' => env('FILE_STORAGE', 'disk'),
];
