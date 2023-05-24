<?php

namespace Core;

class AccessControl
{
    private array $permissions;

    private function retrieveDatas(Database $db, string $tableName): array
    {
        $results = $db->getPDO()->query("SELECT * FROM $tableName")->fetchAll(\PDO::FETCH_ASSOC);
        $data    = [];

        foreach ($results as $item) {
            $data[$item['role']] = explode(',', $item['permissions']);
        }

        return $data;
    }

    public function getDatas()
    {
        return $this->permissions;
    }

    public function dbUp(Database $db, string $tableName): bool
    {
        return count($db->getPDO()->query("SELECT * FROM $tableName")->fetchAll()) > 0;
    }

    public function loadFromJSON(string $filePath): void
    {
        $json              = file_get_contents($filePath);
        $this->permissions = json_decode($json, true);
    }

    public function loadFromDatabase(Database $db, string $tableName): void
    {
        $this->permissions = self::retrieveDatas($db, $tableName);
    }

    public function getRoles()
    {
        $roles = [];

        foreach ($this->permissions as $role => $permissions) {
            $roles[] = $role;
        }

        return $roles;
    }

    public function getPermissions(string $role): array
    {
        foreach ($this->permissions as $r => $permissions) {
            if ($r === $role)
                return $permissions;
        }

        return [];
    }

    public function update(Database $db, string $tableName): void
    {
        foreach (self::getRoles() as $role) {
            $permissions = implode(',', self::getPermissions($role));

            $data = self::retrieveDatas($db, $tableName);

            if (array_key_exists($role, $data)) {
                $db->getPDO()
                    ->prepare("UPDATE $tableName SET permissions=? WHERE role=?")
                    ->execute([$permissions, $role]);
            } else {
                $db->getPDO()
                    ->prepare("INSERT INTO $tableName(role, permissions) VALUES(?, ?)")
                    ->execute([$role, $permissions]);
            }
        }
    }
}
