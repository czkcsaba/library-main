<?php ob_start(); ?>
<section class="grid two">
    <div class="panel">
        <h2>API állapot</h2>
        <p><strong>Beállított URL:</strong> <?= h($apiBaseUrl) ?></p>
    </div>

    <div class="panel">
        <h2>Adatok</h2>
        <p>Könyvek: <strong><?= count($books) ?></strong></p>
        <p>Írók: <strong><?= count($writers) ?></strong></p>
        <p>Kiadók: <strong><?= count($publishers) ?></strong></p>
        <p>Kategóriák: <strong><?= count($categories) ?></strong></p>
        <p>Értékelések: <strong><?= (int)($reviewCount ?? 0) ?></strong></p>
    </div>
</section>

<section class="panel">
    <h2>Első néhány könyv</h2>
    <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Cím</th>
                <th>Író</th>
                <th>Kiadó</th>
                <th>Kategória</th>
                <th>Ár</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (array_slice($books, 0, 6) as $book): ?>
                <tr>
                    <td><?= h($book['id'] ?? '') ?></td>
                    <td><?= h($book['title'] ?? '') ?></td>
                    <td><?= h(entityNameById($writers, (int)($book['writerId'] ?? 0))) ?></td>
                    <td><?= h(entityNameById($publishers, (int)($book['publisherId'] ?? 0))) ?></td>
                    <td><?= h(entityNameById($categories, (int)($book['categoryId'] ?? 0))) ?></td>
                    <td><?= h($book['price'] ?? '') ?> Ft</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>