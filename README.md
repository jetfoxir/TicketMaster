
---

```
# 🎫 Ticketing System (Help Desk)

<p align="center">
  <img src="https://img.shields.io/badge/PHP-7.4%2B-777BB4?logo=php&logoColor=white" alt="PHP Version">
  <img src="https://img.shields.io/badge/MySQL-5.7%2B-4479A1?logo=mysql&logoColor=white" alt="MySQL Version">
  <img src="https://img.shields.io/badge/License-MIT-green" alt="License">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?logo=bootstrap&logoColor=white" alt="Bootstrap">
  <img src="https://img.shields.io/badge/Docker-Ready-2496ED?logo=docker&logoColor=white" alt="Docker">
</p>

<p align="center">
  یک سیستم تیکتینگ (Help Desk) ساده، شیءگرا و دانشگاهی با <strong>PHP خالص</strong> و معماری <strong>MVC</strong> که برای دفاع پایان‌دوره کاردانی یا نمونه‌کار حرفه‌ای طراحی شده است.
</p>

---

## 📖 فهرست

- [✨ ویژگی‌ها](#-ویژگی‌ها)
- [🧱 ساختار پروژه](#-ساختار-پروژه)
- [🚀 نصب و راه‌اندازی](#-نصب-و-راه‌اندازی)
  - [با Docker (پیشنهادی)](#-با-docker-پیشنهادی)
  - [روی هاست معمولی](#-روی-هاست-معمولی)
- [⚙️ تنظیمات](#️-تنظیمات)
- [⏰ کرون جاب (Cron Job)](#-کرون-جاب-cron-job)
- [👥 نقش‌های کاربری](#-نقش‌های-کاربری)
- [🔐 ویژگی‌های امنیتی](#-ویژگی‌های-امنیتی)
- [🖼️ پیش‌نمایش](#️-پیش‌نمایش)
- [🛠️ رفع مشکلات رایج](#️-رفع-مشکلات-رایج)
- [🤝 مشارکت](#-مشارکت)
- [📄 مجوز](#-مجوز)

---

## ✨ ویژگی‌ها

- 🧠 **معماری MVC** – تفکیک کامل Model، View و Controller
- 🔐 **احراز هویت و سطح دسترسی** – سه نقش admin، agent و client
- 🏢 **مدیریت پارلمان‌ها (Departments)** – با دسترسی پویا (Cross-Department Viewing)
- 🎯 **وضعیت‌ها و اولویت‌های قابل تنظیم** – ادمین می‌تواند وضعیت/اولویت جدید با رنگ دلخواه بسازد
- 💬 **ریسهٔ مکالمه (Thread)** – به همراه **یادداشت‌های داخلی (Internal Notes)** که فقط کارشناسان می‌بینند
- 📎 **پیوست فایل** – با محدودیت حجم و فرمت‌های قابل تنظیم توسط ادمین
- ⏰ **بستن خودکار تیکت‌های راکد** – از طریق Cron Job
- 🛡️ **CSRF Protection** – روی تمام فرم‌های حساس
- 🧹 **PDO + Prepared Statements** – امنیت بالا در برابر SQL Injection
- 🐳 **Docker-Ready** – اجرای کامل با یک دستور
- 🎨 **رابط کاربری فارسی و واکنش‌گرا** – با Bootstrap 5 RTL

---

## 🧱 ساختار پروژه

```
project/
├── public/                  # 📂 Document Root
│   ├── index.php            # Front Controller
│   ├── .htaccess            # Rewrite rules
│   └── assets/              # CSS/JS
├── app/
│   ├── Controllers/         # 🎮 منطق برنامه
│   ├── Models/              # 🗄️ ارتباط با دیتابیس
│   ├── Core/                # ⚙️ هسته (Router, Database, Session, ...)
│   └── Helpers/             # 🛟 توابع کمکی
├── views/                   # 🎨 قالب‌های نمایش
│   ├── layouts/             # قالب اصلی (app.php)
│   ├── auth/                # ورود / ثبت‌نام
│   ├── tickets/             # تیکت‌ها
│   └── admin/               # پنل مدیریت
├── uploads/                 # 📎 فایل‌های آپلودشده (غیرقابل دسترس مستقیم)
├── cron/                    # ⏰ اسکریپت‌های زمان‌بندی
│   └── close_stale_tickets.php
├── config/
│   └── database.php         # 🔧 تنظیمات پایگاه داده
├── database.sql             # 🗃️ ساختار + داده‌های پیش‌فرض
├── Dockerfile
├── docker-compose.yml
└── README.md
```

---

## 🚀 نصب و راه‌اندازی

### 🐳 با Docker (پیشنهادی)

1. **پروژه را Clone کنید** (یا فایل‌ها را در سرور قرار دهید):
   ```bash
   git clone https://github.com/YOUR_USERNAME/ticketing.git
   cd ticketing
   ```

2. **یک فایل `.env` برای رمز عبور دیتابیس بسازید** (اختیاری):
   ```bash
   echo 'MYSQL_ROOT_PASSWORD=YourStrongPassword' > .env
   ```

3. **پروژه را اجرا کنید**:
   ```bash
   docker compose up -d --build
   ```

4. **آماده است!**
   - **پروژه:** [http://localhost:9090](http://localhost:9090)
   - **phpMyAdmin:** [http://localhost:9091](http://localhost:9091)  
     (Server: `db`, User: `root`, Password: `secret` یا آنچه در `.env` تنظیم کرده‌اید)

5. **ورود به پنل مدیریت:**
   - 📧 ایمیل: `admin@example.com`
   - 🔑 رمز عبور: `password`

---

### 🌐 روی هاست معمولی

1. **فایل‌ها را در هاست آپلود کنید** (مثلاً داخل پوشه‌ی `ticket`).

2. **پایگاه داده بسازید** و فایل `database.sql` را در phpMyAdmin **ایمپورت** کنید.

3. **اتصال دیتابیس را تنظیم کنید**:
   فایل `config/database.php` را باز کنید و اطلاعات هاست خود را وارد نمایید:
   ```php
   return [
       'host'     => 'localhost',
       'dbname'   => 'نام_دیتابیس_شما',
       'username' => 'نام_کاربری_دیتابیس',
       'password' => 'رمز_عبور_دیتابیس',
       'charset'  => 'utf8mb4',
   ];
   ```

4. **Document Root را تنظیم کنید** (مهم):
   برای اینکه `public/` در URL نیاید، یکی از راه‌های زیر را انجام دهید:

   #### ✅ روش عالی: تنظیم در cPanel / DirectAdmin
   - به بخش **Subdomains** بروید و Document Root ساب‌دامین را به `ticket/public` تغییر دهید.

   #### ✅ روش خوب: سیم‌لینک (SSH)
   ```bash
   cd ticket
   rm -rf public_html  # اگر وجود داشت
   ln -s public public_html
   ```
   سپس Document Root را به `ticket/public_html` تغییر دهید.

   #### ✅ روش جایگزین: فایل index.php در ریشه
   اگر به هیچ‌کدام دسترسی ندارید، یک فایل `index.php` در ریشهٔ `ticket/` بسازید:
   ```php
   <?php require __DIR__ . '/public/index.php';
   ```
   (در این صورت نیازی به `.htaccess` اضافی نیست.)

5. **مجوز نوشتن به پوشه `uploads/` بدهید**:
   ```bash
   chmod -R 775 uploads/
   ```

6. پروژه را در مرورگر باز کنید و با اطلاعات پیش‌فرض ادمین وارد شوید.

---

## ⚙️ تنظیمات

ادمین می‌تواند از طریق پنل مدیریت، موارد زیر را سفارشی‌سازی کند:

- **حداکثر حجم آپلود** (پیش‌فرض ۵MB)
- **فرمت‌های مجاز فایل** (jpg, png, pdf, docx, zip)
- **ایجاد/ویرایش/حذف وضعیت‌ها (Statuses)** با رنگ دلخواه
- **ایجاد/ویرایش/حذف اولویت‌ها (Priorities)** با رنگ دلخواه
- **مدیریت پارلمان‌ها (Departments)** و **دسترسی‌های متقابل** (کدام پارلمان تیکت‌های پارلمان دیگر را ببیند)

---

## ⏰ کرون جاب (Cron Job)

اسکریپت `cron/close_stale_tickets.php` تیکت‌هایی که **۴۸ ساعت** در وضعیت «در انتظار پاسخ» مانده‌اند را به‌طور خودکار **بسته** می‌کند.

**تنظیم در Cron Job (روی هاست):**
```
0 */12 * * * /usr/bin/php /home/username/ticket/cron/close_stale_tickets.php
```

**با Docker:**
```bash
docker exec ticketing_web php /var/www/html/cron/close_stale_tickets.php
```

---

## 👥 نقش‌های کاربری

| نقش | قابلیت‌ها |
|---|---|
| **Admin** | مدیریت کاربران، پارلمان‌ها، وضعیت‌ها، اولویت‌ها، تنظیمات، مشاهدهٔ تمام تیکت‌ها |
| **Agent** | مشاهدهٔ تیکت‌های پارلمان خود + پارلمان‌های مجاز، پاسخ‌دهی، یادداشت داخلی، تغییر وضعیت |
| **Client** | ایجاد تیکت جدید، مشاهده و پاسخ به تیکت‌های خود (عدم مشاهدهٔ یادداشت‌های داخلی) |

---

## 🔐 ویژگی‌های امنیتی

- **PDO + Prepared Statements** – جلوگیری کامل از SQL Injection
- **CSRF Token** – روی تمام فرم‌های POST
- **Password Hashing** – با `password_hash()` و `password_verify()`
- **XSS Prevention** – خروجی‌ها با `htmlspecialchars()`
- **فایل‌های حساس خارج از Document Root** – پوشه‌های `app/`, `views/`, `config/` از وب غیرقابل دسترس هستند
- **محدودیت دانلود فایل** – فقط کاربران مجاز می‌توانند پیوست‌ها را دانلود کنند

---

## 🖼️ پیش‌نمایش

> اسکرین‌شات‌های زیر ظاهر کلی پروژه را نشان می‌دهند. می‌توانید تصاویر واقعی پروژه را در پوشه `screenshots/` قرار دهید.

| صفحهٔ اصلی (لیست تیکت‌ها) | صفحهٔ نمایش تیکت |
|:---:|:---:|
| ![Tickets List](screenshots/tickets_index.png) | ![Ticket Show](screenshots/ticket_show.png) |

| پنل مدیریت (کاربران) | مدیریت پارلمان‌ها |
|:---:|:---:|
| ![Admin Users](screenshots/admin_users.png) | ![Departments](screenshots/departments.png) |

---

## 🛠️ رفع مشکلات رایج

### ❌ خطای `ERR_TOO_MANY_REDIRECTS`
- Document Root را به پوشه `public/` تنظیم کنید (مطابق بخش نصب).
- یا از روش `RedirectMatch 302` در `.htaccess` ریشه استفاده کنید:
  ```apache
  RedirectMatch 302 ^/(?!public/)(.*) /public/$1
  ```

### ❌ خطای `CSRF token mismatch`
- مطمئن شوید پوشه‌ی `sessions/` در ریشهٔ پروژه وجود دارد و قابل نوشتن است:
  ```bash
  mkdir sessions
  chmod 700 sessions
  ```
- در فایل `app/Core/Session.php` مطمئن شوید `session_start()` فراخوانی می‌شود.

### ❌ خطای اتصال به پایگاه داده
- اطلاعات `config/database.php` را با هاست خود تطبیق دهید.
- اگر از Docker استفاده می‌کنید، دقت کنید `DB_HOST` برابر با `db` باشد.

### ❌ فایل‌های CSS/JS بارگذاری نمی‌شوند
- مسیر `assets/` در `views/layouts/app.php` ممکن است نیاز به اصلاح داشته باشد. آدرس CDN بوت‌استرپ را بررسی کنید (پیش‌فرض از `lib.arvancloud.ir` استفاده شده که در ایران در دسترس است).

---

## 🤝 مشارکت

پیشنهادات، Issues و Pull Requests شما باعث بهبود این پروژه می‌شود.  
اگر از این پروژه برای دانشگاه یا نمونه‌کار استفاده می‌کنید، خوشحال می‌شوم با یک ⭐ از آن حمایت کنید.

---

## 📄 مجوز

این پروژه تحت مجوز **MIT** منتشر شده است. برای اطلاعات بیشتر فایل [LICENSE](LICENSE) را ببینید.

---

<p align="center">
  <strong>🎓 مناسب برای ارائهٔ پایان‌دوره کاردانی | 🧩 تمرین عالی MVC خالص | 💼 نمونه‌کار حرفه‌ای برای گیتهاب</strong>
</p>
```

--- 😉
