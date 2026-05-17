# 🎫 سیستم تیکتینگ (Help Desk)

پروژه دانشگاهی سیستم پشتیبانی تحت وب با **PHP خالص**، معماری **MVC** و پایگاه داده **MySQL**

![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?logo=bootstrap&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?logo=docker&logoColor=white)



## 📋 فهرست

- [✨ ویژگی‌ها](#-ویژگی‌ها)
- [👥 نقش‌های کاربری](#-نقش‌های-کاربری)
- [📦 پیش‌نیازها](#-پیش‌نیازها)
- [📥 دریافت پروژه](#-دریافت-پروژه)
- [🚀 روش اول: اجرا با Docker (ساده‌ترین راه)](#-روش-اول-اجرا-با-docker-ساده‌ترین-راه)
- [🌐 روش دوم: اجرا روی هاست معمولی (cPanel / DirectAdmin)](#-روش-دوم-اجرا-روی-هاست-معمولی-cpanel--directadmin)
- [💻 روش سوم: اجرا روی لوکال (XAMPP / WAMP / MAMP)](#-روش-سوم-اجرا-روی-لوکال-xampp--wamp--mamp)
- [🔑 اطلاعات ورود پیش‌فرض](#-اطلاعات-ورود-پیش‌فرض)
- [⚙️ تنظیمات پنل مدیریت](#️-تنظیمات-پنل-مدیریت)
- [⏰ کرون جاب (Cron Job)](#-کرون-جاب-cron-job)
- [🧱 ساختار پروژه](#-ساختار-پروژه)
- [🔐 ویژگی‌های امنیتی](#-ویژگی‌های-امنیتی)
- [📊 جداول پایگاه داده](#-جداول-پایگاه-داده)
- [🎯 مسیرهای اصلی (Routes)](#-مسیرهای-اصلی-routes)
- [🛠️ رفع مشکلات رایج](#️-رفع-مشکلات-رایج)
- [📚 توضیح معماری (MVC)](#-توضیح-معماری-mvc)
- [🤝 مشارکت](#-مشارکت)
- [📄 مجوز](#-مجوز)

---

## ✨ ویژگی‌ها

| ویژگی | توضیح |
|---|---|
| 🧠 **معماری MVC** | تفکیک کامل Model، View و Controller |
| 🔐 **سه نقش کاربری** | `admin`، `agent` و `client` با دسترسی‌های متفاوت |
| 🏢 **پارلمان‌ها** | مدیریت دپارتمان‌ها با **دسترسی پویا** (پارلمان A تیکت‌های پارلمان B را ببیند) |
| 🎨 **وضعیت‌ها و اولویت‌ها** | ادمین می‌تواند با **رنگ دلخواه** وضعیت/اولویت جدید بسازد |
| 💬 **ریسه مکالمه** | گفتگوی چندنفره روی هر تیکت |
| 📝 **یادداشت داخلی** | کارشناسان می‌توانند یادداشت خصوصی بگذارند (مشتری نمی‌بیند) |
| 📎 **پیوست فایل** | آپلود فایل با **محدودیت حجم و پسوند** (تنظیم توسط ادمین) |
| ⏰ **بستن خودکار تیکت‌ها** | تیکت‌های راکد بعد از ۴۸ ساعت بسته می‌شوند (Cron Job) |
| 🛡️ **امنیت بالا** | PDO Prepared Statements، CSRF Token، XSS Prevention |
| 🎨 **ظاهر فارسی و واکنش‌گرا** | Bootstrap 5 RTL |
| 🐳 **Docker-Ready** | اجرای کامل با یک دستور |

---

## 👥 نقش‌های کاربری

| نقش | دسترسی‌ها | توضیح |
|:---:|---|---|
| **Admin** | همه چیز | مدیریت کاربران، پارلمان‌ها، وضعیت‌ها، اولویت‌ها، تنظیمات، مشاهده تمام تیکت‌ها |
| **Agent** | محدود به پارلمان | مشاهده تیکت‌های پارلمان خود + پارلمان‌های مجاز، پاسخ‌دهی، یادداشت داخلی، تغییر وضعیت |
| **Client** | فقط تیکت‌های خودش | ایجاد تیکت جدید، مشاهده و پاسخ به تیکت‌های خود (یادداشت‌های داخلی را نمی‌بیند) |

---

## 📦 پیش‌نیازها

| نرم‌افزار | حداقل نسخه | توضیح |
|---|---|---|
| **PHP** | 7.4 یا بالاتر | با افزونه‌های `pdo`, `pdo_mysql`, `mbstring` |
| **MySQL** | 5.7 یا بالاتر | یا MariaDB 10.2+ |
| **Apache** | 2.4+ | با فعال بودن `mod_rewrite` |
| **Docker** | (اختیاری) | برای اجرای آسان بدون نصب جداگانه |
| **Composer** | (اختیاری) | فقط اگر می‌خواهید از autoloader خودش استفاده کنید |

---

## 📥 دریافت پروژه

### روش ۱: دانلود مستقیم (پیشنهادی برای کاربران عادی)

1. روی دکمه سبز رنگ **`<> Code`** در بالای همین صفحه کلیک کنید
2. گزینه **Download ZIP** را انتخاب کنید
3. فایل ZIP دانلود شده را در مسیر دلخواه **استخراج** (Extract) کنید
4. نام پوشه استخراج شده معمولاً `ticketing-main` است

### روش ۲: با Git (برای برنامه‌نویسان)

```bash
git clone https://github.com/jetfoxir/ticketing.git
cd ticketing
```

> ⚠️ **توجه:** اگر گیتهاب از شما رمز عبور خواست، باید از **Personal Access Token** استفاده کنید (نه رمز عبور معمولی).  
> راهنما: [ساخت توکن در گیتهاب](https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/managing-your-personal-access-tokens)

---

## 🚀 روش اول: اجرا با Docker (ساده‌ترین راه)

این روش همه چیز (PHP، MySQL، Apache، phpMyAdmin) را خودکار نصب و راه‌اندازی می‌کند.

### ۱. نصب Docker (فقط یک بار)

| سیستم عامل | لینک دانلود |
|---|---|
| **Windows** | [Docker Desktop for Windows](https://docs.docker.com/desktop/install/windows-install/) |
| **macOS** | [Docker Desktop for Mac](https://docs.docker.com/desktop/install/mac-install/) |
| **Linux** | `sudo apt install docker.io docker-compose-v2` (Ubuntu/Debian) |

### ۲. وارد پوشه پروژه شوید

```bash
cd ticketing       # اگر با Git دریافت کردید
cd ticketing-main  # اگر با ZIP دریافت کردید
```

### ۳. (اختیاری) تنظیم رمز عبور دیتابیس

```bash
echo 'MYSQL_ROOT_PASSWORD=YourStrongPassword' > .env
```

اگر این کار را نکنید، رمز عبور پیش‌فرض `secret` خواهد بود.

### ۴. اجرا کنید

```bash
docker compose up -d --build
```

### ۵. تمام!

| سرویس | آدرس | توضیح |
|---|---|---|
| **پروژه تیکتینگ** | http://localhost:9090 | سیستم اصلی |
| **phpMyAdmin** | http://localhost:9091 | مدیریت پایگاه داده |

**اطلاعات ورود به phpMyAdmin:**

| فیلد | مقدار |
|---|---|
| Server | `db` |
| Username | `root` |
| Password | `secret` (یا آنچه در `.env` تنظیم کردید) |

### ۶. توقف پروژه

```bash
docker compose down           # توقف بدون پاک کردن دیتابیس
docker compose down -v        # توقف + پاک کردن کامل دیتابیس
```

### ۷. اجرای کرون جاب (در Docker)

```bash
docker exec ticketing_web php /var/www/html/cron/close_stale_tickets.php
```

---

## 🌐 روش دوم: اجرا روی هاست معمولی (cPanel / DirectAdmin)

### ۱. آپلود فایل‌ها

فایل‌های پروژه (تمام پوشه‌ها) را در هاست خود آپلود کنید.  
مثلاً در مسیر `public_html/ticket/` یا هر جای دیگر.

### ۲. ساخت پایگاه داده

1. وارد **cPanel** → **MySQL® Databases** شوید
2. یک **Database** جدید بسازید (مثلاً `ticketing`)
3. یک **User** جدید بسازید و به آن Database دسترسی کامل بدهید
4. **نام دیتابیس**، **نام کاربری** و **رمز عبور** را یادداشت کنید

### ۳. ایمپورت دیتابیس

1. وارد **phpMyAdmin** شوید
2. دیتابیس ساخته شده را انتخاب کنید
3. روی **Import** کلیک کنید
4. فایل `database.sql` (که در پوشه پروژه است) را انتخاب و اجرا کنید

### ۴. تنظیم فایل کانفیگ

فایل `config/database.php` را با یک ویرایشگر متن باز کنید و اطلاعات واقعی را وارد کنید:

```php
<?php
return [
    'host'     => 'localhost',
    'dbname'   => 'نام_دیتابیسی_که_ساختید',
    'username' => 'نام_کاربری_دیتابیس',
    'password' => 'رمز_عبور_دیتابیس',
    'charset'  => 'utf8mb4',
];
```

### ۵. تنظیم Document Root (بسیار مهم)

برای اینکه آدرس سایت تمیز باشد (بدون `/public/` در URL):

#### ✅ روش عالی: تنظیم در cPanel

1. وارد cPanel → **Domains** یا **Subdomains** شوید
2. دامنه/ساب‌دامین مورد نظر را پیدا کنید
3. **Document Root** را به مسیر `public_html/ticket/public` تغییر دهید
4. ذخیره کنید

#### ✅ روش جایگزین: فایل index.php در ریشه

اگر به تنظیمات Document Root دسترسی ندارید، یک فایل `index.php` در **ریشه پروژه** (کنار پوشه `public/`) بسازید:

```php
<?php
require __DIR__ . '/public/index.php';
```

و فایل `.htaccess` که در ریشه پروژه وجود دارد را **پاک کنید**.

### ۶. تنظیم دسترسی پوشه آپلود

```bash
chmod -R 775 uploads/
```

(از File Manager یا SSH)

### ۷. تنظیم Cron Job (اختیاری ولی توصیه می‌شود)

وارد cPanel → **Cron Jobs** شوید و دستور زیر را اضافه کنید:

```
0 */12 * * * /usr/bin/php /home/username/public_html/ticket/cron/close_stale_tickets.php
```

> `/home/username/public_html/ticket/` را با مسیر واقعی پروژه خود جایگزین کنید.

---

## 💻 روش سوم: اجرا روی لوکال (XAMPP / WAMP / MAMP)

### ۱. نصب XAMPP

از [apachefriends.org](https://www.apachefriends.org/) دانلود و نصب کنید.

### ۲. کپی پروژه

پوشه پروژه را در مسیر `htdocs` کپی کنید:

```
C:\xampp\htdocs\ticketing\
```

### ۳. ساخت دیتابیس

1. XAMPP Control Panel را باز کنید
2. **Apache** و **MySQL** را **Start** کنید
3. مرورگر را باز کنید و به http://localhost/phpmyadmin بروید
4. یک دیتابیس جدید بسازید (مثلاً `ticketing`)
5. فایل `database.sql` را ایمپورت کنید

### ۴. تنظیم کانفیگ

فایل `config/database.php` را ویرایش کنید:

```php
<?php
return [
    'host'     => 'localhost',
    'dbname'   => 'ticketing',
    'username' => 'root',
    'password' => '',          // در XAMPP معمولاً خالی است
    'charset'  => 'utf8mb4',
];
```

### ۵. اجرا

مرورگر را باز کنید و به آدرس زیر بروید:

```
http://localhost/ticketing/public/
```

---

## 🔑 اطلاعات ورود پیش‌فرض

| نقش | ایمیل | رمز عبور | توضیح |
|---|---|---|---|
| **Admin** | `admin@example.com` | `password` | دسترسی کامل به همه بخش‌ها |
| **Agent** | (ندارد - باید بسازید) | — | از پنل ادمین ایجاد کنید |
| **Client** | (ندارد - ثبت‌نام کنید) | — | از صفحه ثبت‌نام ایجاد کنید |

> 🔒 **توصیه امنیتی:** بعد از اولین ورود، حتماً رمز عبور ادمین را تغییر دهید.

---

## ⚙️ تنظیمات پنل مدیریت

بعد از ورود با اکانت ادمین، می‌توانید موارد زیر را شخصی‌سازی کنید:

| بخش | مسیر | توضیح |
|---|---|---|
| **مدیریت کاربران** | `/admin/users` | ایجاد، ویرایش، فعال/غیرفعال‌سازی کاربران |
| **پارلمان‌ها** | `/admin/departments` | ایجاد و مدیریت دپارتمان‌ها + تنظیم **دسترسی‌های متقابل** |
| **وضعیت‌ها** | `/admin/statuses` | ایجاد وضعیت جدید با **نام و رنگ دلخواه** (مثلاً: "در حال بررسی" با رنگ آبی) |
| **اولویت‌ها** | `/admin/priorities` | ایجاد اولویت جدید با **نام و رنگ دلخواه** (مثلاً: "بحرانی" با رنگ قرمز) |
| **تنظیمات** | `/admin/settings` | تنظیم **حداکثر حجم آپلود** (پیش‌فرض 5MB) و **فرمت‌های مجاز** (مثلاً `jpg,png,pdf,docx,zip`) |

---

## ⏰ کرون جاب (Cron Job)

اسکریپت `cron/close_stale_tickets.php` تیکت‌هایی که **۴۸ ساعت** در وضعیت **«در انتظار پاسخ»** مانده‌اند را به‌طور خودکار **می‌بندد**.

### تنظیم در cPanel

```
0 */12 * * * /usr/bin/php /home/username/public_html/ticket/cron/close_stale_tickets.php
```

### تنظیم در Docker

```bash
docker exec ticketing_web php /var/www/html/cron/close_stale_tickets.php
```

### اجرای دستی

```bash
php cron/close_stale_tickets.php
```

---

## 🧱 ساختار پروژه

```
ticketing/
│
├── 📁 public/                      # 🔥 Document Root (تنها پوشه در دسترس وب)
│   ├── 📄 index.php                # Front Controller (همه درخواست‌ها از اینجا عبور می‌کنند)
│   ├── 📄 .htaccess                # Rewrite Rules
│   └── 📁 assets/                  # فایل‌های استاتیک (CSS, JS, تصاویر)
│       └── 📄 style.css
│
├── 📁 app/                         # 🧠 مغز پروژه (غیرقابل دسترس از وب)
│   ├── 📁 Controllers/             # کنترلرها (منطق برنامه)
│   │   ├── 📄 AuthController.php   # ورود، ثبت‌نام، خروج
│   │   ├── 📄 TicketController.php # مدیریت تیکت‌ها
│   │   └── 📄 AdminController.php  # پنل مدیریت
│   ├── 📁 Models/                  # مدل‌ها (ارتباط با دیتابیس)
│   │   ├── 📄 User.php
│   │   ├── 📄 Ticket.php
│   │   ├── 📄 Department.php
│   │   ├── 📄 DepartmentPermission.php
│   │   ├── 📄 Reply.php
│   │   ├── 📄 Attachment.php
│   │   ├── 📄 Status.php
│   │   ├── 📄 Priority.php
│   │   └── 📄 Setting.php
│   ├── 📁 Core/                    # هسته مرکزی
│   │   ├── 📄 Autoload.php         # بارگذاری خودکار کلاس‌ها
│   │   ├── 📄 Database.php         # اتصال PDO (الگوی Singleton)
│   │   ├── 📄 Router.php           # مسیریاب
│   │   ├── 📄 Request.php          # مدیریت درخواست‌ها + CSRF
│   │   ├── 📄 Session.php          # مدیریت نشست
│   │   ├── 📄 View.php             # موتور نمایش (View + Layout)
│   │   ├── 📄 Validator.php        # اعتبارسنجی فرم‌ها
│   │   └── 📄 Controller.php       # کنترلر پایه
│   └── 📁 Helpers/                 # توابع کمکی
│       └── 📄 functions.php
│
├── 📁 views/                       # 🎨 قالب‌های نمایش
│   ├── 📁 layouts/
│   │   └── 📄 app.php              # قالب اصلی (Header, Navbar, Footer)
│   ├── 📁 auth/                    # صفحات احراز هویت
│   │   ├── 📄 login.php
│   │   └── 📄 register.php
│   ├── 📁 tickets/                 # صفحات تیکت
│   │   ├── 📄 index.php            # لیست تیکت‌ها
│   │   ├── 📄 show.php             # نمایش یک تیکت + پاسخ‌ها
│   │   └── 📄 create.php           # ایجاد تیکت جدید
│   └── 📁 admin/                   # پنل مدیریت
│       ├── 📁 users/
│       ├── 📁 departments/
│       ├── 📁 statuses/
│       ├── 📁 priorities/
│       └── 📁 settings/
│
├── 📁 config/
│   └── 📄 database.php             # تنظیمات اتصال پایگاه داده
│
├── 📁 uploads/                     # فایل‌های آپلودشده (غیرقابل دسترس مستقیم)
│   └── 📄 .htaccess                # Deny from all
│
├── 📁 cron/
│   └── 📄 close_stale_tickets.php  # اسکریپت بستن تیکت‌های راکد
│
├── 📄 database.sql                 # ساختار جداول + داده‌های پیش‌فرض
├── 📄 Dockerfile                   # تنظیمات ایمیج Docker
├── 📄 docker-compose.yml           # تنظیمات سرویس‌های Docker
└── 📄 README.md                    # همین فایل
```

---

## 🔐 ویژگی‌های امنیتی

| ویژگی | توضیح | پیاده‌سازی |
|---|---|---|
| **SQL Injection Prevention** | تمام کوئری‌ها با Prepared Statement اجرا می‌شوند | `PDO::prepare()` + `execute()` |
| **CSRF Protection** | تمام فرم‌های POST دارای توکن امنیتی هستند | `Request::generateCsrfToken()` |
| **Password Hashing** | رمز عبورها با الگوریتم bcrypt هش می‌شوند | `password_hash()` + `password_verify()` |
| **XSS Prevention** | خروجی‌ها قبل از نمایش پاک‌سازی می‌شوند | `htmlspecialchars()` |
| **File Upload Security** | محدودیت حجم و پسوند فایل‌ها | تنظیم در پنل ادمین |
| **Directory Protection** | پوشه‌های حساس از وب غیرقابل دسترس هستند | `.htaccess` + Document Root روی `public/` |
| **Secure File Download** | فقط کاربران مجاز می‌توانند فایل‌های پیوست را دانلود کنند | کنترل دسترسی در `TicketController@download` |

---

## 📊 جداول پایگاه داده

| جدول | توضیح | ستون‌های مهم |
|---|---|---|
| `users` | کاربران سیستم | `id`, `name`, `email`, `password`, `role`, `department_id`, `is_active` |
| `departments` | پارلمان‌ها | `id`, `name` |
| `department_permissions` | دسترسی‌های متقابل پارلمان‌ها | `department_id`, `can_view_department_id` |
| `tickets` | تیکت‌ها | `id`, `client_id`, `department_id`, `subject`, `body`, `priority_id`, `status_id` |
| `replies` | پاسخ‌ها و یادداشت‌ها | `id`, `ticket_id`, `user_id`, `message`, `is_internal` |
| `attachments` | فایل‌های پیوست | `id`, `ticket_id`, `reply_id`, `file_name`, `file_path`, `file_size` |
| `statuses` | وضعیت‌های تیکت | `id`, `name`, `color` |
| `priorities` | اولویت‌های تیکت | `id`, `name`, `color` |
| `settings` | تنظیمات سیستم | `id`, `key`, `value` |

---

## 🎯 مسیرهای اصلی (Routes)

| مسیر | متد | کنترلر | توضیح |
|---|---|---|---|
| `/login` | GET | `AuthController@showLogin` | صفحه ورود |
| `/login` | POST | `AuthController@login` | پردازش ورود |
| `/register` | GET | `AuthController@showRegister` | صفحه ثبت‌نام |
| `/register` | POST | `AuthController@register` | پردازش ثبت‌نام |
| `/logout` | GET | `AuthController@logout` | خروج |
| `/tickets` | GET | `TicketController@index` | لیست تیکت‌های کاربر |
| `/tickets/create` | GET | `TicketController@create` | فرم ایجاد تیکت جدید |
| `/tickets/store` | POST | `TicketController@store` | ذخیره تیکت جدید |
| `/tickets/{id}` | GET | `TicketController@show` | نمایش یک تیکت |
| `/tickets/{id}/reply` | POST | `TicketController@reply` | ارسال پاسخ |
| `/tickets/{id}/change-status` | POST | `TicketController@changeStatus` | تغییر وضعیت تیکت |
| `/attachments/{id}/download` | GET | `TicketController@download` | دانلود فایل پیوست |
| `/admin` | GET | `AdminController@dashboard` | داشبورد مدیریت |
| `/admin/users` | GET | `AdminController@users` | مدیریت کاربران |
| `/admin/departments` | GET | `AdminController@departments` | مدیریت پارلمان‌ها |
| `/admin/statuses` | GET | `AdminController@statuses` | مدیریت وضعیت‌ها |
| `/admin/priorities` | GET | `AdminController@priorities` | مدیریت اولویت‌ها |
| `/admin/settings` | GET | `AdminController@settings` | تنظیمات سیستم |

---

## 🛠️ رفع مشکلات رایج

<details>
<summary><strong>❌ ERR_TOO_MANY_REDIRECTS (حلقه ریدایرکت)</strong></summary>

**علت:** Document Root به درستی روی پوشه `public/` تنظیم نشده است.

**راه حل‌ها:**

1. **بهترین راه:** در cPanel/DirectAdmin، Document Root را به `ticket/public` تغییر دهید.

2. **راه جایگزین:** یک فایل `index.php` در ریشه پروژه بسازید:
   ```php
   <?php
   require __DIR__ . '/public/index.php';
   ```
   و فایل `.htaccess` اضافی در ریشه را پاک کنید.

3. **راه موقت:** از `RedirectMatch` در `.htaccess` ریشه استفاده کنید:
   ```apache
   RedirectMatch 302 ^/(?!public/)(.*) /public/$1
   ```
</details>

<details>
<summary><strong>❌ CSRF token mismatch</strong></summary>

**علت:** نشست (Session) به درستی ذخیره نمی‌شود.

**راه حل‌ها:**

1. مطمئن شوید پوشه `sessions/` در ریشه پروژه وجود دارد و قابل نوشتن است:
   ```bash
   mkdir sessions
   chmod 700 sessions
   ```

2. در فایل `app/Core/Session.php` بررسی کنید `session_start()` فراخوانی می‌شود.

3. اگر باز هم خطا می‌دهد، موقتاً CSRF را غیرفعال کنید (فقط برای تست):
   در `app/Core/Request.php` متد `verifyCsrfToken()` را تغییر دهید:
   ```php
   public static function verifyCsrfToken() {
       return true; // فقط برای تست
   }
   ```
</details>

<details>
<summary><strong>❌ صفحه سفید یا خطای 500</strong></summary>

**علت:** خطای PHP که نمایش داده نمی‌شود.

**راه حل:**

1. فایل `public/index.php` را باز کنید و این کد را در ابتدا اضافه کنید:
   ```php
   ini_set('display_errors', 1);
   error_reporting(E_ALL);
   ```

2. خطای نمایش داده شده را بررسی کنید.

3. علت‌های رایج:
   - فایل `config/database.php` اطلاعات نادرست دارد
   - دیتابیس وجود ندارد یا `database.sql` ایمپورت نشده است
   - پوشه `uploads/` قابل نوشتن نیست
   - افزونه `pdo_mysql` در PHP فعال نیست
</details>

<details>
<summary><strong>❌ خطای 404 در همه صفحات</strong></summary>

**علت:** `mod_rewrite` فعال نیست یا `.htaccess` وجود ندارد.

**راه حل:**

1. مطمئن شوید `mod_rewrite` در Apache فعال است:
   ```bash
   sudo a2enmod rewrite
   sudo systemctl restart apache2
   ```

2. بررسی کنید فایل `public/.htaccess` وجود دارد و محتوای آن صحیح است.
</details>

<details>
<summary><strong>❌ آپلود فایل کار نمی‌کند</strong></summary>

**علت:** تنظیمات PHP یا دسترسی پوشه نادرست است.

**راه حل:**

1. پوشه `uploads/` باید دسترسی نوشتن داشته باشد:
   ```bash
   chmod -R 775 uploads/
   ```

2. در Docker، فایل `Dockerfile` را بررسی کنید که `upload_max_filesize` و `post_max_size` مناسب باشند.

3. در پنل ادمین (`/admin/settings`)، `max_upload_size` را بررسی کنید (پیش‌فرض 5MB = 5242880 بایت).
</details>

---

## 📚 توضیح معماری (MVC)

### جریان یک درخواست در پروژه

```
1. کاربر آدرس را در مرورگر وارد می‌کند: http://localhost:9090/tickets

2. Apache (mod_rewrite) درخواست را به public/index.php می‌فرستد

3. index.php (Front Controller):
   - Autoloader را فعال می‌کند
   - Session را شروع می‌کند
   - Router را می‌سازد

4. Router تشخیص می‌دهد:
   - GET /tickets → TicketController@index

5. TicketController@index:
   - authCheck(): بررسی می‌کند کاربر لاگین کرده است
   - getUserTickets(): از Model ها تیکت‌ها را می‌خواند
   - view('tickets/index', ['tickets' => $tickets]): View را صدا می‌زند

6. View::render():
   - فایل views/tickets/index.php را اجرا می‌کند (با بافرینگ)
   - محتوا را در قالب views/layouts/app.php قرار می‌دهد
   - نتیجه نهایی را به مرورگر می‌فرستد

7. مرورگر: صفحه HTML کامل را نمایش می‌دهد
```

### فلسفه MVC در این پروژه

| لایه | مسئولیت | نباید |
|---|---|---|
| **Model** | ارتباط با دیتابیس، کوئری‌ها، اعتبارسنجی داده | نباید HTML تولید کند |
| **View** | نمایش داده، فرم‌ها، HTML | نباید مستقیم به دیتابیس وصل شود |
| **Controller** | دریافت درخواست، هماهنگی Model و View، بررسی دسترسی | نباید کوئری SQL بنویسد |

---

## 🤝 مشارکت

پیشنهادات، Issues و Pull Requests شما باعث بهبود این پروژه می‌شود.

اگر از این پروژه برای دانشگاه یا نمونه‌کار استفاده می‌کنید، خوشحال می‌شوم با یک ⭐ از آن حمایت کنید.

---

## 📄 مجوز

این پروژه تحت مجوز **MIT** منتشر شده است. برای اطلاعات بیشتر فایل [LICENSE](LICENSE) را ببینید.

---

<p align="center">
  <strong>
    🎓 مناسب برای ارائه دانشگاهی (کاردانی / کارشناسی)<br>
    🧩 تمرین عالی معماری MVC با PHP خالص<br>
  </strong>
</p>

<p align="center">
  ساخته شده با ❤️ و ☕
</p>



