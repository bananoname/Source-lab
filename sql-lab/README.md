# Hướng Dẫn Triển Khai Ứng Dụng Đăng Nhập với Docker

## Mục Lục

1. [Giới Thiệu](#giới-thiệu)
2. [Cấu Trúc Thư Mục](#cấu-trúc-thư-mục)
3. [Tạo Dockerfile](#tạo-dockerfile)
4. [Tạo Docker Compose File](#tạo-docker-compose-file)
5. [Thiết Lập Cơ Sở Dữ Liệu](#thiết-lập-cơ-sở-dữ-liệu)
6. [Xử Lý Lỗi và SQL Injection](#xử-lý-lỗi-và-sql-injection)
7. [Chạy Ứng Dụng](#chạy-ứng-dụng)

## Giới Thiệu

Hướng dẫn này mô tả cách triển khai một ứng dụng đăng nhập cơ bản sử dụng Docker và MySQL. Ứng dụng này có thể gặp lỗi bảo mật SQL Injection, và hướng dẫn này bao gồm cách cập nhật mã PHP để xử lý lỗi và tránh các lỗ hổng bảo mật.

## Cấu Trúc Thư Mục

Dưới đây là cấu trúc thư mục dự án:

```
.
├── docker
│   ├── Dockerfile
│   └── hacker-login-form
│       ├── dist
│       │   ├── index.html
│       │   └── style.css
│       └── src
│           ├── index.html
│           ├── index.html.bk
│           ├── index.html.bk1
│           ├── login.php
│           ├── login.php.bk
│           └── style.css
├── docker-compose.yml
└── source
    ├── 2023-hacker-login-form.zip
    ├── hacker-login-form
    │   ├── dist
    │   │   ├── index.html
    │   │   └── style.css
    │   └── src
    │       ├── index.html
    │       ├── index.html.bk
    │       ├── index.html.bk1
    │       ├── login.php
    │       ├── login.php.bk
    │       └── style.css
    └── sql
        └── init.sql

9 directories, 20 files
```

## Tạo Dockerfile

Tạo file `Dockerfile` trong thư mục `docker` với nội dung sau:

**Dockerfile**

```
# Sử dụng image PHP với Apache
FROM php:7.4-apache

# Cài đặt phần mở rộng mysqli
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Sao chép mã nguồn ứng dụng từ thư mục 'source/hacker-login-form/src' vào thư mục gốc của Apache trong container
COPY ./hacker-login-form/src /var/www/html/

# Đặt quyền sở hữu cho thư mục /var/www/html
RUN chown -R www-data:www-data /var/www/html
```
## Tạo Docker Compose File 

Tạo file docker-compose.yml với nội dung sau:

```
version: '3.8'

services:
  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_DATABASE: demo_login
      MYSQL_USER: user
      MYSQL_PASSWORD: userpassword
    volumes:
      - ./source/sql/init.sql:/docker-entrypoint-initdb.d/init.sql
    ports:
      - "3306:3306"

  web:
    build:
      context: ./docker
    volumes:
      - ./source/hacker-login-form/src:/var/www/html
    ports:
      - "8080:80"
    depends_on:
      - db
```
