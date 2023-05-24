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
        $stmt = $this->db->getPDO()
            ->prepare("SELECT classes.*
            FROM classes, niveaux, annee_scolaire
            WHERE niveaux.slug = ?
            AND annee_scolaire.periode = ?
            AND classes.id_niveau = niveaux.id
            AND annee_scolaire.id = niveaux.as_id");

        $stmt->execute([$niveauSlug, $period]);

        return $stmt->fetchAll();
    }

    public function getNiveauId($period, $niveauSlug)
    {
        return $this->db->pexec(
            "SELECT annee_scolaire.id FROM annee_scolaire, niveaux
            WHERE periode = ?
            AND annee_scolaire.id = as_id
            AND slug = ?",
            [$period, $niveauSlug],
            'fetch'
        );
    }

    public function saveClasse(array $datas): bool
    {
        return $this->db->pexec(
            "INSERT INTO classes(libelle, id_niveau) VALUES(?, ?)",
            [$datas['libelleClasse'], $datas['niveauId']]
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
