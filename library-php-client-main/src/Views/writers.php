<?php ob_start(); ?>
<section class="panel">
    <h2>Új író</h2>
    <form method="post" class="stack-gap">
        <input type="hidden" name="action" value="create_writer">

        <div>
            <label>Név</label>
            <input type="text" name="name" required>
        </div>

        <div>
            <label>Bio</label>
            <textarea name="bio" rows="4"></textarea>
        </div>

        <div class="actions">
            <button type="submit" class="small-btn">Mentés</button>
        </div>
    </form>
</section>

<section class="panel">
    <h2>Írók</h2>

    <div class="entity-list">
        <?php foreach ($items as $item): ?>
            <form method="post" class="writer-card">
                <input type="hidden" name="action" value="update_writer">
                <input type="hidden" name="id" value="<?= h($item['id'] ?? '') ?>">

                <div class="writer-top-row">
                    <div class="writer-name-wrap">
                        <label>Név</label>
                        <input type="text" name="name" value="<?= h($item['name'] ?? '') ?>" required>
                    </div>

                    <div class="writer-top-actions">
                        <button type="submit" class="small-btn">Mentés</button>
                    </div>
                </div>

                <div class="writer-bottom-row">
                    <div class="writer-bio-wrap">
                        <label>Bio</label>
                        <textarea name="bio" rows="4"><?= h($item['bio'] ?? '') ?></textarea>
                    </div>

                    <div class="writer-bottom-actions">
                        <button
                            type="submit"
                            formaction="?section=writers&amp;api_base_url=<?= urlencode($apiBaseUrl) ?>"
                            name="action"
                            value="delete_writer"
                            class="danger small-btn"
                            onclick="return confirm('Biztosan törlöd ezt az írót?');"
                        >
                            Törlés
                        </button>
                    </div>
                </div>
            </form>
        <?php endforeach; ?>
    </div>
</section>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>