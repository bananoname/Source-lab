<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ - Phần Mềm Quản Lý Nhân Sự</title>
    <link rel="stylesheet" href="css/upload-style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <h1>Phần Mềm Quản Lý Nhân Sự</h1>
                <nav>
                    <ul>
                        <li><a href="index.php">Trang Chính</a></li>
                        <li><a href="about.php">Giới Thiệu Công Ty</a></li>
                        <li><a href="contact.php">Liên Hệ</a></li>
                        <li><a href="login.php">Login</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <section class="contact">
                <h2>Liên Hệ</h2>
                <p>Địa chỉ: 123 Đường ABC, Quận 1, TP. Hồ Chí Minh</p>
                <p>Email: contact@abc.com</p>
                <p>Điện thoại: (028) 1234 5678</p>
                <form action="upload.php" method="post" enctype="multipart/form-data" class="contact-form">
                    <div class="form-group">
                        <label for="name">Tên:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Tin nhắn:</label>
                        <textarea id="message" name="message" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="file">Đính kèm tệp tin:</label>
                        <input type="file" id="file" name="file">
                    </div>
                    <button type="submit">Gửi Tin Nhắn</button>
                </form>
            </section>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Công Ty ABC. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>
</body>
</html>
