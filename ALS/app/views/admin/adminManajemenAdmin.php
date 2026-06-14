<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Admin - Admin Panel ALS</title>
    <link rel="stylesheet" href="<?= BASEURL ?>/ALS/public/css/admin.css?v=<?= time() ?>">
</head>
<body>
<div class="admin-sidebar">
    <h2>Admin Panel</h2>
    <a href="<?= BASEURL ?>/index.php?controller=admin&action=dashboard">Dashboard</a>
    <a href="<?= BASEURL ?>/index.php?controller=admin&action=jadwal">Kelola Jadwal</a>
    <a href="<?= BASEURL ?>/index.php?controller=admin&action=transaksi">Laporan Transaksi</a>
    <a href="<?= BASEURL ?>/index.php?controller=admin&action=penumpang">Kelola Penumpang</a>
    <a href="<?= BASEURL ?>/index.php?controller=admin&action=operator">Kelola Operator</a>
    <a href="<?= BASEURL ?>/index.php?controller=admin&action=manajemenAdmin" class="nav-aktif">Kelola Admin</a>
    <a href="<?= BASEURL ?>/index.php?controller=admin&action=log">Log Sistem</a>
    <a href="<?= BASEURL ?>/index.php?controller=admin&action=pengaturan">Pengaturan</a>
    <a href="<?= BASEURL ?>/index.php?controller=auth&action=logout" class="link-logout">Logout</a>
</div>

<div class="admin-main">
    <?php if ($viewMode === 'list'): ?>
        <div class="admin-header">
            <h1>Kelola Akun Admin</h1>
            <a href="<?= BASEURL ?>/index.php?controller=admin&action=manajemenAdmin&sub_action=add" class="btn btn-success">+ Tambah Admin</a>
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
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($admins)): ?>
                    <tr><td colspan="6" class="td-tengah">Tidak ada data.</td></tr>
                <?php else: ?>
                    <?php foreach ($admins as $a): ?>
                    <tr>
                        <td><?= htmlspecialchars($a['username']) ?></td>
                        <td><?= htmlspecialchars($a['nama_lengkap']) ?></td>
                        <td><?= ucfirst($a['role'] ?? '') ?></td>
                        <td><?= ucfirst($a['status'] ?? '') ?></td>
                        <td><?= date('d M Y', strtotime($a['created_at'])) ?></td>
                        <td>
                            <a href="<?= BASEURL ?>/index.php?controller=admin&action=manajemenAdmin&sub_action=edit&id=<?= $a['id'] ?>" class="btn btn-warning">Edit</a>
                            <?php if ($a['id'] != $_SESSION['admin_id']): ?>
                            <a href="<?= BASEURL ?>/index.php?controller=admin&action=manajemenAdmin&sub_action=delete&id=<?= $a['id'] ?>" class="btn btn-danger">Hapus</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

    <?php elseif ($viewMode === 'form'): ?>
        <div class="admin-header">
            <h1><?= $adminData ? 'Edit Akun Admin' : 'Tambah Admin Baru' ?></h1>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="admin-form admin-form-narrow">
            <form action="<?= BASEURL ?>/index.php?controller=admin&action=manajemenAdmin&sub_action=<?= $adminData ? 'edit&id='.$adminData['id'] : 'add' ?>" method="POST">
                <?php if (!$adminData): ?>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required>
                </div>
                <?php else: ?>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" value="<?= htmlspecialchars($adminData['username']) ?>" disabled class="input-disabled">
                </div>
                <?php endif; ?>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($adminData['nama_lengkap'] ?? '') ?>" required>
                </div>
                <?php if ($adminData): ?>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="aktif"    <?= ($adminData['status'] ?? '') === 'aktif'    ? 'selected' : '' ?>>Aktif</option>
                        <option value="inactive" <?= ($adminData['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <label><?= $adminData ? 'Password Baru (kosongkan jika tidak diubah)' : 'Password (min. 8 karakter)' ?></label>
                    <input type="password" name="password" <?= $adminData ? '' : 'required minlength="8"' ?> minlength="8">
                </div>
                <div class="grup-tombol-mt">
                    <button type="submit" class="btn btn-primary"><?= $adminData ? 'Simpan Perubahan' : 'Buat Akun' ?></button>
                    <a href="<?= BASEURL ?>/index.php?controller=admin&action=manajemenAdmin" class="btn btn-warning">Batal</a>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
