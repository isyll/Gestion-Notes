<?php

namespace App\Model;

use Core\Database;

class SubjectsModel
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getGroups()
    {
        return $this->db->pexec(
            'SELECT * FROM groupes_disciplines',
            [],
            'fetchAll'
        );
    }

    public function groupNameExists(string $name): bool
    {
        return $this->db->pexec(
            'SELECT 1 FROM groupes_disciplines WHERE nom = ?',
            [$name],
            'fetch'
        ) ? true : false;
    }

    public function saveGroup(array $data)
    {
        return $this->db->pexec(
            'INSERT INTO groupes_disciplines(nom) VALUES(?)',
            [$data['groupName']],
        ) ? true : false;
    }
}
