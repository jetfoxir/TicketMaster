<?php
require_once __DIR__ . '/../app/Core/Autoload.php';
\App\Core\Autoload::register();

use App\Core\Database;
use App\Models\Status;

$db = Database::getInstance()->getConnection();

// گرفتن شناسه وضعیت‌های "در انتظار پاسخ" و "بسته"
$waitingStatus = Status::findByName('در انتظار پاسخ');
$closedStatus = Status::findByName('بسته');

if (!$waitingStatus || !$closedStatus) {
    echo "❌ وضعیت‌های مورد نیاز یافت نشدند.\n";
    exit(1);
}

// بستن تیکت‌هایی که 48 ساعت از آخرین بروزرسانی‌شان گذشته و در وضعیت "در انتظار پاسخ" هستند
$sql = "UPDATE tickets 
        SET status_id = :closed_status, updated_at = NOW() 
        WHERE status_id = :waiting_status 
        AND updated_at < DATE_SUB(NOW(), INTERVAL 48 HOUR)";

$stmt = $db->prepare($sql);
$stmt->execute([
    ':closed_status' => $closedStatus['id'],
    ':waiting_status' => $waitingStatus['id'],
]);

$count = $stmt->rowCount();
echo "✅ {$count} تیکت بسته شد.\n";

// نمایش تیکت‌های بسته شده برای لاگ
if ($count > 0) {
    $sql = "SELECT id, subject FROM tickets 
            WHERE status_id = :closed_status 
            AND updated_at >= DATE_SUB(NOW(), INTERVAL 1 MINUTE)";
    $stmt = $db->prepare($sql);
    $stmt->execute([':closed_status' => $closedStatus['id']]);
    $tickets = $stmt->fetchAll();

    foreach ($tickets as $ticket) {
        echo "  - تیکت #{$ticket['id']}: {$ticket['subject']}\n";
    }
}