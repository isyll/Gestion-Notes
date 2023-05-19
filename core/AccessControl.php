<?php

namespace Core;

class AccessControl
{
  private static array $permissions;
  private static $separator = ',';

  private static function retrieveDatas(Database $db, string $tableName): array
  {
    $results = $db->getPDO()->query("SELECT * FROM $tableName")->fetchAll(\PDO::FETCH_ASSOC);
    $data    = [];

    foreach ($results as $item) {
      $data[$item['role']] = explode(self::$separator, $item['permissions']);
    }

    return $data;
  }

  public static function getDatas()
  {
    return self::$permissions;
  }

  public static function dbUp(Database $db, string $tableName): bool
  {
    return count($db->getPDO()->query("SELECT * FROM $tableName")->fetchAll()) > 0;
  }

  public static function loadFromJSON(string $filePath): void
  {
    $json              = file_get_contents($filePath);
    self::$permissions = json_decode($json, true);
  }

  public static function loadFromDatabase(Database $db, string $tableName): void
  {
    self::$permissions = self::retrieveDatas($db, $tableName);
  }

  public static function getRoles()
  {
    $roles = [];

    foreach (self::$permissions as $role => $permissions) {
      $roles[] = $role;
    }

    return $roles;
  }

  public static function getPermissions(string $role): array
  {
    foreach (self::$permissions as $r => $permissions) {
      if ($r === $role)
        return $permissions;
    }

    return [];
  }

  public static function update(Database $db, string $tableName): void
  {
    foreach (self::getRoles() as $role) {
      $permissions = implode(self::$separator, self::getPermissions($role));

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