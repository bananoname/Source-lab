# Sử dụng PHP phiên bản với Apache
FROM php:8.1-apache

# Cài đặt các extension cần thiết
RUN docker-php-ext-install mysqli

# Copy mã nguồn vào container
COPY src/ /var/www/html/

# Đặt quyền cho thư mục chứa mã nguồn
RUN chown -R www-data:www-data /var/www/html/

# Expose port 8002 để truy cập ứng dụng
EXPOSE 8002

# Khởi động Apache
CMD ["apache2-foreground"]
