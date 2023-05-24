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

    public function getClasses(string $period, string $niveauSlug)
    {

    }

    public function containsClasse(string $period, string $niveauSlug, string $classeSlug): bool
    {
        $stmt = $this->db->getPDO()
            ->prepare("SELECT classes.*
                FROM classes, niveaux, annee_scolaire
                WHERE annee_scolaire.periode = ?
                AND niveaux.as_id = annee_scolaire.id
                AND niveaux.slug = ?
                AND classes.id_niveau = niveaux.id
                AND classes.slug = ?
                AND classes.supprime = 0");

        $stmt->execute([$period, $niveauSlug, $classeSlug]);

        return $stmt->fetch() ? true : false;
    }

    public function getAllStudents(string $period, string $niveauSlug, string $classeSlug)
    {
        $stmt = $this->db->getPDO()
            ->prepare("SELECT personnes.*, eleves.*
                FROM classes, personnes, niveaux, annee_scolaire, eleves
                JOIN personnes AS p ON eleves.id_personne = p.id
                WHERE annee_scolaire.periode = ?
                AND niveaux.as_id = annee_scolaire.id
                AND niveaux.slug = ?
                AND classes.id_niveau = niveaux.id
                AND classes.slug = ?");

        $stmt->execute([$period, $niveauSlug, $classeSlug]);

        return $stmt->fetchAll();
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
