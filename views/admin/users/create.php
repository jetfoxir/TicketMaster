<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">ایجاد کاربر جدید</h4>
            </div>
            <div class="card-body">
                <?php if ($errors = \App\Core\Session::get('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $msgs): ?>
                                <?php foreach ($msgs as $msg): ?>
                                    <li><?= e($msg) ?></li>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/admin/users/store">
                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Request::generateCsrfToken() ?>">

                    <div class="mb-3">
                        <label for="name" class="form-label">نام</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= old('name') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">ایمیل</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= old('email') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">رمز عبور</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">نقش</label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="">انتخاب کنید...</option>
                            <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>ادمین</option>
                            <option value="agent" <?= old('role') === 'agent' ? 'selected' : '' ?>>کارشناس</option>
                            <option value="client" <?= old('role') === 'client' ? 'selected' : '' ?>>مشتری</option>
                        </select>
                    </div>

                    <div class="mb-3" id="departmentGroup" style="display:none">
                        <label for="department_id" class="form-label">پارلمان</label>
                        <select name="department_id" id="department_id" class="form-select">
                            <option value="">انتخاب کنید...</option>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?= $dept['id'] ?>"><?= e($dept['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">ایجاد کاربر</button>
                    <a href="/admin/users" class="btn btn-secondary">انصراف</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('role').addEventListener('change', function() {
        var deptGroup = document.getElementById('departmentGroup');
        deptGroup.style.display = this.value === 'agent' ? 'block' : 'none';
    });
</script>