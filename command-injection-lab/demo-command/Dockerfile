# Sử dụng image PHP chính thức với Apache
FROM php:7.4-apache

# Sao chép mã nguồn vào thư mục gốc của web server
COPY . /var/www/html/

# Tạo file flag.txt trong thư mục gốc của container
RUN echo "This is the flag: HUYQA{CommandInjectionIsFun}" > /flag.txt

# Cấp quyền truy cập thích hợp cho các thư mục
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Khởi động Apache
CMD ["apache2-foreground"]

