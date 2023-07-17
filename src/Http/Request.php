<?php

// Define el espacio de nombres para la clase Request.

namespace Asaa\Http;

use Asaa\Server\Server;

// Clase Request que representa una solicitud HTTP.
class Request
{
    // Propiedades de la clase para almacenar la URI, el método HTTP, los datos enviados y los parámetros de consulta.
    protected string $uri;
    protected string $method;
    protected array $data;
    protected array $query;

    /**
     * Constructor de la clase Request.
     * Recibe un objeto que implementa la interfaz Server como parámetro.
     * Utiliza dicho objeto para obtener la información de la solicitud HTTP y almacenarla en las propiedades de la clase.
     *
     * @param Server $server Objeto que implementa la interfaz Server.
     */
    public function __construct(Server $server)
    {
        // Obtiene la URI, el método HTTP, los datos enviados y los parámetros de consulta utilizando el objeto Server recibido.
        // Luego, los almacena en las propiedades de la clase para su uso posterior.
        $this->uri = $server->requestUri();
        $this->method = $server->requestMethod();
        $this->data = $server->postData();
        $this->query = $server->queryParams();
    }

    /**
     * Obtiene la URI de la solicitud HTTP.
     *
     * @return string URI de la solicitud HTTP.
     */
    public function uri(): string
    {
        // Retorna el valor de la propiedad $uri, que contiene la URI de la solicitud HTTP.
        return $this->uri;
    }

    /**
     * Obtiene el método HTTP de la solicitud HTTP.
     *
     * @return string Método HTTP de la solicitud HTTP (por ejemplo, GET, POST, PUT, etc.).
     */
    public function method(): string
    {
        // Retorna el valor de la propiedad $method, que contiene el método HTTP de la solicitud HTTP.
        return $this->method;
    }

    public function data(): array
    {
        return $this->data;
    }

    public function query(): array
    {
        return $this->query;
    }
}
