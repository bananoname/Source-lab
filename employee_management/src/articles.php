<?php
include 'config.php';

$article_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($article_id) {
    $stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
    $stmt->bind_param('i', $article_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $article = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($article['title'] ?? 'Bài Viết'); ?> - Phần Mềm Quản Lý Nhân Viên</title>
    <link rel="stylesheet" type="text/css" href="css/index-styles.css">
</head>
<body>
    <header class="site-header">
        <div class="header-container">
            <img src="images/logo.png" alt="Logo" class="logo">
            <nav class="navbar">
                <a href="index.php" class="nav-link">Trang Chủ</a>
                <a href="admin.php" class="nav-link">Quản Lý Nhân Viên</a>
                <a href="about.php" class="nav-link">Giới Thiệu</a>
            </nav>
        </div>
    </header>

    <main class="article-main">
        <div class="article-container">
            <?php if ($article): ?>
                <h1><?php echo htmlspecialchars($article['title']); ?></h1>
                <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
            <?php else: ?>
                <p>Bài viết không tồn tại.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer class="site-footer">
        <div class="footer-container">
            <p>&copy; 2024 Phần Mềm Quản Lý Nhân Viên. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>
</body>
</html>
