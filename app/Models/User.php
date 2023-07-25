<?php

namespace App\Models;

use Asaa\Auth\Authenticatable;

class User extends Authenticatable
{
    protected array $hidden = ['password'];

    protected array $fillable = [
        'id',
        'name',
        'email',
        'password'
    ];
}
