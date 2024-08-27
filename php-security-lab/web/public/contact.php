<?php
// contact.php
include '../includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ - TechNova Solutions</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <style>
        /* Inline CSS for decoration */
        .contact-container {
            padding: 3rem;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .contact-intro {
            margin-bottom: 2rem;
        }
        .contact-intro h2 {
            color: #007bff;
            margin-bottom: 1rem;
        }
        .contact-info, .contact-form {
            margin-bottom: 2rem;
        }
        .contact-form textarea {
            height: 150px;
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
        <div class="contact-container">
            <h1 class="text-center mb-4">Liên Hệ Với TechNova Solutions</h1>

            <!-- Company Introduction -->
            <div class="contact-intro">
                <h2 class="text-center">Giới Thiệu Công Ty</h2>
                <p class="text-center">Chào mừng bạn đến với <strong>TechNova Solutions</strong>. Chúng tôi cung cấp các giải pháp công nghệ tiên tiến để giúp doanh nghiệp của bạn phát triển và thành công. Đội ngũ của chúng tôi luôn sẵn sàng hỗ trợ bạn để đạt được mục tiêu của mình. Với kinh nghiệm dày dạn và đội ngũ chuyên gia hàng đầu, chúng tôi cam kết mang đến dịch vụ và sản phẩm chất lượng cao nhất.</p>
            </div>

            <!-- Contact Information -->
            <div class="contact-info mb-4">
                <h2 class="text-center">Thông Tin Liên Hệ</h2>
                <p class="text-center">Nếu bạn có bất kỳ câu hỏi nào hoặc cần hỗ trợ, vui lòng liên hệ với chúng tôi qua email:</p>
                <p class="text-center"><strong>Email:</strong> <a href="mailto:support@technova.com" class="text-decoration-none">support@technova.com</a></p>
                <p class="text-center"><strong>Điện thoại:</strong> +84 123 456 789</p>
                <p class="text-center"><strong>Địa chỉ:</strong> Tầng 10, Tòa nhà TechNova, 123 Đường Công Nghệ, Quận 1, TP.HCM, Việt Nam</p>
            </div>

            <!-- Contact Form -->
            <div class="contact-form">
                <h2 class="text-center">Gửi Tin Nhắn</h2>
                <form action="contact_process.php" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ Tên</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Tin Nhắn</label>
                        <textarea name="message" id="message" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary-custom">Gửi</button>
                </form>
            </div>
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

