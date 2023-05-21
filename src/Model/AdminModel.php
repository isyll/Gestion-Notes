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

    public function getYears() {
        return $this->db->getPDO()
            ->query('SELECT periode FROM annee_scolaire;')->fetchAll();
    }

    public function saveYear($data) : bool
    {
        try {
            $this->db->getPDO()
                ->prepare("INSERT INTO annee_scolaire(periode) VALUES(?)")
                ->execute([$data['period']]);
            return true;
        }
        catch (\PDOException $e) {
            return false;
        }
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
