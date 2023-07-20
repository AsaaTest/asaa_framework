<?php

namespace Asaa\Validation;

use Asaa\Validation\Rules\Email;
use Asaa\Validation\Rules\LessThan;
use Asaa\Validation\Rules\Number;
use Asaa\Validation\Rules\Required;
use Asaa\Validation\Rules\RequiredWhen;
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

    public static function number(): ValidationRule
    {
        return new Number();
    }

    public static function lessThan(float $value): ValidationRule
    {
        return new LessThan($value);
    }

    public static function requiredWhen(string $otherField, string $operator, int|float $value): ValidationRule
    {
        return new RequiredWhen($otherField, $operator, $value);
    }

}
