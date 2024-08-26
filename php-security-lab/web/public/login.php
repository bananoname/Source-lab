<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../includes/config.php';
session_start(); // Bắt đầu phiên làm việc

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        // Xử lý đăng nhập
        $username = $_POST['username'];
        $password = $_POST['password'];

        // SQL Injection có thể xảy ra ở đây
        $query = "SELECT * FROM employees WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $_SESSION['user_id'] = $username; // Lưu thông tin đăng nhập
            
            // Xác định trang sau khi đăng nhập
            $redirect_url = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'manage_users.php';
            unset($_SESSION['redirect_url']); // Xóa URL chuyển hướng sau khi đã xử lý

            header('Location: ' . $redirect_url);
            exit();
        } else {
            $message = "<p class='error'>Đăng nhập thất bại!</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="css/login-style.css">
</head>
<body>
    <div class="container">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <h1>Đăng Nhập</h1>
            <?php echo $message; ?>
            <form method="post" action="">
                <label for="username">Tài khoản:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit" name="login">Đăng Nhập</button>
            </form>
        <?php else: ?>
            <p class="success">Chúc mừng bạn đã đăng nhập thành công! <a href="manage_users.php">Truy cập trang quản lý người dùng</a></p>
        <?php endif; ?>
    </div>
</body>
</html>

