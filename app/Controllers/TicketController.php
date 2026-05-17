<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;
use App\Models\Ticket;
use App\Models\Reply;
use App\Models\Attachment;
use App\Models\Department;
use App\Models\DepartmentPermission;
use App\Models\Status;
use App\Models\Priority;
use App\Models\Setting;
use App\Models\User;

class TicketController extends Controller
{
    protected function getUserTicketsQuery($userId, $role, $departmentId = null)
    {
        $db = \App\Core\Database::getInstance()->getConnection();
        if ($role === 'client') {
            $sql = "SELECT t.*, s.name as status_name, s.color as status_color, p.name as priority_name, p.color as priority_color, d.name as department_name
                    FROM tickets t
                    JOIN statuses s ON t.status_id = s.id
                    JOIN priorities p ON t.priority_id = p.id
                    JOIN departments d ON t.department_id = d.id
                    WHERE t.client_id = :uid";
            $stmt = $db->prepare($sql);
            $stmt->execute([':uid' => $userId]);
            return $stmt->fetchAll();
        } elseif ($role === 'agent') {
            $depIds = [$departmentId];
            // پیدا کردن پارلمان‌هایی که اجازهٔ دیدن دارند
            $perm = DepartmentPermission::allForDepartment($departmentId);
            foreach ($perm as $p) {
                $depIds[] = $p['can_view_department_id'];
            }
            $depIds = array_unique($depIds);
            if (empty($depIds)) return [];
            $in = implode(',', array_fill(0, count($depIds), '?'));
            $sql = "SELECT t.*, s.name as status_name, s.color as status_color, p.name as priority_name, p.color as priority_color, d.name as department_name
                    FROM tickets t
                    JOIN statuses s ON t.status_id = s.id
                    JOIN priorities p ON t.priority_id = p.id
                    JOIN departments d ON t.department_id = d.id
                    WHERE t.department_id IN ($in)";
            $stmt = $db->prepare($sql);
            $stmt->execute($depIds);
            return $stmt->fetchAll();
        } elseif ($role === 'admin') {
            $sql = "SELECT t.*, s.name as status_name, s.color as status_color, p.name as priority_name, p.color as priority_color, d.name as department_name
                    FROM tickets t
                    JOIN statuses s ON t.status_id = s.id
                    JOIN priorities p ON t.priority_id = p.id
                    JOIN departments d ON t.department_id = d.id";
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        }
        return [];
    }

    public function index()
    {
        $this->authCheck();
        $userId = Session::get('user_id');
        $role = Session::get('role');
        $departmentId = Session::get('department_id');

        $tickets = $this->getUserTicketsQuery($userId, $role, $departmentId);
        $this->view('tickets/index', ['tickets' => $tickets, 'role' => $role]);
    }

    public function create()
    {
        $this->authCheck();
        if (Session::get('role') !== 'client') {
            die('دسترسی مجاز نیست');
        }
        $departments = Department::all();
        $priorities = Priority::all();
        $this->view('tickets/create', ['departments' => $departments, 'priorities' => $priorities]);
    }

    public function store()
    {
        $this->authCheck();
        if (Session::get('role') !== 'client') die('دسترسی مجاز نیست');
        Request::verifyCsrfToken();

        $validator = new Validator();
        $rules = [
            'subject' => 'required',
            'body' => 'required',
            'department_id' => 'required',
            'priority_id' => 'required',
        ];
        if (!$validator->validate($_POST, $rules)) {
            Session::set('_old', $_POST);
            Session::set('errors', $validator->errors());
            $this->redirect('/tickets/create');
        }

        // وضعیت اولیه "باز" (id=1)
        $openStatus = Status::findByName('باز');
        if (!$openStatus) die('خطا: وضعیت باز یافت نشد');

        $ticketData = [
            'client_id' => Session::get('user_id'),
            'department_id' => $_POST['department_id'],
            'subject' => $_POST['subject'],
            'body' => $_POST['body'],
            'priority_id' => $_POST['priority_id'],
            'status_id' => $openStatus['id'],
        ];
        $ticketId = Ticket::create($ticketData);

        // آپلود فایل
        $this->handleUpload('attachment', $ticketId, null);

        $this->redirect('/tickets');
    }

    public function show($id)
    {
        $this->authCheck();
        $ticket = Ticket::find($id);
        if (!$ticket) die('تیکت یافت نشد');

        // بررسی دسترسی
        $userId = Session::get('user_id');
        $role = Session::get('role');
        if ($role === 'client' && $ticket['client_id'] != $userId) {
            die('دسترسی غیرمجاز');
        }
        if ($role === 'agent') {
            $depId = Session::get('department_id');
            $allowedDeps = [$depId];
            $perms = DepartmentPermission::allForDepartment($depId);
            foreach ($perms as $p) $allowedDeps[] = $p['can_view_department_id'];
            if (!in_array($ticket['department_id'], $allowedDeps)) die('دسترسی غیرمجاز');
        }
        // admin همه را می‌بیند

        $replies = Reply::allForTicket($id);
        $attachments = Attachment::allForTicket($id);
        $statuses = Status::all();
        $this->view('tickets/show', [
            'ticket' => $ticket,
            'replies' => $replies,
            'attachments' => $attachments,
            'statuses' => $statuses,
            'role' => $role,
            'userId' => $userId,
        ]);
    }

    public function reply($ticketId)
    {
        $this->authCheck();
        Request::verifyCsrfToken();

        $ticket = Ticket::find($ticketId);
        if (!$ticket) die('تیکت یافت نشد');
        // بررسی دسترسی مشابه show
        $userId = Session::get('user_id');
        $role = Session::get('role');
        // دسترسی مشتری فقط به تیکت خود، کارشناس و ادمین با مجوز پارلمان
        if ($role === 'client' && $ticket['client_id'] != $userId) die('دسترسی غیرمجاز');
        if ($role === 'agent') {
            $depId = Session::get('department_id');
            $allowed = [$depId];
            $perms = DepartmentPermission::allForDepartment($depId);
            foreach ($perms as $p) $allowed[] = $p['can_view_department_id'];
            if (!in_array($ticket['department_id'], $allowed)) die('دسترسی غیرمجاز');
        }

        $message = $_POST['message'] ?? '';
        $isInternal = isset($_POST['is_internal']) ? 1 : 0;
        if (trim($message) === '') {
            $this->redirect("/tickets/{$ticketId}");
        }

        // فقط agent/admin می‌توانند یادداشت داخلی ثبت کنند
        if ($isInternal && !in_array($role, ['agent', 'admin'])) {
            $isInternal = 0;
        }

        $replyId = Reply::create([
            'ticket_id' => $ticketId,
            'user_id' => $userId,
            'message' => $message,
            'is_internal' => $isInternal,
        ]);

        // آپلود فایل
        $this->handleUpload('attachment', $ticketId, $replyId);

        // به‌روزرسانی updated_at تیکت
        Ticket::touch($ticketId);

        $this->redirect("/tickets/{$ticketId}");
    }

    public function changeStatus($ticketId)
    {
        $this->requireAgentOrAdmin();
        Request::verifyCsrfToken();
        $newStatusId = $_POST['status_id'] ?? null;
        if ($newStatusId) {
            Ticket::updateStatus($ticketId, $newStatusId);
        }
        $this->redirect("/tickets/{$ticketId}");
    }

    public function download($attachmentId)
    {
        $this->authCheck();
        $attachment = Attachment::find($attachmentId);
        if (!$attachment) die('فایل یافت نشد');

        $ticket = Ticket::find($attachment['ticket_id']);
        if (!$ticket) die('تیکت وجود ندارد');

        // بررسی دسترسی
        $userId = Session::get('user_id');
        $role = Session::get('role');
        if ($role === 'client' && $ticket['client_id'] != $userId) die('دسترسی غیرمجاز');
        if ($role === 'agent') {
            $depId = Session::get('department_id');
            $allowed = [$depId];
            $perms = DepartmentPermission::allForDepartment($depId);
            foreach ($perms as $p) $allowed[] = $p['can_view_department_id'];
            if (!in_array($ticket['department_id'], $allowed)) die('دسترسی غیرمجاز');
        }

        $file = __DIR__ . '/../../uploads/' . $attachment['file_path'];
        if (!file_exists($file)) die('فایل موجود نیست');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $attachment['file_name'] . '"');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }

    protected function handleUpload($inputName, $ticketId, $replyId = null)
    {
        $file = $_FILES[$inputName] ?? null;
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) return;
        $settings = Setting::getAsArray();
        $maxSize = (int) ($settings['max_upload_size'] ?? 5242880);
        $allowedExt = explode(',', $settings['allowed_extensions'] ?? 'jpg,jpeg,png,pdf,docx');
        $fileSize = $file['size'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExt)) {
            Session::set('error', 'فرمت فایل مجاز نیست.');
            return;
        }
        if ($fileSize > $maxSize) {
            Session::set('error', 'حجم فایل بیش از حد مجاز است.');
            return;
        }
        $fileName = uniqid() . '.' . $ext;
        $uploadDir = __DIR__ . '/../../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $dest = $uploadDir . $fileName;
        move_uploaded_file($file['tmp_name'], $dest);
        Attachment::create([
            'ticket_id' => $ticketId,
            'reply_id' => $replyId,
            'file_name' => $file['name'],
            'file_path' => $fileName,
            'file_size' => $fileSize,
        ]);
    }
}