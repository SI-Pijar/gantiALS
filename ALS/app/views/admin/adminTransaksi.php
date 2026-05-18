<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - Admin Panel ALS</title>
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
        <?php if ($viewMode === 'list'): ?>
            <div class="admin-header">
                <h1>Laporan Transaksi</h1>
                <span>Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin'); ?></span>
            </div>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Tanggal</th>
                        <th>Metode Pembayaran</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (empty($transaksis)):
                    ?>
                        <tr><td colspan="6" style="text-align:center;">Belum ada transaksi.</td></tr>
                    <?php else: ?>
                        <?php foreach ($transaksis as $t): ?>
                        <tr>
                            <td>#<?= $t['id'] ?></td>
                            <td><?= date('d M Y H:i', strtotime($t['created_at'])) ?></td>
                            <td><?= htmlspecialchars($t['metode_pembayaran'] ?? '-') ?></td>
                            <td>Rp <?= number_format($t['total_harga'] ?? 0, 0, ',', '.') ?></td>
                            <td><?= ucfirst($t['status_pembayaran'] ?? 'pending') ?></td>
                            <td>
                                <a href="/gantiALS/admin/transaksi?action=detail&id=<?= $t['id'] ?>" class="btn btn-primary">Detail</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

        <?php elseif ($viewMode === 'detail'): ?>
            <div class="admin-header">
                <h1>Detail Transaksi #<?= $transaksi['id'] ?></h1>
                <span>Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin'); ?></span>
            </div>

            <div class="admin-form">
                <p><strong>ID Transaksi:</strong> <?= $transaksi['id'] ?></p>
                <p><strong>Tanggal:</strong> <?= date('d M Y H:i', strtotime($transaksi['created_at'])) ?></p>
                <p><strong>Metode Pembayaran:</strong> <?= htmlspecialchars($transaksi['metode_pembayaran'] ?? '-') ?></p>
                <p><strong>Total Harga:</strong> Rp <?= number_format($transaksi['total_harga'] ?? 0, 0, ',', '.') ?></p>
                <p><strong>Status:</strong> <?= ucfirst($transaksi['status_pembayaran'] ?? 'pending') ?></p>
                <div style="margin-top: 20px;">
                    <a href="/gantiALS/admin/transaksi" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
