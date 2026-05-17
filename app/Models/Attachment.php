<?php
namespace App\Models;

use App\Core\Database;

class Attachment
{
    public static function allForTicket($ticketId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM attachments WHERE ticket_id = :tid ORDER BY uploaded_at ASC");
        $stmt->execute([':tid' => $ticketId]);
        return $stmt->fetchAll();
    }

    public static function find($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM attachments WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public static function create(array $data)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO attachments (ticket_id, reply_id, file_name, file_path, file_size) VALUES (:ticket_id, :reply_id, :file_name, :file_path, :file_size)");
        $stmt->execute([
            ':ticket_id' => $data['ticket_id'],
            ':reply_id' => $data['reply_id'] ?? null,
            ':file_name' => $data['file_name'],
            ':file_path' => $data['file_path'],
            ':file_size' => $data['file_size'],
        ]);
        return $db->lastInsertId();
    }
}