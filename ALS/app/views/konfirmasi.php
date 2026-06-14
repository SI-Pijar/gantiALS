<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi - ALS</title>
    <link rel="stylesheet" href="<?= BASEURL ?>/ALS/public/css/<?= htmlspecialchars($konfirmasi_css_file) ?>.css?v=<?= time() ?>">
</head>
<body class="konfirmasi-page">
    <div class="konfirmasi-card">
        <div class="konfirmasi-ikon">!</div>
        <h2>Konfirmasi Tindakan</h2>
        <p><?= htmlspecialchars($konfirmasi_pesan) ?></p>
        <div class="konfirmasi-tombol">
            <form method="POST" action="<?= htmlspecialchars($konfirmasi_action) ?>">
                <button type="submit" class="btn-konfirmasi-ya">Ya, Lanjutkan</button>
            </form>
            <a href="<?= htmlspecialchars($konfirmasi_kembali) ?>" class="btn-konfirmasi-batal">Batal</a>
        </div>
    </div>
</body>
</html>
