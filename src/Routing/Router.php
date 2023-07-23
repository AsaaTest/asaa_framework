<?php

namespace Asaa\Routing;

use Closure;

use Asaa\Http\Request;
use Asaa\Http\Response;
use Asaa\Routing\Route;
use Asaa\Http\HttpNotFoundException;

class Router
{
    // Array que almacenará las rutas registradas, agrupadas por métodos HTTP.
    protected array $routes = [];

    /**
     * Resuelve la ruta y el método HTTP para obtener la acción correspondiente.
     *
     * @param string $uri La URI solicitada.
     * @param string $method El método HTTP de la solicitud (GET, POST, PUT, PATCH, DELETE).
     * @return Route $route La ruta que coincide con la URI y el método.
     * @throws HttpNotFoundException Si no se encuentra ninguna acción para la ruta y el método especificados.
     */
    public function resolveRoute(Request $request): Route
    {
        // Iterar sobre las rutas registradas para el método HTTP específico.
        foreach ($this->routes[$request->method()] as $route) {
            // Comprobar si la ruta coincide con la URI solicitada utilizando el método "matches" de la clase "Route".
            if ($route->matches($request->uri())) {
                return $route; // Devuelve la ruta que coincide.
            }
        }

        // Si no se encuentra ninguna ruta coincidente, lanzar una excepción "HttpNotFoundException".
        throw new HttpNotFoundException();
    }

    /**
     * Resuelve la ruta asociada a la solicitud y ejecuta la acción correspondiente.
     * Si la ruta tiene middlewares configurados, los ejecuta antes de la acción principal.
     *
     * @param Request $request La solicitud HTTP entrante.
     * @return Response Respuesta generada por la acción principal o por los middlewares.
     */
    public function resolve(Request $request): Response
    {
        // Resuelve la ruta asociada a la solicitud utilizando el método "resolveRoute()" del enrutador.
        $route = $this->resolveRoute($request);

        // Asigna la ruta resuelta al objeto de solicitud para que pueda ser accedida por otros componentes.
        $request->setRoute($route);

        // Obtiene la acción asociada a la ruta resuelta.
        $action = $route->action();

        if(is_array($action)) {
            $controller = new $action[0]();
            $action[0] = $controller;
        }

        return $this->runMiddlewares($request, $route->middlewares(), fn () => call_user_func($action, $request));

    }

    protected function runMiddlewares(Request $request, array $middlewares, $target): Response
    {
        if (count($middlewares) == 0) {
            return $target();
        }
        return $middlewares[0]->handle(
            $request,
            fn ($request) => $this->runMiddlewares($request, array_slice($middlewares, 1), $target)
        );
    }


    protected function registerRoute(string $method, string $uri, Closure|array $action): Route
    {
        $route = new Route($uri, $action);
        // Crea un nuevo objeto "Route" con la URI y la acción proporcionadas y lo agrega al array de rutas.
        $this->routes[$method][] = $route;
        return $route;
    }


    public function get(string $uri, Closure|array $action): Route
    {
        return $this->registerRoute('GET', $uri, $action);
    }


    public function post(string $uri, Closure|array $action): Route
    {
        return $this->registerRoute('POST', $uri, $action);
    }


    public function put(string $uri, Closure|array $action): Route
    {
        return $this->registerRoute('PUT', $uri, $action);
    }


    public function patch(string $uri, Closure|array $action): Route
    {
        return $this->registerRoute('PATCH', $uri, $action);
    }

    public function delete(string $uri, Closure|array $action): Route
    {
        return $this->registerRoute('DELETE', $uri, $action);
    }


}
