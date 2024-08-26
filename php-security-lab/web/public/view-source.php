<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

if (!isset($_GET['file']) || empty($_GET['file'])) {
    header("Location: source-check.php"); // Chuyển hướng nếu không có tệp
    exit();
}

$file = basename($_GET['file']);
$file_path = "../uploads/" . $file;

if (!file_exists($file_path)) {
    echo "<p class='error'>Tệp không tồn tại.</p>";
    exit();
}

$content = htmlspecialchars(file_get_contents($file_path));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Xem Mã Nguồn</title>
    <link rel="stylesheet" href="css/upload-style.css">
</head>
<body>
    <div class="container">
        <h1>Mã Nguồn Của Tệp: <?php echo htmlspecialchars($file); ?></h1>
        <pre><?php echo $content; ?></pre>
        <a href="source-check.php" class="back-button">Quay Lại</a>
    </div>
</body>
</html>

