<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-warning">
                <h4 class="mb-0">ویرایش کاربر: <?= e($user['name']) ?></h4>
            </div>
            <div class="card-body">
                <form method="POST" action="/admin/users/<?= $user['id'] ?>/update">
                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Request::generateCsrfToken() ?>">

                    <div class="mb-3">
                        <label for="name" class="form-label">نام</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= e($user['name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">ایمیل</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= e($user['email']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">رمز عبور (خالی بگذارید تا تغییر نکند)</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">نقش</label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>ادمین</option>
                            <option value="agent" <?= $user['role'] === 'agent' ? 'selected' : '' ?>>کارشناس</option>
                            <option value="client" <?= $user['role'] === 'client' ? 'selected' : '' ?>>مشتری</option>
                        </select>
                    </div>

                    <div class="mb-3" id="departmentGroup" style="display:<?= $user['role'] === 'agent' ? 'block' : 'none' ?>">
                        <label for="department_id" class="form-label">پارلمان</label>
                        <select name="department_id" id="department_id" class="form-select">
                            <option value="">انتخاب کنید...</option>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?= $dept['id'] ?>" <?= $user['department_id'] == $dept['id'] ? 'selected' : '' ?>>
                                    <?= e($dept['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-warning">بروزرسانی</button>
                    <a href="/admin/users" class="btn btn-secondary">انصراف</a>
                </form>
            </div>
        </div>
    </div>
</div>