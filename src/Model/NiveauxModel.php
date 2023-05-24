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

    public function getSYNiveauxById(int $id): array
    {
        $stmt = $this->db->getPDO()
            ->prepare("SELECT * FROM niveaux WHERE as_id=?");

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getSYNiveauxByPeriod(string $period): array
    {
        $stmt = $this->db->getPDO()
            ->prepare("SELECT * FROM niveaux JOIN annee_scolaire ON annee_scolaire.id=as_id WHERE annee_scolaire.periode=? AND annee_scolaire.supprime=0");

        $stmt->execute([$period]);

        return $stmt->fetchAll();
    }

    public function getNiveauBySlug(string $period, string $slug)
    {
        $stmt = $this->db->getPDO()
            ->prepare("SELECT * FROM niveaux JOIN annee_scolaire ON periode=? WHERE slug=?");

        $stmt->execute([$period, $slug]);

        return $stmt->fetch();
    }

    public function niveausIsDeleted(string $period, string $slug): bool
    {
        $result = $this->getNiveauBySlug($period, $slug);

        if ($result) {
            return $result['supprime'] ? true : false;
        }

        return false;
    }

    public function getAll()
    {
        return $this->db->getPDO()->query("SELECT * FROM niveaux")->fetchAll();
    }

    public function getNiveauById(int $id): array
    {
        $stmt = $this->db->getPDO()
            ->prepare("SELECT id, libelle FROM niveaux WHERE id=?");

        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    public function getClasses(int $niveauxId)
    {
        $cm = new ClassesModel($this->db);

        return $cm->classes($niveauxId);
    }

    public function classeExist(int $niveauId, string $libelle)
    {
        return (new ClassesModel($this->db))->classeExist($niveauId, $libelle);
    }

    public function niveauExist(string $libelle)
    {
        $result = $this->getAll();

        foreach ($result as $r) {
            if ($r['libelle'] === $libelle)
                return true;
        }

        return false;
    }

    public function hasClass(int $id): bool
    {
        return count($this->getClasses($id)) > 0;
    }

    public function saveNiveau($data): bool
    {
        try {
            $this->db->getPDO()
                ->prepare("INSERT INTO niveaux(libelle) VALUES(?)")
                ->execute([$data['libelle']]);
            return true;
        }
        catch (\PDOException $e) {
            return false;
        }
    }
}
