<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">ایجاد تیکت جدید</h4>
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

                <form method="POST" action="/tickets/store" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Request::generateCsrfToken() ?>">

                    <div class="mb-3">
                        <label for="subject" class="form-label">عنوان</label>
                        <input type="text" name="subject" id="subject" class="form-control" value="<?= old('subject') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="department_id" class="form-label">پارلمان</label>
                        <select name="department_id" id="department_id" class="form-select" required>
                            <option value="">انتخاب کنید...</option>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?= $dept['id'] ?>" <?= old('department_id') == $dept['id'] ? 'selected' : '' ?>>
                                    <?= e($dept['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="priority_id" class="form-label">اولویت</label>
                        <select name="priority_id" id="priority_id" class="form-select" required>
                            <option value="">انتخاب کنید...</option>
                            <?php foreach ($priorities as $priority): ?>
                                <option value="<?= $priority['id'] ?>" <?= old('priority_id') == $priority['id'] ? 'selected' : '' ?>>
                                    <?= e($priority['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="body" class="form-label">متن تیکت</label>
                        <textarea name="body" id="body" class="form-control" rows="6" required><?= old('body') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="attachment" class="form-label">فایل پیوست (اختیاری)</label>
                        <input type="file" name="attachment" id="attachment" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">ثبت تیکت</button>
                    <a href="/tickets" class="btn btn-secondary">انصراف</a>
                </form>
            </div>
        </div>
    </div>
</div>