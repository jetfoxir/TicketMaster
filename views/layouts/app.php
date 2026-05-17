<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سیستم تیکتینگ</title>
    <link href="https://lib.arvancloud.ir/bootstrap/5.3.0/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="/assets/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">Help Desk</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="/admin/users">کاربران</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/departments">پارلمان‌ها</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/statuses">وضعیت‌ها</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/priorities">اولویت‌ها</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/settings">تنظیمات</a></li>
                        <li class="nav-item"><a class="nav-link" href="/tickets">همه تیکت‌ها</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="/tickets">تیکت‌ها</a></li>
                        <?php if ($_SESSION['role'] === 'client'): ?>
                            <li class="nav-item"><a class="nav-link" href="/tickets/create">ایجاد تیکت جدید</a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <li class="nav-item"><span class="nav-link text-light"><?= e($_SESSION['name']) ?></span></li>
                    <li class="nav-item"><a class="nav-link" href="/logout">خروج</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/login">ورود</a></li>
                    <li class="nav-item"><a class="nav-link" href="/register">ثبت‌نام</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4">
    <?php if ($msg = \App\Core\Session::get('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= e($msg) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php \App\Core\Session::remove('success'); ?>
    <?php endif; ?>

    <?php if ($msg = \App\Core\Session::get('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= e($msg) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php \App\Core\Session::remove('error'); ?>
    <?php endif; ?>

    <?= $content ?? '' ?>
</main>

<script src="https://lib.arvancloud.ir/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>