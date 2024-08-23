<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Thông tin về tệp tin tải lên
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra nếu tệp tin thực sự là tệp tin hay hình ảnh
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "Tệp tin không phải là hình ảnh.";
            $uploadOk = 0;
        }
    }

    // Kiểm tra kích thước tệp tin
    if ($_FILES["file"]["size"] > 500000) {
        echo "Xin lỗi, tệp tin quá lớn.";
        $uploadOk = 0;
    }

    // Cho phép các định dạng tệp tin nhất định
    if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
        echo "Xin lỗi, chỉ các định dạng JPG, JPEG, PNG & GIF được phép.";
        $uploadOk = 0;
    }

    // Kiểm tra nếu $uploadOk được đặt thành 0 bởi lỗi
    if ($uploadOk == 0) {
        echo "Xin lỗi, tệp tin của bạn không được tải lên.";
    // Nếu mọi thứ ổn, cố gắng tải lên tệp tin
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "Tệp tin " . htmlspecialchars(basename($_FILES["file"]["name"])) . " đã được tải lên.";
        } else {
            echo "Xin lỗi, đã có lỗi xảy ra khi tải lên tệp tin của bạn.";
        }
    }
}
?>
