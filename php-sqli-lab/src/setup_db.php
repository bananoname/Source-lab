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
    ('charlie', 'charlie@example.com'),
    ('david', 'david@example.com'),
    ('eve', 'eve@example.com'),
    ('frank', 'frank@example.com'),
    ('grace', 'grace@example.com'),
    ('heidi', 'heidi@example.com'),
    ('ivan', 'ivan@example.com'),
    ('judy', 'judy@example.com'),
    ('karl', 'karl@example.com'),
    ('lisa', 'lisa@example.com'),
    ('mike', 'mike@example.com'),
    ('nina', 'nina@example.com'),
    ('olivia', 'olivia@example.com'),
    ('paul', 'paul@example.com'),
    ('quinn', 'quinn@example.com'),
    ('rachel', 'rachel@example.com'),
    ('sam', 'sam@example.com'),
    ('tina', 'tina@example.com'),
    ('ursula', 'ursula@example.com'),
    ('victor', 'victor@example.com'),
    ('wendy', 'wendy@example.com'),
    ('xander', 'xander@example.com'),
    ('yara', 'yara@example.com'),
    ('zach', 'zach@example.com')";

if ($conn->query($sql) === TRUE) {
    echo "Dữ liệu mẫu đã được chèn thành công.";
} else {
    echo "Lỗi chèn dữ liệu: " . $conn->error;
}

