<?php
// article_edit.php

session_start(); // Bắt đầu phiên làm việc

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Chuyển hướng đến trang đăng nhập
    exit();
}

// Dữ liệu mẫu cho bài viết
$articles = [
    ['id' => 1, 'title' => 'Hướng dẫn sử dụng PHP PDO', 'content' => 'PHP Data Objects (PDO) là một lớp dữ liệu trong PHP cung cấp một giao diện nhất quán cho việc truy cập cơ sở dữ liệu. PDO hỗ trợ nhiều cơ sở dữ liệu khác nhau và cung cấp các phương thức bảo mật để tránh SQL injection. Bài viết này sẽ hướng dẫn bạn cách sử dụng PDO trong PHP để kết nối và thao tác với cơ sở dữ liệu.'],
    ['id' => 2, 'title' => 'Các phương pháp tối ưu hóa MySQL', 'content' => 'Tối ưu hóa MySQL là một phần quan trọng trong quản trị cơ sở dữ liệu. Bài viết này sẽ trình bày các phương pháp tối ưu hóa hiệu suất của MySQL, bao gồm việc tối ưu hóa truy vấn, chỉ số, và cấu hình máy chủ. Những kỹ thuật này sẽ giúp tăng cường hiệu suất và giảm thiểu thời gian truy xuất dữ liệu.'],
    ['id' => 3, 'title' => 'Giới thiệu về Docker và cách sử dụng', 'content' => 'Docker là một nền tảng mã nguồn mở cho phép bạn tạo, triển khai và chạy các ứng dụng trong các container. Các container giúp đóng gói phần mềm với tất cả các phụ thuộc của nó, cho phép chạy ứng dụng nhất quán trên nhiều môi trường khác nhau. Bài viết này sẽ giới thiệu về Docker, cách cài đặt, và cách sử dụng Docker để phát triển ứng dụng.'],
    ['id' => 4, 'title' => 'Các kỹ thuật bảo mật cho ứng dụng web', 'content' => 'Bảo mật ứng dụng web là một yếu tố quan trọng để bảo vệ dữ liệu và người dùng của bạn. Bài viết này sẽ khám phá các kỹ thuật bảo mật quan trọng như xác thực, phân quyền, và mã hóa dữ liệu. Bạn cũng sẽ tìm hiểu về các lỗ hổng bảo mật phổ biến và cách phòng tránh chúng.'],
    ['id' => 5, 'title' => 'Cách triển khai CI/CD với GitLab', 'content' => 'Continuous Integration (CI) và Continuous Deployment (CD) là các phương pháp quản lý mã nguồn giúp tự động hóa quy trình phát triển phần mềm. GitLab cung cấp các công cụ mạnh mẽ để triển khai CI/CD. Bài viết này sẽ hướng dẫn bạn cách thiết lập pipeline CI/CD với GitLab để tự động hóa quá trình kiểm tra và triển khai mã nguồn.'],
    ['id' => 6, 'title' => 'Giới thiệu về Kubernetes và cách triển khai', 'content' => 'Kubernetes là một nền tảng mã nguồn mở để quản lý container và triển khai ứng dụng. Nó cung cấp các tính năng như tự động mở rộng, cân bằng tải, và quản lý trạng thái. Bài viết này sẽ giới thiệu các khái niệm cơ bản về Kubernetes và hướng dẫn bạn cách triển khai ứng dụng trong môi trường Kubernetes.']
];

// Tìm bài viết theo ID
$article_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$article = null;

foreach ($articles as $item) {
    if ($item['id'] === $article_id) {
        $article = $item;
        break;
    }
}

if ($article === null) {
    echo 'Bài viết không tồn tại hoặc không hợp lệ.';
    exit();
}

// Xử lý form chỉnh sửa bài viết
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SESSION['user_id'] === 'admin') { // Kiểm tra nếu là admin
        $new_title = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : $article['title'];
        $new_content = isset($_POST['content']) ? htmlspecialchars($_POST['content']) : $article['content'];
        
        foreach ($articles as &$item) {
            if ($item['id'] === $article_id) {
                $item['title'] = $new_title;
                $item['content'] = $new_content;
                break;
            }
        }
        header('Location: article_detail.php?id=' . $article_id);
        exit();
    } else {
        echo 'Bạn không có quyền chỉnh sửa bài viết này.';
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh Sửa Bài Viết</title>
</head>
<body>
    <h1>Chỉnh Sửa Bài Viết</h1>
    <?php if ($_SESSION['user_id'] === 'admin'): ?>
        <form method="post" action="">
            <label for="title">Tiêu Đề:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($article['title']); ?>" required>
            <label for="content">Nội Dung:</label>
            <textarea id="content" name="content" rows="10" required><?php echo htmlspecialchars($article['content']); ?></textarea>
            <button type="submit">Cập Nhật</button>
        </form>
    <?php else: ?>
        <p>Chỉ admin mới có quyền chỉnh sửa bài viết này.</p>
    <?php endif; ?>
    <a href="article_detail.php?id=<?php echo $article_id; ?>">Trở lại chi tiết bài viết</a>
</body>
</html>

