<?php

namespace Asaa\container;

/**
 * Clase Container para gestionar y resolver las instancias de las clases.
 */
class Container
{
    /**
     * Almacena las instancias de las clases singleton creadas.
     *
     * @var array
     */
    private static array $instances = [];

    /**
     * Resuelve una instancia de una clase como singleton.
     *
     * Si la instancia de la clase ya ha sido creada, la retorna.
     * Si la instancia no existe, la crea y la almacena para futuras referencias.
     *
     * @param string $class El nombre de la clase a resolver como singleton.
     * @return object|null Una instancia de la clase si existe o null si no existe.
     */
    public static function singleton(string $class, string|callable|null $build = null)
    {
        // Verifica si la instancia de la clase ya existe en el arreglo $instances.
        if (!array_key_exists($class, self::$instances)) {
            // Si no existe, crea una nueva instancia de la clase utilizando la reflexión de PHP.
            // La instancia de la clase se almacena en el arreglo $instances para futuras referencias.
            match (true) {
                is_null($build) => self::$instances[$class] = new $class(),
                is_string($build) => self::$instances[$class] = new $build(),
                is_callable($build) => self::$instances[$class] = $build(),
            };
        }

        // Retorna la instancia de la clase.
        return self::$instances[$class];
    }

    /**
     * Resuelve una instancia de una clase.
     *
     * Retorna la instancia de la clase si ya ha sido creada y almacenada en el arreglo $instances.
     * Si la instancia no existe, retorna null.
     *
     * @param string $class El nombre de la clase a resolver.
     * @return object|null Una instancia de la clase si existe o null si no existe.
     */
    public static function resolve(string $class)
    {
        // Retorna la instancia de la clase si existe en el arreglo $instances, de lo contrario, retorna null.
        return self::$instances[$class] ?? null;
    }
}
