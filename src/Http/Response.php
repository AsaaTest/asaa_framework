<?php

namespace Asaa\Http;

use Asaa\App;
use Asaa\container\Container;

/**
 * Clase Response que representa una respuesta HTTP.
 * Esta clase almacena información relevante sobre la respuesta que será enviada al cliente, como el código de estado HTTP, los encabezados y el contenido.
 */
class Response
{
    protected int $status = 200; // Código de estado HTTP predeterminado.
    protected array $headers = []; // Encabezados de la respuesta.
    protected ?string $content = null; // Contenido de la respuesta (puede ser nulo).

    /**
     * Obtiene el código de estado HTTP de la respuesta.
     *
     * @return int Código de estado HTTP.
     */
    public function status(): int
    {
        return $this->status;
    }

    /**
     * Establece el código de estado HTTP de la respuesta.
     *
     * @param int $status Código de estado HTTP a establecer.
     * @return self
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Obtiene los encabezados (headers) de la respuesta.
     *
     * @param string|null $key La clave del encabezado a obtener (opcional).
     * @return array|string|null Los encabezados de la respuesta o un encabezado específico si se proporciona la clave.
     */
    public function headers(?string $key = null): array|string|null
    {
        if (is_null($key)) {
            return $this->headers;
        }

        return $this->headers[strtolower($key)] ?? null;
    }

    /**
     * Establece un encabezado (header) específico en la respuesta.
     *
     * @param string $header Nombre del encabezado (header) a establecer.
     * @param string $value Valor del encabezado (header) a establecer.
     * @return self
     */
    public function setHeader(string $header, string $value): self
    {
        $this->headers[strtolower($header)] = $value;
        return $this;
    }

    /**
     * Elimina un encabezado (header) específico de la respuesta.
     *
     * @param string $header Nombre del encabezado (header) a eliminar.
     * @return void
     */
    public function removeHeader(string $header)
    {
        unset($this->headers[strtolower($header)]);
    }

    /**
     * Establece el encabezado "Content-Type" en la respuesta.
     *
     * @param string $value Valor del encabezado "Content-Type".
     * @return self
     */
    public function setContentType(string $value): self
    {
        $this->setHeader("Content-Type", $value);
        return $this;
    }

    /**
     * Obtiene el contenido de la respuesta.
     *
     * @return string|null Contenido de la respuesta.
     */
    public function content(): ?string
    {
        return $this->content;
    }

    /**
     * Establece el contenido de la respuesta.
     *
     * @param string $content Contenido a establecer en la respuesta.
     * @return self
     */
    public function setcontent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Prepara la respuesta antes de enviarla al cliente.
     *
     * Este método ajusta los encabezados de la respuesta según el contenido.
     * Si el contenido es nulo, se eliminan los encabezados "Content-Type" y "Content-Length".
     * Si el contenido tiene valor, se establece el encabezado "Content-Length" con la longitud del contenido.
     *
     * @return void
     */
    public function prepare()
    {
        if (is_null($this->content)) {
            $this->removeHeader("Content-Type");
            $this->removeHeader("Content-Length");
        } else {
            $this->setHeader("Content-Length", strlen($this->content));
        }
    }

    /**
     * Crea una nueva instancia de la clase Response con contenido en formato JSON.
     *
     * @param array $data Arreglo de datos a convertir a formato JSON.
     * @return self Instancia de la clase Response con contenido en formato JSON.
     */
    public static function json(array $data): self
    {
        return (new self())
            ->setContentType("application/json")
            ->setcontent(json_encode($data));
    }

    /**
     * Crea una nueva instancia de la clase Response con contenido de texto plano.
     *
     * @param string $text Texto a establecer como contenido.
     * @return self Instancia de la clase Response con contenido de texto plano.
     */
    public static function text(string $text): self
    {
        return (new self())
            ->setContentType("text/plain")
            ->setcontent($text);
    }

    /**
     * Crea una nueva instancia de la clase Response para redirigir a otra URI.
     *
     * @param string $uri URI a la que se debe redirigir.
     * @return self Instancia de la clase Response para redirección.
     */
    public static function redirect(string $uri): self
    {
        return (new self())
            ->setStatus(302)
            ->setHeader("Location", $uri);
    }

    public static function view(string $viewName, array $params = [], $layout = null): self
    {
        $content = app()->view->render($viewName, $params, $layout);
        return (new self())
            ->setContentType("text/html")
            ->setContent($content);
    }
}
