<?php

// Define el espacio de nombres para la interfaz Server.

namespace Asaa\Server;

// Importa la clase de respuesta (Response) del espacio de nombres Asaa\Http.
use Asaa\Http\Response;

// Interfaz Server que define los métodos para obtener información de una solicitud HTTP.
interface Server
{
    /**
     * Obtiene la URI (Uniform Resource Identifier) de la solicitud actual.
     *
     * @return string URI de la solicitud actual.
     */
    public function requestUri(): string;

    /**
     * Obtiene el método HTTP de la solicitud actual.
     *
     * @return string Método HTTP de la solicitud actual (por ejemplo, GET, POST, PUT, etc.).
     */
    public function requestMethod(): string;

    /**
     * Obtiene los datos enviados en la solicitud actual (en caso de una solicitud POST).
     *
     * @return array Datos enviados en la solicitud actual.
     */
    public function postData(): array;

    /**
     * Obtiene los parámetros de la consulta (query parameters) de la solicitud actual.
     *
     * @return array Parámetros de la consulta de la solicitud actual.
     */
    public function queryParams(): array;

    /**
     * Envía la respuesta (Response) al cliente.
     *
     * @param Response $response La respuesta que se enviará al cliente.
     * @return void
     */
    public function sendResponse(Response $response);
}
