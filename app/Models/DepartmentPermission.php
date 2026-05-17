<?php
namespace App\Models;

use App\Core\Database;

class DepartmentPermission
{
    public static function allForDepartment($departmentId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT dp.*, d.name as can_view_name FROM department_permissions dp JOIN departments d ON dp.can_view_department_id = d.id WHERE dp.department_id = :did");
        $stmt->execute([':did' => $departmentId]);
        return $stmt->fetchAll();
    }

    public static function add($departmentId, $canViewDepartmentId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT IGNORE INTO department_permissions (department_id, can_view_department_id) VALUES (:did, :cvid)");
        return $stmt->execute([':did' => $departmentId, ':cvid' => $canViewDepartmentId]);
    }

    public static function remove($departmentId, $canViewDepartmentId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM department_permissions WHERE department_id = :did AND can_view_department_id = :cvid");
        return $stmt->execute([':did' => $departmentId, ':cvid' => $canViewDepartmentId]);
    }
}