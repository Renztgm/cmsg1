<?php
include_once 'db.php';
include 'createwebsite.php';

?>

<?php
if (isset($_GET['delete_website'])) {
    $websiteId = $_GET['delete_website'];

    // 1. Get all pages for this website
    $stmt = $pdo->prepare("SELECT pageId FROM page WHERE websiteId = ?");
    $stmt->execute([$websiteId]);
    $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($pages as $page) {
        $pageId = $page['pageId'];
        // 2. Get all templates for each page
        $stmtT = $pdo->prepare("SELECT templateId FROM templates WHERE pageId = ?");
        $stmtT->execute([$pageId]);
        $templates = $stmtT->fetchAll(PDO::FETCH_ASSOC);

        foreach ($templates as $template) {
            $templateId = $template['templateId'];
            // 3. Delete all contents for each template
            $pdo->prepare("DELETE FROM contents WHERE templateId = ?")->execute([$templateId]);
        }
        // 4. Delete all templates for the page
        $pdo->prepare("DELETE FROM templates WHERE pageId = ?")->execute([$pageId]);
    }
    // 5. Delete all pages for the website
    $pdo->prepare("DELETE FROM page WHERE websiteId = ?")->execute([$websiteId]);
    // 6. Delete the website itself
    $pdo->prepare("DELETE FROM website WHERE websiteId = ?")->execute([$websiteId]);

    header("Location: index.php");
    exit();
}

if (isset($_GET['delete_page'])) {
    $pageId = $_GET['delete_page'];

    // Delete all contents under all templates of this page
    $stmtT = $pdo->prepare("SELECT templateId FROM templates WHERE pageId = ?");
    $stmtT->execute([$pageId]);
    $templates = $stmtT->fetchAll(PDO::FETCH_ASSOC);

    foreach ($templates as $template) {
        $templateId = $template['templateId'];
        $pdo->prepare("DELETE FROM contents WHERE templateId = ?")->execute([$templateId]);
    }
    $pdo->prepare("DELETE FROM templates WHERE pageId = ?")->execute([$pageId]);
    $pdo->prepare("DELETE FROM page WHERE pageId = ?")->execute([$pageId]);

    header("Location: index.php");
    exit();
}
?>

<!-- ✅ Add enctype attribute here -->
<form method="POST" action="" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="logo">Logo:</label>
    <input type="file" name="logo" id="logo" accept="image/*" required><br><br>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea><br><br>


    <input type="submit" value="Submit">
</form>

<div class="recents" style="padding: 20px; background-color: #f9f9f9; border: 1px solid #ccc; display: flex; flex-wrap: wrap; flex-direction: row; align-items: center;">
    <?php
        include_once 'db.php';

        // Fetch all websites
        $query = "SELECT * FROM website";
        $stmt = $pdo->query($query);
        $websites = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <?php foreach ($websites as $website): ?>
        <?php
            // Get the lowest pageId for each website
            $minPageStmt = $pdo->prepare("SELECT MIN(pageId) as minPageId FROM page WHERE websiteId = :id");
            $minPageStmt->execute([':id' => $website['websiteId']]);
            $minPage = $minPageStmt->fetch(PDO::FETCH_ASSOC);
            $minPageId = $minPage && $minPage['minPageId'] !== null ? $minPage['minPageId'] : '';
        ?>
        <a href="editpage.php?websiteId=<?php echo htmlspecialchars($website['websiteId']); ?>&pageId=<?php echo htmlspecialchars($minPageId); ?>" style="text-decoration: none; color: black;">
            <div style="border: 1px solid #ccc; padding: 10px; margin: 10px; width: 200px; height: 300px;display: inline-block; border-radius: 5px; align-items: center; display: flex; justify-content: center; flex-direction: column;">
                <strong>Website ID:</strong> <?php echo htmlspecialchars($website['websiteId']); ?><br>
                <img src="uploads/<?php echo htmlspecialchars($website['logo']); ?>" alt="Logo" width="150"><br>
                <strong>Name:</strong> <?php echo htmlspecialchars($website['name']); ?><br>
                <strong>Description:</strong> <?php echo htmlspecialchars($website['description']); ?>
                <a href="index.php?delete_website=<?= $website['websiteId'] ?>"
                   onclick="return confirm('Delete this website and ALL its pages, templates, and contents?');"
                   style="color:red; margin-top:10px; font-size:14px; display:block;">Delete Website</a>
            </div>
        </a>
    <?php endforeach; ?>
</div>
