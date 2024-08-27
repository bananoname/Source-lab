# SQL Injection Lab

## Giới thiệu

Bài lab này cung cấp một ứng dụng PHP đơn giản với lỗ hổng SQL Injection đã được khắc phục. Bạn có thể sử dụng bài lab này để học về các vấn đề bảo mật liên quan đến SQL Injection và cách bảo vệ ứng dụng của mình bằng cách sử dụng câu lệnh SQL chuẩn bị.

## Yêu cầu

- Docker
- Docker Compose

# 1. Cấu hình Docker
Tạo một file Dockerfile để xây dựng hình ảnh Docker cho ứng dụng PHP của bạn:
```
# Dockerfile
FROM php:8.2-apache

# Cài đặt các phụ thuộc cần thiết
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli

# Sao chép mã nguồn vào thư mục web của Apache
COPY src/ /var/www/html/

# Expose port 80
EXPOSE 80
```
Tạo một file docker-compose.yml để dễ dàng khởi động container với PHP và MySQL:

```
# docker-compose.yml
version: '3.8'

services:
  web:
    build: .
    ports:
      - "8080:80"
    depends_on:
      - db

  db:
    image: mysql:5.7
    environment:
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_DATABASE: testdb
      MYSQL_USER: user
      MYSQL_PASSWORD: password
    volumes:
      - db_data:/var/lib/mysql

volumes:
  db_data:
```
# 2. Cài đặt và cấu hình ứng dụng PHP
Tạo thư mục src và thêm các file sau:

## 2.1. Tạo file src/index.php

```
<?php
$servername = "db";
$username = "user";
$password = "password";
$dbname = "testdb";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ truy vấn SQL
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM users WHERE username LIKE '%$search%'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>SQL Injection Lab</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; }
        .container { width: 80%; margin: 0 auto; padding: 20px; background: #fff; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .search { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>SQL Injection Lab</h1>
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Tìm kiếm người dùng" value="<?php echo htmlspecialchars($search); ?>" class="search"/>
            <button type="submit">Tìm kiếm</button>
        </form>
        
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Không có kết quả nào.</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </div>
</body>
</html>
```
## 2.2. Tạo file src/setup_db.php
```
<?php
$servername = "db";
$username = "user";
$password = "password";
$dbname = "testdb";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Tạo bảng người dùng
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Bảng 'users' đã được tạo thành công.";
} else {
    echo "Lỗi tạo bảng: " . $conn->error;
}

// Chèn dữ liệu mẫu
$sql = "INSERT INTO users (username, email) VALUES 
    ('alice', 'alice@example.com'),
    ('bob', 'bob@example.com'),
    ('charlie', 'charlie@example.com')";

if ($conn->query($sql) === TRUE) {
    echo "Dữ liệu mẫu đã được chèn thành công.";
} else {
    echo "Lỗi chèn dữ liệu: " . $conn->error;
}

$conn->close();
```
# 3. Khởi động Docker
 Chạy các lệnh sau để xây dựng và khởi động các container Docker:

```
docker-compose build
docker-compose up -d
```
# 4. Cài đặt cơ sở dữ liệu
Chạy file setup_db.php để thiết lập cơ sở dữ liệu và chèn dữ liệu mẫu:

```
docker-compose exec web php /var/www/html/setup_db.php
```
# 5. Truy cập ứng dụng

![image](https://github.com/user-attachments/assets/453f4cda-d59c-4fdd-b341-a20c8c480365)

Truy cập ứng dụng của bạn tại http://localhost:8080 trong trình duyệt. Bạn có thể thử nghiệm SQL Injection bằng cách nhập các chuỗi như ' OR '1'='1 vào ô tìm kiếm để xem các kết quả trả về.

![image](https://github.com/user-attachments/assets/89bd7ebe-8283-4a43-bf52-c2e9deb180ed)
# 6 Bảo mật
Hãy lưu ý rằng bài lab này được thiết kế để minh họa lỗ hổng SQL Injection. Trong thực tế, bạn nên bảo vệ ứng dụng của mình bằng cách sử dụng các phương pháp bảo mật như chuẩn bị câu lệnh SQL, sử dụng tham số truy vấn, và kiểm tra đầu vào của người dùng để ngăn ngừa các lỗ hổng bảo mật.
# Tài liệu tham khảo
SQL Injection Wikipedia

PHP mysqli documentation

Docker documentation

# 7 Cập nhật mã PHP để sử dụng Prepared Statements

Để khắc phục lỗ hổng SQL Injection trong ứng dụng PHP của bạn, bạn cần cải thiện cách xử lý truy vấn SQL để tránh việc tiêm mã độc qua các tham số đầu vào. Phương pháp tốt nhất là sử dụng các câu lệnh SQL chuẩn bị (prepared statements) và các tham số liên quan để bảo vệ ứng dụng của bạn.

## Cập nhật mã PHP để sử dụng Prepared Statements
###  Cập nhật src/index.php
```
<?php
$servername = "db";
$username = "user";
$password = "password";
$dbname = "testdb";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Sử dụng câu lệnh SQL chuẩn bị để bảo vệ khỏi SQL Injection
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Tạo câu lệnh chuẩn bị
$stmt = $conn->prepare("SELECT * FROM users WHERE username LIKE ?");
$searchTerm = "%$search%";
$stmt->bind_param("s", $searchTerm);

// Thực thi câu lệnh
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>SQL Injection Lab</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; }
        .container { width: 80%; margin: 0 auto; padding: 20px; background: #fff; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .search { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>SQL Injection Lab</h1>
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Tìm kiếm người dùng" value="<?php echo htmlspecialchars($search); ?>" class="search"/>
            <button type="submit">Tìm kiếm</button>
        </form>
        
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Không có kết quả nào.</p>
        <?php endif; ?>

        <?php $stmt->close(); ?>
        <?php $conn->close(); ?>
    </div>
</body>
</html>
```
# Các bước thực hiện:
## Kiểm tra mục tiêu bằng sqlmap:
```sudo sqlmap -u http://localhost:8088/?search=1 --dbms=mysql```
![image](https://github.com/user-attachments/assets/2498922d-910d-465d-b663-c54e34decf71)

- **sqlmap **sẽ tiến hành kiểm tra và bạn sẽ thấy các bước kiểm tra được hiển thị trong terminal. Quá trình này có thể mất một khoảng thời gian tùy thuộc vào độ phức tạp của ứng dụng và số lượng kiểm tra mà sqlmap thực hiện.

- Xác định cơ sở dữ liệu và bảng:

- Nếu sqlmap tìm thấy lỗ hổng, bạn có thể tiếp tục sử dụng các tùy chọn như:

**--dbs** để liệt kê các cơ sở dữ liệu.
**--tables** để liệt kê các bảng trong một cơ sở dữ liệu cụ thể.
**--columns** để liệt kê các cột trong một bảng cụ thể.
**--dump **để trích xuất dữ liệu từ các bảng.

- Ví dụ lệnh tiếp theo:
Liệt kê tất cả các cơ sở dữ liệu:

```sudo sqlmap -u http://localhost:8088/?search=1 --dbms=mysql --dbs```

Liệt kê tất cả các bảng trong cơ sở dữ liệu testdb:

```sudo sqlmap -u http://localhost:8088/?search=1 --dbms=mysql -D testdb --tables```

![image](https://github.com/user-attachments/assets/6966a5d6-58e0-498c-aa26-25fe73b54a5a)

Trích xuất dữ liệu từ bảng users trong cơ sở dữ liệu testdb:

```sudo sqlmap -u http://localhost:8088/?search=1 --dbms=mysql -D testdb -T users --dump```
![image](https://github.com/user-attachments/assets/e9585e8f-c959-4beb-8628-f2e3977cb539)

Nếu bạn gặp bất kỳ vấn đề nào trong quá trình sử dụng sqlmap, bạn có thể cung cấp thêm thông tin chi tiết, và tôi sẽ hỗ trợ bạn thêm.
