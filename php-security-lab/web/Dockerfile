# Dockerfile cho ứng dụng PHP
FROM php:8.0-apache

# Cài đặt các tiện ích cần thiết
RUN docker-php-ext-install mysqli

# Sao chép mã nguồn vào thư mục /var/www/html
COPY . /var/www/html/

# Cấu hình Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Mở cổng 80
EXPOSE 80
