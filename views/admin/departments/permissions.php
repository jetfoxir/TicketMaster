<div class="mb-3">
    <a href="/admin/departments" class="btn btn-secondary">&larr; بازگشت</a>
</div>

<h2>دسترسی‌های پارلمان: <?= e($department['name']) ?></h2>

<div class="card shadow mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">پارلمان‌های قابل مشاهده توسط این پارلمان</h5>
    </div>
    <div class="card-body">
        <ul class="list-group">
            <?php foreach ($permissions as $perm): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= e($perm['can_view_name']) ?>
                    <form method="POST" action="/admin/departments/<?= $department['id'] ?>/permissions/remove" style="display:inline">
                        <input type="hidden" name="csrf_token" value="<?= \App\Core\Request::generateCsrfToken() ?>">
                        <input type="hidden" name="can_view_department_id" value="<?= $perm['can_view_department_id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<div class="card shadow">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">افزودن دسترسی جدید</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/admin/departments/<?= $department['id'] ?>/permissions/add">
            <input type="hidden" name="csrf_token" value="<?= \App\Core\Request::generateCsrfToken() ?>">
            <div class="row">
                <div class="col">
                    <select name="can_view_department_id" class="form-select" required>
                        <option value="">انتخاب پارلمان...</option>
                        <?php foreach ($allDepartments as $dept): ?>
                            <?php if ($dept['id'] != $department['id']): ?>
                                <option value="<?= $dept['id'] ?>"><?= e($dept['name']) ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success">افزودن</button>
                </div>
            </div>
        </form>
    </div>
</div>