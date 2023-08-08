<?php

namespace Asaa\Cli\Commands;

use Asaa\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Comando MakeModule
 *
 * Este comando permite crear un nuevo módulo en la aplicación.
 */
class MakeModule extends Command
{
    protected static $defaultName = "make:module";
    protected static $defaultDescription = "Create a new module";

    /**
     * Configura los argumentos del comando.
     *
     * Define el argumento "name" como requerido para especificar el nombre del nuevo módulo a crear.
     */
    protected function configure()
    {
        $this->addArgument("name", InputArgument::REQUIRED, "Module name");
    }

    /**
     * Ejecuta el comando MakeModule.
     *
     * Crea una nueva carpeta para el módulo en la carpeta "app/Modules" de la aplicación.
     * El nombre del módulo se toma del argumento "name".
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $moduleName = $input->getArgument("name");
        $modulePath = App::$root . "/modules/$moduleName";

        // Verificar si el módulo ya existe
        if (is_dir($modulePath)) {
            $output->writeln("<error>Module $moduleName already exists</error>");
            return Command::FAILURE;
        }
        mkdir($modulePath, 0755, true);
        mkdir($modulePath . '/Controllers', 0755, true);
        mkdir($modulePath . '/Models', 0755, true);
        mkdir($modulePath . '/Providers', 0755, true);
        mkdir($modulePath . '/routes', 0755, true);
        mkdir($modulePath . '/Views', 0755, true);
        // Crear el archivo RouteServiceProvider dentro de Providers
        $routeServiceProviderContent = '<?php
namespace Modules\\' . $moduleName . '\Providers;

use Asaa\App;
use Asaa\Routing\Route;
use Asaa\Providers\ServiceProvider;

class RouteServiceProvider implements ServiceProvider 
{
    public function registerServices() 
    {
        Route::load(App::$root . "/modules/' . $moduleName . '/routes");
    }
}';
        file_put_contents($modulePath . '/Providers/RouteServiceProvider.php', $routeServiceProviderContent);
        $templateController = file_get_contents(resourcesDirectory() . "/templates/controllerResource.php");
        $controllerName = $moduleName . 'Controller';
        $templateController = str_replace("ControllerName", $controllerName, $templateController);
        file_put_contents($modulePath . "/Controllers/$controllerName.php", $templateController);
        // Crear la carpeta del módulo en "app/Modules"
        $output->writeln("<info>Module created => $moduleName</info>");

        // Retorna el código de éxito del comando.
        return Command::SUCCESS;
    }
}
