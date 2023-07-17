<?php
// Importa las clases necesarias para su uso en el script.
use Asaa\Routing\Router;
use Asaa\Http\Request;
use Asaa\Server\PhpNativeServer;
use Asaa\Http\HttpNotFoundException;
use Asaa\Http\Response;

// Incluye el archivo "vendor/autoload.php" para cargar las clases definidas por Composer (como el enrutador y otras dependencias).
require_once "../vendor/autoload.php";

/**
 * Crea una nueva instancia del enrutador.
 */
$router = new Router;

/**
 * Define las rutas y sus acciones correspondientes utilizando los métodos "get" y "post" del enrutador.
 * Estas acciones son funciones anónimas (closures) que se ejecutarán cuando la ruta coincida con la solicitud.
 */
$router->get('/test', function (Request $request) {
    // Retorna una respuesta de texto con el mensaje "GET OK".
    return Response::text("GET OK");
});

$router->post('/test', function (Request $request) {    
    // Retorna una respuesta de texto con el mensaje "POST OK".
    return Response::text("POST OK");
});

$router->get('/redirect', function (Request $request) {    
    // Redirecciona al endpoint '/test'.
    return Response::redirect("/test");
});

// Crea una instancia de la clase PhpNativeServer, que implementa la interfaz Server.
$server = new PhpNativeServer();

try {
    // Intenta resolver la ruta utilizando la URI y el método HTTP de la solicitud actual ($_SERVER["REQUEST_URI"] y $_SERVER["REQUEST_METHOD"]).
    // Crea una instancia de la clase Request utilizando la implementación de PhpNativeServer, que obtiene información de la solicitud HTTP utilizando variables superglobales de PHP.
    $request = new Request($server);
    $route = $router->resolve($request);

    // Obtiene la acción asociada a la ruta resuelta.
    $action = $route->action();

    // Ejecuta la acción y obtiene la respuesta.
    $response = $action($request);

    // Envía la respuesta al cliente utilizando el servidor PhpNativeServer.
    $server->sendResponse($response);
} catch (HttpNotFoundException $e) {
    // Si no se encuentra ninguna ruta coincidente, muestra un mensaje de "Not Found" y establece el código de respuesta HTTP a 404.
    $response = Response::text("Not Found")->setStatus(404);
    $server->sendResponse($response);
}
