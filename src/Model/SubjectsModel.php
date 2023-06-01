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
            'SELECT * FROM groupes_disciplines WHERE supprime = 0',
            [],
            'fetchAll'
        );
    }

    public function getGroupByName(string $name)
    {
        return $this->db->pexec(
            'SELECT * FROM groupes_disciplines WHERE nom = ? AND supprime = 0',
            [$name],
            'fetch'
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

    public function groupIdExists(int $id): bool
    {
        return $this->db->pexec(
            'SELECT 1 FROM groupes_disciplines WHERE id = ?',
            [$id],
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

    public function editGroup(int $id, array $data)
    {
        return $this->db->pexec(
            'UPDATE groupes_disciplines SET nom = ? WHERE id = ?',
            [$data['groupName'], $id],
        ) ? true : false;
    }

    public function deleteGroupById(int $id)
    {
        return $this->db->pexec(
            'UPDATE groupes_disciplines SET supprime = 1 WHERE id = ?',
            [$id],
        );
    }

    public function restoreGroupById(int $id)
    {
        return $this->db->pexec(
            'UPDATE groupes_disciplines SET supprime = 0 WHERE id = ?',
            [$id],
        );
    }
}
