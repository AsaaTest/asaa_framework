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
            // Intenta resolver la ruta utilizando el enrutador y la solicitud HTTP actual.
            $route = $this->router->resolve($this->request);

            // Asigna la ruta resuelta a la propiedad $route de la solicitud HTTP actual.
            $this->request->setRoute($route);

            // Obtiene la acción asociada a la ruta resuelta.
            $action = $route->action();

            // Ejecuta la acción pasando la solicitud HTTP actual como argumento y obtiene la respuesta.
            $response = $action($this->request);

            // Envía la respuesta al cliente utilizando el servidor.
            $this->server->sendResponse($response);
        } catch (HttpNotFoundException $e) {
            // Si no se encuentra ninguna ruta coincidente, muestra un mensaje de "Not Found" y establece el código de respuesta HTTP a 404.
            $response = Response::text("Not Found")->setStatus(404);
            $this->server->sendResponse($response);
        }
    }
}
