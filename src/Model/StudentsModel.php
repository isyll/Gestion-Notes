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

    private function getStudentBy(string $column, mixed $value): array|bool
    {
        if ($value === '')
            return false;

        return $this->db->pexec(
            "SELECT * FROM eleves WHERE $column = ? AND supprime = 0",
            [$value],
            'fetch'
        );
    }

    public function getStudentByPhone(string $phone)
    {
        return $this->getStudentBy('telephone', $phone);
    }

    public function emailExists(string $email)
    {
        if ($email === '')
            return false;

        return $this->db->pexec(
            "SELECT * FROM eleves WHERE email = ?",
            [$email],
            'fetch'
        ) ? true : false;
    }

    public function phoneExists(string $phone)
    {
        if ($phone === '')
            return false;

        return $this->db->pexec(
            "SELECT * FROM eleves WHERE telephone = ?",
            [$phone],
            'fetch'
        ) ? true : false;
    }

    public function getStudentByEmail(string $email)
    {
        return $this->getStudentBy('email', $email);
    }

    public function getStudentById(int $id)
    {
        return $this->getStudentBy('id', $id);
    }

    public function saveStudent(array $data)
    {
        $this->db->getPDO()->query('BEGIN');

        $result = $this->db->pexec(
            'INSERT INTO eleves(numero,type,prenom,nom,adresse,email,telephone,naissance) VALUES(?,?,?,?,?,?,?,?)',
            [
                $data['numero'],
                $data['studentType'],
                $data['firstname'],
                $data['lastname'],
                $data['address'],
                $data['email'],
                $data['phone'],
                $data['birthdate'],
            ]
        );

        $this->db->pexec(
            'INSERT INTO inscriptions(id_eleve, id_classe, id_annee) VALUES(?,?,?)',
            [
                $this->db->getPDO()->lastInsertId(),
                $data['classeId'],
                $data['yearId']
            ]
        );

        return $this->db->getPDO()->query('COMMIT');
    }

    public function editStudent(int $id, array $data)
    {
        return $this->db->pexec(
            "UPDATE eleves SET prenom = ?, nom = ?, type = ?, numero = ?,
            adresse = ?, email = ?, telephone = ?, naissance = ?
            WHERE id = $id",
            [
                $data['firstname'],
                $data['lastname'],
                $data['studentType'],
                $data['numero'],
                $data['address'],
                $data['email'],
                $data['phone'],
                $data['birthdate'],
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

    public function deleteStudent(int $id)
    {
        return $this->db->pexec(
            'UPDATE eleves SET supprime = 1 WHERE id = ?',
            [$id]
        );
    }

    public function restoreStudent(int $id)
    {
        return $this->db->pexec(
            'UPDATE eleves SET supprime = 0 WHERE id = ?',
            [$id]
        );
    }
}
