<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">ورود به سیستم</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="/login">
                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Request::generateCsrfToken() ?>">

                    <div class="mb-3">
                        <label for="email" class="form-label">ایمیل</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= old('email') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">رمز عبور</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">ورود</button>
                </form>
                <div class="text-center mt-3">
                    <a href="/register">ثبت‌نام نکرده‌اید؟ ثبت‌نام کنید</a>
                </div>
            </div>
        </div>
    </div>
</div>