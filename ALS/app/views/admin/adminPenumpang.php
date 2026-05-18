<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Penumpang - Admin Panel ALS</title>
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
                <h1>Kelola Penumpang</h1>
                <span>Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin'); ?></span>
            </div>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Username / Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (empty($penumpangs)):
                    ?>
                        <tr><td colspan="5" style="text-align:center;">Belum ada Penumpang.</td></tr>
                    <?php else: ?>
                        <?php foreach ($penumpangs as $u): ?>
                        <tr>
                            <td><?= htmlspecialchars($u['username'] ?? $u['name'] ?? $u['nama_lengkap'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($u['email'] ?? '-') ?></td>
                            <td><?= ucfirst($u['status'] ?? 'aktif') ?></td>
                            <td><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                            <td>
                                <a href="/gantiALS/admin/penumpang?action=detail&id=<?= $u['id'] ?>" class="btn btn-primary">Detail</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

        <?php elseif ($viewMode === 'detail'): ?>
            <div class="admin-header">
                <h1>Detail Penumpang #<?= $penumpang['id'] ?></h1>
                <span>Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin'); ?></span>
            </div>

            <div class="admin-form">
                <p><strong>ID Penumpang:</strong> <?= $penumpang['id'] ?></p>
                <p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($penumpang['name'] ?? $penumpang['nama_lengkap'] ?? '-') ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($penumpang['email'] ?? '-') ?></p>
                <p><strong>No. Telepon:</strong> <?= htmlspecialchars($penumpang['no_telepon'] ?? $penumpang['telepon'] ?? '-') ?></p>
                <p><strong>Status Akun:</strong> <?= ucfirst($penumpang['status'] ?? 'aktif') ?></p>
                <p><strong>Bergabung Pada:</strong> <?= date('d M Y H:i:s', strtotime($penumpang['created_at'])) ?></p>
                <div style="margin-top: 20px;">
                    <a href="/gantiALS/admin/penumpang" class="btn btn-primary">Kembali</a>
                    <?php if (($penumpang['status'] ?? 'aktif') !== 'suspended'): ?>
                    <a href="/gantiALS/admin/penumpang?action=suspend&id=<?= $penumpang['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin suspend akun ini?')">Suspend Akun</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
