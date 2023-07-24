<?php

namespace Asaa\Cli;

use Asaa\App;
use Asaa\Cli\Commands\MakeController;
use Asaa\Cli\Commands\MakeMigration;
use Asaa\Cli\Commands\MakeModel;
use Asaa\Cli\Commands\Migrate;
use Asaa\Cli\Commands\MigrateRollback;
use Asaa\Cli\Commands\Serve;
use Dotenv\Dotenv;
use Asaa\Config\Config;
use Asaa\Database\Drivers\DatabaseDriver;
use Asaa\Database\Migrations\Migrator;
use Symfony\Component\Console\Application;

class Cli
{
    public static function bootstrap(string $root): self
    {
        App::$root = $root;
        Dotenv::createImmutable($root)->load();
        Config::load($root. "/config");
        foreach(config("providers.cli") as $provider) {
            (new $provider())->registerServices();
        }

        app(DatabaseDriver::class)->connect(
            config("database.connection"),
            config("database.host"),
            config("database.port"),
            config("database.database"),
            config("database.username"),
            config("database.password")
        );
        singleton(
            Migrator::class,
            fn () => new Migrator(
                "$root/database/migrations",
                resourcesDirectory() . "/templates",
                app(DatabaseDriver::class)
            )
        );
        return new self();
    }

    public function run()
    {
        $cli = new Application("Asaa");

        $cli->addCommands([
            new MakeMigration(),
            new Migrate(),
            new MigrateRollback(),
            new MakeController(),
            new MakeModel(),
            new Serve()
        ]);

        $cli->run();
    }
}