<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;
use App\Models\User;
use App\Models\Department;
use App\Models\DepartmentPermission;
use App\Models\Status;
use App\Models\Priority;
use App\Models\Setting;

class AdminController extends Controller
{
    public function dashboard()
    {
        $this->requireAdmin();
        $this->redirect('/admin/users');
    }

    // ==================== مدیریت کاربران ====================
    public function users()
    {
        $this->requireAdmin();
        $users = User::all();
        $this->view('admin/users/index', ['users' => $users]);
    }

    public function createUser()
    {
        $this->requireAdmin();
        $departments = Department::all();
        $this->view('admin/users/create', ['departments' => $departments]);
    }

    public function storeUser()
    {
        $this->requireAdmin();
        Request::verifyCsrfToken();

        $validator = new Validator();
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
        ];

        if (!$validator->validate($_POST, $rules)) {
            Session::set('_old', $_POST);
            Session::set('errors', $validator->errors());
            $this->redirect('/admin/users/create');
        }

        $role = $_POST['role'];
        $departmentId = null;

        if ($role === 'agent') {
            $departmentId = $_POST['department_id'] ?? null;
        }

        User::create([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'role' => $role,
            'department_id' => $departmentId,
            'is_active' => 1,
        ]);

        Session::set('success', 'کاربر با موفقیت ایجاد شد.');
        $this->redirect('/admin/users');
    }

    public function editUser($id)
    {
        $this->requireAdmin();
        $user = User::find($id);

        if (!$user) {
            die('کاربر یافت نشد');
        }

        $departments = Department::all();
        $this->view('admin/users/edit', [
            'user' => $user,
            'departments' => $departments
        ]);
    }

    public function updateUser($id)
    {
        $this->requireAdmin();
        Request::verifyCsrfToken();

        $user = User::find($id);
        if (!$user) {
            die('کاربر یافت نشد');
        }

        $rules = [
            'name' => 'required|min:3',
            'email' => "required|email|unique:users,email,{$id}",
            'role' => 'required',
        ];

        if (!empty($_POST['password'])) {
            $rules['password'] = 'min:6';
        }

        $validator = new Validator();
        if (!$validator->validate($_POST, $rules)) {
            Session::set('_old', $_POST);
            Session::set('errors', $validator->errors());
            $this->redirect("/admin/users/{$id}/edit");
        }

        $role = $_POST['role'];
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'role' => $role,
            'department_id' => ($role === 'agent') ? ($_POST['department_id'] ?? null) : null,
        ];

        if (!empty($_POST['password'])) {
            $data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }

        User::update($id, $data);
        Session::set('success', 'کاربر با موفقیت به‌روزرسانی شد.');
        $this->redirect('/admin/users');
    }

    public function toggleActive($id)
    {
        $this->requireAdmin();
        Request::verifyCsrfToken();

        $user = User::find($id);
        if (!$user) {
            die('کاربر یافت نشد');
        }

        $newStatus = $user['is_active'] ? 0 : 1;
        User::update($id, ['is_active' => $newStatus]);

        $message = $newStatus ? 'کاربر فعال شد.' : 'کاربر غیرفعال شد.';
        Session::set('success', $message);
        $this->redirect('/admin/users');
    }

    // ==================== مدیریت پارلمان‌ها ====================
    public function departments()
    {
        $this->requireAdmin();
        $departments = Department::all();
        $this->view('admin/departments/index', ['departments' => $departments]);
    }

    public function createDepartment()
    {
        $this->requireAdmin();
        $this->view('admin/departments/create');
    }

    public function storeDepartment()
    {
        $this->requireAdmin();
        Request::verifyCsrfToken();

        $name = $_POST['name'] ?? '';
        if (empty(trim($name))) {
            Session::set('error', 'نام پارلمان الزامی است.');
            $this->redirect('/admin/departments/create');
        }

        Department::create(trim($name));
        Session::set('success', 'پارلمان با موفقیت ایجاد شد.');
        $this->redirect('/admin/departments');
    }

    public function editDepartment($id)
    {
        $this->requireAdmin();
        $department = Department::find($id);

        if (!$department) {
            die('پارلمان یافت نشد');
        }

        $this->view('admin/departments/edit', ['department' => $department]);
    }

    public function updateDepartment($id)
    {
        $this->requireAdmin();
        Request::verifyCsrfToken();

        $department = Department::find($id);
        if (!$department) {
            die('پارلمان یافت نشد');
        }

        $name = $_POST['name'] ?? '';
        if (empty(trim($name))) {
            Session::set('error', 'نام پارلمان الزامی است.');
            $this->redirect("/admin/departments/{$id}/edit");
        }

        Department::update($id, trim($name));
        Session::set('success', 'پارلمان با موفقیت به‌روزرسانی شد.');
        $this->redirect('/admin/departments');
    }

    public function deleteDepartment($id)
    {
        $this->requireAdmin();
        Request::verifyCsrfToken();

        Department::delete($id);
        Session::set('success', 'پارلمان با موفقیت حذف شد.');
        $this->redirect('/admin/departments');
    }

    public function permissionsDepartment($id)
    {
        $this->requireAdmin();

        $department = Department::find($id);
        if (!$department) {
            die('پارلمان یافت نشد');
        }

        $allDepartments = Department::all();
        $permissions = DepartmentPermission::allForDepartment($id);

        // 🔥 مطمئن شو $permissions همیشه آرایه باشه
        if (!is_array($permissions)) {
            $permissions = [];
        }

        $allowedIds = [];
        foreach ($permissions as $p) {
            $allowedIds[] = $p['can_view_department_id'];
        }

        $this->view('admin/departments/permissions', [
            'department' => $department,
            'allDepartments' => $allDepartments,
            'permissions' => $permissions,  // 🔥 این خط رو اضافه کن
            'allowedIds' => $allowedIds
        ]);
    }
    public function addPermission($departmentId)
    {
        $this->requireAdmin();
        Request::verifyCsrfToken();

        $canViewId = $_POST['can_view_department_id'] ?? null;

        if ($canViewId && $canViewId != $departmentId) {
            DepartmentPermission::add($departmentId, $canViewId);
            Session::set('success', 'دسترسی با موفقیت اضافه شد.');
        } else {
            Session::set('error', 'پارلمان انتخاب شده نامعتبر است.');
        }

        $this->redirect("/admin/departments/{$departmentId}/permissions");
    }

    public function removePermission($departmentId)
    {
        $this->requireAdmin();
        Request::verifyCsrfToken();

        $canViewId = $_POST['can_view_department_id'] ?? null;

        if ($canViewId) {
            DepartmentPermission::remove($departmentId, $canViewId);
            Session::set('success', 'دسترسی با موفقیت حذف شد.');
        }

        $this->redirect("/admin/departments/{$departmentId}/permissions");
    }

    // ==================== مدیریت وضعیت‌ها ====================
    public function statuses()
    {
        $this->requireAdmin();
        $statuses = Status::all();
        $this->view('admin/statuses/index', ['statuses' => $statuses]);
    }

    public function createStatus()
    {
        $this->requireAdmin();
        $this->view('admin/statuses/create');
    }

    public function storeStatus()
    {
        $this->requireAdmin();
        Request::verifyCsrfToken();

        $name = $_POST['name'] ?? '';
        $color = $_POST['color'] ?? '#000000';

        if (empty(trim($name))) {
            Session::set('error', 'نام وضعیت الزامی است.');
            $this->redirect('/admin/statuses/create');
        }

        Status::create([
            'name' => trim($name),
            'color' => $color
        ]);

        Session::set('success', 'وضعیت با موفقیت ایجاد شد.');
        $this->redirect('/admin/statuses');
    }

    public function editStatus($id)
    {
        $this->requireAdmin();
        $status = Status::find($id);

        if (!$status) {
            die('وضعیت یافت نشد');
        }

        $this->view('admin/statuses/edit', ['status' => $status]);
    }

    public function updateStatus($id)
    {
        $this->requireAdmin();
        Request::verifyCsrfToken();

        $status = Status::find($id);
        if (!$status) {
            die('وضعیت یافت نشد');
        }

        $name = $_POST['name'] ?? '';
        $color = $_POST['color'] ?? '#000000';

        if (empty(trim($name))) {
            Session::set('error', 'نام وضعیت الزامی است.');
            $this->redirect("/admin/statuses/{$id}/edit");
        }

        Status::update($id, [
            'name' => trim($name),
            'color' => $color
        ]);

        Session::set('success', 'وضعیت با موفقیت به‌روزرسانی شد.');
        $this->redirect('/admin/statuses');
    }

    public function deleteStatus($id)
    {
        $this->requireAdmin();
        Request::verifyCsrfToken();

        Status::delete($id);
        Session::set('success', 'وضعیت با موفقیت حذف شد.');
        $this->redirect('/admin/statuses');
    }

    // ==================== مدیریت اولویت‌ها ====================
    public function priorities()
    {
        $this->requireAdmin();
        $priorities = Priority::all();
        $this->view('admin/priorities/index', ['priorities' => $priorities]);
    }

    public function createPriority()
    {
        $this->requireAdmin();
        $this->view('admin/priorities/create');
    }

    public function storePriority()
    {
        $this->requireAdmin();
        Request::verifyCsrfToken();

        $name = $_POST['name'] ?? '';
        $color = $_POST['color'] ?? '#000000';

        if (empty(trim($name))) {
            Session::set('error', 'نام اولویت الزامی است.');
            $this->redirect('/admin/priorities/create');
        }

        Priority::create([
            'name' => trim($name),
            'color' => $color
        ]);

        Session::set('success', 'اولویت با موفقیت ایجاد شد.');
        $this->redirect('/admin/priorities');
    }

    public function editPriority($id)
    {
        $this->requireAdmin();
        $priority = Priority::find($id);

        if (!$priority) {
            die('اولویت یافت نشد');
        }

        $this->view('admin/priorities/edit', ['priority' => $priority]);
    }

    public function updatePriority($id)
    {
        $this->requireAdmin();
        Request::verifyCsrfToken();

        $priority = Priority::find($id);
        if (!$priority) {
            die('اولویت یافت نشد');
        }

        $name = $_POST['name'] ?? '';
        $color = $_POST['color'] ?? '#000000';

        if (empty(trim($name))) {
            Session::set('error', 'نام اولویت الزامی است.');
            $this->redirect("/admin/priorities/{$id}/edit");
        }

        Priority::update($id, [
            'name' => trim($name),
            'color' => $color
        ]);

        Session::set('success', 'اولویت با موفقیت به‌روزرسانی شد.');
        $this->redirect('/admin/priorities');
    }

    public function deletePriority($id)
    {
        $this->requireAdmin();
        Request::verifyCsrfToken();

        Priority::delete($id);
        Session::set('success', 'اولویت با موفقیت حذف شد.');
        $this->redirect('/admin/priorities');
    }

    // ==================== مدیریت تنظیمات ====================
    public function settings()
    {
        $this->requireAdmin();
        $settings = Setting::getAsArray();
        $this->view('admin/settings/index', ['settings' => $settings]);
    }

    public function updateSettings()
    {
        $this->requireAdmin();
        Request::verifyCsrfToken();

        $maxUploadSize = $_POST['max_upload_size'] ?? '5242880';
        $allowedExtensions = $_POST['allowed_extensions'] ?? 'jpg,jpeg,png,pdf,docx,zip';

        Setting::set('max_upload_size', $maxUploadSize);
        Setting::set('allowed_extensions', $allowedExtensions);

        Session::set('success', 'تنظیمات با موفقیت به‌روزرسانی شد.');
        $this->redirect('/admin/settings');
    }
}