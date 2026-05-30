<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Sistem - Admin Panel ALS</title>
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
            <h1>Log Sistem</h1>
            <span>Selamat datang, <?= htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin') ?></span>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="filter-bar">
            <form method="GET" action="<?= BASEURL ?>/index.php" class="form-filter">
                <input type="hidden" name="controller" value="admin">
                <input type="hidden" name="action" value="log">
                <div class="form-group form-group-0">
                    <label>Level</label>
                    <select name="filter_level">
                        <option value="">-- Semua --</option>
                        <?php foreach (['info', 'berhasil', 'error'] as $lvl): ?>
                            <option value="<?= $lvl ?>" <?= ($_GET['filter_level'] ?? '') === $lvl ? 'selected' : '' ?>><?= ucfirst($lvl) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group form-group-0">
                    <label>Tanggal</label>
                    <input type="date" name="filter_date" value="<?= htmlspecialchars($_GET['filter_date'] ?? '') ?>">
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="<?= BASEURL ?>/index.php?controller=admin&action=log" class="btn btn-warning">Reset</a>
            </form>

            <form method="POST" action="<?= BASEURL ?>/index.php?controller=admin&action=log"
                  onsubmit="return confirm('Yakin ingin menghapus semua log? Tindakan ini tidak dapat dibatalkan.')">
                <input type="hidden" name="action" value="hapus_semua">
                <button type="submit" class="btn btn-danger">Hapus Semua Log</button>
            </form>
        </div>

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
                <?php if (empty($logs)): ?>
                    <tr><td colspan="4" class="td-tengah">Belum ada log.</td></tr>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?= date('d M Y H:i:s', strtotime($log['created_at'])) ?></td>
                        <td><?= htmlspecialchars($log['username'] ?? ('ID: ' . ($log['admin_id'] ?? '-'))) ?></td>
                        <td><?= htmlspecialchars($log['pesan'] ?? '') ?></td>
                        <td><?= htmlspecialchars($log['level'] ?? '') ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
