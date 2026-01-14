<?php
include "config.php";
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    // Check if user already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $message = "Username already exists";
    } elseif ($password !== $confirm) {
        $message = "Passwords do not match";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert = "INSERT INTO users (username, password) 
                   VALUES ('$username', '$hashed_password')";

        if (mysqli_query($conn, $insert)) {
            $message = "Registration successful! <a href='login.php'>Login</a>";
        } else {
            $message = "Error occurred. Try again";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #43cea2, #185a9d);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .signup-box {
            background: #fff;
            padding: 30px;
            width: 350px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .signup-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .signup-box input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .signup-box button {
            width: 100%;
            padding: 10px;
            background: #43cea2;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .signup-box button:hover {
            background: #36b38a;
        }
        .message {
            text-align: center;
            margin-top: 10px;
            color: red;
        }
        .success {
            color: green;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="signup-box">
    <h2>Sign Up</h2>
    <form method="post">
        <input type="text" name="First name" placeholder="Enter first name" required>
        <input type="text" name="last name" placeholder="Enter last name" required>
        <input type="text" name="password" placeholder="Enter password" required>
        <input type="int" name="phone no" placeholder="Enter your phone no" required>
        <input type="text" name="email" placeholder="Enter your email" required>
        <input type="text" name="Address" placeholder="Enter your Address" required>
        <button type="submit">Register</button>
    </form>
    <div class="message <?= ($message && strpos($message, 'successful') !== false) ? 'success' : '' ?>">
        <?= $message ?>
    </div>
    <div class="login-link">
        Already have an account? <a href="login.php">Login</a>
    </div>
</div>
</body>
</html>