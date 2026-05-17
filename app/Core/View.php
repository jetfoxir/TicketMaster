<?php
namespace App\Core;

class View
{
    protected $layout = 'layouts/app';

    public function render($view, $data = [])
    {
        extract($data);
        $viewPath = __DIR__ . '/../../views/' . $view . '.php';
        ob_start();
        require $viewPath;
        $content = ob_get_clean();
        require __DIR__ . '/../../views/' . $this->layout . '.php';
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
}