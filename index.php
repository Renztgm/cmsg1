<?php
include_once 'db.php';
include 'createwebsite.php';
?>
<link rel="icon" type="image/svg" href="icons/logo.svg">
<!-- Top Navigation Bar -->
<nav style="width:100%;background:#2B7A78;padding:18px 0 18px 0;box-shadow:0 2px 8px rgba(23,37,42,0.08);margin-bottom:32px;">
    <div style="max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;padding:0 24px;">
        <div style="font-size:1.5em;font-weight:bold;color:#FEFFFF;letter-spacing:1px; align-items:center;display:flex; gap: 30px;" >
            <img src="icons/logo.svg" width="75px" height="auto" alt=""> PRISM
        </div>
        <div style="display:flex;gap:18px;">
            <a href="index.php" style="color:#FEFFFF;text-decoration:none;font-weight:500;font-size:1em;">Home</a>
            
            <a href="userlogout.php" style="color:#3AAFA9;text-decoration:none;font-weight:500;font-size:1em;">Logout</a>
        </div>
    </div>
</nav>

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

<style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        line-height: 1.6;
        color: #17252A;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0;
        background-color: #DEF2F1;
    }

    .form-container {
        background: #FEFFFF;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(42,122,120,0.05);
        margin-bottom: 40px;
        max-width: 600px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #2d3748;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 16px;
        transition: border-color 0.2s;
    }

    input[type="text"]:focus,
    textarea:focus {
        outline: none;
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
    }

    textarea {
        min-height: 120px;
        resize: vertical;
    }

    input[type="file"] {
        padding: 10px;
        border: 2px dashed #e2e8f0;
        border-radius: 6px;
        width: 100%;
        cursor: pointer;
    }

    input[type="submit"] {
        background-color: #4299e1;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    input[type="submit"]:hover {
        background-color: #3182ce;
    }

    .websites-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        padding: 20px 0;
    }

    .website-card {
        background: #FEFFFF;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 2px 15px rgba(42,122,120,0.05);
        border: 1px solid #3AAFA9;
        display: block;
        text-decoration: none;
        color: inherit;
    }

    .website-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(42,122,120,0.10);
    }

    .website-content {
        padding: 20px;
        display: grid;
        gap: 15px;
    }

    .website-header {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 15px;
        align-items: start;
    }

    .website-logo {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    .website-info {
        display: grid;
        gap: 5px;
    }

    .website-id {
        font-size: 12px;
        color: #718096;
        font-weight: 500;
    }

    .website-title {
        font-size: 18px;
        font-weight: 600;
        color: #2B7A78;
        margin: 0;
    }

    .website-description {
        color: #718096;
        font-size: 14px;
        line-height: 1.5;
        margin: 0;
    }

    .delete-link {
        color: #e53e3e;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        display: inline-block;
        padding: 8px 16px;
        border: 1px solid #e53e3e;
        border-radius: 6px;
        text-align: center;
        transition: all 0.2s;
        background: #DEF2F1;
    }

    .delete-link:hover {
        color: #FEFFFF;
        background-color: #e53e3e;
    }
</style>

<div class="form-container">
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Website Name</label>
            <input type="text" id="name" name="name" required placeholder="Enter website name">
        </div>

        <div class="form-group">
            <label for="logo">Website Logo</label>
            <input type="file" name="logo" id="logo" accept="image/*" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" required placeholder="Enter website description"></textarea>
        </div>

        <input type="submit" value="Create Website">
    </form>
</div>

<div class="websites-grid">
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
        <div class="website-card">
            <div class="website-content">
                <div class="website-header">
                    <img src="uploads/<?php echo htmlspecialchars($website['logo']); ?>" 
                         alt="<?php echo htmlspecialchars($website['name']); ?> Logo" 
                         class="website-logo">
                    <div class="website-info">
                        <div class="website-id">ID: <?php echo htmlspecialchars($website['websiteId']); ?></div>
                        <div class="website-title"><?php echo htmlspecialchars($website['name']); ?></div>
                    </div>
                </div>
                <div class="website-description"><?php echo htmlspecialchars($website['description']); ?></div>
                <div style="display: flex; gap: 10px;">
                    <a href="editpage.php?websiteId=<?php echo htmlspecialchars($website['websiteId']); ?>&pageId=<?php echo htmlspecialchars($minPageId); ?>" 
                       class="delete-link" 
                       style="background-color: #4299e1; color: white; border-color: #4299e1;">
                        Edit Website
                    </a>
                    <a href="index.php?delete_website=<?= $website['websiteId'] ?>"
                       onclick="return confirm('Delete this website and ALL its pages, templates, and contents?');"
                       class="delete-link">Delete Website</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
