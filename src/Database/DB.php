<?php

namespace Asaa\Database;

class DB
{
    public static function statement(string $query, array $bind = [])
    {
        return app()->database->statement($query, $bind);
    }
}