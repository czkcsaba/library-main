<?php ob_start(); ?>
<section class="panel">
    <h2>Könyv értékelései</h2>
    <form method="get" class="grid three">
        <input type="hidden" name="section" value="reviews">
        <input type="hidden" name="api_base_url" value="<?= h($apiBaseUrl) ?>">

        <div class="full-row">
            <label>Könyv kiválasztása</label>
            <select name="book_id">
                <option value="0">Válassz könyvet</option>
                <?php foreach ($books as $book): ?>
                    <option value="<?= h($book['id'] ?? '') ?>" <?= $selectedBookId === (int)($book['id'] ?? 0) ? 'selected' : '' ?>>
                        <?= h($book['title'] ?? '') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="full-row actions">
            <button type="submit" class="small-btn">Betöltés</button>
        </div>
    </form>
</section>

<?php if ($selectedBook): ?>
    <section class="panel">
        <h2><?= h($selectedBook['title'] ?? '') ?></h2>
        <p><strong>ISBN:</strong> <?= h($selectedBook['ISBN'] ?? '') ?></p>
        <p><strong>Ár:</strong> <?= h($selectedBook['price'] ?? '') ?> Ft</p>
        <p><strong>Író:</strong> <?= h(entityNameById($writers, (int)($selectedBook['writerId'] ?? 0))) ?></p>
        <p><strong>Kiadó:</strong> <?= h(entityNameById($publishers, (int)($selectedBook['publisherId'] ?? 0))) ?></p>
        <p><strong>Kategória:</strong> <?= h(entityNameById($categories, (int)($selectedBook['categoryId'] ?? 0))) ?></p>
    </section>

    <section class="panel">
        <h2>Új review hozzáadása</h2>
        <form method="post" class="stack-gap">
            <input type="hidden" name="action" value="save_rating">
            <input type="hidden" name="id" value="<?= h($selectedBook['id'] ?? '') ?>">

            <div>
                <label>Értékelés</label>
                <div class="star-rating">
                    <input type="radio" id="star5" name="stars" value="5" required>
                    <label for="star5">★</label>

                    <input type="radio" id="star4" name="stars" value="4">
                    <label for="star4">★</label>

                    <input type="radio" id="star3" name="stars" value="3">
                    <label for="star3">★</label>

                    <input type="radio" id="star2" name="stars" value="2">
                    <label for="star2">★</label>

                    <input type="radio" id="star1" name="stars" value="1">
                    <label for="star1">★</label>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="small-btn">Hozzáadás</button>
            </div>
        </form>
    </section>

    <section class="panel">
        <h2>Review-k</h2>
        <?php if (empty($reviews)): ?>
            <p>Nincs még értékelés ehhez a könyvhöz.</p>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Értékelés</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($reviews as $index => $review): ?>
                        <?php $stars = clampStars((int)(is_array($review) ? ($review['stars'] ?? 0) : $review)); ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="stars-display"><?= str_repeat('★', $stars) . str_repeat('☆', 5 - $stars) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>

<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>