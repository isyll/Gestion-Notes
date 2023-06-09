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

    public function getClasseNiveau(int $classeId)
    {
        return $this->db->pexec(
            'SELECT n.* FROM niveaux AS n
            JOIN classes AS c ON c.id_niveau = n.id
            AND c.id = ?',
            [$classeId],
            'fetch'
        );
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
            'SELECT 1 FROM classes WHERE libelle = ? AND supprime = 0',
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

    public function getStudents(int $classeId)
    {
        return $this->db->pexec(
            "SELECT e.* FROM eleves AS e
            JOIN inscriptions AS i ON i.id_eleve = e.id
            AND i.id_classe = ? WHERE e.supprime = 0",
            [$classeId],
            'fetchAll'
        );
    }

    public function hasStudent(int $classeId, int $studentId) : bool
    {
        return $this->db->pexec(
            "SELECT e.id FROM eleves AS e
            JOIN inscriptions AS i ON i.id_eleve = e.id AND i.id_classe = ?
            WHERE e.id = ?",
            [$classeId, $studentId],
            'fetchAll'
        ) ? true : false;
    }

    public function classeNiveauMatch(int $classeId, int $niveauId)
    {
        return $this->db->pexec(
            "SELECT 1 FROM classes WHERE id = ? AND id_niveau = ? AND supprime = 0",
            [$niveauId, $classeId],
            'fetch'
        ) ? true : false;
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

    public function deleteClasse(int $niveauId, int $classeId)
    {
        return $this->db->pexec(
            'UPDATE classes SET supprime = 1 WHERE id_niveau = ? AND id = ?',
            [$niveauId, $classeId]
        );
    }

    public function editClasse(int $id, string $newLibelle): bool
    {
        return $this->db->pexec(
            "UPDATE classes SET libelle = ? WHERE id = ?",
            [$newLibelle, $id]
        );
    }
}
