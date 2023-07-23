<?php
// Importa las clases necesarias para su uso en el script.

use Asaa\App;
use Asaa\Database\DB;
use Asaa\Http\Request;
use Asaa\Http\Response;
use Asaa\Routing\Route;
use Asaa\Database\Model;
use Asaa\Http\Middleware;
use Asaa\Validation\Rule;
use Asaa\Validation\Rules\Required;

// Incluye el archivo "vendor/autoload.php" para cargar las clases definidas por Composer (como el enrutador y otras dependencias).
require_once "../vendor/autoload.php";

$app = App::bootstrap(__DIR__ . "/..");

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
    // session()->flash('alert2', 'success');
    // return json(["id" =>session()->id(), 'test' => session()->get('test', 'por def')]);
    return json($_SESSION);
});

Route::get('/form', fn (Request $request) => view('form'));

Route::post('/form', function (Request $request) {
    return json($request->validate([
        'email' => 'email|required',
        'name' => 'required|number'
    ]));
}); 

Route::post('/user', function (Request $request){
    DB::statement("INSERT INTO users (name, email) VALUES (?,?)", [$request->data('name'), $request->data('email')]);
    return json(["message" => "Ok"]);
});

Route::get('/users', function (Request $request){
    return json(DB::statement("SELECT * FROM users"));
});

class User extends Model
{
    protected array $fillable = ['name', 'email'];
}

Route::post('/user/model', function (Request $request){
    // $user = new User();
    // $user->name = $request->data('name');
    // $user->email = $request->data('email');
    // $user->save();
    return json(User::create($request->data())->toArray());
});

Route::get('/user/query', function (Request $request){
    return json(array_map(fn ($m) => $m->toArray(), User::where('name', 'mass')));
});

Route::post('/users/{id}/update', function (Request $request) {
    $user = User::find($request->routeParameters('id'));

    $user->name = $request->data('name');
    $user->email = $request->data('email');
    
    return json($user->update()->toArray());
});

Route::delete('/users/{id}/delete', function (Request $request) {
    $user = User::find($request->routeParameters('id'));

    return json($user->delete()->toArray());
});

Route::get('/dbhost', function (Request $request){
    return Response::text(config('database.port'));
});

$app->run();