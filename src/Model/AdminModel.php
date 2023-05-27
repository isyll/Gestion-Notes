<?php

namespace App\Model;

use Core\Database;

class AdminModel
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function saveUser(array $datas)
    {
        return $this->db->pexec(
            'INSERT INTO comptes(prenom, nom, email, telephone, type, password_hash, hash_algorithm) VALUES(?,?,?,?,?,?,?)',
            [
                $datas['firstname'],
                $datas['lastname'],
                $datas['email'],
                $datas['phone'],
                $datas['type'],
                $datas['password_hash'],
                $datas['hash_algorithm'],
            ]
        );
    }
}
