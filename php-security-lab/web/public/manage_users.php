<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../includes/config.php';
session_start(); // Bắt đầu phiên làm việc

// Tạo mã thông báo CSRF nếu chưa có
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = '';
$back_button = '';

// Hàm hiển thị mã nguồn của chính tập tin này
function viewCode() {
    return "<pre class='code-view'><code>" . htmlspecialchars(file_get_contents(__FILE__)) . "</code></pre>";
}

// Hàm hiển thị thông tin người dùng hiện tại
function viewUser() {
    if (isset($_SESSION['user_id'])) {
        return "<p class='info'>Người dùng hiện tại: " . htmlspecialchars($_SESSION['user_id']) . "</p>";
    } else {
        return "<p class='error'>Chưa có người dùng nào đăng nhập.</p>";
    }
}

// Xử lý yêu cầu POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Xác thực mã thông báo CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "<p class='error'>Yêu cầu không hợp lệ.</p>";
    } else {
        // Xử lý các hành động khác nhau
        switch (true) {
            case isset($_POST['view_code']):
                $message = viewCode();
                $back_button = "<form method='post' action=''><button type='submit' name='back' class='btn back-button'>Trở Lại</button></form>";
                break;
            case isset($_POST['upload_file']):
                header("Location: upload.php");
                exit();
            case isset($_POST['view_user']):
                $message = viewUser();
                break;
	   case isset($_POST['articles.php']):
		$message = articles.php();
		exit();
            case isset($_POST['view_all_users']):
                header("Location: viewuser.php");
                exit();
            case isset($_POST['back']):
                header("Location: login.php");
                exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Người Dùng</title>
    <link rel="stylesheet" href="css/manageuser-style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <a href="#" class="logo">Quản Lý Người Dùng</a>
                <ul class="nav-links">
                    <li><a href="index.php">Trang Chủ</a></li>
                   <li><a href="articles.php">Bài viết</a></li> 
		   <li><a href="upload.php">Upload File</a></li>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === 'admin'): ?>
                        <li><a href="viewuser.php">Xem Tất Cả Người Dùng</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">Đăng Xuất</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main class="container">
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="main-content">
                <h1>Quản Lý Người Dùng</h1>
                <p class="intro-text">
                    Chào mừng bạn đến với hệ thống Quản Lý Người Dùng, một nền tảng trực tuyến được thiết kế để giúp bạn dễ dàng quản lý tài khoản và thông tin cá nhân.
                    Hệ thống của chúng tôi không chỉ là công cụ hỗ trợ quản trị viên, mà còn là cầu nối giúp người dùng tương tác và kiểm soát các dữ liệu cá nhân của mình một cách hiệu quả và an toàn.
                    <br><br>
                    Tại đây, bạn có thể thực hiện nhiều thao tác khác nhau liên quan đến việc quản lý người dùng. Chẳng hạn, nếu bạn là quản trị viên,
                    bạn có thể xem danh sách tất cả người dùng đã đăng ký trên hệ thống, kiểm tra hoạt động gần đây của họ, và thậm chí có thể chỉnh sửa hoặc xóa các tài khoản không còn cần thiết.
                    Ngoài ra, chức năng tải lên tập tin cho phép bạn cập nhật hoặc thêm mới các tài liệu quan trọng liên quan đến tài khoản của bạn, giúp lưu trữ và quản lý thông tin một cách khoa học.
                    <br><br>
                    Một trong những tính năng nổi bật của hệ thống là khả năng hiển thị mã nguồn của chính trang web này. Điều này không chỉ giúp bạn kiểm tra tính minh bạch
                    và bảo mật của hệ thống, mà còn tạo điều kiện cho các lập trình viên hoặc những người yêu thích công nghệ có thể học hỏi và nghiên cứu từ mã nguồn thực tế.
                    Với cơ chế bảo mật mã thông báo CSRF, bạn hoàn toàn có thể yên tâm rằng các thao tác của mình được bảo vệ khỏi các cuộc tấn công giả mạo và không bị lạm dụng từ các nguồn không tin cậy.
                    <br><br>
                    Đặc biệt, chúng tôi hiểu rằng mỗi người dùng đều có nhu cầu riêng, do đó hệ thống cũng cung cấp các tùy chọn tùy chỉnh theo ý muốn của bạn.
                    Bạn có thể chọn các chức năng mình muốn sử dụng và dễ dàng chuyển đổi giữa các chức năng đó chỉ với vài cú nhấp chuột. Đối với những người dùng đặc quyền như quản trị viên,
                    bạn sẽ có thêm các tùy chọn nâng cao để quản lý hệ thống một cách toàn diện và chi tiết hơn.
                    <br><br>
                    Với mục tiêu mang lại trải nghiệm người dùng tốt nhất, chúng tôi luôn nỗ lực phát triển và cập nhật các tính năng mới nhằm đáp ứng nhu cầu ngày càng cao của bạn.
                    Từ giao diện thân thiện, dễ sử dụng, cho đến các chức năng mạnh mẽ và linh hoạt, hệ thống Quản Lý Người Dùng chắc chắn sẽ là một công cụ đắc lực hỗ trợ bạn trong việc quản lý thông tin cá nhân và tài khoản người dùng.
                    <br><br>
                    Hãy khám phá tất cả các tính năng mà chúng tôi đã chuẩn bị cho bạn! Dù bạn là người dùng mới hay là một quản trị viên lâu năm,
                    hệ thống này sẽ mang đến cho bạn một trải nghiệm quản lý tài khoản chưa từng có. Chúng tôi cam kết bảo mật thông tin của bạn,
                    đồng thời cung cấp các công cụ và tài nguyên cần thiết để bạn có thể thực hiện mọi thao tác một cách hiệu quả và an toàn.
                    <br><br>
                    Nếu bạn cần hỗ trợ hoặc có bất kỳ câu hỏi nào, đừng ngần ngại liên hệ với đội ngũ hỗ trợ của chúng tôi. Chúng tôi luôn sẵn sàng giúp đỡ bạn trong mọi tình huống.
                    Hãy bắt đầu hành trình khám phá hệ thống Quản Lý Người Dùng ngay hôm nay và tận hưởng những tiện ích mà chúng tôi mang lại!
                </p>
                <form method="post" action="" class="action-form">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <button type="submit" name="view_code" class="btn">Xem Mã Nguồn</button>
                    <button type="submit" name="upload_file" class="btn">Upload File</button>
                    <button type="submit" name="view_user" class="btn">Xem Người Dùng Đăng Nhập</button>
                    <?php if ($_SESSION['user_id'] === 'admin'): ?>
                        <button type="submit" name="view_all_users" class="btn">Xem Tất Cả Người Dùng</button>
                    <?php endif; ?>
                </form>
                <div class="message-container">
                    <?php echo $message; ?>
                    <?php echo $back_button; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="login-prompt">
                <p class='error'>Bạn cần đăng nhập để truy cập vào trang này.</p>
                <a href="login.php" class="btn">Trở Lại Đăng Nhập</a>
            </div>
        <?php endif; ?>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Quản Lý Người Dùng. Tất cả các quyền được bảo lưu.</p>
        </div>
    </footer>
</body>
</html>

