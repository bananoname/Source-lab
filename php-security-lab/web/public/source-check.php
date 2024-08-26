<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

$files = array_diff(scandir('../uploads/'), array('.', '..'));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kiểm Tra Mã Nguồn</title>
    <link rel="stylesheet" href="css/upload-style.css">
</head>
<body>
    <div class="container">
        <h1>Danh Sách Tệp Tải Lên</h1>
        <ul>
            <?php foreach ($files as $file): ?>
                <li><a href="view-source.php?file=<?php echo urlencode($file); ?>"><?php echo htmlspecialchars($file); ?></a></li>
            <?php endforeach; ?>
        </ul>
        <a href="upload.php" class="back-button">Quay Lại</a>
    </div>
</body>
</html>

