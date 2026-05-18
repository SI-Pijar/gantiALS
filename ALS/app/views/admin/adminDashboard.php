<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ALS</title>
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
            <h1>Dashboard</h1>
            <span>Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin'); ?></span>
        </div>

        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Pendapatan (Hari Ini)</h3>
                <p>Rp <?php echo number_format($totalPendapatan ?? 0, 0, ',', '.'); ?></p>
            </div>
            <div class="card">
                <h3>Tiket Terjual (Hari Ini)</h3>
                <p><?php echo htmlspecialchars($tiketTerjual ?? 0); ?></p>
            </div>
            <div class="card">
                <h3>Total Penumpang</h3>
                <p><?php echo htmlspecialchars($totalPenumpang ?? 0); ?></p>
            </div>
            <div class="card">
                <h3>Total Jadwal Aktif</h3>
                <p><?php echo htmlspecialchars($totalJadwal ?? 0); ?></p>
            </div>
            <div class="card">
                <h3>Gangguan Sistem</h3>
                <p><?php echo htmlspecialchars($gangguanSistem ?? 0); ?></p>
            </div>
        </div>

        <h2>Aktivitas Terbaru</h2>
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
                <?php if (!empty($aktivitasTerbaru)): ?>
                    <?php foreach (array_slice($aktivitasTerbaru, 0, 5) as $log): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($log['created_at']); ?></td>
                            <td><?php echo htmlspecialchars($log['admin_id'] ?? $log['user_id'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($log['action'] ?? $log['aksi'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($log['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">Belum ada aktivitas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
