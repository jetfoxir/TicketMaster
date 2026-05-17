

-- جدول کاربران
CREATE TABLE `users` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `name` varchar(255) NOT NULL,
                         `email` varchar(255) NOT NULL UNIQUE,
                         `password` varchar(255) NOT NULL,
                         `role` enum('admin','agent','client') NOT NULL,
                         `department_id` int(11) DEFAULT NULL,
                         `is_active` tinyint(1) NOT NULL DEFAULT 1,
                         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                         PRIMARY KEY (`id`),
                         KEY `department_id` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- جدول پارلمان‌ها
CREATE TABLE `departments` (
                               `id` int(11) NOT NULL AUTO_INCREMENT,
                               `name` varchar(255) NOT NULL,
                               `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                               PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- مجوزهای دیدن پارلمان‌ها توسط دیگر پارلمان‌ها
CREATE TABLE `department_permissions` (
                                          `department_id` int(11) NOT NULL,
                                          `can_view_department_id` int(11) NOT NULL,
                                          PRIMARY KEY (`department_id`, `can_view_department_id`),
                                          FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
                                          FOREIGN KEY (`can_view_department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- جدول اولویت‌ها
CREATE TABLE `priorities` (
                              `id` int(11) NOT NULL AUTO_INCREMENT,
                              `name` varchar(100) NOT NULL,
                              `color` varchar(7) NOT NULL DEFAULT '#000000',
                              `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                              PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- جدول وضعیت‌ها
CREATE TABLE `statuses` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `name` varchar(100) NOT NULL,
                            `color` varchar(7) NOT NULL DEFAULT '#000000',
                            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- جدول تیکت‌ها
CREATE TABLE `tickets` (
                           `id` int(11) NOT NULL AUTO_INCREMENT,
                           `client_id` int(11) NOT NULL,
                           `department_id` int(11) NOT NULL,
                           `subject` varchar(255) NOT NULL,
                           `body` text NOT NULL,
                           `priority_id` int(11) NOT NULL,
                           `status_id` int(11) NOT NULL,
                           `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                           `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                           PRIMARY KEY (`id`),
                           KEY `client_id` (`client_id`),
                           KEY `department_id` (`department_id`),
                           KEY `priority_id` (`priority_id`),
                           KEY `status_id` (`status_id`),
                           CONSTRAINT `fk_ticket_client` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`),
                           CONSTRAINT `fk_ticket_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
                           CONSTRAINT `fk_ticket_priority` FOREIGN KEY (`priority_id`) REFERENCES `priorities` (`id`),
                           CONSTRAINT `fk_ticket_status` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- پاسخ‌ها (ریسه مکالمه)
CREATE TABLE `replies` (
                           `id` int(11) NOT NULL AUTO_INCREMENT,
                           `ticket_id` int(11) NOT NULL,
                           `user_id` int(11) NOT NULL,
                           `message` text NOT NULL,
                           `is_internal` tinyint(1) NOT NULL DEFAULT 0,
                           `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                           PRIMARY KEY (`id`),
                           KEY `ticket_id` (`ticket_id`),
                           KEY `user_id` (`user_id`),
                           CONSTRAINT `fk_reply_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
                           CONSTRAINT `fk_reply_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- پیوست‌ها
CREATE TABLE `attachments` (
                               `id` int(11) NOT NULL AUTO_INCREMENT,
                               `ticket_id` int(11) NOT NULL,
                               `reply_id` int(11) DEFAULT NULL,
                               `file_name` varchar(255) NOT NULL,
                               `file_path` varchar(255) NOT NULL,
                               `file_size` int(11) NOT NULL,
                               `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
                               PRIMARY KEY (`id`),
                               KEY `ticket_id` (`ticket_id`),
                               KEY `reply_id` (`reply_id`),
                               CONSTRAINT `fk_attachment_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
                               CONSTRAINT `fk_attachment_reply` FOREIGN KEY (`reply_id`) REFERENCES `replies` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- تنظیمات
CREATE TABLE `settings` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `key` varchar(100) NOT NULL UNIQUE,
                            `value` text NOT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- داده‌های پیش‌فرض
INSERT INTO `departments` (`id`, `name`) VALUES
                                             (1, 'پشتیبانی فنی'),
                                             (2, 'فروش'),
                                             (3, 'مالی');

INSERT INTO `priorities` (`id`, `name`, `color`) VALUES
                                                     (1, 'عادی', '#28a745'),
                                                     (2, 'مهم', '#ffc107'),
                                                     (3, 'فوری', '#dc3545');

INSERT INTO `statuses` (`id`, `name`, `color`) VALUES
                                                   (1, 'باز', '#007bff'),
                                                   (2, 'در انتظار پاسخ', '#6c757d'),
                                                   (3, 'پاسخ داده شده', '#17a2b8'),
                                                   (4, 'بسته', '#28a745');

INSERT INTO `settings` (`key`, `value`) VALUES
                                            ('max_upload_size', '5242880'),
                                            ('allowed_extensions', 'jpg,jpeg,png,pdf,docx,zip');

-- ادمین پیش‌فرض (رمز: password)
INSERT INTO `users` (`name`, `email`, `password`, `role`, `is_active`) VALUES
    ('مدیر سیستم', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1);

-- اعمال کلید خارجی users به departments
ALTER TABLE `users` ADD CONSTRAINT `fk_user_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;
