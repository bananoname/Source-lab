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
    } elseif (isset($_POST['view_code'])) {
        // Xử lý xem mã nguồn
        $code = htmlspecialchars(file_get_contents(__FILE__));
        $message = "<pre class='code-view'><code>$code</code></pre>";
        $back_button = "<form method='post' action=''><button type='submit' name='back' class='back-button'>Trở Lại</button></form>";
    } elseif (isset($_POST['view_user'])) {
        // Xử lý xem người dùng đã đăng nhập
        if (isset($_SESSION['user_id'])) {
            $message = "<p class='info'>Người dùng hiện tại: " . htmlspecialchars($_SESSION['user_id']) . "</p>";
        } else {
            $message = "<p class='error'>Chưa có người dùng nào đăng nhập.</p>";
        }
    } elseif (isset($_POST['view_all_users'])) {
        // Xử lý xem tất cả người dùng (dành cho quản trị viên)
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === 'admin') {
            $query = "SELECT username FROM employees"; // Thay đổi nếu cần
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $users = "<ul>";
                while ($row = $result->fetch_assoc()) {
                    $users .= "<li>" . htmlspecialchars($row['username']) . "</li>";
                }
                $users .= "</ul>";
                $message = "<p class='info'>Danh sách người dùng:</p>" . $users;
            } else {
                $message = "<p class='info'>Không có người dùng nào.</p>";
            }
        } else {
            $message = "<p class='error'>Bạn không có quyền xem danh sách người dùng.</p>";
        }
    } elseif (isset($_POST['back'])) {
        // Xử lý quay lại trang trước
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
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
            <!-- Các nút chức năng bổ sung -->
            <form method="post" action="">
                <button type="submit" name="view_code" class="view-code-button">Xem Mã Nguồn</button>
                <button type="submit" name="view_user" class="view-user-button">Xem Người Dùng Đăng Nhập</button>
                <?php if ($_SESSION['user_id'] === 'admin'): ?>
                    <button type="submit" name="view_all_users" class="view-all-users-button">Xem Tất Cả Người Dùng</button>
                <?php endif; ?>
            </form>
        <?php endif; ?>
        <!-- Hiển thị thông báo -->
        <div class="message-container">
            <?php echo $message; ?>
            <?php echo $back_button ?? ''; ?>
        </div>
    </div>
</body>
</html>

