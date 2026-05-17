<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">ایجاد پارلمان جدید</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="/admin/departments/store">
                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Request::generateCsrfToken() ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">نام پارلمان</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">ایجاد</button>
                    <a href="/admin/departments" class="btn btn-secondary">انصراف</a>
                </form>
            </div>
        </div>
    </div>
</div>