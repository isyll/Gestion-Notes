<?php

namespace Core;

class FormValidator
{
    public static int $DEL_MULTIPLE_SPACES = 1;
    public static int $TO_LOWER_CASE = 2;

    private array $errors;
    private array $values;
    private array $rules;

    public function __construct(array $rules = [], array $values = [])
    {
        $this->values = $values;
        $this->rules  = $rules;
        $this->errors = [];
    }

    public function process(int $option, bool $value)
    {

    }

    public function rules(array $rules)
    {
        $this->rules = $rules;
    }

    public function values(array &$values)
    {
        $this->values = $values;
    }

    public function validate()
    {
        foreach ($this->rules as $field) {
            $rules = $field['rules'];
            $name  = $field['name'];
            $value = $this->values[$name] ?? '';

            if ($value === '') {
                if (array_search('required', $rules) !== false)
                    $this->errors[$name] = $rules['error_msg'];
                continue;
            }

            foreach ($rules as $k => $v) {
                if (!is_array($v))
                    continue;

                if ($k === 'min_length') {
                    if (strlen($value) < $v['value'])
                        $this->errors[$name] = $v['error_msg'];
                } elseif ($k === 'max_length') {
                    if (strlen($value) > $v['value'])
                        $this->errors[$name] = $v['error_msg'];
                } elseif ($k === 'type') {
                    if ($v['value'] === 'regex') {
                        if (!preg_match($v['regex'], $value)) {
                            $this->errors[$name] = $v['error_msg'];
                        }
                    } elseif ($v['value'] === 'set') {
                        if (!in_array($value, $v['set_values'])) {
                            $this->errors[$name] = $v['error_msg'];
                        }
                    } elseif (!$this->validateType($v['value'], $value))
                        $this->errors[$name] = $v['error_msg'];
                }

            }
        }
    }

    public function getErrors(): array|bool
    {
        if (count($this->errors) > 0)
            return $this->errors;
        return false;
    }

    private function validateType(string $type, $value)
    {
        switch ($type) {
            case 'number':
                return is_numeric($value);
            case 'email':
                return filter_var($value, FILTER_VALIDATE_EMAIL) ? true : false;
            case 'phone':
                return preg_match('/^[0-9\s()+-]*$/', $value);
            case 'alphanum':
                return preg_match('/^[A-Za-z0-9]+$/', $value);
            case 'alpha':
                return preg_match('/^[A-Za-z]+$/', $value);
            default:
                return true;
        }
    }
}
