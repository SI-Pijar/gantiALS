<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Penumpang - Admin Panel ALS</title>
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
                <h1>Kelola Penumpang</h1>
                <span>Selamat datang, <?= htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin') ?></span>
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
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($penumpangs)): ?>
                        <tr><td colspan="5" class="td-tengah">Belum ada penumpang.</td></tr>
                    <?php else: ?>
                        <?php foreach ($penumpangs as $u): ?>
                        <tr>
                            <td><?= htmlspecialchars($u['nama_lengkap'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($u['email'] ?? '-') ?></td>
                            <td><?= ucfirst($u['status'] ?? 'aktif') ?></td>
                            <td><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                            <td>
                                <a href="<?= BASEURL; ?>/index.php?controller=admin&action=penumpang&sub_action=detail&id=<?= $u['id'] ?>" class="btn btn-primary">Detail</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

        <?php elseif ($viewMode === 'detail'): ?>
            <div class="admin-header">
                <h1>Detail Penumpang</h1>
                <span>Selamat datang, <?= htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin') ?></span>
            </div>

            <div class="admin-form">
                <p><strong>ID Penumpang:</strong> <?= $penumpang['id'] ?></p>
                <p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($penumpang['nama_lengkap'] ?? '-') ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($penumpang['email'] ?? '-') ?></p>

                <p><strong>Status Akun:</strong> <?= ucfirst($penumpang['status'] ?? 'aktif') ?></p>
                <p><strong>Bergabung Pada:</strong> <?= date('d M Y H:i:s', strtotime($penumpang['created_at'])) ?></p>
                <div class="grup-tombol mt-20">
                    <a href="<?= BASEURL; ?>/index.php?controller=admin&action=penumpang" class="btn btn-primary">Kembali</a>

                    <?php if (($penumpang['status'] ?? 'aktif') !== 'suspended'): ?>

                        <a href="<?= BASEURL; ?>/index.php?controller=admin&action=penumpang&sub_action=suspend&id=<?= $penumpang['id'] ?>"
                           class="btn btn-danger"
                           onclick="return confirm('Yakin ingin menonaktifkan akun ini?')">
                            Nonaktifkan Akun
                        </a>
                    <?php else: ?>

                        <a href="<?= BASEURL; ?>/index.php?controller=admin&action=penumpang&sub_action=activate&id=<?= $penumpang['id'] ?>"
                           class="btn btn-success"
                           onclick="return confirm('Aktifkan kembali akun ini?')">
                            Aktifkan Kembali
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
