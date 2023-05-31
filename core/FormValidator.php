<?php

namespace Core;

class FormValidator
{
    public static int $DEL_MULTIPLE_SPACES = 1;
    public static int $DEL_ALL_SPACES = 2;
    public static int $TO_LOWER_CASE = 3;
    public static bool $toLowerCase = true;

    private array $errors;
    private array $values;
    private array $rules;

    public function __construct(array $rules = [], array $values = [])
    {
        $this->values = $values;
        $this->rules  = $rules;
        $this->errors = [];
    }

    public function form(array $rules, array &$values)
    {
        $this->rules = $rules;
        $this->process($values);
        $this->values = $values;
    }

    public function validate()
    {
        foreach ($this->rules as $field) {
            $rules = $field['rules'];
            $name  = $field['name'];
            $value = $this->values[$name] ?? NULL;

            if (!$value) {
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
                } elseif ($k === 'regex') {
                    if (!preg_match($v['value'], $value)) {
                        $this->errors[$name] = $v['error_msg'];
                    }
                } elseif ($k === 'type') {
                    if ($v['value'] === 'set') {
                        if (!in_array($value, $v['set_values'], true)) {
                            $this->errors[$name] = $v['error_msg'];
                        }
                    } elseif ($v['value'] === 'date') {
                        if (strtotime($value) === false)
                            $this->errors[$name] = $v['error_msg'];
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

    private function process(array &$datas)
    {
        foreach ($this->rules as $field) {
            if ($process = $field['process'] ?? false) {
                if (in_array('del_all_spaces', $process))
                    $datas[$field['name']] = Helpers::rms($datas[$field['name']]);
                if (in_array('del_multiple_spaces', $process))
                    $datas[$field['name']] = Helpers::rmms($datas[$field['name']]);
                if (in_array('to_lower_case', $process))
                    $datas[$field['name']] = strtolower($datas[$field['name']]);
                if (in_array('to_upper_case', $process))
                    $datas[$field['name']] = strtoupper($datas[$field['name']]);
                if (in_array('capitalize', $process))
                    $datas[$field['name']] = ucwords($datas[$field['name']]);
            }

            if ($datas[$field['name']] == '')
                $datas[$field['name']] = NULL;
        }

        return $datas;
    }
}
