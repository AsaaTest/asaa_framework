<?php

namespace Asaa\Validation\Rules;

class RequiredWith implements ValidationRule
{
    protected string $withField;

    public function __construct(string $withField)
    {
        $this->withField = $withField;
    }

    public function message(): string
    {
        return "The :attribute field is required when :other {$this->withField} is :value.";
    }

    public function isValid(string $field, array $data): bool
    {
        if(isset($data[$this->withField]) && $data[$this->withField] != "") {
            return isset($data[$field]) && $data[$field] != "";
        }

        return true;
    }



}
