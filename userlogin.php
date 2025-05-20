<?php
session_start();
include_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['userId'];
        $_SESSION['user_username'] = $user['username'];
        $_SESSION['user_name'] = $user['fullName'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
     <link rel="icon" type="image/svg" href="icons/logo.svg">
    <style>
        body {
            background: #DEF2F1;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .form-container {
            background: #FEFFFF;
            box-shadow: 0 4px 24px rgba(42,122,120,0.08);
            border-radius: 12px;
            padding: 40px 32px 32px 32px;
            margin: 60px auto;
            max-width: 350px;
        }
        h1 {
            color: #2B7A78;
            margin-bottom: 24px;
            font-size: 2em;
            text-align: center;
        }
        label {
            color: #2B7A78;
            font-weight: 500;
            margin-top: 18px;
            margin-bottom: 6px;
            display: block;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 0 0 18px 0;
            border: 1.5px solid #3AAFA9;
            border-radius: 6px;
            background: #DEF2F1;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.2s, background 0.2s;
            display: block;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #2B7A78;
            background: #FEFFFF;
            outline: none;
        }
        button[type="submit"] {
            width: 100%;
            background: #2B7A78;
            color: #FEFFFF;
            border: none;
            border-radius: 6px;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        button[type="submit"]:hover {
            background: #17252A;
        }
        .register-link {
            margin-top: 18px;
            text-align: center;
        }
        .register-link a {
            color: #3AAFA9;
            text-decoration: none;
            font-weight: bold;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #f87171;
            margin-bottom: 16px;
            text-align: center;
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h1>User Login</h1>
    <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required autofocus>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Login</button>
    </form>
    <div class="register-link">
        No account? <a href="userregister.php">Register</a>
    </div>
</div>
</body>
</html>