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

    public function classeIdExists(int $id)
    {
        return $this->db->pexec(
            'SELECT 1 FROM classes WHERE id = ?',
            [$id],
            'fetch'
        ) ? true : false;
    }

    public function getClasseNiveau(int $classeId)
    {
        return $this->db->pexec(
            'SELECT n.* FROM niveaux AS n
            JOIN classes AS c ON c.id_niveau = n.id
            AND c.id = ?',
            [$classeId],
            'fetch'
        );
    }

    public function getClassesByNiveau(int $id)
    {
        return $this->db->pexec(
            'SELECT * FROM classes WHERE id_niveau = ? AND supprime = 0',
            [$id],
            'fetchAll'
        );
    }

    public function classeLibelleExists(string $libelle)
    {
        return $this->db->pexec(
            'SELECT 1 FROM classes WHERE libelle = ? AND supprime = 0',
            [$libelle],
            'fetch'
        ) ? true : false;
    }

    public function getClasseById(int $id)
    {
        return $this->db->pexec(
            "SELECT * FROM classes WHERE id = ? AND supprime = 0",
            [$id],
            'fetch'
        );
    }

    public function getStudents(int $classeId)
    {
        return $this->db->pexec(
            "SELECT e.* FROM eleves AS e
            JOIN inscriptions AS i ON i.id_eleve = e.id
            AND i.id_classe = ? WHERE e.supprime = 0",
            [$classeId],
            'fetchAll'
        );
    }

    public function hasStudent(int $classeId, int $studentId): bool
    {
        return $this->db->pexec(
            "SELECT e.id FROM eleves AS e
            JOIN inscriptions AS i ON i.id_eleve = e.id AND i.id_classe = ?
            WHERE e.id = ?",
            [$classeId, $studentId],
            'fetchAll'
        ) ? true : false;
    }

    public function classeNiveauMatch(int $classeId, int $niveauId)
    {
        return $this->db->pexec(
            "SELECT 1 FROM classes WHERE id = ? AND id_niveau = ? AND supprime = 0",
            [$niveauId, $classeId],
            'fetch'
        ) ? true : false;
    }

    public function saveClasse(
        string $classeLibelle,
        int $niveauId
    ): bool {
        return $this->db->pexec(
            "INSERT INTO classes(libelle,  id_niveau) VALUES(?, ?)",
            [$classeLibelle, $niveauId]
        );
    }

    public function deleteClasse(int $niveauId, int $classeId)
    {
        return $this->db->pexec(
            'UPDATE classes SET supprime = 1 WHERE id_niveau = ? AND id = ?',
            [$niveauId, $classeId]
        );
    }

    public function editClasse(int $id, string $newLibelle): bool
    {
        return $this->db->pexec(
            "UPDATE classes SET libelle = ? WHERE id = ?",
            [$newLibelle, $id]
        );
    }

    public function addNoteType(int $classeId, string $noteType, int $yearId)
    {
        $result = $this->db->pexec(
            'INSERT INTO typesnote_classes(id_classe, nom_type)
            VALUES(?, ?)',
            [
                $classeId,
                $noteType
            ]
        );

        $subjectModel = new SubjectsModel($this->db);
        $subjects     = $subjectModel->getClasseSubjects($classeId);

        foreach ($subjects as $s)
            $subjectModel->insertClasseSubjectMax([
                'max_note' => 0,
                'nom_type' => $noteType,
                'classeId' => $classeId,
                'subjectId' => $s['id'],
                'yearId' => $yearId
            ]);

        return $result;
    }

    public function delNoteType(int $niveauId, string $noteType)
    {
        return $this->db->pexec(
            'DELETE FROM typesnote_classes
            WHERE id_classe = ?
            AND nom_type = ?',
            [
                $niveauId,
                $noteType
            ]
        );
    }

    public function getClasseNoteTypes(int $classeId)
    {
        return $this->db->pexec(
            'SELECT * FROM typesnote_classes
            WHERE id_classe = ?',
            [
                $classeId
            ],
            'fetchAll'
        );
    }

    public function getClasseNotesMax(int $classeId)
    {
        return $this->db->pexec(
            'SELECT tn.*, cdtn.max_note, d.id as id_discipline
            FROM typesnote_classes as tn
            JOIN cd_typesnote as cdtn
            ON tn.id = cdtn.id_typesnote
            JOIN classes_disciplines as cd
            ON cd.id_classe = tn.id_classe
            AND cd.id = cdtn.id_cd
            JOIN disciplines as d
            ON d.id = cd.id_discipline
            WHERE tn.id_classe = ?',
            [
                $classeId
            ],
            'fetchAll'
        );
    }
}
