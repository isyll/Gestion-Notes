<?php

namespace App\Model;

use Core\Database;

class SchoolYearsModel
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getYearByLibelle(string $libelle)
    {
        return $this->db->pexec(
            'SELECT * FROM annees_scolaires WHERE libelle = ? AND supprime=0',
            [$libelle],
            'fetch'
        );
    }

    public function getYearById(int $id)
    {
        return $this->db->pexec(
            'SELECT * FROM annees_scolaires WHERE id = ? AND supprime=0',
            [$id],
            'fetch'
        );
    }

    public function updateYearById(int $id, string $newLibelle)
    {
        return $this->db->pexec(
            "UPDATE annees_scolaires SET libelle = ? WHERE id = ?",
            [$newLibelle, $id]
        );
    }

    public function updateYearByLibelle(string $oldLibelle, string $newLibelle)
    {
        return $this->db->pexec(
            "UPDATE annees_scolaires SET libelle = ? WHERE libelle = ?",
            [$newLibelle, $oldLibelle]
        );
    }

    public function getYears()
    {
        return $this->db->pexec(
            "SELECT * FROM annees_scolaires WHERE supprime=0",
            [],
            'fetchAll'
        );
    }

    public function yearLibelleExists(string $libelle): bool
    {
        return $this->db->pexec(
            "SELECT 1 FROM annees_scolaires WHERE libelle = ?",
            [$libelle],
            'fetch'
        ) ? true : false;
    }

    public function yearIdExists(int $id): bool
    {
        return $this->db->pexec(
            "SELECT 1 FROM annees_scolaires WHERE id = ?",
            [$id],
            'fetch'
        ) ? true : false;
    }

    public function deleteYearById(int $id)
    {
        return $this->db->pexec(
            'UPDATE annees_scolaires SET supprime=1 WHERE id = ?',
            [$id],
        );
    }

    public function deleteYearByLibelle(string $libelle)
    {
        return $this->db->pexec(
            'UPDATE annees_scolaires SET supprime=1 WHERE libelle = ?',
            [$libelle],
        );
    }

    public function restoreYearById(int $id)
    {
        return $this->db->pexec(
            'UPDATE annees_scolaires SET supprime=0 WHERE id = ?',
            [$id],
        );
    }

    public function restoreYearByLibelle(string $libelle)
    {
        return $this->db->pexec(
            'UPDATE annees_scolaires SET supprime=0 WHERE libelle = ?',
            [$libelle],
        );
    }

    public function saveYear(array $data): bool
    {
        return $this->db->pexec(
            "INSERT INTO annees_scolaires(libelle) VALUES(?)",
            [$data['libelle']],
        );
    }

    public function editYear(int $id, array $data): bool
    {
        return $this->db->pexec(
            "UPDATE annees_scolaires SET libelle = ? WHERE id = ?",
            [$data['libelle'], $id],
        );
    }
}
