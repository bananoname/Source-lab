<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Xử lý upload file
    handleFileUpload($_FILES['file']);
}

function handleFileUpload($file) {
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
    <title>Upload File</title>
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
        <h1>Upload File</h1>
        <form method="post" action="" enctype="multipart/form-data">
            <label for="file">Chọn tệp để tải lên:</label>
            <input type="file" id="file" name="file" required>
            <button type="submit">Tải lên</button>
        </form>
    </div>
</body>
</html>

