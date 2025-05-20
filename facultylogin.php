<?php
session_start();
include_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM faculty WHERE username = ?");
    $stmt->execute([$username]);
    $faculty = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($faculty && password_verify($password, $faculty['password'])) {
        $_SESSION['faculty_id'] = $faculty['facultyId'];
        $_SESSION['faculty_username'] = $faculty['username'];
        $_SESSION['faculty_name'] = $faculty['fullName'];
        header("Location: faculty_dashboard.php");
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
    <title>Faculty Login</title>
    <style>
        body {
            background: #CBC3BE;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .form-container {
            background: #fff;
            box-shadow: 0 4px 24px rgba(179,33,19,0.08);
            border-radius: 14px;
            padding: 40px 32px 32px 32px;
            margin: 60px auto;
            max-width: 350px;
            border: 2px solid #B32113;
        }
        h1 {
            color: #B32113;
            margin-bottom: 24px;
            font-size: 2em;
            text-align: center;
            font-weight: bold;
        }
        label {
            color: #8F1600;
            font-weight: 500;
            margin-top: 18px;
            margin-bottom: 6px;
            display: block;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 0 0 18px 0;
            border: 1.5px solid #B32113;
            border-radius: 6px;
            background: #CBC3BE;
            font-size: 16px;
            color: #831005;
            box-sizing: border-box;
            transition: border-color 0.2s, background 0.2s;
            display: block;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #8F1600;
            background: #fff;
            outline: none;
        }
        button[type="submit"] {
            width: 100%;
            background: #B32113;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        button[type="submit"]:hover {
            background: #831005;
        }
        .register-link {
            margin-top: 18px;
            text-align: center;
        }
        .register-link a {
            color: #B32113;
            text-decoration: none;
            font-weight: bold;
        }
        .register-link a:hover {
            text-decoration: underline;
            color: #8F1600;
        }
        .error-message {
            color: #B32113;
            margin-bottom: 16px;
            text-align: center;
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h1>Faculty Login</h1>
    <?php if ($error): ?><div class="error-message"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" required autofocus>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
    <div class="register-link">
        No account? <a href="facultyregister.php">Register</a>
    </div>
</div>
</body>
</html>