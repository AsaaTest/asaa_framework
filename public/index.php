<?php
// Se requiere el archivo autoload.php del directorio "vendor" para cargar las dependencias de la aplicación.
require_once __DIR__ . "/../vendor/autoload.php";

// Se utiliza el método estático "bootstrap" de la clase "App" para inicializar la aplicación.
// El método "bootstrap" recibe como argumento el directorio raíz de la aplicación (dirname(__DIR__) es el directorio padre del directorio actual).
$app = Asaa\App::bootstrap(dirname(__DIR__));

// Se llama al método "run" de la aplicación para iniciar el procesamiento de la solicitud HTTP actual.
$app->run();
