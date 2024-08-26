<?php
// Hàm để kiểm tra nếu người dùng đã đăng nhập
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Hàm để đăng nhập người dùng
function login($username, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM employees WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['employee_id'];
        return true;
    }
    return false;
}

// Hàm để đăng xuất người dùng
function logout() {
    session_unset();
    session_destroy();
}

// Hàm để kiểm tra quyền của người dùng
function isAdmin() {
    global $conn;
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT position FROM employees WHERE employee_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    return $user['position'] === 'Administrator';
}

// Hàm để xử lý upload tệp và kiểm tra các lỗi bảo mật
function handleFileUpload($file) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra nếu tệp đã tồn tại
    if (file_exists($target_file)) {
        echo "Tệp đã tồn tại.";
        $uploadOk = 0;
    }

    // Kiểm tra kích thước tệp
    if ($file["size"] > 500000) { // 500KB
        echo "Tệp quá lớn.";
        $uploadOk = 0;
    }

    // Chỉ cho phép các định dạng hình ảnh
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        echo "Chỉ cho phép tệp JPG, JPEG, PNG, GIF.";
        $uploadOk = 0;
    }

    // Kiểm tra nếu $uploadOk = 0 do lỗi
    if ($uploadOk == 0) {
        echo "Tệp không được tải lên.";
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            echo "Tệp " . htmlspecialchars(basename($file["name"])) . " đã được tải lên thành công.";
        } else {
            echo "Lỗi khi tải tệp lên.";
        }
    }
}
?>

