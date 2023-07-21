<?php
// Importa las clases necesarias para su uso en el script.

use Asaa\App;
use Asaa\Http\Request;
use Asaa\Http\Response;
use Asaa\Routing\Route;
use Asaa\Http\Middleware;
use Asaa\Validation\Rule;
use Asaa\Validation\Rules\Required;

// Incluye el archivo "vendor/autoload.php" para cargar las clases definidas por Composer (como el enrutador y otras dependencias).
require_once "../vendor/autoload.php";

$app = App::bootstrap();

Route::get('/test/{param}', function (Request $request) {
    return json($request->routeParameters());
});

Route::post('/test', function (Request $request) {
    return json($request->data());
});

Route::get('/redirect', function (Request $request) {
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

Route::post('/validate', fn(Request $request) => json($request->validate([
    'test' => 'required',
    'num' => 'required|number',
    'email' => 'required_when:num,>,4|email'
],
[
    'email' => [
        'email' => 'DAME EL 2CAMPO'
    ]
]
)));

Route::get('/session', function (Request $request) {
    session()->remove('test');
    return json(["id" =>session()->id(), 'test' => session()->get('test', 'por def')]);
});

$app->run();