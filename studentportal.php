<?php
session_start();
include_once 'db.php';

$enrollmentId = $_GET['id'] ?? null;
if (!$enrollmentId) {
    echo "<h2>Invalid access.</h2>";
    exit();
}

// Fetch student info
$stmt = $pdo->prepare("SELECT * FROM enrollmentForm WHERE enrollmentId = ?");
$stmt->execute([$enrollmentId]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    echo "<h2>Student not found.</h2>";
    exit();
}

$status = strtolower($student['status'] ?? '');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Portal</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .portal-container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 32px 28px 24px 28px;
            text-align: center;
        }
        .status-message {
            font-size: 1.2em;
            color: #6366f1;
            margin-bottom: 24px;
        }
        .rejected {
            color: #f87171;
        }
        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 24px;
        }
        .grades-table th, .grades-table td {
            border: 1px solid #d1d5db;
            padding: 10px;
            text-align: center;
        }
        .grades-table th {
            background: #f3f4f6;
        }
    </style>
</head>
<body>
<div class="portal-container">
    <h1>Welcome, <?= htmlspecialchars($student['firstName'] . ' ' . $student['lastName']) ?></h1>
    <a href="logout.php">Logout</a>
    <?php if ($status === 'pending'): ?>
        <div class="status-message">Your account is still on hold. Please wait for approval.</div>
    <?php elseif ($status === 'rejected'): ?>
        <div class="status-message rejected">
            Your enrollment is rejected due to some concern.<br>
            Please contact the faculty regarding this issue.
        </div>
    <?php elseif ($status === 'approved'): ?>
        <div class="status-message" style="color:#22c55e;">Your enrollment is approved. Here are your grades:</div>
        <?php
        // Fetch grades for this student, ordered by year and semester
        $gradesStmt = $pdo->prepare("SELECT professor, subject, grade, semester, schoolYear FROM grades WHERE enrollmentId = ? ORDER BY schoolYear DESC, semester ASC");
        $gradesStmt->execute([$enrollmentId]);
        $grades = $gradesStmt->fetchAll(PDO::FETCH_ASSOC);

        $grouped = [];
        foreach ($grades as $row) {
            $key = $row['schoolYear'] . ' - ' . $row['semester'];
            $grouped[$key][] = $row;
        }

        $totalSum = 0;
        $totalCount = 0;

        if ($grades):
            foreach ($grouped as $group => $rows):
                // Calculate average for this semester
                $sum = 0;
                $count = 0;
                foreach ($rows as $row) {
                    if (is_numeric($row['grade'])) {
                        $sum += $row['grade'];
                        $count++;
                        $totalSum += $row['grade'];   // accumulate for GWA
                        $totalCount++;
                    }
                }
                $average = $count > 0 ? round($sum / $count, 2) : 'N/A';
        ?>
            <h3 style="margin-top:30px; color:#6366f1;"><?= htmlspecialchars($group) ?></h3>
            <table class="grades-table">
                <tr>
                    <th>Professor</th>
                    <th>Subject</th>
                    <th>Grade</th>
                </tr>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['professor']) ?></td>
                        <td><?= htmlspecialchars($row['subject']) ?></td>
                        <td><?= htmlspecialchars($row['grade']) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2" style="text-align:right; font-weight:bold;">Average Grade:</td>
                    <td style="font-weight:bold;"><?= $average ?></td>
                </tr>
            </table>
        <?php
            endforeach;
            // GWA calculation and display
            $gwa = $totalCount > 0 ? round($totalSum / $totalCount, 2) : 'N/A';
        ?>
            <div style="margin-top:32px; font-size:1.2em; font-weight:bold; color:#6366f1;">
                General Weighted Average (GWA): <?= $gwa ?>
            </div>
        <?php
        else:
            echo '<div style="margin-top:24px;">No grades available.</div>';
        endif;
        ?>
    <?php else: ?>
        <div class="status-message">Unknown status.</div>
    <?php endif; ?>
</div>
</body>
</html>