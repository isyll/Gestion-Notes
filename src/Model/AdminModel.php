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
        $this->db->getPDO()->query("BEGIN");

        $this->db->getPDO()->prepare("INSERT INTO personnes(email, prenoms, nom, adresse, telephone, type) VALUES(?,?,?,?,?,?)")
            ->execute(
                [
                    $datas['email'],
                    $datas['firstname'],
                    $datas['lastname'],
                    $datas['address'],
                    $datas['phone'],
                    'user'
                ]
            );

        $this->db->getPDO()->prepare("INSERT INTO accounts(personne_id, username, type, password_hash, hash_algorithm) VALUES(?,?,?,?,?)")
            ->execute(
                [
                    $this->db->getPDO()->lastInsertId(),
                    $datas['username'],
                    'user',
                    $datas['passwordHash'],
                    $datas['hash']
                ]
            );

        $this->db->getPDO()->query("COMMIT");
    }
}
