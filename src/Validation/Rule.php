<?php

namespace Asaa\Validation;

use Asaa\Validation\Rules\Email;
use Asaa\Validation\Rules\Required;
use Asaa\Validation\Rules\RequiredWith;
use Asaa\Validation\Rules\ValidationRule;

class Rule
{
    public static function email(): ValidationRule
    {
        return new Email();
    }

    public static function required(): ValidationRule
    {
        return new Required();
    }

    public static function requiredWith(string $withField): ValidationRule
    {
        return new RequiredWith($withField);
    }
}
