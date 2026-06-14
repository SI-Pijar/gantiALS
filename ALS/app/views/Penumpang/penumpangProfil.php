<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profil Saya - ALS</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" href="<?= BASEURL ?>/ALS/public/css/penumpang.css?v=<?= time() ?>"/>
  </head>
<body>
  <nav class="navbar ticket-nav">
    <div class="container">
      <div class="logo">
        <img src="<?= BASEURL ?>/ALS/public/gambar/logo als.jpg" alt="Logo ALS" width="58" height="58"/>
        <div class="logo-text"><h1>ALS</h1><p>Bekerjasama Dan Sama-Sama Bekerja</p></div>
      </div>
      <div class="nav-menu">
        <a href="<?= BASEURL ?>/index.php?page=home">Tiket Bus</a>
      </div>
      <div class="nav-auth">
        <a href="<?= BASEURL ?>/index.php?page=riwayat" class="btn-outline">Pesanan Saya</a>
        <a href="<?= BASEURL ?>/index.php?page=profil" class="btn-biru">Profil</a>
        <a href="<?= BASEURL ?>/index.php?controller=auth&action=logout" class="btn-outline">Keluar</a>
      </div>
    </div>
  </nav>

  <main class="container page-content">
    <div class="profil-wrapper">

      <div class="profil-card">
        <h3><i class="fa-solid fa-user"></i> Data Akun</h3>

        <?php if ($success_profil): ?>
          <div class="profil-alert success"><?= htmlspecialchars($success_profil) ?></div>
        <?php endif; ?>
        <?php if ($error_profil): ?>
          <div class="profil-alert error"><?= htmlspecialchars($error_profil) ?></div>
        <?php endif; ?>

        <p class="info-akun-teks">Email: <strong><?= htmlspecialchars($penumpang['email'] ?? '') ?></strong></p>

        <form action="<?= BASEURL ?>/index.php?page=proses_ubah_profil" method="POST">
          <div class="input-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($penumpang['nama_lengkap'] ?? '') ?>" required>
          </div>
          <button type="submit" class="btn-bayar btn-full mt-8">
            Simpan Perubahan
          </button>
        </form>
      </div>

      <div class="profil-card">
        <h3><i class="fa-solid fa-lock"></i> Ganti Password</h3>

        <?php if ($success_password): ?>
          <div class="profil-alert success"><?= htmlspecialchars($success_password) ?></div>
        <?php endif; ?>
        <?php if ($error_password): ?>
          <div class="profil-alert error"><?= htmlspecialchars($error_password) ?></div>
        <?php endif; ?>

        <form action="<?= BASEURL ?>/index.php?page=proses_ganti_password" method="POST">
          <div class="input-group">
            <label>Password Lama</label>
            <input type="password" name="password_lama" required>
          </div>
          <div class="input-group">
            <label>Password Baru (min. 8 karakter)</label>
            <input type="password" name="password_baru" required minlength="8">
          </div>
          <div class="input-group">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="konfirmasi_password" required minlength="8">
          </div>
          <button type="submit" class="btn-bayar btn-full mt-8">
            Ubah Password
          </button>
        </form>
      </div>

    </div>
  </main>
</body>
</html>
