# Sử dụng image PHP chính thức
FROM php:8.1-apache

# Cài đặt gói iputils-ping
RUN apt-get update && apt-get install -y iputils-ping

# Sao chép mã nguồn vào thư mục của Apache
COPY src/ /var/www/html/

# Cấp quyền cho thư mục web
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

