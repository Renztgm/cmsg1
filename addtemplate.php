<?php
include_once 'db.php';
$_SESSION['websiteId'] = $_GET['websiteId'];
$pageId = $_GET['pageId'];
?>

<form method="POST" action="insert_template.php" enctype="multipart/form-data">
    <input type="text" name="websiteId" value="<?php echo $websiteId ?>" placeholder="Website ID" hidden>
    <input type="text" name="pageId" value="<?php echo $pageId ?>" placeholder="Template Name" hidden>
    <label for="templateName">Template Name:</label>
    <input type="text" id="templateName" name="templateName" required><br><br>
    <label for="templateType">Template Type:</label>
    <select name="templateType" id="templateType" required>
        <option value="Navigation">Navigation</option>
        <option value="Content">Content</option>
        <option value="Footer">Footer</option>
        <option value="Header">Header</option>
    </select><br><br>
    <label for="width">Width:</label>
    <input type="number" id="width" name="width" required>
    <select name="widthSuffix">
        <option value="px">px</option>
        <option value="rem">rem</option>
        <option value="%">%</option>
        <option value="vw">vw</option>
    </select><br><br>
    <label for="height">Height:</label>
    <input type="number" id="height" name="height" required>
    <select name="heightSuffix">
        <option value="px">px</option>
        <option value="rem">rem</option>
        <option value="%">%</option>
        <option value="vw">vh</option>
    </select><br><br>
    <label for="backgroundColor">Background Color (integer value):</label>
    <input type="color" id="backgroundColor" name="backgroundColor"><br><br>
    <label for="borderValue">Border Value:</label>
    <input type="number" id="borderValue" name="borderValue"><br><br>
    <label for="borderStyle">Border Style:</label>
    <input type="text" id="borderStyle" name="borderStyle"><br><br>
    <label for="borderColor">Border Color (integer value):</label>
    <input type="color" id="borderColor" name="borderColor"><br><br>
    <label for="flexDirection">Flex Direction:</label>
    <input type="text" id="flexDirection" name="flexDirection"><br><br>
    <label for="alignItems">Align Items:</label>
    <input type="text" id="alignItems" name="alignItems"><br><br>
    <label for="justifyContent">Justify Content:</label>
    <input type="text" id="justifyContent" name="justifyContent"><br><br>
    <label for="margin">Margin:</label>
    <input type="number" id="margin" name="margin"><br><br>
    <label for="padding">Padding:</label>
    <input type="number" id="padding" name="padding"><br><br>
    <label for="orderTemp">Order Temp:</label>
    <input type="number" id="orderTemp" name="orderTemp" required><br><br>
    <label for="parentTemplateId">Parent Template ID:</label>
    <select name="parentTemplateId" id="parentTemplateId">
        <option value="">None</option>
        <?php
        // Fetch all templates for the dropdown
        $stmt = $pdo->query("SELECT templateId, templateName FROM templates where pageId = $pageId");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . htmlspecialchars($row['templateId']) . '">' . htmlspecialchars($row['templateName']) . '</option>';
        }
        ?>
    <input type="submit" value="Submit">
</form>