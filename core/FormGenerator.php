<?php

namespace Core;

class FormGenerator
{
    private array $datas;

    public function __construct(array $datas)
    {
        $this->datas = $datas;
    }

    private function generate()
    {

    }

    private function input(
        string $type = 'text',
        string $ph = ''
    )
    {
        $type = isset($type) ? "type=$type" : '';
        echo "<input $type placeholder=$ph/>";
    }
}
