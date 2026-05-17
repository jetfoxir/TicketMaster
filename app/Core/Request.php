<?php
namespace App\Core;

class Request
{
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getPath()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = strtok($uri, '?');
        $base = dirname($_SERVER['SCRIPT_NAME']);
        $path = substr($uri, strlen($base));
        return '/' . trim($path, '/');
    }

    public function input($key, $default = null)
    {
        return $_REQUEST[$key] ?? $default;
    }

    public function all()
    {
        return $_REQUEST;
    }

    public function file($key)
    {
        return $_FILES[$key] ?? null;
    }

    // CSRF Token
    public static function generateCsrfToken()
    {
        $token = bin2hex(random_bytes(32));
        Session::set('csrf_token', $token);
        return $token;
    }

    public static function verifyCsrfToken()
    {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== Session::get('csrf_token')) {
            die('CSRF token mismatch');
        }
    }
}