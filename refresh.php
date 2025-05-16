<?php 
include 'db.php';

        
// Get the lowest pageId for each website
$minPageStmt = $pdo->prepare("SELECT MIN(pageId) as minPageId FROM page WHERE websiteId = :id");
$minPageStmt->execute([':id' => $website['websiteId']]);
$minPage = $minPageStmt->fetch(PDO::FETCH_ASSOC);
$minPageId = $minPage && $minPage['minPageId'] !== null ? $minPage['minPageId'] : '';
$websiteId = $_POST['websiteId'] ?? $_GET['websiteId'];
$pageId = $_POST['pageId'] ?? $_GET['pageId'];

// Check if the pageId is not null
if ($minPageId === null) {
    echo "<script>alert('Page ID is required.'); window.history.back();</script>";
    header("Location: editpage.php?websiteId=$websiteId&pageId=$minPageId");
    exit;
}

?>