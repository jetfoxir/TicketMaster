<?php
namespace App\Models;

use App\Core\Database;

class Setting
{
    public static function getAsArray()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT `key`, `value` FROM settings");
        $settings = [];
        while ($row = $stmt->fetch()) {
            $settings[$row['key']] = $row['value'];
        }
        return $settings;
    }

    public static function get($key, $default = null)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT `value` FROM settings WHERE `key` = :key");
        $stmt->execute([':key' => $key]);
        $row = $stmt->fetch();
        return $row ? $row['value'] : $default;
    }

    public static function set($key, $value)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO settings (`key`, `value`) VALUES (:key, :value) ON DUPLICATE KEY UPDATE `value` = :value2");
        return $stmt->execute([':key' => $key, ':value' => $value, ':value2' => $value]);
    }
}