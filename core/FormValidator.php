<?php

namespace Core;

class FormValidator
{
    private array $datas;
    private array $errors;

    public function __construct(array $datas = [])
    {
        $this->form($datas);
        $this->errors = [];
    }

    public function form(array $datas)
    {
        $this->datas = $datas;
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
            if ($field['type'] === 'email') {
                $this->email($field);
            }
            if ($field['type'] === 'alphanum') {
                $this->alphaNum($field);
            }
            if ($field['type'] === 'chars_only') {
                $this->charsOnly($field);
            }
            if ($field['type'] === 'set') {
                $this->inArray($field);
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

    private function email(array $field)
    {
        if (!filter_var($field['value'], FILTER_VALIDATE_EMAIL))
            $this->addError($field['name'], $field['error_msg'] ?? '');
    }

    private function inArray(array $field)
    {
        if (!in_array($field['value'], $field['set_values']))
            $this->addError($field['name'], $field['error_msg'] ?? '');
    }

    private function errorTest(bool $condition, string $name, string $error): void
    {
        if ($condition)
            $this->addError($name, $error);
    }

    private function charsOnly(array $field): void
    {
        if (!preg_match('/^[A-Za-z]+$/', $field['value']))
            $this->addError($field['name'], $field['error_msg'] ?? '');
    }

    private function alphaNum(array $field): void
    {
        if (!preg_match('/^[A-Za-z0-9]+$/', $field['value']))
            $this->addError($field['name'], $field['error_msg'] ?? '');
    }

    private function regex(array $field)
    {
        if (!preg_match($field['regex'], $field['value']))
            $this->addError($field['name'], $field['error_msg'] ?? '');
    }

    private function required(array $field)
    {
        if (empty($field['value']))
            $this->addError($field['name'], $field['error_msg'] ?? '');
    }

    private function numeric(array $field)
    {
        if (!is_numeric($field['value']))
            $this->addError($field['name'], $field['error_msg'] ?? '');
    }

    private function minLength(array $field)
    {
        $this->errorTest(
            strlen($field['value']) < $field['min_length'],
            $field['name'],
            $field['error_msg'] ?? ''
        );
    }

    private function maxLength(array $field)
    {
        $this->errorTest(
            strlen($field['value']) > $field['max_length'],
            $field['name'],
            $field['error_msg'] ?? ''
        );
    }
}
