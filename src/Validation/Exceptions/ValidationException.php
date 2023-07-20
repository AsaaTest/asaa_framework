<?php

namespace Asaa\Validation\Exceptions;

use Asaa\Exceptions\AsaaException;

class ValidationException extends AsaaException
{
    public function __construct(protected array $errors)
    {
        $this->errors = $errors;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
