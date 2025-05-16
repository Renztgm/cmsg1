<?php
session_start();
include_once 'db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['faculty_id'])) {
    header("Location: facultylogin.php");
    exit();
}

$facultyName = $_SESSION['faculty_name'] ?? 'Faculty';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faculty Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            margin: 0;
            background: #f3f4f6;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 220px;
            height: 100vh;
            background: #6366f1;
            color: #fff;
            position: fixed;
            left: 0; top: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 32px 18px 18px 18px;
            box-shadow: 2px 0 8px rgba(99,102,241,0.08);
        }
        .sidebar h2 {
            margin: 0 0 32px 0;
            font-size: 22px;
            font-weight: bold;
            color: #fff;
        }
        .sidebar a, .sidebar button {
            display: block;
            width: 100%;
            background: none;
            border: none;
            color: #fff;
            text-align: left;
            padding: 12px 0 12px 8px;
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 8px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar button:hover {
            background: #4f46e5;
            color: #e0e7ff;
        }
        .main-content {
            margin-left: 240px;
            padding: 40px 32px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2><?= htmlspecialchars($facultyName) ?></h2>
        <a href="faculty_dashboard.php">Dashboard Home</a>
        <a href="faculty_enrollments.php">Check Enrollment Forms</a>
        <a href="faculty_grades.php">Grades Per Student</a>
        <a href="logout.php" style="color:#f87171;">Logout</a>
    </div>
    <div class="main-content">
        <h1>Welcome, <?= htmlspecialchars($facultyName) ?>!</h1>
        <p>Select an option from the menu to get started.</p>
    </div>
</body>
</html>