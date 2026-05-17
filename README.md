

# 🎫 سیستم تیکتینگ (Help Desk)

پروژه دانشگاهی سیستم پشتیبانی با **PHP خالص**، معماری **MVC** و پایگاه داده **MySQL**

![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?logo=bootstrap&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?logo=docker&logoColor=white)



## ✨ ویژگی‌ها

- معماری **MVC** و کدهای کاملاً **شیءگرا**
- احراز هویت با **سه نقش** (`admin`, `agent`, `client`)
- **پارلمان‌ها (Departments)** با قابلیت **دسترسی پویا** (Cross‑Department View)
- **وضعیت‌ها** و **اولویت‌ها** با رنگ‌های قابل تنظیم توسط ادمین
- ریسه مکالمه (Thread) به همراه **یادداشت داخلی (Internal Note)** برای کارشناسان
- آپلود فایل با محدودیت حجم و پسوند (قابل تنظیم)
- **Cron Job** برای بستن خودکار تیکت‌های راکد
- امنیت بالا: **PDO + Prepared Statements**، **CSRF Token**، **XSS Prevention**
- رابط کاربری **فارسی و واکنش‌گرا** (Bootstrap 5 RTL)

---

## 🧱 ساختار پروژه

```
├── public/                  # Document Root
│   ├── index.php            # Front Controller
│   ├── .htaccess            # Rewrite rules
│   └── assets/              # CSS / JS
├── app/
│   ├── Controllers/         # منطق برنامه
│   ├── Models/              # ارتباط با دیتابیس
│   ├── Core/                # هسته (Router, Database, Session, View, ...)
│   └── Helpers/             # توابع کمکی
├── views/                   # قالب‌های نمایش
│   ├── layouts/
│   ├── auth/
│   ├── tickets/
│   └── admin/
├── uploads/                 # فایل‌های آپلود شده (غیرقابل دسترس مستقیم)
├── cron/
│   └── close_stale_tickets.php
├── config/
│   └── database.php         # تنظیمات اتصال پایگاه داده
├── database.sql             # ساختار جداول + داده‌های پیش‌فرض
├── Dockerfile
├── docker-compose.yml
└── README.md
```

---

## 🚀 نصب و راه‌اندازی

### 🐳 با Docker (پیشنهادی)

1. پروژه را دریافت کنید:

   ```bash
   git clone https://github.com/YOUR_USERNAME/ticketing.git
   cd ticketing
   ```

2. (اختیاری) یک فایل `.env` برای رمز عبور دیتابیس بسازید:

   ```bash
   echo 'MYSQL_ROOT_PASSWORD=YourStrongPassword' > .env
   ```

3. اجرا کنید:

   ```bash
   docker compose up -d --build
   ```

4. پروژه آماده است:

   - **آدرس پروژه:** [http://localhost:9090](http://localhost:9090)
   - **phpMyAdmin:** [http://localhost:9091](http://localhost:9091)  
     (Server: `db`, User: `root`, Password: `secret` یا مقدار داخل `.env`)

5. **اطلاعات ورود پیش‌فرض:**

   - 📧 ایمیل: `admin@example.com`
   - 🔑 رمز عبور: `password`

---

### 🌐 روی هاست معمولی

1. فایل‌ها را در هاست آپلود کنید (مثلاً در پوشه `ticket`).

2. یک پایگاه داده جدید بسازید و فایل `database.sql` را در آن **ایمپورت** کنید.

3. فایل `config/database.php` را با اطلاعات هاست خود ویرایش کنید:

   ```php
   return [
       'host'     => 'localhost',
       'dbname'   => 'نام_دیتابیس_شما',
       'username' => 'نام_کاربری_دیتابیس',
       'password' => 'رمز_عبور_دیتابیس',
       'charset'  => 'utf8mb4',
   ];
   ```

4. **Document Root** را به پوشه `public` تنظیم کنید (مهم):

   - **در cPanel / DirectAdmin:**  
     به مدیریت ساب‌دامین بروید و Document Root را به `ticket/public` تغییر دهید.

   - **اگر دسترسی ندارید:**  
     یک فایل `index.php` در ریشه پروژه (`ticket/`) بسازید:

     ```php
     <?php require __DIR__ . '/public/index.php';
     ```

     سپس فایل `.htaccess` اضافی در ریشه را **پاک کنید**.

5. دسترسی نوشتن به پوشه `uploads/` بدهید:

   ```bash
   chmod -R 775 uploads/
   ```

6. پروژه را در مرورگر باز کنید و با اطلاعات پیش‌فرض ادمین وارد شوید.

---

## ⏰ کرون جاب (Cron Job)

اسکریپت `cron/close_stale_tickets.php` تیکت‌هایی که **۴۸ ساعت** در وضعیت «در انتظار پاسخ» مانده‌اند را به طور خودکار می‌بندد.

- **روی هاست معمولی (Cron Job):**

  ```
  0 */12 * * * /usr/bin/php /home/username/ticket/cron/close_stale_tickets.php
  ```

- **با Docker:**

  ```bash
  docker exec ticketing_web php /var/www/html/cron/close_stale_tickets.php
  ```

---

## 👥 نقش‌های کاربری

| نقش | دسترسی‌ها |
|:---:|---|
| **Admin** | مدیریت کامل کاربران، پارلمان‌ها، وضعیت‌ها، اولویت‌ها، تنظیمات، مشاهده تمام تیکت‌ها |
| **Agent** | مشاهده تیکت‌های پارلمان خود و پارلمان‌های مجاز، پاسخ‌دهی، یادداشت داخلی، تغییر وضعیت |
| **Client** | ایجاد تیکت، مشاهده و پاسخ به تیکت‌های خود (بدون دیدن یادداشت‌های داخلی) |

---

## 🔐 امنیت

- **PDO + Prepared Statements** برای جلوگیری از SQL Injection
- **CSRF Token** روی تمام فرم‌های POST
- **Password Hashing** با `password_hash()` و `password_verify()`
- **XSS Prevention** با `htmlspecialchars()`
- فایل‌های حساس (`app/`, `views/`, `config/`) **خارج از Document Root**
- محدودیت دانلود فایل‌های پیوست فقط برای کاربران مجاز

---

## 🛠️ رفع مشکلات رایج

<details>
  <summary><strong>ERR_TOO_MANY_REDIRECTS</strong></summary>

- Document Root را به پوشه `public/` تنظیم کنید.
- یا از `RedirectMatch` در `.htaccess` ریشه استفاده کنید:
  ```apache
  RedirectMatch 302 ^/(?!public/)(.*) /public/$1
  ```
</details>

<details>
  <summary><strong>CSRF token mismatch</strong></summary>

- از وجود پوشه `sessions/` و قابل نوشتن بودن آن اطمینان حاصل کنید:
  ```bash
  mkdir sessions
  chmod 700 sessions
  ```
- در فایل `app/Core/Session.php` مطمئن شوید `session_start()` به درستی فراخوانی می‌شود.
</details>

<details>
  <summary><strong>خطای اتصال به پایگاه داده</strong></summary>

- اطلاعات `config/database.php` را با هاست خود تطبیق دهید.
- در Docker مطمئن شوید `DB_HOST=db` تنظیم شده است.
</details>

---

## 📄 مجوز

این پروژه تحت مجوز **MIT** منتشر شده است. برای اطلاعات بیشتر فایل [LICENSE](LICENSE) را مطالعه کنید.

---


