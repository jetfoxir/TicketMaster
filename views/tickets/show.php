<?php
$statusBadge = '<span class="badge" style="background-color: ' . e($ticket['status_color']) . '">' . e($ticket['status_name']) . '</span>';
$priorityBadge = '<span class="badge" style="background-color: ' . e($ticket['priority_color']) . '">' . e($ticket['priority_name']) . '</span>';
?>

    <div class="mb-3">
        <a href="/tickets" class="btn btn-secondary">&larr; بازگشت به لیست</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><?= e($ticket['subject']) ?> <small class="text-muted">#<?= $ticket['id'] ?></small></h4>
            <div>
                <?= $priorityBadge ?>
                <?= $statusBadge ?>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>پارلمان:</strong> <?= e($ticket['department_name']) ?><br>
                <strong>تاریخ ایجاد:</strong> <?= e($ticket['created_at']) ?><br>
                <strong>آخرین بروزرسانی:</strong> <?= e($ticket['updated_at']) ?>
            </div>
            <hr>
            <div class="p-3 bg-light rounded">
                <?= nl2br(e($ticket['body'])) ?>
            </div>

            <?php if (!empty($attachments)): ?>
                <hr>
                <strong>فایل‌های پیوست:</strong>
                <ul class="list-group mt-2">
                    <?php foreach ($attachments as $att): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= e($att['file_name']) ?>
                            <span class="text-muted"><?= round($att['file_size'] / 1024, 2) ?> KB</span>
                            <a href="/attachments/<?= $att['id'] ?>/download" class="btn btn-sm btn-outline-primary">دانلود</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <!-- پاسخ‌ها -->
    <h5>پاسخ‌ها</h5>
<?php foreach ($replies as $reply): ?>
    <?php if ($reply['is_internal'] && $role === 'client') continue; ?>
    <div class="card mb-2 <?= $reply['is_internal'] ? 'border-warning bg-light' : '' ?>">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><?= e($reply['user_name']) ?></strong>
            <small class="text-muted"><?= e($reply['created_at']) ?></small>
            <?php if ($reply['is_internal']): ?>
                <span class="badge bg-warning text-dark">یادداشت داخلی</span>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <?= nl2br(e($reply['message'])) ?>
        </div>
    </div>
<?php endforeach; ?>

    <!-- فرم پاسخ -->
<?php if (in_array($role, ['client', 'agent', 'admin'])): ?>
    <div class="card shadow mt-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">ارسال پاسخ</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="/tickets/<?= $ticket['id'] ?>/reply" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= \App\Core\Request::generateCsrfToken() ?>">

                <div class="mb-3">
                    <textarea name="message" class="form-control" rows="4" required placeholder="متن پاسخ..."></textarea>
                </div>

                <?php if (in_array($role, ['agent', 'admin'])): ?>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_internal" id="is_internal" class="form-check-input" value="1">
                        <label for="is_internal" class="form-check-label">یادداشت داخلی (فقط کارشناسان می‌بینند)</label>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <input type="file" name="attachment" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">ارسال پاسخ</button>
            </form>
        </div>
    </div>
<?php endif; ?>

    <!-- تغییر وضعیت (فقط agent/admin) -->
<?php if (in_array($role, ['agent', 'admin'])): ?>
    <div class="card shadow mt-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">تغییر وضعیت</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="/tickets/<?= $ticket['id'] ?>/change-status" class="row g-2">
                <input type="hidden" name="csrf_token" value="<?= \App\Core\Request::generateCsrfToken() ?>">
                <div class="col-auto">
                    <select name="status_id" class="form-select">
                        <?php foreach ($statuses as $status): ?>
                            <option value="<?= $status['id'] ?>" <?= $ticket['status_id'] == $status['id'] ? 'selected' : '' ?>>
                                <?= e($status['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-warning">تغییر</button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>