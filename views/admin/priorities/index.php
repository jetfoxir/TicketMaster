<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>مدیریت اولویت‌ها</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">ایجاد اولویت جدید</button>
</div>

<table class="table table-striped">
    <thead class="table-dark">
    <tr>
        <th>#</th>
        <th>نام</th>
        <th>رنگ</th>
        <th>عملیات</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($priorities as $priority): ?>
        <tr>
            <td><?= $priority['id'] ?></td>
            <td>
                <span class="badge" style="background-color: <?= e($priority['color']) ?>">
                    <?= e($priority['name']) ?>
                </span>
            </td>
            <td><input type="color" value="<?= e($priority['color']) ?>" disabled></td>
            <td>
                <a href="/admin/priorities/<?= $priority['id'] ?>/edit" class="btn btn-sm btn-warning">ویرایش</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal Create -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/admin/priorities/store">
                <input type="hidden" name="csrf_token" value="<?= \App\Core\Request::generateCsrfToken() ?>">
                <div class="modal-header">
                    <h5 class="modal-title">ایجاد اولویت جدید</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">نام</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">رنگ</label>
                        <input type="color" name="color" id="color" class="form-control" value="#000000">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">ایجاد</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                </div>
            </form>
        </div>
    </div>
</div>