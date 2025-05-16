<?php
include_once 'db.php';
session_start();

$websiteId = $_POST['websiteId'] ?? null;
$pageId = $_POST['pageId'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editTemplateId'])) {
    $templateId = $_POST['editTemplateId'];
    $templateName = $_POST['templateName'] ?? '';
    $templateType = $_POST['templateType'] ?? '';
    $width = $_POST['width'] ?? '';
    $height = $_POST['height'] ?? '';
    $backgroundColor = $_POST['backgroundColor'] ?? '';
    $flexDirection = $_POST['flexDirection'] ?? '';
    $alignItems = $_POST['alignItems'] ?? '';
    $justifyContent = $_POST['justifyContent'] ?? '';
    $margin = $_POST['margin'] ?? '';
    $padding = $_POST['padding'] ?? '';

    $stmt = $pdo->prepare("UPDATE templates SET templateName=?, templateType=?, width=?, height=?, backgroundColor=?, flexDirection=?, alignItems=?, justifyContent=?, margin=?, padding=? WHERE templateId=?");
    $success = $stmt->execute([
        $templateName, $templateType, $width, $height, $backgroundColor,
        $flexDirection, $alignItems, $justifyContent, $margin, $padding, $templateId
    ]);
    if ($success) {
        header("Location: editpage.php?websiteId=$websiteId&pageId=$pageId");
        exit();
    } else {
        echo "<script>alert('Update failed. Please try again.');window.history.back();</script>";
    }
}
?>