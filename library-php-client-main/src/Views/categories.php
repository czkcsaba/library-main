<?php ob_start(); ?>
<section class="panel">
    <h2>Új kategória</h2>
    <form method="post" class="stack-gap">
        <input type="hidden" name="action" value="create_category">
        <div>
            <label>Név</label>
            <input type="text" name="name" required>
        </div>
        <div class="actions">
            <button type="submit" class="small-btn">Mentés</button>
        </div>
    </form>
</section>

<section class="panel">
    <h2>Kategóriák</h2>
    <div class="entity-list">
        <?php foreach ($items as $item): ?>
            <form method="post" class="entity-row">
                <input type="hidden" name="id" value="<?= h($item['id'] ?? '') ?>">
                <input type="text" name="name" value="<?= h($item['name'] ?? '') ?>" required>
                <button type="submit" name="action" value="update_category" class="small-btn">Mentés</button>
                <button type="submit" name="action" value="delete_category" class="danger small-btn" onclick="return confirm('Biztosan törlöd?');">Törlés</button>
            </form>
        <?php endforeach; ?>
    </div>
</section>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
