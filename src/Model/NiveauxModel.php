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
        return $this->db->getPDO()->query("SELECT libelle FROM niveaux")->fetchAll();
    }

    public function getAll()
    {
        return $this->db->getPDO()->query("SELECT id, libelle FROM niveaux")->fetchAll();
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
        $result = $this->getNiveaux();

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
