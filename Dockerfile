# ใช้ PHP 8.1 with Apache
FROM php:8.1-apache

# ติดตั้ง MySQLi extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# ติดตั้ง PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# เปิด mod_rewrite
RUN a2enmod rewrite

# ตั้ง working directory
WORKDIR /var/www/html

# Copy โปรเจคทั้งหมด
COPY . /var/www/html/

# ตั้งค่า permissions
RUN chown -R www-data:www-data /var/www/html

# สร้าง images directory
RUN mkdir -p /var/www/html/images && chmod 777 /var/www/html/images

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
