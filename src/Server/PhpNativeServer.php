<?php

// Define el espacio de nombres para la clase PhpNativeServer.

namespace Asaa\Server;

// Importa la clase de respuesta (Response) del espacio de nombres Asaa\Http.
use Asaa\Http\Response;

// Clase PhpNativeServer que implementa la interfaz Server.
class PhpNativeServer implements Server
{
    /**
     * Obtiene la URI (Uniform Resource Identifier) de la solicitud actual.
     *
     * @return string URI de la solicitud actual.
     */
    public function requestUri(): string
    {
        // Utiliza la función parse_url para obtener la URI de la solicitud actual
        // a partir del valor almacenado en $_SERVER["REQUEST_URI"].
        // PHP_URL_PATH se utiliza para obtener la ruta de la URI y excluir la parte de la consulta (query).
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    /**
     * Obtiene el método HTTP de la solicitud actual.
     *
     * @return string Método HTTP de la solicitud actual (por ejemplo, GET, POST, PUT, etc.).
     */
    public function requestMethod(): string
    {
        // Retorna el valor almacenado en $_SERVER["REQUEST_METHOD"],
        // que indica el método HTTP utilizado en la solicitud actual.
        return $_SERVER["REQUEST_METHOD"];
    }

    /**
     * Obtiene los datos enviados en la solicitud actual (en caso de una solicitud POST).
     *
     * @return array Datos enviados en la solicitud actual.
     */
    public function postData(): array
    {
        // Retorna el arreglo $_POST, que contiene los datos enviados en la solicitud actual
        // cuando se utiliza el método HTTP POST.
        // En una solicitud GET u otros métodos HTTP, este arreglo estará vacío.
        return $_POST;
    }

    /**
     * Obtiene los parámetros de la consulta (query parameters) de la solicitud actual.
     *
     * @return array Parámetros de la consulta de la solicitud actual.
     */
    public function queryParams(): array
    {
        // Retorna el arreglo $_GET, que contiene los parámetros de la consulta (query parameters)
        // de la URI en la solicitud actual.
        // Los parámetros de consulta son pares clave-valor que se encuentran después del signo "?" en la URI.
        // Por ejemplo, en la URI "/page?param1=value1&param2=value2", $_GET contendría:
        // ["param1" => "value1", "param2" => "value2"]
        return $_GET;
    }

    /**
     * Envía la respuesta (Response) al cliente.
     *
     * @param Response $response La respuesta que se enviará al cliente.
     * @return void
     */
    public function sendResponse(Response $response)
    {
        // Establece el encabezado "Content-Type" a "None" para evitar que PHP establezca automáticamente
        // el tipo de contenido en la respuesta. Esto permite que la clase de respuesta (Response) tenga
        // control total sobre los encabezados HTTP.
        header("Content-Type: None");

        // Elimina cualquier encabezado "Content-Type" que haya sido configurado automáticamente por PHP,
        // ya que la clase de respuesta (Response) será responsable de establecer el encabezado adecuado.
        header_remove("Content-Type");

        // Prepara la respuesta para su envío, lo cual puede incluir el procesamiento de encabezados adicionales,
        // contenido, etc., según lo definido en la clase de respuesta (Response).
        $response->prepare();

        // Establece el código de respuesta HTTP en la respuesta enviada.
        http_response_code($response->status());

        // Establece los encabezados adicionales de la respuesta enviada, que fueron configurados en la clase de respuesta (Response).
        foreach ($response->headers() as $header => $value) {
            header("$header: $value");
        }

        // Imprime el contenido de la respuesta en la página.
        print($response->content());
    }
}
