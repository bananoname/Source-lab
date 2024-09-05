# Sử dụng image PHP với Apache
FROM php:7.4-apache

# Cài đặt phần mở rộng mysqli
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Sao chép mã nguồn ứng dụng từ thư mục 'source/hacker-login-form/src' vào thư mục gốc của Apache trong container
COPY ./hacker-login-form/src /var/www/html/

# Đặt quyền sở hữu cho thư mục /var/www/html
RUN chown -R www-data:www-data /var/www/html
