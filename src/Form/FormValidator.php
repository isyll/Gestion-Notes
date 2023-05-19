<?php

namespace App\Form;

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
                $this->validateRequired($field);
            }
            if ($field['type'] === 'numeric') {
                $this->validateNumeric($field);
            }
            if (!empty($field['regex'])) {
                $this->validateRegex($field);
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

    private function validateRegex(array $data)
    {
        if (!preg_match($data['regex'], $data['']))
            $this->addError($data['name'], "Le champs {$data['name']} est invalide");
    }

    private function validateRequired(array $data)
    {
        if (empty($data['value']))
            $this->addError($data['name'], "Le champs {$data['name']} est obligatoire");
    }

    private function validateNumeric(array $data)
    {
        if (!is_numeric($data['value']))
            $this->addError($data['name'], "Le champs {$data['name']} doit être de type numérique}");
    }
}