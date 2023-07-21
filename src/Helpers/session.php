<?php

use Asaa\Session\Session;

function session(): Session
{
    return app()->session;
}
