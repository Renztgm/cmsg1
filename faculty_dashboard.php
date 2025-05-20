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
        <style>
        body {
            margin: 0;
            background: #CBC3BE;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .sidebar {
            width: 220px;
            height: 100vh;
            background: #B32113;
            color: #fff;
            position: fixed;
            left: 0; top: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 32px 18px 18px 18px;
            box-shadow: 2px 0 8px rgba(179,33,19,0.08);
        }
        .sidebar h2 {
            margin: 0 0 32px 0;
            font-size: 22px;
            font-weight: bold;
            color: #fff;
            letter-spacing: 1px;
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
            background: #8F1600;
            color: #CBC3BE;
        }
        .sidebar a.logout {
            color: #CBC3BE;
            font-weight: bold;
        }
        .sidebar a.logout:hover {
            background: #CBC3BE;
            color: #B32113;
        }
        .main-content {
            margin-left: 240px;
            padding: 40px 32px;
        }
        .main-content h1 {
            color: #B32113;
            font-size: 2.2em;
            margin-bottom: 12px;
        }
        .main-content p {
            color: #8F1600;
            font-size: 1.1em;
        }
        @media (max-width: 700px) {
            .sidebar {
                width: 100vw;
                height: auto;
                flex-direction: row;
                align-items: center;
                padding: 16px 8px;
                position: static;
                box-shadow: none;
            }
            .sidebar h2 {
                margin: 0 16px 0 0;
                font-size: 1.1em;
            }
            .sidebar a, .sidebar button {
                display: inline-block;
                width: auto;
                padding: 10px 14px;
                margin-bottom: 0;
                margin-right: 8px;
            }
            .main-content {
                margin-left: 0;
                padding: 24px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2><?= htmlspecialchars($facultyName) ?></h2>
        <a href="faculty_dashboard.php">Dashboard Home</a>
        <a href="faculty_enrollments.php">Check Enrollment Forms</a>
        <a href="faculty_grades.php">Grades Per Student</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
    <div class="main-content">
        <h1>Welcome, <?= htmlspecialchars($facultyName) ?>!</h1>
        <p>Select an option from the menu to get started.</p>
    </div>
</body>
</html>