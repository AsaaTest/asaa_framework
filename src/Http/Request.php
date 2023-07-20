<?php

// Define el espacio de nombres para la clase Request.

namespace Asaa\Http;

use Asaa\Routing\Route;
use Asaa\Validation\Validator;

/**
 * Clase Request que representa una solicitud HTTP.
 * Esta clase almacena información relevante sobre la solicitud realizada al servidor, como la URI, el método HTTP, los datos enviados y los parámetros de consulta.
 */
class Request
{
    // Propiedades de la clase Request.
    protected string $uri; // La URI de la solicitud.
    protected Route $route; // Ruta coincidente con la URI.
    protected string $method; // Método HTTP utilizado para esta solicitud.
    protected array $data; // Datos enviados en la solicitud (para solicitudes POST).
    protected array $query; // Parámetros de la consulta (query parameters).
    protected array $headers = []; // Encabezados de la solicitud.

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
     * Obtiene los encabezados de la solicitud.
     *
     * @param string|null $key La clave del encabezado a obtener (opcional).
     * @return array|string|null Los encabezados de la solicitud o un encabezado específico si se proporciona la clave.
     */
    public function headers(?string $key = null): array|string|null
    {
        if (is_null($key)) {
            return $this->headers;
        }

        return $this->headers[strtolower($key)] ?? null;
    }

    /**
     * Establece los encabezados de la solicitud.
     *
     * @param array $headers Los encabezados a establecer.
     * @return self
     */
    public function setHeaders(array $headers): self
    {
        foreach ($headers as $header => $value) {
            $this->headers[strtolower($header)] = $value;
        }

        return $this;
    }

    /**
     * Obtiene los datos enviados en la solicitud (para solicitudes POST).
     *
     * @param string|null $key La clave de los datos a obtener (opcional).
     * @return array|string|null Los datos enviados en la solicitud o un dato específico si se proporciona la clave.
     */
    public function data(?string $key = null): array|string|null
    {
        if (is_null($key)) {
            return $this->data;
        }

        return $this->data[$key] ?? null;
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
     * @param string|null $key La clave del parámetro a obtener (opcional).
     * @return array|string|null Los parámetros de consulta de la solicitud o un parámetro específico si se proporciona la clave.
     */
    public function query(?string $key = null): array|string|null
    {
        if (is_null($key)) {
            return $this->query;
        }

        return $this->query[$key] ?? null;
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
     * @param string|null $key La clave del parámetro de la ruta a obtener (opcional).
     * @return array|string|null Un arreglo asociativo donde las claves son los nombres de los parámetros de la ruta y los valores son sus valores extraídos de la URI de la solicitud, o un valor específico si se proporciona la clave.
     */
    public function routeParameters(?string $key = null): array|string|null
    {
        $parameters = $this->route->parseParameters($this->uri);

        if (is_null($key)) {
            return $parameters;
        }

        return $parameters[$key] ?? null;
    }

    public function validate(array $rules, array $messages = []): array
    {
        $validator = new Validator($this->data);

        return $validator->validate($rules, $messages);
    }
}
