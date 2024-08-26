<?php
// articles.php

// Dữ liệu mẫu cho bài viết
$articles = [
    ['id' => 1, 'title' => 'Hướng dẫn sử dụng PHP PDO', 'content' => 'PHP Data Objects (PDO) là một lớp dữ liệu trong PHP cung cấp một giao diện nhất quán cho việc truy cập cơ sở dữ liệu. PDO hỗ trợ nhiều cơ sở dữ liệu khác nhau và cung cấp các phương thức bảo mật để tránh SQL injection. Bài viết này sẽ hướng dẫn bạn cách sử dụng PDO trong PHP để kết nối và thao tác với cơ sở dữ liệu.'],
    ['id' => 2, 'title' => 'Các phương pháp tối ưu hóa MySQL', 'content' => 'Tối ưu hóa MySQL là một phần quan trọng trong quản trị cơ sở dữ liệu. Bài viết này sẽ trình bày các phương pháp tối ưu hóa hiệu suất của MySQL, bao gồm việc tối ưu hóa truy vấn, chỉ số, và cấu hình máy chủ. Những kỹ thuật này sẽ giúp tăng cường hiệu suất và giảm thiểu thời gian truy xuất dữ liệu.'],
    ['id' => 3, 'title' => 'Giới thiệu về Docker và cách sử dụng', 'content' => 'Docker là một nền tảng mã nguồn mở cho phép bạn tạo, triển khai và chạy các ứng dụng trong các container. Các container giúp đóng gói phần mềm với tất cả các phụ thuộc của nó, cho phép chạy ứng dụng nhất quán trên nhiều môi trường khác nhau. Bài viết này sẽ giới thiệu về Docker, cách cài đặt, và cách sử dụng Docker để phát triển ứng dụng.'],
    ['id' => 4, 'title' => 'Các kỹ thuật bảo mật cho ứng dụng web', 'content' => 'Bảo mật ứng dụng web là một yếu tố quan trọng để bảo vệ dữ liệu và người dùng của bạn. Bài viết này sẽ khám phá các kỹ thuật bảo mật quan trọng như xác thực, phân quyền, và mã hóa dữ liệu. Bạn cũng sẽ tìm hiểu về các lỗ hổng bảo mật phổ biến và cách phòng tránh chúng.'],
    ['id' => 5, 'title' => 'Cách triển khai CI/CD với GitLab', 'content' => 'Continuous Integration (CI) và Continuous Deployment (CD) là các phương pháp quản lý mã nguồn giúp tự động hóa quy trình phát triển phần mềm. GitLab cung cấp các công cụ mạnh mẽ để triển khai CI/CD. Bài viết này sẽ hướng dẫn bạn cách thiết lập pipeline CI/CD với GitLab để tự động hóa quá trình kiểm tra và triển khai mã nguồn.'],
    ['id' => 6, 'title' => 'Giới thiệu về Kubernetes và cách triển khai', 'content' => 'Kubernetes là một nền tảng mã nguồn mở để quản lý container và triển khai ứng dụng. Nó cung cấp các tính năng như tự động mở rộng, cân bằng tải, và quản lý trạng thái. Bài viết này sẽ giới thiệu các khái niệm cơ bản về Kubernetes và hướng dẫn bạn cách triển khai ứng dụng trong môi trường Kubernetes.']
];

// Xử lý tìm kiếm
$search_query = '';
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $articles = array_filter($articles, function($article) use ($search_query) {
        return stripos($article['title'], $search_query) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài Viết</title>
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
        <h1 class="text-center mb-4">Danh Sách Bài Viết</h1>

        <!-- Search Form -->
        <div class="mb-4">
            <form action="articles.php" method="get">
                <div class="input-group">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" class="form-control" placeholder="Tìm kiếm bài viết">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </div>
            </form>
        </div>

        <!-- Articles List -->
        <div class="list-group">
            <?php if (empty($articles)): ?>
                <p class="text-center">Không có bài viết nào.</p>
            <?php else: ?>
                <?php foreach ($articles as $article): ?>
                    <a href="article_detail.php?id=<?php echo $article['id']; ?>" class="list-group-item list-group-item-action">
                        <h4 class="mb-2"><?php echo htmlspecialchars($article['title']); ?></h4>
                        <p><?php echo htmlspecialchars(substr($article['content'], 0, 100)) . '...'; ?></p>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
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

