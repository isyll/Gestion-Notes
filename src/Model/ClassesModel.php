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

    public function getClassesByNiveau(int $id)
    {
        return $this->db->pexec(
            'SELECT * FROM classes WHERE id_niveau = ? AND supprime = 0',
            [$id],
            'fetchAll'
        );
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
            "SELECT * FROM classes WHERE id = ? AND supprime = 0",
            [$id],
            'fetch'
        );
    }

    public function getStudents(int $id)
    {
        return $this->db->pexec(
            "SELECT * FROM eleves AS e
            JOIN inscriptions AS i ON i.id_eleve = e.id
            JOIN classes AS c ON c.id = i.id_classe AND c.id = ?",
            [$id],
            'fetchAll'
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
