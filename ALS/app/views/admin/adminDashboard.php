<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ALS</title>
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
            <h1>Dashboard</h1>
            <span>Selamat datang, <?= htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin') ?></span>
        </div>

        <div class="dashboard-cards">
            <div class="card">
                <h3>Pendapatan Hari Ini</h3>
                <p>Rp <?= number_format($totalPendapatan ?? 0, 0, ',', '.') ?></p>
            </div>
            <div class="card">
                <h3>Tiket Terjual Hari Ini</h3>
                <p><?= htmlspecialchars($tiketTerjual ?? 0) ?></p>
            </div>
            <div class="card">
                <h3>Total Penumpang Terdaftar</h3>
                <p><?= htmlspecialchars($totalPenumpang ?? 0) ?></p>
            </div>
            <div class="card">
                <h3>Total Jadwal</h3>
                <p><?= htmlspecialchars($totalJadwal ?? 0) ?></p>
            </div>
            <div class="card">
                <h3>Total Error Log</h3>
                <p><?= htmlspecialchars($gangguanSistem ?? 0) ?></p>
            </div>
        </div>

        <h2>Aktivitas Terbaru</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Admin</th>
                    <th>Aktivitas</th>
                    <th>Level</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($aktivitasTerbaru)): ?>
                    <?php foreach (array_slice($aktivitasTerbaru, 0, 5) as $log): ?>
                        <tr>
                            <td><?= date('d M Y H:i', strtotime($log['created_at'])) ?></td>
                            <td><?= htmlspecialchars($log['username'] ?? ('ID: ' . ($log['admin_id'] ?? '-'))) ?></td>
                            <td><?= htmlspecialchars($log['pesan'] ?? '') ?></td>
                            <td><?= htmlspecialchars($log['level'] ?? '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="td-tengah">Belum ada aktivitas.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
