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

        // Verifica si la ruta tiene middlewares configurados.
        if ($route->hasMiddlewares()) {
            // Si hay middlewares, ejecuta la función "runMiddlewares()" para procesarlos.
            return $this->runMiddlewares($request, $route->middlewares(), $action);
        }

        // Si no hay middlewares, ejecuta la acción principal directamente y devuelve la respuesta generada por ella.
        return $action($request);
    }

    protected function runMiddlewares(Request $request, array $middlewares, $target): Response
    {
        if (count($middlewares) == 0) {
            return $target($request);
        }
        return $middlewares[0]->handle(
            $request,
            fn ($request) => $this->runMiddlewares($request, array_slice($middlewares, 1), $target)
        );
    }

    /**
     * Registra una ruta con su acción correspondiente para un método HTTP específico.
     *
     * @param string $method El método HTTP de la ruta (GET, POST, PUT, PATCH, DELETE).
     * @param string $uri La URI de la ruta.
     * @param Closure $action La acción a ejecutar cuando la ruta coincida.
     * @return Route
     */
    protected function registerRoute(string $method, string $uri, Closure $action): Route
    {
        $route = new Route($uri, $action);
        // Crea un nuevo objeto "Route" con la URI y la acción proporcionadas y lo agrega al array de rutas.
        $this->routes[$method][] = $route;
        return $route;
    }

    /**
     * Registra una nueva ruta con su acción correspondiente para el método GET.
     *
     * @param string $uri La URI de la ruta.
     * @param Closure $action La acción a ejecutar cuando la ruta coincida.
     * @return Route
     */
    public function get(string $uri, Closure $action): Route
    {
        return $this->registerRoute('GET', $uri, $action);
    }

    /**
     * Registra una nueva ruta con su acción correspondiente para el método POST.
     *
     * @param string $uri La URI de la ruta.
     * @param Closure $action La acción a ejecutar cuando la ruta coincida.
     * @return Route
     */
    public function post(string $uri, Closure $action): Route
    {
        return $this->registerRoute('POST', $uri, $action);
    }

    /**
     * Registra una nueva ruta con su acción correspondiente para el método PUT.
     *
     * @param string $uri La URI de la ruta.
     * @param Closure $action La acción a ejecutar cuando la ruta coincida.
     * @return Route
     */
    public function put(string $uri, Closure $action): Route
    {
        return $this->registerRoute('PUT', $uri, $action);
    }

    /**
     * Registra una nueva ruta con su acción correspondiente para el método PATCH.
     *
     * @param string $uri La URI de la ruta.
     * @param Closure $action La acción a ejecutar cuando la ruta coincida.
     * @return Route
     */
    public function patch(string $uri, Closure $action): Route
    {
        return $this->registerRoute('PATCH', $uri, $action);
    }

    /**
     * Registra una nueva ruta con su acción correspondiente para el método DELETE.
     *
     * @param string $uri La URI de la ruta.
     * @param Closure $action La acción a ejecutar cuando la ruta coincida.
     * @return Route
     */
    public function delete(string $uri, Closure $action): Route
    {
        return $this->registerRoute('DELETE', $uri, $action);
    }


}
