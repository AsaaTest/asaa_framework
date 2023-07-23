<?php

namespace Asaa\Providers;

use Asaa\Crypto\Bcrypt;
use Asaa\Crypto\Hasher;

class HasherServiceProvider implements ServiceProvider
{
    public function registerServices()
    {
        match (config('hashing.hasher', 'bcrypt')) {
            "bcrypt" => singleton(Hasher::class, Bcrypt::class)
        };
    }
}
