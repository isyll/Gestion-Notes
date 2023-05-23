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

    public function periodExist(string $period): bool
    {
        $periods = $this->getYears();

        foreach ($periods as $p) {
            if ($p['periode'] === $period)
                return true;
        }

        return false;
    }

    public function getYearByPeriod(string $period)
    {
        $stmt = $this->db->getPDO()
            ->prepare('SELECT * FROM annee_scolaire WHERE periode=? AND supprime=0');

        $stmt->execute([$period]);

        return $stmt->fetch();
    }

    public function getYears()
    {
        return $this->db->getPDO()
            ->query('SELECT * FROM annee_scolaire WHERE supprime=0')->fetchAll();
    }

    public function getYearById(int $id)
    {
        $stmt = $this->db->getPDO()
            ->prepare('SELECT * FROM annee_scolaire WHERE id=? AND supprime=0');

        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function yearExist(int $id): bool
    {
        return $this->getYearById($id) ? true : false;
    }

    public function deleteYear(int $id)
    {
        $stmt = $this->db->getPDO()
            ->prepare('UPDATE annee_scolaire SET supprime=1 WHERE id=?');

        $stmt->execute([$id]);
    }

    public function saveYear($data): bool
    {
        try {
            $this->db->getPDO()
                ->prepare("INSERT INTO annee_scolaire(periode) VALUES(?)")
                ->execute([$data['period']]);
            return true;
        }
        catch (\PDOException $e) {
            return false;
        }
    }
}
