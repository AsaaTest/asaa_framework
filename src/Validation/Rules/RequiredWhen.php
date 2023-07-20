<?php

namespace Asaa\Validation\Rules;

class RequiredWhen
{
    public function __construct(
        private string $otherField,
        private string $operator,
        private string $compareWith
    ) {
        $this->otherField = $otherField;
        $this->operator = $operator;
        $this->compareWith = $compareWith;
    }

    public function message(): string
    {
        return "This field is required when $this->otherField $this->operator $this->compareWith";
    }

    public function isValid($field, $data): bool
    {
        if (!array_key_exists($this->otherField, $data)) {
            return false;
        }

        $isRequired = match ($this->operator) {
            "=" => $data[$this->otherField] == $this->compareWith,
            ">" => $data[$this->otherField] > floatval($this->compareWith),
            "<" => $data[$this->otherField] < floatval($this->compareWith),
            ">=" => $data[$this->otherField] >= floatval($this->compareWith),
            "<=" => $data[$this->otherField] <= floatval($this->compareWith),
        };

        return !$isRequired || isset($data[$field]) && $data[$field] != "";
    }
}