<?php

namespace Asaa;

use Asaa\container\Container;
use Asaa\Http\Request;
use Asaa\Http\Response;
use Asaa\Server\Server;
use Asaa\Routing\Router;
use Asaa\Server\PhpNativeServer;
use Asaa\Http\HttpNotFoundException;

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


    /**
     * Método estático para inicializar y configurar la aplicación.
     *
     * @return App La instancia de la aplicación configurada.
     */
    public static function bootstrap(): App
    {
        // Obtiene o crea una instancia única de la clase App utilizando el contenedor de dependencias (Container).
        $app = Container::singleton(self::class);

        // Crea una nueva instancia del enrutador (Router) y la asigna a la propiedad $router de la aplicación.
        $app->router = new Router();

        // Crea una nueva instancia del servidor HTTP PhpNativeServer y la asigna a la propiedad $server de la aplicación.
        $app->server = new PhpNativeServer();

        // Obtiene la solicitud HTTP actual utilizando el servidor y la asigna a la propiedad $request de la aplicación.
        $app->request = $app->server->getRequest();

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
            $response = Response::text("Not found")->setStatus(404);
            $this->server->sendResponse($response);
        }
    }
}
