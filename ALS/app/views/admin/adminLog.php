<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Sistem - Admin Panel ALS</title>
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
            <h1>Log Sistem</h1>
            <span>Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin'); ?></span>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>User ID</th>
                    <th>Aksi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($logs)):
                ?>
                    <tr><td colspan="4" style="text-align:center;">Belum ada log.</td></tr>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?= date('d M Y H:i:s', strtotime($log['created_at'])) ?></td>
                        <td><?= htmlspecialchars($log['admin_id'] ?? $log['user_id'] ?? '') ?></td>
                        <td><?= htmlspecialchars($log['action'] ?? $log['aksi'] ?? '') ?></td>
                        <td><?= ucfirst($log['status']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
