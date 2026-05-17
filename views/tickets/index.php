<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>لیست تیکت‌ها</h2>
    <?php if ($role === 'client'): ?>
        <a href="/tickets/create" class="btn btn-primary">ایجاد تیکت جدید</a>
    <?php endif; ?>
</div>

<?php if (empty($tickets)): ?>
    <div class="alert alert-info">هیچ تیکتی یافت نشد.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>عنوان</th>
                <th>پارلمان</th>
                <th>اولویت</th>
                <th>وضعیت</th>
                <th>تاریخ</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td><?= $ticket['id'] ?></td>
                    <td><?= e($ticket['subject']) ?></td>
                    <td><?= e($ticket['department_name']) ?></td>
                    <td>
                        <span class="badge" style="background-color: <?= e($ticket['priority_color']) ?>">
                            <?= e($ticket['priority_name']) ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge" style="background-color: <?= e($ticket['status_color']) ?>">
                            <?= e($ticket['status_name']) ?>
                        </span>
                    </td>
                    <td><?= e($ticket['updated_at']) ?></td>
                    <td>
                        <a href="/tickets/<?= $ticket['id'] ?>" class="btn btn-sm btn-info">مشاهده</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>