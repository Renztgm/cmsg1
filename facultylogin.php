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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="form-container" style="max-width:350px;margin:60px auto;">
    <h1>Faculty Login</h1>
    <?php if ($error): ?><div style="color:#f87171;"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" required autofocus>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
    <div style="margin-top:10px;">
        No account? <a href="facultyregister.php">Register</a>
    </div>
</div>
</body>
</html>