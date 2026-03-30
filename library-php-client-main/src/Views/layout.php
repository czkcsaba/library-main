<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($title ?? 'Library API PHP kliens') ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="page">
    <aside class="sidebar">
        <h1>Library Client</h1>

        <nav>
            <a class="nav-link <?= $section === 'dashboard' ? 'active' : '' ?>" href="?section=dashboard&amp;api_base_url=<?= urlencode($apiBaseUrl) ?>">Áttekintés</a>
            <a class="nav-link <?= $section === 'books' ? 'active' : '' ?>" href="?section=books&amp;api_base_url=<?= urlencode($apiBaseUrl) ?>">Könyvek</a>
            <a class="nav-link <?= $section === 'writers' ? 'active' : '' ?>" href="?section=writers&amp;api_base_url=<?= urlencode($apiBaseUrl) ?>">Írók</a>
            <a class="nav-link <?= $section === 'publishers' ? 'active' : '' ?>" href="?section=publishers&amp;api_base_url=<?= urlencode($apiBaseUrl) ?>">Kiadók</a>
            <a class="nav-link <?= $section === 'categories' ? 'active' : '' ?>" href="?section=categories&amp;api_base_url=<?= urlencode($apiBaseUrl) ?>">Kategóriák</a>
            <a class="nav-link <?= $section === 'reviews' ? 'active' : '' ?>" href="?section=reviews&amp;api_base_url=<?= urlencode($apiBaseUrl) ?>">Értékelések</a>
        </nav>

        <form method="post" class="connect-panel stack-gap">
            <input type="hidden" name="action" value="set_api_url">
            <input type="hidden" name="section" value="<?= h($section) ?>">
            <label>API alap URL</label>
            <input type="text" name="api_base_url" value="<?= h($apiBaseUrl) ?>" placeholder="http://localhost:8000/api">
            <button type="submit" class="small-btn">Mentés</button>
        </form>

    </aside>

    <main class="content">
        <?php if (!empty($flash)): ?>
            <div class="flash <?= h($flash['type']) ?>"><?= h($flash['message']) ?></div>
        <?php endif; ?>

        <?= $content ?>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.star-rating').forEach(function (rating) {
        const inputs = rating.querySelectorAll('input[name="stars"]');
        const outputId = rating.getAttribute('data-output');
        const output = outputId ? document.getElementById(outputId) : null;

        inputs.forEach(function (input) {
            input.addEventListener('change', function () {
                if (output) {
                    output.textContent = this.value + ' csillag kiválasztva';
                }
            });
        });
    });
});
</script>
</body>
</html>
