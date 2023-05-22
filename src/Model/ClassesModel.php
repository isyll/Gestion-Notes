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

    public function saveClasse(array $datas): bool
    {
        try {
            $this->db->getPDO()
                ->prepare("INSERT INTO classes(libelle, id_niveau) VALUES(?,?)")
                ->execute([$datas['libelleClasse'], $datas['niveauId']]);
            return true;
        }
        catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function classeExist(int $niveauId, string $libelleClasse): bool
    {
        $stmt = $this->db->getPDO()
            ->prepare("SELECT libelle FROM classes WHERE id_niveau=? AND libelle=?");

        $stmt->execute([$niveauId, $libelleClasse]);

        return count($stmt->fetchAll()) > 0;
    }
}
