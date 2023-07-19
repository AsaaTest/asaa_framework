<?php

use Asaa\Http\Request;
use Asaa\Http\Response;

function json(array $data): Response
{
    return Response::json($data);
}


function redirect(string $uri): Response
{
    return Response::redirect($uri);
}

function view(string $viewName, array $params = [], $layout = null): Response
{
    return Response::view($viewName, $params, $layout);
}

function request(): Request
{
    return app()->request;
}
