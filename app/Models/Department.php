<?php
namespace App\Models;

use App\Core\Database;

class Department
{
    public static function all()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM departments ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public static function find($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM departments WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public static function create($name)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO departments (name) VALUES (:name)");
        $stmt->execute([':name' => $name]);
        return $db->lastInsertId();
    }

    public static function update($id, $name)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE departments SET name = :name WHERE id = :id");
        return $stmt->execute([':name' => $name, ':id' => $id]);
    }

    public static function delete($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM departments WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}