<?php
// Importa las clases necesarias para su uso en el script.

use Asaa\App;
use Asaa\Http\Request;
use Asaa\Http\Response;

// Incluye el archivo "vendor/autoload.php" para cargar las clases definidas por Composer (como el enrutador y otras dependencias).
require_once "../vendor/autoload.php";

$app = App::bootstrap();

$app->router->get('/test/{param}', function (Request $request) {
    return Response::json($request->routeParameters());
});

$app->router->post('/test', function (Request $request) {
    return Response::json($request->query('test'));
});

$app->router->get('/redirect', function (Request $request) {
    return Response::redirect("/test");
});

$app->run();