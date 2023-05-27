<?php

namespace App\Model;

use Core\Database;

class AdminModel
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function usernameExists(string $username): bool
    {
        return $this->db->pexec(
            'SELECT 1 FROM comptes WHERE username LIKE ?',
            [$username],
            'fetch'
        ) ? true : false;
    }

    public function login(string $username, string $password): array|bool
    {
        $datas = $this->db->pexec(
            'SELECT * FROM comptes WHERE username LIKE ?',
            [$username],
            'fetch'
        );

        if ($datas && password_verify($password, $datas['password_hash']))
            return $datas;

        return false;
    }

    public function saveUser(array $datas)
    {
        return $this->db->pexec(
            'INSERT INTO comptes(username, prenom, nom, email, telephone, type, password_hash, hash_algorithm) VALUES(?,?,?,?,?,?,?,?)',
            [
                $datas['username'],
                $datas['firstname'],
                $datas['lastname'],
                $datas['email'],
                $datas['phone'],
                $datas['type'],
                $datas['password_hash'],
                $datas['hash_algorithm'],
            ]
        );
    }
}
