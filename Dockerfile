FROM php:8.1-apache

RUN docker-php-ext-install pdo pdo_mysql

RUN a2enmod rewrite

COPY . /var/www/html/

RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# 🔥 این خط رو اضافه کن: افزایش محدودیت آپلود به 50 مگابایت
RUN echo "upload_max_filesize = 5000M\npost_max_size = 5000M" > /usr/local/etc/php/conf.d/uploads.ini

RUN chown -R www-data:www-data /var/www/html/uploads && chmod -R 775 /var/www/html/uploads

WORKDIR /var/www/html