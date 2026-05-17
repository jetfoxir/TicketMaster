<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>مدیریت کاربران</h2>
    <a href="/admin/users/create" class="btn btn-primary">ایجاد کاربر جدید</a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>نام</th>
            <th>ایمیل</th>
            <th>نقش</th>
            <th>پارلمان</th>
            <th>وضعیت</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= e($user['name']) ?></td>
                <td><?= e($user['email']) ?></td>
                <td>
                    <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'agent' ? 'warning' : 'primary') ?>">
                        <?= e($user['role']) ?>
                    </span>
                </td>
                <td><?= e($user['department_id'] ?? '-') ?></td>
                <td>
                    <span class="badge bg-<?= $user['is_active'] ? 'success' : 'secondary' ?>">
                        <?= $user['is_active'] ? 'فعال' : 'غیرفعال' ?>
                    </span>
                </td>
                <td>
                    <a href="/admin/users/<?= $user['id'] ?>/edit" class="btn btn-sm btn-warning">ویرایش</a>
                    <form method="POST" action="/admin/users/<?= $user['id'] ?>/toggle-active" style="display:inline">
                        <input type="hidden" name="csrf_token" value="<?= \App\Core\Request::generateCsrfToken() ?>">
                        <button type="submit" class="btn btn-sm btn-<?= $user['is_active'] ? 'secondary' : 'success' ?>">
                            <?= $user['is_active'] ? 'غیرفعال' : 'فعال' ?>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>