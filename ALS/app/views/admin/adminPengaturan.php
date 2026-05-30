<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Sistem - Admin Panel ALS</title>
    <link rel="stylesheet" href="<?= BASEURL; ?>/ALS/public/css/admin.css?v=<?= time(); ?>">
</head>
<body>

    <div class="admin-sidebar">
        <h2>Admin Panel</h2>
        <a href="<?= BASEURL; ?>/index.php?controller=admin&action=dashboard">Dashboard</a>
        <a href="<?= BASEURL; ?>/index.php?controller=admin&action=jadwal">Kelola Jadwal</a>
        <a href="<?= BASEURL; ?>/index.php?controller=admin&action=transaksi">Laporan Transaksi</a>
        <a href="<?= BASEURL; ?>/index.php?controller=admin&action=penumpang">Kelola Penumpang</a>
        <a href="<?= BASEURL; ?>/index.php?controller=admin&action=operator">Kelola Operator</a>
        <a href="<?= BASEURL; ?>/index.php?controller=admin&action=manajemenAdmin">Kelola Admin</a>
        <a href="<?= BASEURL; ?>/index.php?controller=admin&action=log">Log Sistem</a>
        <a href="<?= BASEURL; ?>/index.php?controller=admin&action=pengaturan">Pengaturan</a>
        <a href="<?= BASEURL; ?>/index.php?controller=auth&action=logout" class="link-logout">Logout</a>
    </div>

    <div class="admin-main">
        <div class="admin-header">
            <h1>Pengaturan Sistem</h1>
            <span>Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin'); ?></span>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="admin-form">
            <form action="<?= BASEURL; ?>/index.php?controller=admin&action=pengaturan" method="POST">
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
                <div class="form-group mt-15">
                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
