<?php

namespace App\Model;

use Core\Database;
use Core\Helpers;

class StudentsModel
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    private function getStudentBy(string $column, mixed $value): array
    {
        return $this->db->pexec(
            "SELECT * FROM eleves WHERE $column=?",
            [$value],
            'fetch'
        );
    }

    public function getStudentByPhone(string $phone)
    {
        return $this->getStudentBy('telephone', $phone);
    }

    public function getStudentByEmail(string $email)
    {
        return $this->getStudentBy('email', $email);
    }

    public function saveStudent(array $data)
    {
        return $this->db->pexec(
            'INSERT INTO eleves(numero,type,prenom,nom,adresse,email,telephone)',
            [
                $data['numero'],
                $data['type'],
                $data['prenom'],
                $data['nom'],
                $data['adresse'] ?? NULL,
                $data['email'] ?? NULL,
                $data['telephone'] ?? NULL,
            ]
        );
    }

    public function getAvailableNumber()
    {
        $num = $this->db->getPDO()->query("SELECT MIN(numero+1) AS num FROM eleves e1
                WHERE NOT EXISTS (
                    SELECT 1
                    FROM eleves e2
                    WHERE e2.numero = e1.numero + 1) LIMIT 1")
            ->fetch()['num'];

        return $num ? $num : 1;
    }
}
