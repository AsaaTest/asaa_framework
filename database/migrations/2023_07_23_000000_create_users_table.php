<?php

use Asaa\Database\DB;
use Asaa\Database\Migrations\Migration;

// Definición de la migración utilizando una clase anónima que implementa la interfaz Migration
return new class() implements Migration {
    // Método "up" para crear la tabla "users" y sus columnas
    public function up() {
        // Utiliza el objeto de la clase DB para ejecutar una sentencia SQL para crear la tabla "users"
        DB::statement('CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(256),
            email VARCHAR(256),
            password VARCHAR(256),
            created_at DATETIME,
            updated_at DATETIME NULL
            )');
    }

    // Método "down" para revertir la migración y eliminar la tabla "users"
    public function down(){
        // Utiliza el objeto de la clase DB para ejecutar una sentencia SQL para eliminar la tabla "users"
        DB::statement('DROP TABLE users');
    }
};
