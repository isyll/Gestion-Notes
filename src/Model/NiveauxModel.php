<?php

namespace App\Model;

use Core\Database;

class NiveauxModel
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }
}
