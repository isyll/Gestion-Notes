<?php

namespace App\Model;

use Core\Database;
use Core\Helpers;

class SubjectsModel
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getGroups()
    {
        return $this->db->pexec(
            'SELECT * FROM groupes_disciplines WHERE supprime = 0',
            [],
            'fetchAll'
        );
    }

    public function subjectNameExists(string $name): bool
    {
        if ($name === '')
            return false;

        return $this->db->pexec(
            'SELECT 1 FROM disciplines WHERE nom LIKE ?',
            [$name],
            'fetch'
        ) ? true : false;
    }

    public function subjectCodeExists(string $code): bool
    {
        if ($code === '')
            return false;

        return $this->db->pexec(
            'SELECT 1 FROM disciplines WHERE code = ?',
            [$code],
            'fetch'
        ) ? true : false;
    }

    public function getGroupByName(string $name)
    {
        return $this->db->pexec(
            'SELECT * FROM groupes_disciplines WHERE nom = ? AND supprime = 0',
            [$name],
            'fetch'
        );
    }

    public function getGroupById(int $id)
    {
        return $this->db->pexec(
            'SELECT * FROM groupes_disciplines WHERE id = ? AND supprime = 0',
            [$id],
            'fetch'
        );
    }

    public function groupNameExists(string $name): bool
    {
        return $this->db->pexec(
            'SELECT 1 FROM groupes_disciplines WHERE nom = ?',
            [$name],
            'fetch'
        ) ? true : false;
    }

    public function groupIdExists(int $id): bool
    {
        return $this->db->pexec(
            'SELECT 1 FROM groupes_disciplines WHERE id = ?',
            [$id],
            'fetch'
        ) ? true : false;
    }

    public function getClasseSubjects(int $classeId)
    {
        return $this->db->pexec(
            'SELECT d.* FROM disciplines AS d
            JOIN classes_disciplines AS cd ON cd.id_discipline = d.id
            JOIN classes ON cd.id_classe = classes.id
            AND classes.id = ?',
            [$classeId],
            'fetchAll'
        );
    }

    public function getClasseDiscipline(array $data)
    {
        return $this->db->pexec(
            'SELECT * FROM classes_disciplines
            WHERE id_classe = ?
            AND id_discipline = ?
            AND id_annee = ?',
            [
                $data['classeId'],
                $data['subjectId'],
                $data['yearId'],
            ],
            'fetch'
        );
    }

    public function isClasseHasSubject(int $classeId, string $sbjName): bool
    {
        return $this->db->pexec(
            'SELECT d.* FROM disciplines AS d
            JOIN classes_disciplines AS cd ON cd.id_discipline = d.id
            JOIN classes ON cd.id_classe = classes.id
            AND classes.id = ?
            WHERE d.nom = ?',
            [$classeId, $sbjName],
            'fetch'
        ) ? true : false;
    }

    public function getSubjectById(int $id)
    {
        return $this->db->pexec(
            'SELECT * FROM disciplines WHERE id = ?',
            [$id],
            'fetch'
        );
    }

    public function getSubjectByCode(string $code)
    {
        return $this->db->pexec(
            'SELECT * FROM disciplines WHERE code = ?',
            [$code],
            'fetch'
        );
    }

    public function getSubjectByName(string $name)
    {
        return $this->db->pexec(
            'SELECT * FROM disciplines WHERE nom = ?',
            [$name],
            'fetch'
        );
    }

    public function addSubjectToClasse(int $classeId, int $sbjId, int $yearId)
    {
        return $this->db->pexec(
            'INSERT INTO classes_disciplines(id_classe, id_discipline, id_annee) VALUES(?,?,?)',
            [$classeId, $sbjId, $yearId],
        );
    }

    public function delSubjectFromClasse(int $classeId, int $sbjId, int $yearId)
    {
        return $this->db->pexec(
            'DELETE FROM classes_disciplines
            WHERE id_classe = ? AND id_discipline = ? AND id_annee = ?',
            [$classeId, $sbjId, $yearId],
        );
    }

    public function saveGroup(array $data)
    {
        return $this->db->pexec(
            'INSERT INTO groupes_disciplines(nom) VALUES(?)',
            [$data['groupName']],
        ) ? true : false;
    }

    public function editGroup(int $id, array $data)
    {
        return $this->db->pexec(
            'UPDATE groupes_disciplines SET nom = ? WHERE id = ?',
            [$data['groupName'], $id],
        ) ? true : false;
    }

    public function deleteGroupById(int $id)
    {
        return $this->db->pexec(
            'UPDATE groupes_disciplines SET supprime = 1 WHERE id = ?',
            [$id],
        );
    }

    public function restoreGroupById(int $id)
    {
        return $this->db->pexec(
            'UPDATE groupes_disciplines SET supprime = 0 WHERE id = ?',
            [$id],
        );
    }

    public function saveSubject(array $data)
    {
        return $this->db->pexec(
            'INSERT INTO disciplines(nom, code, id_groupe) VALUES(?,?,?)',
            [
                $data['subjectName'],
                $this->genSubjectCode($data['subjectName']),
                $data['groupId']
            ]
        );
    }

    public function getClasseSubjectMax(array $data)
    {
        return $this->db->pexec(
            "SELECT * FROM cd_typesnote as cdtn
            JOIN classes_disciplines as cd
            ON cd.id = cdtn.id_cd
            AND cd.id_classe = ?
            AND cd.id_discipline = ?
            AND cd.id_annee = ?
            JOIN typesnote_classes as tn
            ON tn.id = cdtn.id_typesnote
            AND tn.nom_type = ?",
            [
                $data['classeId'],
                $data['subjectId'],
                $data['yearId'],
                $data['nom_type'],
            ],
            'fetch'
        );
    }

    public function insertClasseSubjectMax(array $data)
    {
        return $this->db->pexec(
            "INSERT INTO cd_typesnote(id_cd, id_typesnote, max_note)
            SELECT cd.id, tn.id, ?
            FROM classes_disciplines as cd
            JOIN typesnote_classes as tn
            ON tn.nom_type = ?
            AND tn.id_classe = cd.id_classe
            WHERE cd.id_classe = ?
            AND cd.id_discipline = ?
            AND cd.id_annee = ?",
            [
                $data['max_note'],
                $data['nom_type'],
                $data['classeId'],
                $data['subjectId'],
                $data['yearId'],
            ]
        );
    }

    public function updateClasseSubjectMax(array $data)
    {
        return $this->db->pexec(
            "UPDATE cd_typesnote as cdtn
            JOIN classes_disciplines as cd
            ON cd.id = cdtn.id_cd
            AND cd.id_classe = ?
            AND cd.id_discipline = ?
            AND cd.id_annee = ?
            JOIN typesnote_classes as tn
            ON tn.id = cdtn.id_typesnote
            AND tn.nom_type = ?
            SET max_note = ?",
            [
                $data['classeId'],
                $data['subjectId'],
                $data['yearId'],
                $data['nom_type'],
                $data['max_note'],
            ]
        );
    }

    private function genSubjectCode(string $name): string
    {
        $name = trim($name);

        if (count(explode(' ', $name)) === 1) {
            $length = 3;

            do {
                $code = substr($name, 0, $length++);
            } while ($this->subjectCodeExists($code));
        } else {
            $code = [];
            preg_match_all('/\b[a-zA-Z]/', $name, $code);
            $code = implode('', $code[0]);

            $offset = 1;
            $suffix = "";
            while ($this->subjectCodeExists($code . $suffix)) {
                $suffix .= substr($name, $offset++, 1);
            }

            $code .= $suffix;
        }

        return strtoupper($code);
    }
}
