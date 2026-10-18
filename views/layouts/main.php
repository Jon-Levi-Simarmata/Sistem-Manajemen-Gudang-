<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? "Sistem Gudang") ?></title>
    <!-- CSS Global -->
    <link rel="stylesheet" href="/css/style.css">
    <!-- Library Barcode Scanner via Kamera -->
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body>

    <!-- Header Component -->
    <?php require __DIR__ . '/../components/header.php'; ?>

    <!-- Navbar Component -->
    <?php require __DIR__ . '/../components/navbar.php'; ?>

    <!-- Content Dinamis -->
    <main class="container">
        <?= $content ?? '' ?>
    </main>

    <!-- Footer Component -->
    <?php require __DIR__ . '/../components/footer.php'; ?>

    <!-- JS Global -->
    <script src="/js/app.js"></script>

</body>
</html>