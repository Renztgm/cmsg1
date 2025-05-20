<?php
session_start();
include_once 'db.php';

if (!isset($_SESSION['faculty_id'])) {
    header("Location: facultylogin.php");
    exit();
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'], $_POST['enrollmentId'])) {
    $newStatus = $_POST['update_status'];
    $enrollmentId = $_POST['enrollmentId'];
    if (in_array($newStatus, ['approved', 'pending', 'rejected'])) {
        $stmt = $pdo->prepare("UPDATE enrollmentForm SET status = ? WHERE enrollmentId = ?");
        $stmt->execute([$newStatus, $enrollmentId]);
    }
    // Refresh to show updated status
    header("Location: faculty_enrollments.php");
    exit();
}

// Fetch all enrollment forms
$stmt = $pdo->query("SELECT enrollmentId, firstName, lastName, status FROM enrollmentForm ORDER BY status, lastName");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check Enrollment Forms</title>
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
        .sidebar a {
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
        .sidebar a:hover {
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
            margin-bottom: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 24px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(179,33,19,0.06);
        }
        th, td {
            border: 1px solid #A6A6AB;
            padding: 12px;
            text-align: center;
        }
        th {
            background: #CBC3BE;
            color: #831005;
            font-weight: bold;
        }
        .status-pending { color: #B32113; font-weight: bold; }
        .status-approved { color: #22c55e; font-weight: bold; }
        .status-rejected { color: #8F1600; font-weight: bold; }
        a.view-link {
            color: #1873D3;
            text-decoration: underline;
            font-weight: bold;
            transition: color 0.2s;
        }
        a.view-link:hover {
            color: #020082;
        }
        @media (max-width: 900px) {
            .main-content { padding: 20px 5vw; margin-left: 0; }
            .sidebar { position: static; width: 100vw; height: auto; flex-direction: row; align-items: center; padding: 16px 8px; }
            .sidebar h2 { margin: 0 16px 0 0; font-size: 1.1em; }
            .sidebar a { display: inline-block; width: auto; padding: 10px 14px; margin-bottom: 0; margin-right: 8px; }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2><?= htmlspecialchars($_SESSION['faculty_name']) ?></h2>
        <a href="faculty_dashboard.php">Dashboard Home</a>
        <a href="faculty_enrollments.php">Check Enrollment Forms</a>
        <a href="faculty_grades.php">Grades Per Student</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
    <div class="main-content">
        <h1>Enrollment Forms</h1>
        <table>
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($students as $student): ?>
            <tr>
                <td><?= htmlspecialchars($student['lastName'] . ', ' . $student['firstName']) ?></td>
                <td class="status-<?= strtolower($student['status']) ?>">
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="enrollmentId" value="<?= $student['enrollmentId'] ?>">
                        <select name="update_status" onchange="this.form.submit()" style="padding:4px 8px; border-radius:4px;">
                            <option value="pending" <?= $student['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="approved" <?= $student['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                            <option value="rejected" <?= $student['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                        </select>
                    </form>
                </td>
                <td>
                    <a href="faculty_view_grades.php?id=<?= $student['enrollmentId'] ?>" target="_blank" class="view-link">View</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>