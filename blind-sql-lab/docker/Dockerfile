FROM php:7.4-apache

# Cài đặt mysqli extension
RUN docker-php-ext-install mysqli

# Cài đặt các tiện ích bổ sung khác (nếu cần)
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd
