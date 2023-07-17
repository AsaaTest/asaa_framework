<?php

// Define el espacio de nombres para las clases de pruebas del enrutador.
namespace Asaa\Tests\Routing;

// Importa las clases necesarias para las pruebas.

use Asaa\Http\Request;
use Asaa\Server\Server;
use Asaa\Routing\Router;
use PHPUnit\Framework\TestCase;

// Clase de pruebas para el enrutador (Router).
class RouterTest extends TestCase
{
    // Función auxiliar para crear una instancia simulada de solicitud (MockRequest).
    // Esta función toma una URI y un método HTTP y devuelve una instancia de Request con un servidor simulado (MockServer).
    private function createMockRequest(string $uri, string $method): Request
    {
        // Crea una instancia simulada de Server utilizando PHPUnit's getMock().
        $mock = $this->getMockBuilder(Server::class)->getMock();
        
        // Configura el comportamiento simulado de los métodos de Server para devolver la URI y el método HTTP proporcionados.
        $mock->method('requestUri')->willReturn($uri);
        $mock->method('requestMethod')->willReturn($method);

        // Crea una instancia de Request utilizando el servidor simulado.
        return new Request($mock);
    }

    /**
     * Prueba para resolver una ruta básica con una acción de devolución de llamada.
     */
    public function test_resolve_basic_route_with_callback_action()
    {
        // Define la URI de la ruta a probar.
        $uri = '/test';

        // Define la acción de devolución de llamada para la ruta.
        // En este caso, es una función anónima que simplemente devuelve "test".
        $action = fn () => "test";

        // Crea una nueva instancia del enrutador.
        $router = new Router();

        // Registra la ruta y su acción asociada en el enrutador utilizando el método "get".
        $router->get($uri, $action);

        // Resuelve la ruta utilizando un objeto de solicitud simulado (MockRequest) que contiene la URI y el método HTTP (GET).
        $route = $router->resolve($this->createMockRequest($uri, 'GET'));

        // Verifica que la ruta resuelta tenga la misma URI y acción que las registradas previamente.
        $this->assertEquals($uri, $route->uri());
        $this->assertEquals($action, $route->action());
    }

    /**
     * Prueba para resolver múltiples rutas básicas con acciones de devolución de llamada.
     */
    public function test_resolve_multiple_basic_routes_with_callback_action()
    {
        // Define un arreglo de rutas y sus acciones de devolución de llamada para la prueba.
        $routes = [
            '/test' => fn () => "test",
            '/foo' => fn () => "foo",
            '/bar' => fn () => "bar",
            '/long/nested/route' => fn () => "long nested route"
        ];

        // Crea una nueva instancia del enrutador.
        $router = new Router();

        // Registra todas las rutas con sus acciones asociadas en el enrutador utilizando el método "get".
        foreach ($routes as $uri => $action) {
            $router->get($uri, $action);
        }

        // Resuelve cada ruta utilizando un objeto de solicitud simulado (MockRequest) que contiene la URI y el método HTTP (GET).
        foreach ($routes as $uri => $action) {
            $route = $router->resolve($this->createMockRequest($uri, 'GET'));

            // Verifica que cada ruta resuelta tenga la misma URI y acción que las registradas previamente.
            $this->assertEquals($uri, $route->uri());
            $this->assertEquals($action, $route->action());
        }
    }

    /**
     * Prueba para resolver múltiples rutas básicas con acciones de devolución de llamada
     * para diferentes métodos HTTP.
     */
    public function test_resolve_multiple_basic_routes_with_callback_action_for_different_http_methods()
    {
        // Define un arreglo de rutas con sus acciones de devolución de llamada y métodos HTTP para la prueba.
        $routes = [
            ['GET', '/test', fn () => "get"],
            ['POST', '/test', fn () => "post"],
            ['PUT', '/test', fn () => "put"],
            ['PATCH', '/test', fn () => "patch"],
            ['DELETE', '/test', fn () => "delete"],
            ['GET', '/random/test', fn () => "get"],
            ['POST', '/random/nested/test', fn () => "post"],
            ['PUT', '/put/random/route', fn () => "put"],
            ['PATCH', '/some/pathc/route', fn () => "patch"],
            ['DELETE', '/d', fn () => "delete"]
        ];

        // Crea una nueva instancia del enrutador.
        $router = new Router();

        // Registra todas las rutas con sus acciones asociadas y métodos HTTP en el enrutador utilizando los métodos "get", "post", etc.
        foreach ($routes as [$method, $uri, $action]) {
            $router->{strtolower($method)}($uri, $action);
        }

        // Resuelve cada ruta utilizando un objeto de solicitud simulado (MockRequest) que contiene la URI y el método HTTP correspondiente.
        foreach ($routes as [$method, $uri, $action]) {
            $route = $router->resolve($this->createMockRequest($uri, $method));

            // Verifica que cada ruta resuelta tenga la misma URI y acción que las registradas previamente.
            $this->assertEquals($uri, $route->uri());
            $this->assertEquals($action, $route->action());
        }
    }
}
