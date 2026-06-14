<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Bus Operator</title>
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
            <a href="<?= BASEURL; ?>/index.php?controller=operator&action=bilList" class="active">
                <span>Kelola Bus</span>
            </a>
            <a href="<?= BASEURL; ?>/index.php?controller=operator&action=jadwalList">
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
        <h2>Kelola Bus</h2>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php
        $isEdit = $busEdit !== null;
        $KELAS_KAPASITAS = [
            'Super Executive' => 22,
            'Executive Class' => 30,
            'Patas AC'        => 38,
            'Ekonomi AC'      => 44,
            'Ekonomi Non-AC'  => 50,
        ];
        $formAction = $isEdit
            ? BASEURL . '/index.php?controller=operator&action=bilEdit&id=' . $busEdit['id']
            : BASEURL . '/index.php?controller=operator&action=bilAdd';
        ?>
        <div class="card">
            <h3><?= $isEdit ? 'Edit Bus' : 'Tambah Bus' ?></h3>
            <form action="<?= $formAction ?>" method="POST">
                <div class="form-group">
                    <label>No Polisi</label>
                    <input type="text" name="no_polisi" value="<?= htmlspecialchars($busEdit['no_polisi'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Kelas Bus</label>
                    <select name="kelas_bus" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php foreach ($KELAS_KAPASITAS as $kelas => $kap): ?>
                        <option value="<?= $kelas ?>" <?= ($busEdit['kelas_bus'] ?? '') === $kelas ? 'selected' : '' ?>>
                            <?= $kelas ?> (<?= $kap ?> kursi)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status_bus">
                        <option value="Aktif"      <?= ($busEdit['status_bus'] ?? 'Aktif') === 'Aktif'      ? 'selected' : '' ?>>Aktif</option>
                        <option value="Tidak Aktif" <?= ($busEdit['status_bus'] ?? '')      === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                    </select>
                </div>
                <div class="grup-tombol">
                    <button type="submit" class="btn btn-success"><?= $isEdit ? 'Update Bus' : 'Simpan Bus' ?></button>
                    <?php if ($isEdit): ?>
                    <a href="<?= BASEURL ?>/index.php?controller=operator&action=bilList" class="btn btn-warning">Batal Edit</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="card">
            <h3>Daftar Bus</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>No Polisi</th>
                        <th>Kelas</th>
                        <th>Kapasitas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($busList)): ?>
                        <?php foreach ($busList as $bus): ?>
                        <tr>
                            <td><?= $bus['id'] ?></td>
                            <td><?= htmlspecialchars($bus['no_polisi']) ?></td>
                            <td><?= htmlspecialchars($bus['kelas_bus']) ?></td>
                            <td><?= $bus['kapasitas'] ?></td>
                            <td><?= $bus['status_bus'] ?></td>
                            <td>
                                <a href="<?= BASEURL ?>/index.php?controller=operator&action=bilList&edit_id=<?= $bus['id'] ?>" class="btn btn-warning">Edit</a>
                                <a href="<?= BASEURL ?>/index.php?controller=operator&action=bilDelete&id=<?= $bus['id'] ?>" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6">Belum ada data bus.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
