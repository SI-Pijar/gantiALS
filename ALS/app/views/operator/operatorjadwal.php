<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jadwal Operator</title>
    <link rel="stylesheet" href="<?= BASEURL; ?>/ALS/public/css/operator.css?v=<?= time(); ?>">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="<?= BASEURL; ?>/ALS/public/gambar/logo%20als.jpg" alt="Logo ALS">
            <span>Operator ALS</span>
        </div>
        <nav class="sidebar-nav">
            <a href="<?= BASEURL; ?>/index.php?controller=operator&action=dashboard">
                <span>Dashboard</span>
            </a>
            <a href="<?= BASEURL; ?>/index.php?controller=operator&action=bilList">
                <span>Kelola Bus</span>
            </a>
            <a href="<?= BASEURL; ?>/index.php?controller=operator&action=jadwalList" class="active">
                <span>Kelola Jadwal</span>
            </a>
            <a href="<?= BASEURL; ?>/index.php?controller=operator&action=pemesananList">
                <span>Kelola Pemesanan</span>
            </a>
            <a href="<?= BASEURL; ?>/index.php?controller=operator&action=profil">
                <span>Profil Saya</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= BASEURL; ?>/index.php?controller=operator&action=logout">
                <span>Logout</span>
            </a>
        </div>
    </div>
    <div class="content">
        <h2>Kelola Jadwal</h2>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php
        $isEdit = $jadwalEdit !== null;
        $formAction = $isEdit
            ? BASEURL . '/index.php?controller=operator&action=jadwalEdit&id=' . $jadwalEdit['id']
            : BASEURL . '/index.php?controller=operator&action=jadwalAdd';
        ?>
        <div class="card">
            <h3><?= $isEdit ? 'Edit Jadwal' : 'Tambah Jadwal' ?></h3>
            <form action="<?= $formAction ?>" method="POST">
                <div class="form-group">
                    <label>Bus</label>
                    <select name="bus_id" required>
                        <option value="">-- Pilih Bus --</option>
                        <?php foreach ($busListOptions as $busOp): ?>
                            <option value="<?= $busOp['id'] ?>"
                                <?= ($jadwalEdit['bus_id'] ?? 0) == $busOp['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($busOp['no_polisi']) ?> (<?= htmlspecialchars($busOp['kelas_bus']) ?>, <?= (int)$busOp['kapasitas'] ?> kursi)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Asal</label>
                    <select name="asal" required>
                        <option value="">-- Pilih Kota Asal --</option>
                        <?php foreach ($ruteList as $rute): ?>
                            <option value="<?= htmlspecialchars($rute) ?>"
                                <?= ($jadwalEdit['asal'] ?? '') === $rute ? 'selected' : '' ?>>
                                <?= htmlspecialchars($rute) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tujuan</label>
                    <select name="tujuan" required>
                        <option value="">-- Pilih Kota Tujuan --</option>
                        <?php foreach ($ruteList as $rute): ?>
                            <option value="<?= htmlspecialchars($rute) ?>"
                                <?= ($jadwalEdit['tujuan'] ?? '') === $rute ? 'selected' : '' ?>>
                                <?= htmlspecialchars($rute) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal Keberangkatan</label>
                    <input type="date" name="tanggal" value="<?= htmlspecialchars($jadwalEdit['tanggal'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Jam Keberangkatan</label>
                    <input type="time" name="jam_berangkat" value="<?= htmlspecialchars($jadwalEdit['jam_berangkat'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" value="<?= htmlspecialchars($jadwalEdit['harga'] ?? '') ?>" required min="1">
                </div>
                <div class="grup-tombol">
                    <button type="submit" class="btn btn-success"><?= $isEdit ? 'Update Jadwal' : 'Simpan Jadwal' ?></button>
                    <?php if ($isEdit): ?>
                    <a href="<?= BASEURL ?>/index.php?controller=operator&action=jadwalList" class="btn btn-warning">Batal Edit</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="card">
            <h3>Daftar Jadwal</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Bus</th>
                        <th>Rute</th>
                        <th>Waktu</th>
                        <th>Harga</th>
                        <th>Kursi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($jadwalList)): ?>
                        <?php foreach ($jadwalList as $jadwal): ?>
                        <tr>
                            <td><?= $jadwal['id'] ?></td>
                            <td><?= htmlspecialchars($jadwal['no_polisi']) ?></td>
                            <td><?= htmlspecialchars($jadwal['asal']) ?> - <?= htmlspecialchars($jadwal['tujuan']) ?></td>
                            <td><?= htmlspecialchars($jadwal['tanggal']) ?><br><?= htmlspecialchars($jadwal['jam_berangkat']) ?></td>
                            <td>Rp <?= number_format($jadwal['harga'], 0, ',', '.') ?></td>
                            <td><?= $jadwal['kursi_tersedia'] ?? '-' ?></td>
                            <td>
                                <a href="<?= BASEURL ?>/index.php?controller=operator&action=jadwalList&edit_id=<?= $jadwal['id'] ?>" class="btn btn-warning">Edit</a>
                                <a href="<?= BASEURL ?>/index.php?controller=operator&action=jadwalDelete&id=<?= $jadwal['id'] ?>" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7">Belum ada data jadwal.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
