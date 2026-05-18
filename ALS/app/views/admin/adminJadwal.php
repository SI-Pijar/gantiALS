<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jadwal - Admin Panel ALS</title>
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
                <h1>Kelola Jadwal Keberangkatan</h1>
                <span>Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin'); ?></span>
            </div>

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <div style="margin-bottom: 20px;">
                <a href="/gantiALS/admin/jadwal?action=add" class="btn btn-primary">Tambah Jadwal</a>
            </div>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Asal</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Berangkat</th>
                        <th>Tiba</th>
                        <th>Harga</th>
                        <th>Kursi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if (empty($jadwals)):
                    ?>
                        <tr><td colspan="10" style="text-align:center;">Belum ada jadwal.</td></tr>
                    <?php else: ?>
                        <?php foreach ($jadwals as $j): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($j['asal']) ?></td>
                            <td><?= htmlspecialchars($j['tujuan']) ?></td>
                            <td><?= date('d M Y', strtotime($j['tanggal'])) ?></td>
                            <td><?= substr($j['jam_berangkat'], 0, 5) ?></td>
                            <td><?= substr($j['jam_tiba'], 0, 5) ?></td>
                            <td>Rp <?= number_format($j['harga'], 0, ',', '.') ?></td>
                            <td><?= $j['kursi_tersedia'] ?></td>
                            <td><?= ucfirst($j['status']) ?></td>
                            <td>
                                <a href="/gantiALS/admin/jadwal?action=edit&id=<?= $j['id'] ?>" class="btn btn-warning">Edit</a>
                                <a href="/gantiALS/admin/jadwal?action=delete&id=<?= $j['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus jadwal ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

        <?php elseif ($viewMode === 'form'): ?>
            <div class="admin-header">
                <h1><?= $jadwal ? 'Edit' : 'Tambah' ?> Jadwal Keberangkatan</h1>
                <span>Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin'); ?></span>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <div class="admin-form">
                <form action="<?= $jadwal ? '/gantiALS/admin/jadwal?action=edit&id=' . $jadwal['id'] : '/gantiALS/admin/jadwal?action=add' ?>" method="POST">
                    <?php if ($jadwal): ?>
                        <input type="hidden" name="id" value="<?= $jadwal['id'] ?>">
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label for="asal">Asal</label>
                        <input type="text" id="asal" name="asal" value="<?= htmlspecialchars($jadwal['asal'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tujuan">Tujuan</label>
                        <input type="text" id="tujuan" name="tujuan" value="<?= htmlspecialchars($jadwal['tujuan'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" value="<?= htmlspecialchars($jadwal['tanggal'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="jam_berangkat">Jam Berangkat</label>
                        <input type="time" id="jam_berangkat" name="jam_berangkat" value="<?= htmlspecialchars($jadwal['jam_berangkat'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="jam_tiba">Jam Tiba</label>
                        <input type="time" id="jam_tiba" name="jam_tiba" value="<?= htmlspecialchars($jadwal['jam_tiba'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga (Rp)</label>
                        <input type="number" id="harga" name="harga" value="<?= htmlspecialchars($jadwal['harga'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="kursi_tersedia">Jumlah Kursi</label>
                        <input type="number" id="kursi_tersedia" name="kursi_tersedia" value="<?= htmlspecialchars($jadwal['kursi_tersedia'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="aktif" <?= ($jadwal['status'] ?? '') === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= ($jadwal['status'] ?? '') === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-top: 15px;">
                        <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                        <a href="/gantiALS/admin/jadwal" class="btn btn-danger">Batal</a>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
