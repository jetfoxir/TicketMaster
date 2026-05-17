<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>مدیریت پارلمان‌ها</h2>
    <a href="/admin/departments/create" class="btn btn-primary">ایجاد پارلمان جدید</a>
</div>

<table class="table table-striped table-hover">
    <thead class="table-dark">
    <tr>
        <th>#</th>
        <th>نام</th>
        <th>عملیات</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($departments as $dept): ?>
        <tr>
            <td><?= $dept['id'] ?></td>
            <td><?= e($dept['name']) ?></td>
            <td>
                <a href="/admin/departments/<?= $dept['id'] ?>/permissions" class="btn btn-sm btn-info">دسترسی‌ها</a>
                <a href="/admin/departments/<?= $dept['id'] ?>/edit" class="btn btn-sm btn-warning">ویرایش</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>