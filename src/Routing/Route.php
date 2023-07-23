<?php

namespace Asaa\Routing;

class Route
{
    protected string $uri; // La URI de la ruta.
    protected \Closure|array $action; // La acción asociada a la ruta.
    protected string $regex; // Expresión regular generada a partir de la URI para hacer coincidencias.
    protected array $parameters; // Lista de parámetros extraídos de la URI.
    protected array $middlewares = [];

    /**
     * Constructor de la clase Route.
     *
     * @param string $uri La URI de la ruta.
     * @param \Closure $action La acción asociada a la ruta.
     */
    public function __construct(string $uri, \Closure|array $action)
    {
        $this->uri = $uri;
        $this->action = $action;

        // Genera una expresión regular a partir de la URI que reemplaza los segmentos
        // de la forma {param} por ([a-zA-Z0-9]+), lo que permite hacer coincidencias.
        $this->regex = preg_replace('/\{([a-zA-Z]+)\}/', '([a-zA-Z0-9]+)', $uri);

        // Extrae los nombres de los parámetros de la URI y los almacena en la propiedad $parameters.
        preg_match_all('/\{([a-zA-Z]+)\}/', $uri, $parameters);
        $this->parameters = $parameters[1];
    }

    /**
     * Obtiene la URI de la ruta.
     *
     * @return string La URI de la ruta.
     */
    public function uri()
    {
        return $this->uri;
    }

    /**
     * Obtiene la acción asociada a la ruta.
     *
     * @return \Closure La acción asociada a la ruta.
     */
    public function action(): \Closure|array
    {
        return $this->action;
    }


    public function middlewares(): array
    {
        return $this->middlewares;
    }

    public function setMiddlewares(array $middlewares): self
    {
        $this->middlewares = array_map(fn ($middleware) => new $middleware(), $middlewares);
        return $this;
    }

    public function hasMiddlewares(): bool
    {
        return count($this->middlewares) > 0;
    }


    /**
     * Comprueba si la URI dada coincide con la ruta.
     *
     * @param string $uri La URI a comparar con la ruta.
     * @return bool True si hay coincidencia, False en caso contrario.
     */
    public function matches(string $uri): bool
    {
        // Utiliza la expresión regular generada previamente para verificar si la URI coincide con la ruta.
        return preg_match("#^$this->regex/?$#", $uri);
    }

    /**
     * Verifica si la ruta tiene parámetros.
     *
     * @return bool True si la ruta tiene parámetros, False en caso contrario.
     */
    public function hasParameters(): bool
    {
        return count($this->parameters) > 0;
    }

    /**
     * Extrae y devuelve los valores de los parámetros de la URI.
     *
     * @param string $uri La URI de la ruta.
     * @return array Un arreglo asociativo donde las claves son los nombres de los parámetros y los valores son sus valores extraídos de la URI.
     */
    public function parseParameters(string $uri): array
    {
        // Utiliza la expresión regular generada previamente para extraer los valores de los parámetros de la URI.
        preg_match("#^$this->regex$#", $uri, $arguments);

        // Combina los nombres de los parámetros con los valores extraídos y devuelve un arreglo asociativo.
        return array_combine($this->parameters, array_slice($arguments, 1));
    }

    public static function load(string $routesDirectory)
    {
        foreach(glob("$routesDirectory/*.php") as $routes) {
            require_once $routes;
        }
    }


    public static function get(string $uri, \Closure|array $action): Route
    {
        // Se utiliza el contenedor de dependencias (Container) para resolver la instancia de la clase App.
        // Luego, se accede al enrutador (router) de la instancia de la clase App y se agrega la ruta HTTP GET.
        return app()->router->get($uri, $action);
    }


    public static function post(string $uri, \Closure|array $action): Route
    {
        // Se utiliza el contenedor de dependencias (Container) para resolver la instancia de la clase App.
        // Luego, se accede al enrutador (router) de la instancia de la clase App y se agrega la ruta HTTP GET.
        return app()->router->post($uri, $action);
    }

    public static function put(string $uri, \Closure|array $action): Route
    {
        return app()->router->put($uri, $action);
    }

    public static function delete(string $uri, \Closure|array $action): Route
    {
        return app()->router->delete($uri, $action);
    }

}
