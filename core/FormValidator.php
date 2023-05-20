<?php

namespace Core;

class FormValidator
{
    private array $datas;
    private array $errors;

    public function __construct(array $datas)
    {
        $this->datas  = $datas;
        $this->errors = [];
    }

    public function validate()
    {
        foreach ($this->datas as $field) {
            if ($field['required']) {
                $this->required($field);
            } else if (empty($field['value']))
                continue;

            $field['type'] = $field['type'] ?? 'string';

            if ($field['type'] === 'numeric') {
                $this->numeric($field);
            }
            if ($field['type'] === 'alphanum') {
                $this->alphaNum($field);
            }
            if ($field['type'] === 'chars_only') {
                $this->charsOnly($field);
            }
            if (!empty($field['regex'])) {
                $this->regex($field);
            }
            if (!empty($field['min_length'])) {
                $this->minLength($field);
            }
            if (!empty($field['max_length'])) {
                $this->maxLength($field);
            }
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function addError($name, $error)
    {
        $this->errors[$name] = $error;
    }

    private function errorTest(bool $condition, string $name, string $error): void
    {
        if ($condition)
            $this->addError($name, $error);
    }

    private function charsOnly(array $field): void
    {
        if (!preg_match('/^[A-Za-z]+$/', $field['value']))
            $this->addError($field['name'], "Le champs {$field['name']} est invalide");
    }

    private function alphaNum(array $field): void
    {
        if (!preg_match('/^[A-Za-z0-9]+$/', $field['value']))
            $this->addError($field['name'], "Le champs {$field['name']} est invalide");
    }

    private function regex(array $field)
    {
        if (!preg_match($field['regex'], $field['value']))
            $this->addError($field['name'], "Le champs {$field['name']} est invalide");
    }

    private function required(array $field)
    {
        if (empty($field['value']))
            $this->addError($field['name'], "Le champs {$field['name']} est obligatoire");
    }

    private function numeric(array $field)
    {
        if (!is_numeric($field['value']))
            $this->addError($field['name'], "Le champs {$field['name']} doit être de type numérique}");
    }

    private function minLength(array $field)
    {
        $this->errorTest(
            strlen($field['value']) < $field['min_length'],
            $field['name'],
            "Le champs {$field['name']} est inférieure à la taille minimale ({$field['min_length']})"
        );
    }

    private function maxLength(array $field)
    {
        $this->errorTest(
            strlen($field['value']) > $field['max_length'],
            $field['name'],
            "Le champs {$field['name']} dépasse la taille maximale ({$field['max_length']})"
        );
    }
}
