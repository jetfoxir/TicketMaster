<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-warning">
                <h4 class="mb-0">ویرایش وضعیت</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="/admin/statuses/<?= $status['id'] ?>/update">
                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Request::generateCsrfToken() ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">نام</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= e($status['name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">رنگ</label>
                        <input type="color" name="color" id="color" class="form-control" value="<?= e($status['color']) ?>">
                    </div>
                    <button type="submit" class="btn btn-warning">بروزرسانی</button>
                    <a href="/admin/statuses" class="btn btn-secondary">انصراف</a>
                </form>
            </div>
        </div>
    </div>
</div>