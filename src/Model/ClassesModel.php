<?php

namespace App\Model;

use Core\Database;

class ClassesModel
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function classeIdExists(int $id)
    {
        return $this->db->pexec(
            'SELECT 1 FROM classes WHERE id = ?',
            [$id],
            'fetch'
        ) ? true : false;
    }

    public function classeLibelleExists(string $libelle)
    {
        return $this->db->pexec(
            'SELECT 1 FROM classes WHERE libelle = ?',
            [$libelle],
            'fetch'
        ) ? true : false;
    }

    public function getClasseById(int $id)
    {
        return $this->db->pexec(
            "SELECT * FROM classes WHERE id = ?",
            [$id],
            'fetch'
        );
    }

    public function saveClasse(
        string $classeLibelle,
        int $niveauId
    ): bool {
        return $this->db->pexec(
            "INSERT INTO classes(libelle,  id_niveau) VALUES(?, ?)",
            [$classeLibelle, $niveauId]
        );
    }
}
