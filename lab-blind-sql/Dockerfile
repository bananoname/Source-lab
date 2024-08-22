# Dockerfile cho PHP
FROM php:8.2-apache

# Cài đặt các phụ thuộc cần thiết
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli

# Sao chép mã nguồn vào thư mục của Apache
COPY src/ /var/www/html/

# Expose cổng 80
EXPOSE 80

