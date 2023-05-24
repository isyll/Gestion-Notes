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

    public function getName(int $id)
    {
        $stmt = $this->db->getPDO()
            ->prepare("SELECT libelle FROM classes WHERE id=?");

        $stmt->execute([$id]);

        return $stmt->fetchAll();
    }

    public function classes(int $niveauId)
    {
        $stmt = $this->db->getPDO()
            ->prepare("SELECT * FROM classes WHERE id_niveau=?");

        $stmt->execute([$niveauId]);

        return $stmt->fetchAll();
    }

    public function getClasses(string $period, string $niveauSlug)
    {
        return $this->db->pexec(
            "SELECT classes.* FROM classes
            JOIN niveaux AS nv ON nv.id = classes.id_niveau AND nv.slug = ?
            JOIN annee_scolaire AS ans ON ans.periode = ?
            WHERE classes.supprime = 0",
            [$niveauSlug, $period],
            'fetchAll'
        );
    }

    public function getNiveauId($period, $niveauSlug)
    {
        return $this->db->pexec(
            "SELECT niveaux.id
            FROM annee_scolaire, niveaux
            WHERE periode = ?
            AND annee_scolaire.id = as_id
            AND slug = ?",
            [$period, $niveauSlug],
            'fetch'
        );
    }

    public function saveClasse(
        string $libelleClasse,
        string $classeSlug,
        int $niveauId
    ): bool {
        return $this->db->pexec(
            "INSERT INTO classes(libelle, slug, id_niveau) VALUES(?, ?, ?)",
            [$libelleClasse, $classeSlug, $niveauId]
        );
    }

    public function classeExist(int $niveauId, string $libelleClasse): bool
    {
        $stmt = $this->db->getPDO()
            ->prepare("SELECT libelle FROM classes WHERE id_niveau=? AND libelle=?");

        $stmt->execute([$niveauId, $libelleClasse]);

        return count($stmt->fetchAll()) > 0;
    }
}
