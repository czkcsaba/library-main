<?php ob_start(); ?>
<section class="panel">
    <h2>Könyvek keresése</h2>
    <form method="get" class="grid three">
        <input type="hidden" name="section" value="books">
        <input type="hidden" name="api_base_url" value="<?= h($apiBaseUrl) ?>">

        <div>
            <label>Keresés szövegre</label>
            <input type="text" name="text" value="<?= h($bookQuery['text'] ?? '') ?>" placeholder="pl. Harry">
        </div>

        <div>
            <label>Tábla</label>
            <select name="table">
                <option value="books" <?= ($bookQuery['table'] ?? '') === 'books' ? 'selected' : '' ?>>books</option>
                <option value="writers" <?= ($bookQuery['table'] ?? '') === 'writers' ? 'selected' : '' ?>>writers</option>
                <option value="publishers" <?= ($bookQuery['table'] ?? '') === 'publishers' ? 'selected' : '' ?>>publishers</option>
                <option value="categories" <?= ($bookQuery['table'] ?? '') === 'categories' ? 'selected' : '' ?>>categories</option>
            </select>
        </div>

        <div class="full-row actions">
            <button type="submit" class="small-btn">Keresés</button>
            <a class="button-link small-btn" href="?section=books&amp;api_base_url=<?= urlencode($apiBaseUrl) ?>">Alap lista</a>
        </div>
    </form>
</section>

<section class="panel">
    <h2>Új könyv</h2>
    <form method="post" enctype="multipart/form-data" class="grid two">
        <input type="hidden" name="action" value="create_book">
        <div>
            <label>Cím</label>
            <input type="text" name="title" required>
        </div>
        <div>
            <label>ISBN</label>
            <input type="text" name="ISBN" required>
        </div>
        <div>
            <label>Író</label>
            <select name="writerId" required>
                <?php foreach ($writers as $writer): ?>
                    <option value="<?= h($writer['id'] ?? '') ?>"><?= h(trim($writer['name'] ?? '')) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Kiadó</label>
            <select name="publisherId" required>
                <?php foreach ($publishers as $publisher): ?>
                    <option value="<?= h($publisher['id'] ?? '') ?>"><?= h(trim($publisher['name'] ?? '')) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Kategória</label>
            <select name="categoryId" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= h($category['id'] ?? '') ?>"><?= h(trim($category['name'] ?? '')) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Ár (Ft)</label>
            <input type="number" name="price" required>
        </div>
        <div class="full-row">
            <label>Tartalom</label>
            <textarea name="content" rows="4" required></textarea>
        </div>
        <div class="full-row">
            <label>Borítókép</label>
            <input type="file" name="coverImage" accept="image/*">
        </div>
        <div class="full-row actions">
            <button type="submit" class="small-btn">Mentés</button>
        </div>
    </form>
</section>

<section class="panel">
    <h2>Könyvlista</h2>
    <div class="cards">
        <?php foreach ($books as $book): ?>
            <article class="book-card">
                <!-- <?php $coverSrc = imageDataUrl($book['coverImage'] ?? null); ?> 
                <?php if ($coverSrc !== ''): ?>
                    <img src="<?= h($coverSrc) ?>" alt="borító">
                <?php endif; ?> -->
                <div class="book-card-body">
                    <h3><?= h($book['title'] ?? '') ?></h3>
                    <p><strong>ID:</strong> <?= h($book['id'] ?? '') ?></p>
                    <p><strong>Író:</strong> <?= h(entityNameById($writers, (int)($book['writerId'] ?? 0))) ?></p>
                    <p><strong>Kiadó:</strong> <?= h(entityNameById($publishers, (int)($book['publisherId'] ?? 0))) ?></p>
                    <p><strong>Kategória:</strong> <?= h(entityNameById($categories, (int)($book['categoryId'] ?? 0))) ?></p>
                    <p><strong>ISBN:</strong> <?= h($book['ISBN'] ?? '') ?></p>
                    <p><strong>Ár:</strong> <?= h($book['price'] ?? '') ?> Ft</p>

                    <details>
                        <summary>Módosítás</summary>
                        <form method="post" enctype="multipart/form-data" class="stack-gap inner-form">
                            <input type="hidden" name="action" value="update_book">
                            <input type="hidden" name="id" value="<?= h($book['id'] ?? '') ?>">
                            <input type="text" name="title" value="<?= h($book['title'] ?? '') ?>" required>
                            <input type="text" name="ISBN" value="<?= h($book['ISBN'] ?? '') ?>" required>
                            <input type="number" name="price" value="<?= h($book['price'] ?? '') ?>" required>
                            <select name="writerId">
                                <?php foreach ($writers as $writer): ?>
                                    <option value="<?= h($writer['id'] ?? '') ?>" <?= (int)($book['writerId'] ?? 0) === (int)($writer['id'] ?? 0) ? 'selected' : '' ?>><?= h(trim($writer['name'] ?? '')) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select name="publisherId">
                                <?php foreach ($publishers as $publisher): ?>
                                    <option value="<?= h($publisher['id'] ?? '') ?>" <?= (int)($book['publisherId'] ?? 0) === (int)($publisher['id'] ?? 0) ? 'selected' : '' ?>><?= h(trim($publisher['name'] ?? '')) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select name="categoryId">
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= h($category['id'] ?? '') ?>" <?= (int)($book['categoryId'] ?? 0) === (int)($category['id'] ?? 0) ? 'selected' : '' ?>><?= h(trim($category['name'] ?? '')) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <textarea name="content" rows="4"><?= h($book['content'] ?? '') ?></textarea>
                            <input type="file" name="coverImage" accept="image/*">
                            <button type="submit" class="small-btn card-action-btn">Mentés</button>
                        </form>
                    </details>

                    <form method="post" onsubmit="return confirm('Biztosan törlöd ezt a könyvet?');">
                        <input type="hidden" name="action" value="delete_book">
                        <input type="hidden" name="id" value="<?= h($book['id'] ?? '') ?>">
                        <button type="submit" class="danger small-btn card-action-btn">Törlés</button>
                    </form>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>