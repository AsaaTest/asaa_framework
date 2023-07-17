<?php

// Define el espacio de nombres para la clase Request.

namespace Asaa\Http;

use Asaa\Routing\Route;

/**
 * Clase Request que representa una solicitud HTTP.
 * Esta clase almacena información relevante sobre la solicitud realizada al servidor, como la URI, el método HTTP, los datos enviados y los parámetros de consulta.
 */
class Request
{
    protected string $uri; // La URI de la solicitud.
    protected Route $route; // Ruta coincidente con la URI.
    protected string $method; // Método HTTP utilizado para esta solicitud.
    protected array $data; // Datos enviados en la solicitud (para solicitudes POST).
    protected array $query; // Parámetros de la consulta (query parameters).

    /**
     * Obtiene la URI de la solicitud.
     *
     * @return string La URI de la solicitud.
     */
    public function uri(): string
    {
        return $this->uri;
    }

    /**
     * Establece la URI de la solicitud.
     *
     * @param string $uri La URI a establecer.
     * @return self
     */
    public function setUri(string $uri): self
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * Obtiene la ruta coincidente con la URI de esta solicitud.
     *
     * @return Route La ruta coincidente con la URI de esta solicitud.
     */
    public function route(): Route
    {
        return $this->route;
    }

    /**
     * Establece la ruta para esta solicitud.
     *
     * @param Route $route La ruta a establecer.
     * @return self
     */
    public function setRoute(Route $route): self
    {
        $this->route = $route;
        return $this;
    }

    /**
     * Obtiene el método HTTP de la solicitud.
     *
     * @return string El método HTTP de la solicitud.
     */
    public function method(): string
    {
        return $this->method;
    }

    /**
     * Establece el método HTTP de la solicitud.
     *
     * @param string $method El método HTTP a establecer.
     * @return self
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Obtiene los datos enviados en la solicitud (para solicitudes POST).
     *
     * @return array Los datos enviados en la solicitud.
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * Establece los datos enviados en la solicitud (para solicitudes POST).
     *
     * @param array $data Los datos a establecer en la solicitud.
     * @return self
     */
    public function setPostData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Obtiene los parámetros de consulta (query parameters).
     *
     * @return array Los parámetros de consulta de la solicitud.
     */
    public function query(): array
    {
        return $this->query;
    }

    /**
     * Establece los parámetros de consulta (query parameters).
     *
     * @param array $query Los parámetros de consulta a establecer.
     * @return self
     */
    public function setQueryParameters(array $query): self
    {
        $this->query = $query;
        return $this;
    }

    /**
     * Obtiene todos los parámetros de la ruta.
     *
     * @return array Un arreglo asociativo donde las claves son los nombres de los parámetros de la ruta y los valores son sus valores extraídos de la URI de la solicitud.
     */
    public function routeParameters(): array
    {
        return $this->route->parseParameters($this->uri);
    }
}
