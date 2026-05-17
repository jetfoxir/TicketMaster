<?php
namespace App\Core;

class Controller
{
    protected function view($view, $data = [])
    {
        $viewObj = new View();
        $viewObj->render($view, $data);
    }

    protected function redirect($url)
    {
        header("Location: {$url}");
        exit;
    }

    protected function authCheck()
    {
        if (!Session::get('user_id')) {
            $this->redirect('/login');
        }
    }

    protected function isAdmin()
    {
        return Session::get('role') === 'admin';
    }

    protected function requireAdmin()
    {
        $this->authCheck();
        if (!$this->isAdmin()) {
            die('دسترسی غیرمجاز');
        }
    }

    protected function requireAgentOrAdmin()
    {
        $this->authCheck();
        $role = Session::get('role');
        if (!in_array($role, ['agent', 'admin'])) {
            die('دسترسی غیرمجاز');
        }
    }
}