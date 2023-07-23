<?php

use Asaa\App;
use Asaa\container\Container;

function app($class = App::class)
{
    return Container::resolve($class);
}


function singleton(string $class, string|callable|null $build = null)
{
    return Container::singleton($class, $build);
}
