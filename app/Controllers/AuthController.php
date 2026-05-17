<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        $this->view('auth/login');
    }

    public function login()
    {
        Request::verifyCsrfToken();
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $user = User::findByEmail($email);
        if ($user && $user['is_active'] && password_verify($password, $user['password'])) {
            Session::set('user_id', $user['id']);
            Session::set('role', $user['role']);
            Session::set('department_id', $user['department_id']);
            Session::set('name', $user['name']);
            $this->redirect('/tickets');
        }
        Session::set('_old', $_POST);
        Session::set('error', 'اطلاعات ورود صحیح نیست');
        $this->redirect('/login');
    }

    public function showRegister()
    {
        $this->view('auth/register');
    }

    public function register()
    {
        Request::verifyCsrfToken();
        $validator = new Validator();
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ];
        if (!$validator->validate($_POST, $rules)) {
            Session::set('_old', $_POST);
            Session::set('errors', $validator->errors());
            $this->redirect('/register');
        }
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'role' => 'client',
            'is_active' => 1,
        ];
        User::create($data);
        Session::set('success', 'ثبت‌نام با موفقیت انجام شد. وارد شوید.');
        $this->redirect('/login');
    }

    public function logout()
    {
        Session::destroy();
        $this->redirect('/login');
    }
}