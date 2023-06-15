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

    public function getStudentClasse(int $studentId)
    {
        return $this->db->pexec(
            "SELECT cl.* FROM classes as cl
            JOIN inscriptions as i ON i.id_classe = cl.id
            AND i.id_eleve = ?",
            [$studentId],
            'fetch'
        );
    }

    public function getStudentNiveau(int $studentId)
    {
        return $this->db->pexec(
            "SELECT n.* FROM niveaux as n
            JOIN classes as cl ON cl.id_niveau = n.id
            JOIN inscriptions as i ON i.id_classe = cl.id
            AND i.id_eleve = ?",
            [$studentId],
            'fetch'
        );
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
            'INSERT INTO eleves(numero,type,prenom,nom,adresse,email,telephone,naissance,photo) VALUES(?,?,?,?,?,?,?,?,?)',
            [
                $data['numero'],
                $data['studentType'],
                $data['firstname'],
                $data['lastname'],
                $data['address'],
                $data['email'],
                $data['phone'],
                $data['birthdate'],
                $data['photo'],
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

        $this->db->pexec(
            'INSERT INTO cd_eleves(id_cd, id_insc)
            SELECT cd.id, ? FROM classes_disciplines as cd
            JOIN classes as cl ON cl.id = cd.id_classe
            AND cl.id = ? WHERE cd.id_annee = ?',
            [
                $this->db->getPDO()->lastInsertId(),
                $data['classeId'],
                $data['yearId']
            ]
        );

        return $this->db->getPDO()->query('COMMIT');
    }

    public function removeSubjectToStudent(array $data)
    {
        $this->removeStudentNotes($data);

        return $this->db->pexec(
            'UPDATE cd_eleves as cde
            JOIN inscriptions as i
            ON i.id = cde.id_insc
            AND i.id_eleve = ?
            JOIN classes_disciplines as cd
            ON cd.id = cde.id_cd
            AND cd.id_discipline = ?
            AND cd.id_classe = ?
            AND cd.id_annee = ?
            SET cde.faire_disc = 0',
            [
                $data['e_id'],
                $data['subjectId'],
                $data['classeId'],
                $data['yearId']
            ]
        );
    }

    public function removeStudentNotes(array $data)
    {
        return $this->db->pexec(
            'DELETE ne FROM notes_eleves ne
            JOIN inscriptions as i
            ON i.id = ne.id_insc
            JOIN eleves as e
            ON e.id = i.id_eleve AND e.id = ?
            JOIN classes_disciplines as cd
            ON cd.id = ne.id_cd
            AND cd.id_discipline = ?
            AND cd.id_annee = ?',
            [
                $data['e_id'],
                $data['subjectId'],
                $data['yearId'],
            ],
            'fetch'
        );
    }

    public function restoreSubjectToStudent(array $data)
    {
        return $this->db->pexec(
            'UPDATE cd_eleves as cde
            JOIN inscriptions as i
            ON i.id = cde.id_insc
            AND i.id_eleve = ?
            JOIN classes_disciplines as cd
            ON cd.id = cde.id_cd
            AND cd.id_discipline = ?
            AND cd.id_classe = ?
            AND cd.id_annee = ?
            SET cde.faire_disc = 1',
            [
                $data['e_id'],
                $data['subjectId'],
                $data['classeId'],
                $data['yearId']
            ]
        );
    }

    public function getCDE(array $data)
    {
        return $this->db->pexec(
            'SELECT cde.*, i.id_eleve as e_id
            FROM cd_eleves as cde
            JOIN inscriptions as i
            ON i.id = cde.id_insc
            JOIN classes_disciplines as cd
            ON cd.id = cde.id_cd
            AND cd.id_discipline = ?
            AND cd.id_classe = ?
            AND cd.id_annee = ?',
            [
                $data['subjectId'],
                $data['classeId'],
                $data['yearId']
            ],
            'fetchAll'
        );
    }

    public function editStudent(int $id, array $data)
    {
        $p = $data['photo'] ?? null;

        $sql = "UPDATE eleves SET prenom = ?, nom = ?, type = ?, numero = ?,
        adresse = ?, email = ?, telephone = ?, naissance = ? ";
        $sql .= $p ? ', photo = ? ' : '';

        $sql .= "WHERE id = $id";

        $d = [
            $data['firstname'],
            $data['lastname'],
            $data['studentType'],
            $data['numero'],
            $data['address'],
            $data['email'],
            $data['phone'],
            $data['birthdate'],
        ];

        if ($p)
            $d[] = $p;

        return $this->db->pexec(
            $sql,
            $d
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

    // public function updateupdatestudentsnotes()
    // {
    //     $allStudents = $this->db->pexec(
    //         'SELECT * FROM eleves WHERE supprime = 0',
    //         [],
    //         'fetchAll'
    //     );

    //     $sql = 'INSERT INTO cd_eleves(id_cd, id_insc)
    //         SELECT cd.id, i.id FROM classes_disciplines as cd
    //         JOIN inscriptions as i
    //         ON i.id_annee = cd.id_annee
    //         AND i.id_classe = cd.id_classe
    //         AND i.id_eleve = ?';

    //     $stmt = $this->db->getPDO()->prepare($sql);

    //     foreach ($allStudents as $s)
    //         $stmt->execute([
    //             $s['id']
    //         ]);
    // }
}
