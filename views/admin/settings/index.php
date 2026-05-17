<h2>تنظیمات سیستم</h2>

<div class="card shadow">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">تنظیمات آپلود فایل</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/admin/settings/update">
            <input type="hidden" name="csrf_token" value="<?= \App\Core\Request::generateCsrfToken() ?>">

            <div class="mb-3">
                <label for="max_upload_size" class="form-label">حداکثر حجم فایل (بایت)</label>
                <input type="number" name="max_upload_size" id="max_upload_size" class="form-control" value="<?= e($settings['max_upload_size'] ?? '5242880') ?>">
                <small class="text-muted">پیش‌فرض: 5 مگابایت (5242880 بایت)</small>
            </div>

            <div class="mb-3">
                <label for="allowed_extensions" class="form-label">فرمت‌های مجاز</label>
                <input type="text" name="allowed_extensions" id="allowed_extensions" class="form-control" value="<?= e($settings['allowed_extensions'] ?? 'jpg,jpeg,png,pdf,docx,zip') ?>">
                <small class="text-muted">با کاما جدا کنید. مثال: jpg,png,pdf</small>
            </div>

            <button type="submit" class="btn btn-primary">ذخیره تنظیمات</button>
        </form>
    </div>
</div>