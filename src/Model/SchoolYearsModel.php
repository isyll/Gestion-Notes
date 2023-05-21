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

    public function getYears()
    {
        return $this->db->getPDO()
            ->query('SELECT periode FROM annee_scolaire;')->fetchAll();
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
