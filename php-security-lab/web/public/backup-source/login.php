<?php
include '../includes/config.php';
session_start(); // Bắt đầu phiên làm việc

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        // Xử lý đăng nhập
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Không sử dụng câu lệnh chuẩn bị, dễ bị tấn công SQL Injection
        $query = "SELECT * FROM employees WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $_SESSION['user_id'] = $username; // Lưu thông tin đăng nhập
            $message = "<p class='success'>Đăng nhập thành công!</p>";
            header("Location: " . $_SERVER['PHP_SELF']); // Làm mới trang để ẩn khung đăng nhập
            exit();
        } else {
            $message = "<p class='error'>Đăng nhập thất bại!</p>";
        }
    } elseif (isset($_POST['upload'])) {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!isset($_SESSION['user_id'])) {
            $message = "<p class='error'>Vui lòng đăng nhập trước khi upload.</p>";
        } else {
            // Xử lý upload file
            handleFileUpload($_FILES['file']);
        }
    }
}

// Hàm xử lý upload file
function handleFileUpload($file) {
    global $conn;
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($file["name"]);
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

    // Kiểm tra nếu $uploadOk = 0 do lỗi
    if ($uploadOk == 0) {
        echo "<p class='error'>Tệp không được tải lên.</p>";
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            echo "<p class='success'>Tệp " . htmlspecialchars(basename($file["name"])) . " đã được tải lên thành công.</p>";
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
    <title>Đăng Nhập</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .success {
            color: #28a745;
        }
        .error {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <h1>Đăng Nhập</h1>
            <?php echo $message; ?>
            <form method="post" action="" enctype="multipart/form-data">
                <label for="username">Tài khoản:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit" name="login">Đăng Nhập</button>
            </form>
        <?php else: ?>
            <h2>Upload File</h2>
            <?php echo $message; ?>
            <form method="post" action="" enctype="multipart/form-data">
                <label for="file">Chọn tệp để tải lên:</label>
                <input type="file" id="file" name="file" required>
                <button type="submit" name="upload">Tải lên</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>

