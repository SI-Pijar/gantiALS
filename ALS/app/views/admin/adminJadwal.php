<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jadwal - Admin Panel ALS</title>
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
                <h1>Kelola Jadwal Keberangkatan</h1>
                <span>Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin'); ?></span>
            </div>

            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Asal</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Berangkat</th>
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
                        <tr><td colspan="10" class="td-tengah">Belum ada jadwal.</td></tr>
                    <?php else: ?>
                        <?php foreach ($jadwals as $j): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($j['asal']) ?></td>
                            <td><?= htmlspecialchars($j['tujuan']) ?></td>
                            <td><?= date('d M Y', strtotime($j['tanggal'])) ?></td>
                            <td><?= isset($j['jam_berangkat']) ? substr($j['jam_berangkat'], 0, 5) : '-' ?></td>
                            <td>Rp <?= number_format($j['harga'], 0, ',', '.') ?></td>
                            <td><?= $j['kursi_tersedia'] ?></td>
                            <td><?= ucfirst($j['status']) ?></td>
                            <td>
                                <?php if ($j['status'] === 'pending'): ?>
                                    <a href="<?= BASEURL; ?>/index.php?controller=admin&action=jadwal&sub_action=approve&id=<?= $j['id'] ?>" class="btn btn-success btn-setuju">Setuju</a>
                                    <a href="<?= BASEURL; ?>/index.php?controller=admin&action=jadwal&sub_action=reject&id=<?= $j['id'] ?>" class="btn btn-warning btn-tolak-jadwal">Tolak</a>
                                <?php endif; ?>
                                <a href="<?= BASEURL; ?>/index.php?controller=admin&action=jadwal&sub_action=edit&id=<?= $j['id'] ?>" class="btn btn-warning">Edit</a>
                                <a href="<?= BASEURL; ?>/index.php?controller=admin&action=jadwal&sub_action=delete&id=<?= $j['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus jadwal ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

        <?php elseif ($viewMode === 'form'): ?>
            <div class="admin-header">
                <h1>Edit Jadwal Keberangkatan</h1>
                <span>Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin'); ?></span>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <div class="admin-form admin-form-medium">
                <form action="<?= $jadwal ? BASEURL . '/index.php?controller=admin&action=jadwal&sub_action=edit&id=' . $jadwal['id'] : BASEURL . '/index.php?controller=admin&action=jadwal&sub_action=add' ?>" method="POST">
                    <?php if ($jadwal): ?>
                        <input type="hidden" name="id" value="<?= $jadwal['id'] ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="asal">Asal</label>
                        <select id="asal" name="asal" required>
                            <option value="">-- Pilih Kota Asal --</option>
                            <?php foreach ($ruteList as $rute): ?>
                                <option value="<?= htmlspecialchars($rute) ?>" <?= ($jadwal['asal'] ?? '') === $rute ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($rute) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tujuan">Tujuan</label>
                        <select id="tujuan" name="tujuan" required>
                            <option value="">-- Pilih Kota Tujuan --</option>
                            <?php foreach ($ruteList as $rute): ?>
                                <option value="<?= htmlspecialchars($rute) ?>" <?= ($jadwal['tujuan'] ?? '') === $rute ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($rute) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
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
                            <option value="pending" <?= ($jadwal['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="ditolak" <?= ($jadwal['status'] ?? '') === 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                        </select>
                    </div>
                    <div class="form-group mt-15">
                        <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                        <a href="<?= BASEURL; ?>/index.php?controller=admin&action=jadwal" class="btn btn-danger">Batal</a>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
