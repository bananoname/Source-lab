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
            $message = "<p class='success'>Đăng nhập thành công! <a href='upload.php'>Truy cập trang upload</a></p>";
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
            <!-- Nếu đã đăng nhập, thông báo và liên kết tới trang upload -->
            <p class="success">Chúc mừng bạn đã đăng nhập thành công! <a href="upload.php">Truy cập trang upload</a></p>
        <?php endif; ?>
    </div>
</body>
</html>

