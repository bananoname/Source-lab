<?php
// index.php
include '../includes/config.php';

// Kiểm tra lỗi path traversal hoặc file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['upload_file'])) {
        $file = $_FILES['upload_file'];
        
        // Giả lập lỗi tải file (ví dụ: kích thước file quá lớn)
        if ($file['error'] === UPLOAD_ERR_INI_SIZE) {
            echo "<p class='alert alert-danger'>Lỗi tải file: Kích thước file vượt quá giới hạn cho phép.</p>";
        } else {
            // Đảm bảo tên file không chứa ký tự path traversal
            $filename = basename($file['name']);
            $upload_dir = 'uploads/';
            $upload_file = $upload_dir . $filename;
            
            // Giả lập lỗi path traversal
            if (strpos($filename, '..') !== false) {
                echo "<p class='alert alert-danger'>Đường dẫn file không hợp lệ: Không thể tải lên file chứa '..'</p>";
            } else {
                // Tải file lên
                if (move_uploaded_file($file['tmp_name'], $upload_file)) {
                    echo "<p class='alert alert-success'>Tải file thành công!</p>";
                } else {
                    echo "<p class='alert alert-danger'>Lỗi khi tải file lên.</p>";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="bg-primary text-white py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="index.php" class="text-white text-decoration-none fs-4">Trang Chủ</a>
                <nav>
                    <a href="login.php" class="btn btn-light">Đăng Nhập</a>
                    <a href="articles.php" class="btn btn-light">Bài Viết</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container my-5">
        <h1 class="text-center mb-4">Chào Mừng Bạn Đến Với Trang Chủ</h1>

        <!-- Upload Form -->
        <div class="card p-4">
            <h2 class="card-title mb-4">Tải Lên File</h2>
            <form action="index.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="upload_file" class="form-label">Chọn file để tải lên:</label>
                    <input type="file" name="upload_file" id="upload_file" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Tải lên</button>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-light py-3">
        <div class="container text-center">
            <p class="mb-0">© 2024 Trang Chủ. Tất cả các quyền được bảo lưu.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

