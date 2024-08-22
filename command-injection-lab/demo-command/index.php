<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Command Injection Demo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        footer {
            background: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .content {
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .input-section {
            margin-bottom: 20px;
        }
        .input-section input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .input-section input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }
        .input-section input[type="submit"]:hover {
            background-color: #555;
        }
        pre {
            background: #eee;
            padding: 10px;
            border-radius: 4px;
            white-space: pre-wrap; /* Preserve formatting */
        }
        .flag {
            background: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Command Injection Demo</h1>
    </header>
    <div class="container">
        <div class="content">
            <div class="input-section">
                <form method="get">
                    <input type="text" name="file" placeholder="Enter file path..." />
                    <input type="submit" value="View File" />
                </form>
            </div>
            <?php
            // Nhận input từ người dùng thông qua query string 'file'
            $file = isset($_GET['file']) ? $_GET['file'] : '';

            // Kiểm tra nếu có input và xử lý
            if ($file) {
                // Sử dụng shell_exec để thực thi lệnh cat với input từ người dùng
                $output = shell_exec("cat " . escapeshellarg($file));

                // Hiển thị kết quả
                echo "<pre>$output</pre>";
            }
            ?>
            <div class="flag">
                HUYQA{CommandInjectionIsFun}
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Command Injection Demo. All rights reserved.</p>
    </footer>
</body>
</html>

