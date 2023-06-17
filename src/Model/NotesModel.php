<?php

namespace App\Model;

use Core\Database;

class NotesModel
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function filterNotes(array $data)
    {
        return $this->db->pexec(
            'SELECT ne.*, e.id as e_id,
            e.prenom, e.nom, cdtn.max_note
            FROM notes_eleves as ne
            JOIN cd_typesnote as cdtn
            ON cdtn.id = ne.id_cd_typesnote
            JOIN typesnote_classes as tn
            ON tn.id = cdtn.id_typesnote
            AND tn.nom_type = ?
            JOIN classes_disciplines as cd
            ON cd.id = cdtn.id_cd
            AND cd.id_discipline = ?
            AND cd.id_classe = ?
            JOIN inscriptions as i
            ON i.id = ne.id_insc
            JOIN eleves as e
            ON e.id = i.id_eleve
            WHERE ne.cycle = ?',
            [
                $data['noteType'],
                $data['subjectId'],
                $data['classeId'],
                $data['cycle']
            ],
            'fetchAll'
        );
    }

    public function getStudentNote(array $data)
    {
        return $this->db->pexec(
            'SELECT ne.* FROM notes_eleves as ne
            JOIN inscriptions as i
            ON i.id = ne.id_insc
            JOIN eleves as e
            ON e.id = i.id_eleve
            AND e.id = ?
            JOIN classes_disciplines as cd
            ON cd.id_discipline = ?
            AND cd.id_annee = ?
            JOIN cd_typesnote as cdtn
            ON cdtn.id_cd = cd.id
            JOIN typesnote_classes as tn
            ON tn.id = cdtn.id_typesnote
            AND tn.nom_type = ?
            WHERE cycle = ?',
            [
                $data['e_id'],
                $data['subjectId'],
                $data['yearId'],
                $data['note_type'],
                $data['cycle'],
            ],
            'fetch'
        );
    }

    public function updateStudentNotes(array $data)
    {
        // return $this->db->pexec(
        //     'UPDATE notes_eleves as ne
        //     JOIN inscriptions as i
        //     ON i.id = ne.id_insc
        //     JOIN eleves as e
        //     ON e.id = i.id_eleve
        //     AND e.id = ?
        //     JOIN classes_disciplines as cd
        //     ON cd.id = ne.id_cd
        //     AND cd.id_discipline = ?
        //     AND cd.id_annee = ?
        //     SET note = ?
        //     WHERE cycle = ?
        //     AND type_note = ?',
        //     [
        //         $data['e_id'],
        //         $data['subjectId'],
        //         $data['yearId'],
        //         $data['note'],
        //         $data['cycle'],
        //         $data['note_type'],
        //     ],
        //     'fetch'
        // );


        return $this->db->pexec(
            'UPDATE notes_eleves as ne
            JOIN inscriptions as i
            ON ne.id_insc = i.id
            JOIN eleves as e
            ON e.id = i.id_eleve
            AND i.id_eleve = ?
            JOIN classes_disciplines as cd
            ON cd.id_classe = i.id_classe
            AND cd.id_discipline = ?
            AND cd.id_annee = ?
            JOIN cd_typesnote as cdtn
            ON cdtn.id_cd = cd.id
            JOIN typesnote_classes as tn
            ON cdtn.id_typesnote = tn.id
            AND tn.nom_type = ?
            SET note = ? WHERE ne.cycle = ?',
            [
                $data['e_id'],
                $data['subjectId'],
                $data['yearId'],
                $data['note_type'],
                $data['note'],
                $data['cycle'],
            ]
        );
    }

    public function insertStudentNotes(array $data)
    {
        return $this->db->pexec(
            'INSERT INTO notes_eleves(id_cd_typesnote, id_insc, cycle, note)
            SELECT cdtn.id, i.id, ?, ?
            FROM classes_disciplines as cd
            JOIN inscriptions as i
            ON i.id_eleve = ?
            AND cd.id_classe = i.id_classe
            JOIN cd_typesnote as cdtn
            ON cdtn.id_cd = cd.id
            JOIN typesnote_classes as tn
            ON cdtn.id_typesnote = tn.id
            AND tn.nom_type = ?
            WHERE cd.id_discipline = ?
            AND cd.id_annee = ?',
            [
                $data['cycle'],
                $data['note'],
                $data['e_id'],
                $data['note_type'],
                $data['subjectId'],
                $data['yearId'],
            ],
            'fetch'
        );
    }
}
