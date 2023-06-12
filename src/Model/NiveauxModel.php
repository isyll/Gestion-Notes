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

    public function getNiveaux()
    {
        return $this->db->pexec(
            'SELECT * FROM niveaux WHERE supprime = 0',
            [],
            'fetchAll'
        );
    }

    public function getNiveauById(int $id): array
    {
        return $this->db->pexec(
            "SELECT * FROM niveaux WHERE id = ? AND supprime = 0",
            [$id],
            'fetch'
        );
    }

    public function niveauIdExists(int $id): bool
    {
        return $this->db->pexec(
            'SELECT 1 FROM niveaux WHERE id = ? AND supprime = 0',
            [$id],
            'fetch'
        ) ? true : false;
    }

    public function niveauLibelleExists(string $libelle): bool
    {
        return $this->db->pexec(
            'SELECT 1 FROM niveaux WHERE libelle = ? AND supprime = 0',
            [$libelle],
            'fetch'
        ) ? true : false;
    }

    public function getClasses(int $niveauId)
    {
        return $this->db->pexec(
            "SELECT * FROM classes WHERE id_niveau = ? AND supprime = 0",
            [$niveauId],
            'fetchAll'
        );
    }

    public function hasClasseLibelle(int $niveauId, string $classeLibelle): bool
    {
        return $this->db->pexec(
            'SELECT 1 FROM classes, niveaux WHERE classes.libelle = ? AND classes.id = ? AND classes.supprime = 0 AND niveaux.supprime = 0',
            [$niveauId, $classeLibelle],
            'fetch'
        ) ? true : false;
    }

    public function hasClasseId(int $niveauId, int $classeId): bool
    {
        return $this->db->pexec(
            'SELECT 1 FROM classes, niveaux WHERE classes.id_niveau = ? AND classes.id = ? AND classes.supprime = 0 AND niveaux.supprime = 0',
            [$niveauId, $classeId],
            'fetch'
        ) ? true : false;
    }

    public function saveNiveau(array $datas): bool
    {
        return $this->db->pexec(
            "INSERT INTO niveaux(libelle, nom_cycle, nb_cycles) VALUES(?, ?, ?)",
            [
                $datas['niveauLibelle'],
                $datas['cycleName'],
                $datas['cyclesNumber'],
            ]
        );
    }

    public function deleteNiveau(int $id): bool
    {
        return $this->db->pexec(
            "UPDATE niveaux SET supprime = 1 WHERE id = ?",
            [$id]
        );
    }

    public function editNiveau(array $datas): bool
    {
        return $this->db->pexec(
            "UPDATE niveaux SET libelle = ?, nom_cycle = ?, nb_cycles = ? WHERE id = ?",
            [
                $datas['newNiveauLibelle'],
                $datas['cycleName'],
                $datas['cyclesNumber'],
                $datas['niveauId'],
            ]
        );
    }
}