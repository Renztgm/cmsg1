<form method="POST" action="editpage.php?websiteId=<?= $websiteId ?>&pageId=<?= $pageId ?>">
    <input type="hidden" name="websiteId" value="<?= $websiteId ?>">
    <input type="hidden" name="pageId" value="<?= $pageId ?>">

    <?php foreach ($templates as $template): ?>
        <div style="margin-bottom: 20px; border: 1px solid #ccc; padding: 10px;">
            <h3>Template: <?= htmlspecialchars($template['templateName'] ?? 'Unnamed') ?></h3>
            <ul>
                <?php foreach ($contents as $content): ?>
                    <?php if ($content['templateId'] == $template['templateId']): ?>
                        <li>
                            <input type="hidden" name="contentIds[]" value="<?= $content['contentId'] ?>">
                            <label>Content ID <?= $content['contentId'] ?>:</label><br>
                            <textarea name="texts[]" rows="2" cols="60"><?= htmlspecialchars($content['text'] ?? '') ?></textarea>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>

    <button type="submit">Update Content</button>
</form>
