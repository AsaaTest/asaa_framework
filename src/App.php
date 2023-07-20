<?php

namespace Asaa;

use Asaa\View\View;
use Asaa\Http\Request;
use Asaa\Http\Response;
use Asaa\Server\Server;
use Asaa\Routing\Router;
use Asaa\View\AsaaEngine;
use Asaa\container\Container;
use Asaa\Server\PhpNativeServer;
use Asaa\Http\HttpNotFoundException;
use Asaa\Validation\Exceptions\ValidationException;
use Throwable;

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

        // Retorna la instancia de la aplicación configurada.
        return $app;
    }

    /**
    * Método para ejecutar la aplicación web.
    *
    * @return void
    */
    public function run()
    {
        try {
            $response = $this->router->resolve($this->request);
            $this->server->sendResponse($response);
        } catch (HttpNotFoundException $e) {
            $this->abort(Response::text("Not found")->setStatus(404));
        } catch (ValidationException $e) {
            $this->abort(json($e->errors())->setStatus(422));
        } catch(Throwable $e) {
            $response = json([
                "message" => $e->getMessage(),
                "trace" => $e->getTrace()
            ]);
            $this->abort($response);
        }
    }

    public function abort(Response $response)
    {
        $this->server->sendResponse($response);
    }
}
