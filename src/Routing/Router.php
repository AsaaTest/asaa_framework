<?php

namespace Asaa\Routing;

use Closure;

use Asaa\Http\Request;
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
    public function resolve(Request $request)
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
     * Registra una nueva ruta con su acción correspondiente para el método GET.
     *
     * @param string $uri La URI de la ruta.
     * @param Closure $action La acción a ejecutar cuando la ruta coincida.
     */
    public function get(string $uri, Closure $action)
    {
        $this->registerRoute('GET', $uri, $action);
    }

    /**
     * Registra una nueva ruta con su acción correspondiente para el método POST.
     *
     * @param string $uri La URI de la ruta.
     * @param Closure $action La acción a ejecutar cuando la ruta coincida.
     */
    public function post(string $uri, Closure $action)
    {
        $this->registerRoute('POST', $uri, $action);
    }

    /**
     * Registra una nueva ruta con su acción correspondiente para el método PUT.
     *
     * @param string $uri La URI de la ruta.
     * @param Closure $action La acción a ejecutar cuando la ruta coincida.
     */
    public function put(string $uri, Closure $action)
    {
        $this->registerRoute('PUT', $uri, $action);
    }

    /**
     * Registra una nueva ruta con su acción correspondiente para el método PATCH.
     *
     * @param string $uri La URI de la ruta.
     * @param Closure $action La acción a ejecutar cuando la ruta coincida.
     */
    public function patch(string $uri, Closure $action)
    {
        $this->registerRoute('PATCH', $uri, $action);
    }

    /**
     * Registra una nueva ruta con su acción correspondiente para el método DELETE.
     *
     * @param string $uri La URI de la ruta.
     * @param Closure $action La acción a ejecutar cuando la ruta coincida.
     */
    public function delete(string $uri, Closure $action)
    {
        $this->registerRoute('DELETE', $uri, $action);
    }

    /**
     * Registra una ruta con su acción correspondiente para un método HTTP específico.
     *
     * @param string $method El método HTTP de la ruta (GET, POST, PUT, PATCH, DELETE).
     * @param string $uri La URI de la ruta.
     * @param Closure $action La acción a ejecutar cuando la ruta coincida.
     */
    protected function registerRoute(string $method, string $uri, Closure $action)
    {
        // Crea un nuevo objeto "Route" con la URI y la acción proporcionadas y lo agrega al array de rutas.
        $this->routes[$method][] = new Route($uri, $action);
    }
}
