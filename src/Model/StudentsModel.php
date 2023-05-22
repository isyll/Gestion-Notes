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

    public function getStudentByPhone(string $phone)
    {
        $phone = Helpers::rmms($phone);
        return $this->getStudentBy('phone', $phone);
    }

    public function getStudentByEmail(string $email)
    {
        return $this->getStudentBy('email', $email);
    }

    public function getStudentBy(string $column, mixed $value): array
    {
        $stmt = $this->db->getPDO()
            ->prepare("SELECT * FROM eleves WHERE $column=?");

        $stmt->execute([$value]);

        return $stmt->fetchAll();
    }

    public function saveStudent(array $data): void
    {
        try {
            $this->db->getPDO()->query('BEGIN');

            $stmt = $this->db->getPDO()
                ->prepare("INSERT INTO personnes (email, adresse, prenoms, nom, telephone, type) VALUES(?,?,?,?,?,?)");

            $stmt->execute([
                $data['email'],
                $data['adresse'],
                $data['prenoms'],
                $data['nom'],
                $data['telephone'],
                'student'
            ]);

            $stmt = $this->db->getPDO()
                ->prepare("INSERT INTO eleves (id_personne, numero, type) VALUES(?,?,?)");

            $stmt->execute([
                $this->db->getPDO()->lastInsertId(),
                '',
                $data['type']
            ]);

            $this->db->getPDO()->query('COMMIT');
        }
        catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function numero()
    {
        return
            $this->db->getPDO()->query("SELECT MIN(numero+1) AS num FROM eleves e1
                WHERE NOT EXISTS (
                    SELECT 1
                    FROM eleves e2
                    WHERE e2.numero = e1.numero + 1) LIMIT 1")
                ->fetch()['num'];
    }
}
