<?php
include_once 'db.php';
session_start();

$websiteId = $_POST['websiteId'] ?? $_GET['websiteId'] ?? null;
$pageId = $_POST['pageId'] ?? $_GET['pageId'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contentId'])) {
    $contentId = $_POST['contentId'];
    $width = $_POST['width'] ?? null;
    $height = $_POST['height'] ?? null;
    $backgroundColor = (isset($_POST['backgroundColor']) && $_POST['backgroundColor'] !== '') ? $_POST['backgroundColor'] : null;
    $text = $_POST['text'] ?? $_POST['linkText'] ?? null;
    $margin = $_POST['margin'] ?? null;
    $padding = $_POST['padding'] ?? null;
    $fontFamily = $_POST['fontFamily'] ?? $_POST['linkFontFamily'] ?? null;
    $fontSize = $_POST['fontSize'] ?? $_POST['linkFontSize'] ?? null;
    $fontColor = $_POST['fontColor'] ?? $_POST['linkFontColor'] ?? null;
    $href = $_POST['href'] ?? null;
    $target = $_POST['target'] ?? null;

    $success = true;

    // Handle image upload
    if (isset($_FILES['imagePath']) && $_FILES['imagePath']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filename = uniqid() . '_' . basename($_FILES['imagePath']['name']);
        $targetFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['imagePath']['tmp_name'], $targetFile)) {
            $stmt = $pdo->prepare("UPDATE contents SET imagePath = ? WHERE contentId = ?");
            if (!$stmt->execute([$targetFile, $contentId])) {
                $success = false;
            }
        } else {
            $success = false;
        }
    }

    // Update other fields
    $stmt = $pdo->prepare("UPDATE contents SET width = ?, height = ?, backgroundColor = ?, text = ?, margin = ?, padding = ?, fontFamily = ?, fontSize = ?, fontColor = ?, href = ?, target = ? WHERE contentId = ?");
    if (!$stmt->execute([
        $width, $height, $backgroundColor, $text, $margin, $padding,
        $fontFamily, $fontSize, $fontColor,
        $href, $target, $contentId
    ])) {
        $success = false;
    }

    if ($success) {
        echo "'Content updated successfully";
        header("Location: editpage.php?websiteId=$websiteId&pageId=$pageId");
        exit();
    } else {
        echo "<script>alert('Update failed. Please try again.');window.history.back();</script>";
        echo "Update failed. Please try again.";
    }
}
?>