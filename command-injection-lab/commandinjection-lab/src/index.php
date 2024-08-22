<?php
// Header
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Command Injection Demo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"] {
            padding: 10px;
            font-size: 16px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        pre {
            background-color: #f4f4f4;
            padding: 10px;
            border: 1px solid #ddd;
            overflow-x: auto;
        }
        .note {
            margin-top: 20px;
            font-size: 14px;
            color: #ff5722;
            border: 1px solid #ff5722;
            padding: 10px;
        }
    </style>
</head>
<body>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cmd = $_POST['cmd'];

    // Danh sách trắng lệnh an toàn
    $allowed_commands = ['ls', 'date', 'whoami'];
    
    // Chuyển đổi lệnh nhập vào thành một mảng và kiểm tra
    $cmd_array = explode(' ', $cmd);
    $base_cmd = $cmd_array[0];

    if (in_array($base_cmd, $allowed_commands)) {
        // Thực hiện lệnh an toàn
        $output = shell_exec($cmd);
        echo "<pre>$output</pre>";
    } else {
        echo "<p style='color: red;'>Command Injection Detected or Command Not Allowed!</p>";
    }
}

// Form nhập lệnh
echo '<h1>Enter a command:</h1>
<form method="post">
    <input type="text" name="cmd" placeholder="Type your command here" />
    <input type="submit" value="Execute" />
</form>';

// Hướng dẫn tấn công và bảo mật
echo '<div class="note">
    <h2>Demo Instructions:</h2>
    <p>To demonstrate a command injection attack:</p>
    <ul>
        <li>Try entering the following command to list files in the current directory: <code>ls</code></li>
        <li>For a more advanced example, note that commands outside the allowed list will be blocked.</li>
    </ul>
    <h2>Security Recommendations:</h2>
    <ul>
        <li>Use a whitelist of allowed commands instead of filtering characters.</li>
        <li>Avoid executing user inputs directly as system commands.</li>
        <li>Consider using safer alternatives like PHP functions or libraries that do not require command execution.</li>
    </ul>
</div>';

// Footer
echo '<footer style="margin-top: 20px; font-size: 14px; color: #666;">
    <p>&copy; 2024 Command Injection Demo. All rights reserved.</p>
</footer>
</body>
</html>';
