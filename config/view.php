<?php

return [
    /**
     * Motor de plantillas para vistas
     * 
     * Esta opción especifica el motor de plantillas que se utilizará para renderizar las vistas en la aplicación.
     * El valor por defecto es 'asaa', lo que indica que se utilizará el motor de plantillas 'asaa' (posiblemente personalizado para la aplicación).
     * Puedes cambiar esta opción para utilizar otros motores de plantillas compatibles con la aplicación.
     */
    "engine" => 'asaa',

    /**
     * Ruta del directorio de vistas
     * 
     * Esta opción especifica la ruta del directorio donde se encuentran las vistas de la aplicación.
     * El valor por defecto utiliza una función resourcesDirectory() para obtener la ruta del directorio 'resources/views'.
     * Puedes personalizar esta opción si las vistas se encuentran en un directorio diferente.
     */
    'path' => resourcesDirectory() . "/views",
];
