<?php
namespace App\Models;

use App\Core\Database;

class Ticket
{
    public static function all()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT t.*, s.name as status_name, s.color as status_color, p.name as priority_name, p.color as priority_color, d.name as department_name FROM tickets t JOIN statuses s ON t.status_id = s.id JOIN priorities p ON t.priority_id = p.id JOIN departments d ON t.department_id = d.id ORDER BY t.updated_at DESC");
        return $stmt->fetchAll();
    }

    public static function find($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT t.*, s.name as status_name, s.color as status_color, p.name as priority_name, p.color as priority_color, d.name as department_name FROM tickets t JOIN statuses s ON t.status_id = s.id JOIN priorities p ON t.priority_id = p.id JOIN departments d ON t.department_id = d.id WHERE t.id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public static function create(array $data)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO tickets (client_id, department_id, subject, body, priority_id, status_id) VALUES (:client_id, :department_id, :subject, :body, :priority_id, :status_id)");
        $stmt->execute([
            ':client_id' => $data['client_id'],
            ':department_id' => $data['department_id'],
            ':subject' => $data['subject'],
            ':body' => $data['body'],
            ':priority_id' => $data['priority_id'],
            ':status_id' => $data['status_id'],
        ]);
        return $db->lastInsertId();
    }

    public static function updateStatus($id, $statusId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE tickets SET status_id = :status_id, updated_at = NOW() WHERE id = :id");
        return $stmt->execute([':status_id' => $statusId, ':id' => $id]);
    }

    public static function touch($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE tickets SET updated_at = NOW() WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}