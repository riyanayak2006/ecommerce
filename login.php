<?php
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === "admin" && $password === "12345") {
        $message = "Login successful!";
    } else {
        $message = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            background: #fff;
            padding: 30px;
            width: 320px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .login-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .login-box input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .login-box button {
            width: 100%;
            padding: 10px;
            background: #667eea;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .login-box button:hover {
            background: #5a67d8;
        }
        .message {
            text-align: center;
            margin-top: 10px;
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Login</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <?php if ($message != ""): ?>
        <div class="message <?php echo ($message == 'Login successful!') ? 'success' : ''; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
