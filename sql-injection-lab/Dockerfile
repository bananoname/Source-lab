FROM php:7.4-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Sao chép file PHP vào container
COPY php/ /var/www/html/

# Bật mod_rewrite (tùy chọn nếu bạn cần xử lý route)
RUN a2enmod rewrite
