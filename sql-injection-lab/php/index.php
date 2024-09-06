<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Search</title>
    <link rel="stylesheet" href="https://www.free-css.com/assets/css/modern.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            overflow: hidden;
        }
        header {
            background: #333;
            color: #fff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #ccc 1px solid;
            text-align: center;
        }
        header h1 {
            margin: 0;
            font-size: 24px;
        }
        form {
            margin: 20px 0;
            text-align: center;
        }
        form input[type="text"] {
            width: 300px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        form input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background: #333;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        .article {
            background: #fff;
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .article h2 {
            margin: 0 0 10px;
            color: #333;
        }
        .article p {
            margin: 0;
            color: #666;
        }
        .error-message {
            color: red;
            text-align: center;
            margin: 20px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Article Search</h1>
        </div>
    </header>

    <div class="container">
        <!-- Form tìm kiếm -->
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search articles">
            <input type="submit" value="Search">
        </form>

        <?php
        $servername = "mysql";
        $username = "root";
        $password = "my-secret-pw";
        $dbname = "ctf_database";

        // Kết nối đến cơ sở dữ liệu
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Nhận input từ người dùng
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        if ($search !== '') {
            // Tạo câu lệnh SQL tìm kiếm không an toàn
            $sql = "SELECT * FROM articles WHERE title LIKE '%$search%' OR content LIKE '%$search%' OR id = $search";

            // Thực thi câu lệnh SQL
            $result = $conn->query($sql);

            // Kiểm tra lỗi SQL
            if ($conn->error) {
                echo "<div class='error-message'><h3>SQL Syntax Error Detected!</h3>";
                echo "Error details: " . $conn->error . "</div>";
            } else {
                // Hiển thị kết quả tìm kiếm bài viết
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='article'>";
                        echo "<h2>ID: " . $row["id"] . " - Title: " . $row["title"] . "</h2>";
                        echo "<p>" . $row["content"] . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='error-message'>No articles found.</div>";
                }
            }
        } else {
            // Nếu không nhập gì, hiển thị toàn bộ các bài viết
            echo "<h3>All Articles:</h3>";
            $sql = "SELECT * FROM articles";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='article'>";
                    echo "<h2>ID: " . $row["id"] . " - Title: " . $row["title"] . "</h2>";
                    echo "<p>" . $row["content"] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<div class='error-message'>No articles available.</div>";
            }
        }

        $conn->close();
        ?>
    </div>
</body>
</html>

