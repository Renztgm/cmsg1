<?php
include_once 'db.php';

// Get the websiteId from the URL (query parameter)
$targetWebsiteId = isset($_GET['websiteId']) ? (int)$_GET['websiteId'] : null;
$pageId = isset($_GET['pageId']) ? (int)$_GET['pageId'] : null;

if ($targetWebsiteId === null) {
    echo "<script>alert('Website ID is required.'); window.history.back();</script>";
    exit;
}
// 1. Check if website with ID 4 exists
$stmt = $pdo->prepare("SELECT * FROM page WHERE websiteId = :id");
$stmt->execute([':id' => $targetWebsiteId]);
$website = $stmt->fetch(PDO::FETCH_ASSOC);
 

// 2. If not exists, create it
if (!$website) {
    $createStmt = $pdo->prepare("INSERT INTO page (websiteId, name) VALUES (:id, :name)");
    $createStmt->execute([
        ':id' => $targetWebsiteId,
        ':name' => 'Home',
    ]);

    echo "<div style='display:none; align-items: center; justify-content: center; flex-direction: column;'>";
    echo "<strong>Website ID:</strong> " . htmlspecialchars($website['websiteId']) . "<br>";
    echo "<strong>Name:</strong> " . htmlspecialchars($website['name']) . "<br>";
    echo "</div>";
} else {
    // echo "<script>alert('Website ID $targetWebsiteId already exists.');</script>";
    echo "<div style='display:none; align-items: center; justify-content: center; flex-direction: column;'>";
    echo "<strong>Website ID:</strong> " . htmlspecialchars($website['websiteId']) . "<br>";
    echo "<strong>Name:</strong> " . htmlspecialchars($website['name']) . "<br>";
    echo "</div>";
}

$updatePagesStmt = $pdo->prepare("UPDATE page SET websiteId = :id WHERE websiteId IS NULL");
$updatePagesStmt->execute([':id' => $targetWebsiteId]);

if ($updatePagesStmt->rowCount() > 0) {
    // echo "<script>alert('Unlinked pages associated with Website ID $targetWebsiteId');</script>";
} else {
    // echo "<script>alert('No unlinked pages found.');</script>";

}


$logoQuery = "SELECT logo FROM website WHERE websiteId = :id";
$stmt = $pdo->prepare($logoQuery);
$stmt->execute([':id' => $targetWebsiteId]);
$logoResult = $stmt->fetch(PDO::FETCH_ASSOC);

$logoFilename = $logoResult ? $logoResult['logo'] : null;

$templateQuery = "SELECT * FROM templates WHERE pageId = :pageid";
$stmt = $pdo->prepare($templateQuery);
$stmt->execute([':pageid' => $pageId]);
$templateResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($templateResult) {
    // echo "<script>alert('Templates found for this page.');</script>";
} else {
    // echo "<script>alert('No templates found for this page.');</script>";

// Prepare template values
$websiteId = $targetWebsiteId;
$templateName = "Navigation";
$templateType = "Navigation";
$width = "100%";
$height = "80px";
$backgroundColor = "#ffffff";
$borderValue = "0px";
$borderStyle = "none";
$borderColor = "none";
$flexDirection = "row";
$alignItems = "center";
$justifyContent = "space-between";
$margin = "0px";
$padding = "0 10px 0 10px";
$orderTemp = 1; // Integer, not string
$parentTemplateId = null; // Use null if it's meant to be empty

// Use PDO prepared statement
$insertSql = "INSERT INTO templates (
    pageId, templateName, templateType, width, height, backgroundColor,
    borderValue, borderStyle, borderColor, flexDirection, alignItems,
    justifyContent, margin, padding, orderTemp, parentTemplateId
) VALUES (
    :pageId, :templateName, :templateType, :width, :height, :backgroundColor,
    :borderValue, :borderStyle, :borderColor, :flexDirection, :alignItems,
    :justifyContent, :margin, :padding, :orderTemp, :parentTemplateId
)";

$stmt = $pdo->prepare($insertSql);
$success = $stmt->execute([
    ':pageId' => $pageId,
    ':templateName' => $templateName,
    ':templateType' => $templateType,
    ':width' => $width,
    ':height' => $height,
    ':backgroundColor' => $backgroundColor,
    ':borderValue' => $borderValue,
    ':borderStyle' => $borderStyle,
    ':borderColor' => $borderColor,
    ':flexDirection' => $flexDirection,
    ':alignItems' => $alignItems,
    ':justifyContent' => $justifyContent,
    ':margin' => $margin,
    ':padding' => $padding,
    ':orderTemp' => $orderTemp,
    ':parentTemplateId' => $parentTemplateId
]);

// After template insertion
$templateId = $pdo->lastInsertId(); // Capture the newly inserted template's ID

$newPageId = $pdo->lastInsertId();

// Define 3 contents to insert
$contents = [
    [
        'templateId' => $templateId,
        'parentContentId' => null,
        'tag' => 'image',
        'width' => '25px',
        'height' => 'auto',
        'backgroundColor' => null,
        'text' => null,
        'orderContent' => 2,
        'imagePath' => 'uploads/'. $logoFilename,
        'href' => 'home',
        'target' => null,
        'fontcolor' => null,
        'fontstyle' => null,
        'fontsize' => null,
        'fontfamily' => null,
        'isclickable' => 1
    ],
    [
        'templateId' => $templateId,
        'parentContentId' => null,
        'tag' => 'image',
        'width' => '25px',
        'height' => '25px',
        'backgroundColor' => null,
        'text' => null,
        'orderContent' => 1,
        'imagePath' => 'uploads/burger-bar.png',
        'href' => null,
        'target' => null,
        'fontcolor' => null,
        'fontstyle' => null,
        'fontsize' => null,
        'fontfamily' => null,
        'isclickable' => 0
    ],
    [
        'templateId' => $templateId,
        'parentContentId' => null,
        'tag' => 'image',
        'width' => '25px',
        'height' => 'auto',
        'backgroundColor' => null,
        'text' => null,
        'orderContent' => 3,
        'imagePath' => 'uploads/magnifying-glass.png',
        'href' => null,
        'target' => null,
        'fontcolor' => null,
        'fontstyle' => null,
        'fontsize' => null,
        'fontfamily' => null,
        'isclickable' => 0
    ]
];

// Prepare insert statement once
$insertContentSql = "INSERT INTO contents (
    templateId, parentContentId, tag, width, height, backgroundColor,
    text, orderContent, imagePath, href, target,
    fontcolor, fontstyle, fontsize, fontfamily, isclickable
) VALUES (
    :templateId, :parentContentId, :tag, :width, :height, :backgroundColor,
    :text, :orderContent, :imagePath, :href, :target,
    :fontcolor, :fontstyle, :fontsize, :fontfamily, :isclickable
)";
$stmtContent = $pdo->prepare($insertContentSql);

// Insert each row
foreach ($contents as $content) {
    $stmtContent->execute($content);
}

if ($success) {
    echo "New template inserted successfully.";
} else {
    $errorInfo = $stmt->errorInfo();
    echo "Error inserting template: " . $errorInfo[2];
}

}


?>
