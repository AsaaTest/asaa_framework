<?php

namespace Asaa;

use Throwable;
use Asaa\View\View;
use Asaa\Http\Request;
use Asaa\Http\Response;
use Asaa\Server\Server;
use Asaa\Database\Model;
use Asaa\Routing\Router;
use Asaa\Session\Session;
use Asaa\Validation\Rule;
use Asaa\View\AsaaEngine;
use Asaa\Server\PhpNativeServer;
use Asaa\Database\Drivers\PdoDriver;
use Asaa\Http\HttpNotFoundException;
use Asaa\Database\Drivers\DatabaseDriver;
use Asaa\Session\PhpNativeSessionStorage;
use Asaa\Validation\Exceptions\ValidationException;

/**
 * Clase App que representa la aplicación web.
 */
class App
{
    /**
    * Instancia del enrutador (Router) de la aplicación.
    *
    * @var Router
    */
    public Router $router;

    /**
     * Instancia de la solicitud HTTP actual (Request).
     *
     * @var Request
     */
    public Request $request;

    /**
     * Instancia del servidor HTTP (Server) utilizado en la aplicación.
     *
     * @var Server
     */
    public Server $server;

    public View $view;

    public Session $session;

    public DatabaseDriver $database;


    /**
     * Método estático para inicializar y configurar la aplicación.
     *
     * @return App La instancia de la aplicación configurada.
     */
    public static function bootstrap(): App
    {
        // Obtiene o crea una instancia única de la clase App utilizando el contenedor de dependencias (Container).
        $app = singleton(self::class);

        // Crea una nueva instancia del enrutador (Router) y la asigna a la propiedad $router de la aplicación.
        $app->router = new Router();

        // Crea una nueva instancia del servidor HTTP PhpNativeServer y la asigna a la propiedad $server de la aplicación.
        $app->server = new PhpNativeServer();

        // Obtiene la solicitud HTTP actual utilizando el servidor y la asigna a la propiedad $request de la aplicación.
        $app->request = $app->server->getRequest();

        $app->view = new AsaaEngine(__DIR__."/../views");

        $app->session = new Session(new PhpNativeSessionStorage());

        $app->database = new PdoDriver();

        $app->database->connect('mysql', 'localhost', 3306, 'proyecto_framework', 'root', '');

        Model::setDatabaseDriver($app->database);

        Rule::loadDefaultRules();

        // Retorna la instancia de la aplicación configurada.
        return $app;
    }

    public function prepareNextRequest()
    {
        if($this->request->method() == 'GET') {
            $this->session->set('_previous', $this->request->uri());
        }
    }

    public function terminate(Response $response)
    {
        $this->prepareNextRequest();
        $this->server->sendResponse($response);
        $this->database->close();
        exit();
    }

    /**
    * Método para ejecutar la aplicación web.
    *
    * @return void
    */
    public function run()
    {
        try {
            $this->terminate($this->router->resolve($this->request));
        } catch (HttpNotFoundException $e) {
            $this->abort(Response::text("Not found")->setStatus(404));
        } catch (ValidationException $e) {
            $this->abort(back()->withErrors($e->errors(), 422));
        } catch(Throwable $e) {
            $response = json([
                "error" => $e::class,
                "message" => $e->getMessage(),
                "trace" => $e->getTrace()
            ]);
            $this->abort($response->setStatus(500));
        }
    }

    public function abort(Response $response)
    {
        $this->terminate($response);
    }
}
