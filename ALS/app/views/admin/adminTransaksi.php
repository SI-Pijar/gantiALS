<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - Admin Panel ALS</title>
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
        <?php if ($viewMode === 'list'): ?>
            <div class="admin-header">
                <h1>Laporan Transaksi</h1>
                <span>Selamat datang, <?= htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin') ?></span>
            </div>

            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="GET" action="<?= BASEURL ?>/index.php" class="form-filter">
                <input type="hidden" name="controller" value="admin">
                <input type="hidden" name="action" value="transaksi">
                <div class="form-group form-group-0">
                    <label>Dari Tanggal</label>
                    <input type="date" name="filter_dari" value="<?= htmlspecialchars($_GET['filter_dari'] ?? '') ?>">
                </div>
                <div class="form-group form-group-0">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="filter_sampai" value="<?= htmlspecialchars($_GET['filter_sampai'] ?? '') ?>">
                </div>
                <div class="form-group form-group-0">
                    <label>Status Pembayaran</label>
                    <select name="filter_status">
                        <option value="">-- Semua --</option>
                        <?php foreach (['pending', 'Lunas', 'berhasil', 'Gagal', 'batal'] as $s): ?>
                            <option value="<?= $s ?>" <?= ($_GET['filter_status'] ?? '') === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="<?= BASEURL ?>/index.php?controller=admin&action=transaksi" class="btn btn-warning">Reset</a>
            </form>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal Pesan</th>
                        <th>Nama Pemesan</th>
                        <th>Rute</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transaksis)): ?>
                        <tr><td colspan="8" class="td-tengah">Belum ada transaksi.</td></tr>
                    <?php else: ?>
                        <?php foreach ($transaksis as $t): ?>
                        <tr>
                            <td><?= htmlspecialchars($t['id']) ?></td>
                            <td><?= date('d M Y H:i', strtotime($t['tanggal_pesan'])) ?></td>
                            <td><?= htmlspecialchars($t['nama_pemesan'] ?? '-') ?></td>
                            <td><?= htmlspecialchars(($t['asal'] ?? '-') . ' → ' . ($t['tujuan'] ?? '-')) ?></td>
                            <td>Rp <?= number_format($t['total_harga'] ?? 0, 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($t['metode_pembayaran'] ?? '-') ?></td>
                            <td><?= ucfirst($t['status_pembayaran'] ?? 'pending') ?></td>
                            <td>
                                <a href="<?= BASEURL ?>/index.php?controller=admin&action=transaksi&sub_action=detail&id=<?= $t['id'] ?>" class="btn btn-primary">Detail</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

        <?php elseif ($viewMode === 'detail'): ?>
            <div class="admin-header">
                <h1>Detail Transaksi</h1>
                <span>Selamat datang, <?= htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin') ?></span>
            </div>

            <div class="admin-form">
                <p><strong>ID Transaksi:</strong> ALS-<?= str_pad($transaksi['id'], 5, '0', STR_PAD_LEFT) ?></p>
                <p><strong>Tanggal Pesan:</strong> <?= date('d M Y H:i:s', strtotime($transaksi['tanggal_pesan'])) ?></p>
                <p><strong>Nama Pemesan:</strong> <?= htmlspecialchars($transaksi['nama_pemesan'] ?? '-') ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($transaksi['email'] ?? '-') ?></p>
                <p><strong>Telepon:</strong> <?= htmlspecialchars($transaksi['telepon'] ?? '-') ?></p>
                <p><strong>Rute:</strong> <?= htmlspecialchars(($transaksi['asal'] ?? '-') . ' → ' . ($transaksi['tujuan'] ?? '-')) ?></p>
                <p><strong>Tanggal Keberangkatan:</strong> <?= !empty($transaksi['tanggal']) ? date('d M Y', strtotime($transaksi['tanggal'])) : '-' ?> <?= htmlspecialchars($transaksi['jam_berangkat'] ?? '') ?></p>
                <p><strong>Kursi Dipesan:</strong> <?= htmlspecialchars($transaksi['kursi_dipesan'] ?? '-') ?> (<?= $transaksi['jumlah'] ?? 0 ?> kursi)</p>
                <p><strong>Total Harga:</strong> Rp <?= number_format($transaksi['total_harga'] ?? 0, 0, ',', '.') ?></p>
                <p><strong>Metode Pembayaran:</strong> <?= htmlspecialchars($transaksi['metode_pembayaran'] ?? '-') ?></p>
                <p><strong>Status Pembayaran:</strong> <?= ucfirst($transaksi['status_pembayaran'] ?? 'pending') ?></p>
                <p><strong>Status Verifikasi:</strong> <?= htmlspecialchars($transaksi['status_verifikasi'] ?? '-') ?></p>
                <div class="mt-20">
                    <a href="<?= BASEURL ?>/index.php?controller=admin&action=transaksi" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
