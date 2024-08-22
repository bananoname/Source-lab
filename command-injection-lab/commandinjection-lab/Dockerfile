# Sử dụng image chính thức của PHP với Apache
FROM php:8.2-apache

# Cài đặt các gói cần thiết
RUN apt-get update && apt-get install -y \
    nano \
    vim

# Kích hoạt mod_rewrite cho Apache
RUN a2enmod rewrite

# Sao chép mã nguồn PHP vào thư mục web mặc định của Apache
COPY ./src/ /var/www/html/

# Đặt quyền cho thư mục web
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80

# Khởi động Apache
CMD ["apache2-foreground"]
