<?php
session_start(); // Bắt đầu phiên làm việc

// Xóa tất cả các biến phiên
$_SESSION = array();

// Nếu bạn muốn xóa cookie phiên, hãy xóa cookie phiên
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hủy phiên làm việc
session_destroy();

// Chuyển hướng người dùng về trang đăng nhập hoặc trang chính
header("Location: login.php"); // Hoặc header("Location: index.php");
exit();
?>

