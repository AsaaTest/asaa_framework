<?php

return [
    /**
     * Método de cifrado de contraseñas (Hashing)
     * 
     * Esta opción especifica el método de cifrado de contraseñas que se utilizará en la aplicación.
     * El valor por defecto es 'bcrypt', lo que indica que se utilizará el algoritmo bcrypt para cifrar las contraseñas.
     * Puedes personalizar esta opción para utilizar otros métodos de cifrado de contraseñas, como Argon2, SHA256, etc.
     */
    'hasher' => 'bcrypt',
];
