<?php
require_once __DIR__ . '/../app/Core/Autoload.php';
\App\Core\Autoload::register();

require_once __DIR__ . '/../app/Helpers/functions.php';

\App\Core\Session::start();

use App\Core\Router;
use App\Core\Request;

$router = new Router();

// ==================== احراز هویت ====================
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@showRegister');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');

// ==================== تیکت‌ها ====================
$router->get('/', 'TicketController@index');
$router->get('/tickets', 'TicketController@index');
$router->get('/tickets/create', 'TicketController@create');
$router->post('/tickets/store', 'TicketController@store');
$router->get('/tickets/{id}', 'TicketController@show');
$router->post('/tickets/{id}/reply', 'TicketController@reply');
$router->post('/tickets/{id}/change-status', 'TicketController@changeStatus');
$router->get('/attachments/{id}/download', 'TicketController@download');

// ==================== پنل مدیریت ====================
$router->get('/admin', 'AdminController@dashboard');

// کاربران
$router->get('/admin/users', 'AdminController@users');
$router->get('/admin/users/create', 'AdminController@createUser');
$router->post('/admin/users/store', 'AdminController@storeUser');
$router->get('/admin/users/{id}/edit', 'AdminController@editUser');
$router->post('/admin/users/{id}/update', 'AdminController@updateUser');
$router->post('/admin/users/{id}/toggle-active', 'AdminController@toggleActive');

// پارلمان‌ها
$router->get('/admin/departments', 'AdminController@departments');
$router->get('/admin/departments/create', 'AdminController@createDepartment');
$router->post('/admin/departments/store', 'AdminController@storeDepartment');
$router->get('/admin/departments/{id}/edit', 'AdminController@editDepartment');
$router->post('/admin/departments/{id}/update', 'AdminController@updateDepartment');
$router->get('/admin/departments/{id}/permissions', 'AdminController@permissionsDepartment');
$router->post('/admin/departments/{id}/permissions/add', 'AdminController@addPermission');
$router->post('/admin/departments/{id}/permissions/remove', 'AdminController@removePermission');

// وضعیت‌ها
$router->get('/admin/statuses', 'AdminController@statuses');
$router->post('/admin/statuses/store', 'AdminController@storeStatus');
$router->get('/admin/statuses/{id}/edit', 'AdminController@editStatus');
$router->post('/admin/statuses/{id}/update', 'AdminController@updateStatus');

// اولویت‌ها
$router->get('/admin/priorities', 'AdminController@priorities');
$router->post('/admin/priorities/store', 'AdminController@storePriority');
$router->get('/admin/priorities/{id}/edit', 'AdminController@editPriority');
$router->post('/admin/priorities/{id}/update', 'AdminController@updatePriority');

// تنظیمات
$router->get('/admin/settings', 'AdminController@settings');
$router->post('/admin/settings/update', 'AdminController@updateSettings');

// ==================== اجرای درخواست ====================
$request = new Request();
$router->dispatch($request);