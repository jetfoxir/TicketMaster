<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">ثبت‌نام</h4>
            </div>
            <div class="card-body">
                <?php if ($errors = \App\Core\Session::get('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $field => $msgs): ?>
                                <?php foreach ($msgs as $msg): ?>
                                    <li><?= e($msg) ?></li>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php \App\Core\Session::remove('errors'); ?>
                <?php endif; ?>

                <form method="POST" action="/register">
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
                        <label for="password_confirmation" class="form-label">تکرار رمز عبور</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">ثبت‌نام</button>
                </form>
                <div class="text-center mt-3">
                    <a href="/login">قبلاً ثبت‌نام کرده‌اید؟ وارد شوید</a>
                </div>
            </div>
        </div>
    </div>
</div>