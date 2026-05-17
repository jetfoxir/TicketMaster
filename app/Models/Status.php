<?php
namespace App\Models;

use App\Core\Database;

class Status
{
    public static function all()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM statuses ORDER BY id ASC");
        return $stmt->fetchAll();
    }

    public static function find($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM statuses WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public static function findByName($name)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM statuses WHERE name = :name");
        $stmt->execute([':name' => $name]);
        return $stmt->fetch();
    }

    public static function create(array $data)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO statuses (name, color) VALUES (:name, :color)");
        return $stmt->execute([':name' => $data['name'], ':color' => $data['color']]);
    }

    public static function update($id, array $data)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE statuses SET name = :name, color = :color WHERE id = :id");
        return $stmt->execute([':name' => $data['name'], ':color' => $data['color'], ':id' => $id]);
    }

    public static function delete($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM statuses WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}