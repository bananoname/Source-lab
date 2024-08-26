<?php
// index.php
include '../includes/config.php';

// Kiểm tra lỗi path traversal hoặc file upload
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trang Chủ</title>
</head>
<body>
    <h1>Trang Chủ</h1>
    <nav>
        <a href="login.php">Đăng Nhập</a>
    </nav>
    <!-- Thêm form upload và kiểm tra lỗi path traversal ở đây -->
</body>
</html>
