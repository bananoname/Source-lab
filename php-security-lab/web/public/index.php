<?php
// index.php

include '../includes/config.php';

// Xử lý yêu cầu trang
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = "home";
}

$file = "templates/" . $page . ".php";

// Bảo mật đường dẫn tệp để ngăn chặn path traversal
assert("strpos('$file', '..') === false") or die("Detected hacking attempt!");

// Kiểm tra sự tồn tại của tệp
assert("file_exists('$file')") or die("That file doesn't exist!");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - TechNova Solutions</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <style>
        /* Inline CSS for decoration */
        .company-intro {
            margin-bottom: 2rem;
        }
        .company-intro h2 {
            color: #007bff;
            margin-bottom: 1rem;
        }
        .btn-primary-custom {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary-custom:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <header class="bg-primary text-white py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="index.php" class="text-white text-decoration-none fs-4">Trang Chủ</a>
                <nav>
                    <a href="forum.php" class="btn btn-light">Forum</a>
                    <a href="contact.php" class="btn btn-light">Liên Hệ</a>
                    <a href="news.php" class="btn btn-light">Tin Tức</a>
                    <a href="login.php" class="btn btn-light">Đăng Nhập</a>
                    <a href="articles.php" class="btn btn-light">Bài Viết</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container my-5 flex-grow-1">
        <h1 class="text-center mb-4">Chào Mừng Bạn Đến Với TechNova Solutions</h1>

        <!-- Company Introduction -->
        <div class="company-intro">
            <h2 class="text-center">Giới Thiệu Về TechNova Solutions</h2>
            <p class="text-center">TechNova Solutions là một công ty hàng đầu trong lĩnh vực công nghệ thông tin, chuyên cung cấp các giải pháp và dịch vụ công nghệ đột phá cho doanh nghiệp. Với sứ mệnh thúc đẩy sự đổi mới và nâng cao hiệu quả hoạt động, chúng tôi cam kết mang đến các sản phẩm và dịch vụ chất lượng cao nhất cho khách hàng của mình.</p>
            <p class="text-center">Tại TechNova Solutions, chúng tôi tập trung vào việc xây dựng các giải pháp tùy chỉnh phù hợp với nhu cầu cụ thể của từng khách hàng. Đội ngũ chuyên gia của chúng tôi sở hữu kiến thức sâu rộng và kinh nghiệm thực tiễn trong nhiều lĩnh vực công nghệ, từ phát triển phần mềm đến tích hợp hệ thống và hỗ trợ kỹ thuật.</p>
            <p class="text-center">Chúng tôi luôn sẵn sàng đồng hành cùng bạn trên con đường phát triển công nghệ và đạt được những mục tiêu kinh doanh của bạn. Hãy liên hệ với chúng tôi để khám phá cách chúng tôi có thể giúp đỡ bạn.</p>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-light py-3 mt-auto">
        <div class="container text-center">
            <p class="mb-0">© 2024 TechNova Solutions. Tất cả các quyền được bảo lưu.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

