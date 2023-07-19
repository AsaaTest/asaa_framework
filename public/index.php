<?php
// Importa las clases necesarias para su uso en el script.

use Asaa\App;
use Asaa\Http\Request;
use Asaa\Http\Response;
use Asaa\Routing\Route;
use Asaa\Http\Middleware;

// Incluye el archivo "vendor/autoload.php" para cargar las clases definidas por Composer (como el enrutador y otras dependencias).
require_once "../vendor/autoload.php";

$app = App::bootstrap();

$app->router->get('/test/{param}', function (Request $request) {
    return json($request->routeParameters());
});

$app->router->post('/test', function (Request $request) {
    return json($request->data('test'));
});

$app->router->get('/redirect', function (Request $request) {
    return redirect("/test");
});

class AuthMiddleware implements Middleware {
    public function handle(Request $request, Closure $next): Response {
        if ($request->headers('Authorization') != 'test') {
            return json(["message" => "Not authenticated"])->setStatus(401);
        }

        $response = $next($request);
        $response->setHeader('X-Test-Custom-Header', 'Hola');

        return $response;
    }
}

Route::get('/middlewares', fn (Request $request) => json(["message" => "ok"]))->setMiddlewares([AuthMiddleware::class]);

Route::get('/html', fn (Request $request) => view('home', ["user" => "abel"]));

$app->run();