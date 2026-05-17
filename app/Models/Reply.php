<?php
namespace App\Models;

use App\Core\Database;

class Reply
{
    public static function allForTicket($ticketId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT r.*, u.name as user_name, u.role as user_role FROM replies r JOIN users u ON r.user_id = u.id WHERE r.ticket_id = :tid ORDER BY r.created_at ASC");
        $stmt->execute([':tid' => $ticketId]);
        return $stmt->fetchAll();
    }

    public static function create(array $data)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO replies (ticket_id, user_id, message, is_internal) VALUES (:ticket_id, :user_id, :message, :is_internal)");
        $stmt->execute([
            ':ticket_id' => $data['ticket_id'],
            ':user_id' => $data['user_id'],
            ':message' => $data['message'],
            ':is_internal' => $data['is_internal'] ?? 0,
        ]);
        return $db->lastInsertId();
    }
}