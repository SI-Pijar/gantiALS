<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Sistem - Admin Panel ALS</title>
    <link rel="stylesheet" href="/gantiALS/ALS/public/css/admin.css">
</head>
<body>

    <div class="admin-sidebar">
        <h2>Admin Panel</h2>
        <a href="/gantiALS/admin">Dashboard</a>
        <a href="/gantiALS/admin/jadwal">Kelola Jadwal</a>
        <a href="/gantiALS/admin/transaksi">Laporan Transaksi</a>
        <a href="/gantiALS/admin/penumpang">Kelola Penumpang</a>
        <a href="/gantiALS/admin/log">Log Sistem</a>
        <a href="/gantiALS/admin/pengaturan">Pengaturan</a>
        <a href="/gantiALS/index.php?controller=auth&action=logout" style="margin-top: 20px; color: #e74c3c;">Logout</a>
    </div>

    <div class="admin-main">
        <div class="admin-header">
            <h1>Pengaturan Sistem</h1>
            <span>Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin'); ?></span>
        </div>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="admin-form">
            <form action="/gantiALS/admin/pengaturan" method="POST">
                <div class="form-group">
                    <label for="nama_aplikasi">Nama Aplikasi</label>
                    <input type="text" id="nama_aplikasi" name="nama_aplikasi" value="<?= htmlspecialchars($settings['nama_aplikasi'] ?? $settings['nama_situs'] ?? 'ALS') ?>">
                </div>
                <div class="form-group">
                    <label for="email_support">Email Support</label>
                    <input type="email" id="email_support" name="email_support" value="<?= htmlspecialchars($settings['email_support'] ?? $settings['email_kontak'] ?? 'info@als.co.id') ?>">
                </div>
                <div class="form-group">
                    <label for="nomor_telepon">Nomor Telepon</label>
                    <input type="text" id="nomor_telepon" name="nomor_telepon" value="<?= htmlspecialchars($settings['nomor_telepon'] ?? $settings['telepon'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3"><?= htmlspecialchars($settings['alamat'] ?? '') ?></textarea>
                </div>
                <div class="form-group" style="margin-top: 15px;">
                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
