<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya - Operator ALS</title>
    <link rel="stylesheet" href="<?= BASEURL ?>/ALS/public/css/operator.css?v=<?= time() ?>">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="<?= BASEURL ?>/ALS/public/gambar/logo%20als.jpg" alt="Logo ALS">
            <span>Operator ALS</span>
        </div>
        <nav class="sidebar-nav">
            <a href="<?= BASEURL ?>/index.php?controller=operator&action=dashboard"><span>Dashboard</span></a>
            <a href="<?= BASEURL ?>/index.php?controller=operator&action=bilList"><span>Kelola Bus</span></a>
            <a href="<?= BASEURL ?>/index.php?controller=operator&action=jadwalList"><span>Kelola Jadwal</span></a>
            <a href="<?= BASEURL ?>/index.php?controller=operator&action=pemesananList"><span>Kelola Pemesanan</span></a>
            <a href="<?= BASEURL ?>/index.php?controller=operator&action=profil" class="active"><span>Profil Saya</span></a>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= BASEURL ?>/index.php?controller=operator&action=logout"><span>Logout</span></a>
        </div>
    </div>

    <div class="content">
        <h2>Profil Saya</h2>

        <div class="card">
            <h3>Data Akun</h3>

            <?php if ($success_profil): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success_profil) ?></div>
            <?php endif; ?>
            <?php if ($error_profil): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error_profil) ?></div>
            <?php endif; ?>

            <p class="info-akun">
                Username: <strong><?= htmlspecialchars($operator['username'] ?? '') ?></strong> &nbsp;|&nbsp;
                Email: <strong><?= htmlspecialchars($operator['email'] ?? '') ?></strong>
            </p>

            <form action="<?= BASEURL ?>/index.php?controller=operator&action=prosesUbahProfil" method="POST">
                <div class="form-group">
                    <label>Nama Perusahaan</label>
                    <input type="text" name="nama" value="<?= htmlspecialchars($operator['nama'] ?? '') ?>" required>
                </div>
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            </form>
        </div>

        <div class="card">
            <h3>Ganti Password</h3>

            <?php if ($success_password): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success_password) ?></div>
            <?php endif; ?>
            <?php if ($error_password): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error_password) ?></div>
            <?php endif; ?>

            <form action="<?= BASEURL ?>/index.php?controller=operator&action=prosesGantiPassword" method="POST">
                <div class="form-group">
                    <label>Password Lama</label>
                    <input type="password" name="password_lama" required>
                </div>
                <div class="form-group">
                    <label>Password Baru (min. 8 karakter)</label>
                    <input type="password" name="password_baru" required minlength="8">
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="konfirmasi_password" required minlength="8">
                </div>
                <button type="submit" class="btn btn-success">Ubah Password</button>
            </form>
        </div>
    </div>
</body>
</html>
