<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Operator - Admin Panel ALS</title>
    <link rel="stylesheet" href="<?= BASEURL ?>/ALS/public/css/admin.css?v=<?= time() ?>">
</head>
<body>
<div class="admin-sidebar">
    <div class="admin-sidebar-logo">
        <img src="<?= BASEURL ?>/ALS/public/gambar/logo als.jpg" alt="Logo ALS">
        <span>Admin Panel</span>
    </div>
    <a href="<?= BASEURL ?>/index.php?controller=admin&action=dashboard">Dashboard</a>
    <a href="<?= BASEURL ?>/index.php?controller=admin&action=jadwal">Kelola Jadwal</a>
    <a href="<?= BASEURL ?>/index.php?controller=admin&action=transaksi">Laporan Transaksi</a>
    <a href="<?= BASEURL ?>/index.php?controller=admin&action=penumpang">Kelola Penumpang</a>
    <a href="<?= BASEURL ?>/index.php?controller=admin&action=operator" class="nav-aktif">Kelola Operator</a>
    <a href="<?= BASEURL ?>/index.php?controller=admin&action=manajemenAdmin">Kelola Admin</a>
    <a href="<?= BASEURL ?>/index.php?controller=admin&action=log">Log Sistem</a>
    <a href="<?= BASEURL ?>/index.php?controller=admin&action=pengaturan">Pengaturan</a>
    <a href="<?= BASEURL ?>/index.php?controller=auth&action=logout" class="link-logout">Logout</a>
</div>

<div class="admin-main">
    <?php if ($viewMode === 'list'): ?>
        <div class="admin-header">
            <h1>Kelola Operator</h1>
            <a href="<?= BASEURL ?>/index.php?controller=admin&action=operator&sub_action=add" class="btn btn-success">+ Tambah Operator</a>
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
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($operators)): ?>
                    <tr><td colspan="5" class="td-tengah">Belum ada operator.</td></tr>
                <?php else: ?>
                    <?php foreach ($operators as $op): ?>
                    <tr>
                        <td><?= htmlspecialchars($op['username']) ?></td>
                        <td><?= htmlspecialchars($op['nama']) ?></td>
                        <td><?= htmlspecialchars($op['email']) ?></td>
                        <td><?= date('d M Y', strtotime($op['created_at'])) ?></td>
                        <td>
                            <a href="<?= BASEURL ?>/index.php?controller=admin&action=operator&sub_action=edit&id=<?= $op['id'] ?>" class="btn btn-warning">Edit</a>
                            <a href="<?= BASEURL ?>/index.php?controller=admin&action=operator&sub_action=delete&id=<?= $op['id'] ?>" class="btn btn-danger">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

    <?php elseif ($viewMode === 'form'): ?>
        <div class="admin-header">
            <h1><?= $operator ? 'Edit Operator' : 'Tambah Operator Baru' ?></h1>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="admin-form admin-form-narrow">
            <form action="<?= BASEURL ?>/index.php?controller=admin&action=operator&sub_action=<?= $operator ? 'edit&id='.$operator['id'] : 'add' ?>" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($operator['username'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Nama Perusahaan / Nama Operator</label>
                    <input type="text" name="nama" value="<?= htmlspecialchars($operator['nama'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($operator['email'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label><?= $operator ? 'Password Baru (kosongkan jika tidak diubah)' : 'Password (min. 8 karakter)' ?></label>
                    <input type="password" name="password" <?= $operator ? '' : 'required minlength="8"' ?> minlength="8">
                </div>
                <div class="grup-tombol-mt">
                    <button type="submit" class="btn btn-primary"><?= $operator ? 'Simpan Perubahan' : 'Tambah Operator' ?></button>
                    <a href="<?= BASEURL ?>/index.php?controller=admin&action=operator" class="btn btn-warning">Batal</a>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
