<?php

use Asaa\Database\Drivers\DatabaseDriver;
use Asaa\Database\Drivers\PdoDriver;
use Asaa\Database\Migrations\Migrator;
require_once "./vendor/autoload.php";

$driver = singleton(DatabaseDriver::class, PdoDriver::class);
$driver->connect('mysql', 'localhost', 3306, 'proyecto_framework', 'root', '');
$migrator = new Migrator(__DIR__. "/database/migrations",__DIR__. "/templates", $driver);

if($argv[1] == "make:migration"){
    $migrator->make($argv[2]);
}else if($argv[1] == "migrate"){
    $migrator->migrate();
}else if($argv[1] == "rollback"){
    $step = null;
    if(count($argv) == 4 && $argv[2] == "--step"){
        $step = $argv[3];
    }
        $migrator->rollback($step);
}