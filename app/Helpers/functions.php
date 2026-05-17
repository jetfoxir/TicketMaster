<?php
function e($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function old($key, $default = '')
{
    return e($_SESSION['_old'][$key] ?? $default);
}