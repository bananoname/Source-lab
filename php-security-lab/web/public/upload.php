<?php
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Xử lý đăng xuất
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Xử lý upload file
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    handleFileUpload($_FILES['file']);
}

function handleFileUpload($file) {
    $target_dir = "../uploads/";

    // Kiểm tra tên file để tránh path traversal
    $file_name = basename($file["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra nếu tệp đã tồn tại
    if (file_exists($target_file)) {
        echo "<p class='error'>Tệp đã tồn tại.</p>";
        $uploadOk = 0;
    }

    // Kiểm tra kích thước tệp
    if ($file["size"] > 500000) { // 500KB
        echo "<p class='error'>Tệp quá lớn.</p>";
        $uploadOk = 0;
    }

    // Chỉ cho phép các định dạng hình ảnh
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        echo "<p class='error'>Chỉ cho phép tệp JPG, JPEG, PNG, GIF.</p>";
        $uploadOk = 0;
    }

    // Kiểm tra nếu tệp có thể thực thi (các biện pháp bổ sung)
    if ($imageFileType == 'php') {
        echo "<p class='error'>Không được phép tải lên tệp PHP.</p>";
        $uploadOk = 0;
    }

    // Kiểm tra nếu $uploadOk = 0 do lỗi
    if ($uploadOk == 0) {
        echo "<p class='error'>Tệp không được tải lên.</p>";
    } else {
        // Tạo một tên tệp ngẫu nhiên để tránh các vấn đề liên quan đến việc đặt tên file và đảm bảo không trùng lặp
        $new_file_name = uniqid() . '.' . $imageFileType;
        $new_target_file = $target_dir . $new_file_name;

        if (move_uploaded_file($file["tmp_name"], $new_target_file)) {
            echo "<p class='success'>Tệp " . htmlspecialchars($new_file_name) . " đã được tải lên thành công.</p>";
        } else {
            echo "<p class='error'>Lỗi khi tải tệp lên.</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload File</title>
    <link rel="stylesheet" href="css/upload-style.css">
</head>
<body>
    <div class="container">
        <h1>Upload File</h1>
        <form method="post" action="" enctype="multipart/form-data">
            <label for="file">Chọn tệp để tải lên:</label>
            <input type="file" id="file" name="file" required>
            <button type="submit">Tải lên</button>
        </form>
        <!-- Nút Logout -->
        <a href="?logout=true" class="logout-button">Đăng Xuất</a>
        <!-- Liên kết Check Source Code -->
        <a href="source-check.php" class="check-source-button">Xem Mã Nguồn</a>
    </div>
</body>
</html>

