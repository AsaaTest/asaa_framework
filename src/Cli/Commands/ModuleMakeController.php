<?php

namespace Asaa\Cli\Commands;

use Asaa\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Comando ModuleMakeController
 *
 * Este comando permite crear un nuevo controlador dentro de un módulo en la aplicación.
 * Utiliza una plantilla para generar el código del controlador y lo guarda en la carpeta "app/Modules/Module/Controllers".
 */
class ModuleMakeController extends Command
{
    protected static $defaultName = "module:make-controller";
    protected static $defaultDescription = "Create a new controller within a module";

    /**
     * Configura los argumentos del comando.
     *
     * Define el argumento "module" como requerido para especificar el nombre del módulo donde se creará el controlador.
     * Define el argumento "name" como requerido para especificar el nombre del nuevo controlador a crear.
     * Define la opcion "crud" (-crud) como opcional para generar los metodos basicos para un crud.
     */
    protected function configure()
    {
        $this->addArgument("module", InputArgument::REQUIRED, "Module name")
            ->addArgument("name", InputArgument::REQUIRED, "Controller name")
            ->addOption("crud", "crud", InputOption::VALUE_OPTIONAL, "Also create crud methods in controller", false);
    }

    /**
     * Ejecuta el comando ModuleMakeController.
     *
     * Crea un nuevo controlador en la carpeta "app/Modules/Module/Controllers" de la aplicación utilizando una plantilla.
     * El nombre del módulo se toma del argumento "module", y el nombre del controlador del argumento "name".
     * La plantilla se reemplaza con el nombre del controlador y se guarda en un archivo con el mismo nombre en "app/Modules/Module/Controllers".
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $module = $input->getArgument("module");
        $name = $input->getArgument("name");
        $crud = $input->getOption("crud");

        // Verificar si el módulo existe
        $modulePath = App::$root . "/modules/$module";
        if (!is_dir($modulePath)) {
            $output->writeln("<error>Module $module not found</error>");
            return Command::FAILURE;
        }

        // Crear la carpeta "Controllers" si no existe
        $controllersPath = App::$root . "/modules/$module/Controllers";
        if (!is_dir($controllersPath)) {
            mkdir($controllersPath, 0755, true);
        }

        // Leer la plantilla del controlador y reemplazar el nombre del controlador
        $template = file_get_contents(resourcesDirectory() . "/templates/controller.php");
        $template = str_replace("ControllerName", $name, $template);

        // Si se especificó la opción "crud", crear los métodos crud en el controlador
        if ($crud !== false) {
            $template = file_get_contents(resourcesDirectory() . "/templates/controllerResource.php");
            $template = str_replace("ControllerName", $name, $template);
        }

        // Crear el archivo del controlador en la carpeta del módulo
        file_put_contents("$controllersPath/$name.php", $template);
        $output->writeln("<info>Controller created => $module/$name.php</info>");

        // Retorna el código de éxito del comando
        return Command::SUCCESS;
    }
}
