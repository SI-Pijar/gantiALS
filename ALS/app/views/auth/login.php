<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $mode === 'register' ? 'Daftar' : 'Masuk' ?> - PT. Antar Lintas Sumatera</title>
  <link rel="stylesheet" href="<?= BASEURL; ?>/ALS/public/css/auth.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  </head>
<body>
  <div class="auth-wrapper">
    <div class="auth-side auth-side-image">
      <div class="image-caption">
        <h2>Perjalanan mudah untuk semua pengguna</h2>
        <p>Masuk atau daftar sekali untuk mengakses semua layanan ALS, mulai dari pemesanan tiket hingga kelola dashboard.</p>
      </div>
    </div>

    <section class="auth-form">
      <h2><?= $mode === 'register' ? 'Daftar Akun Baru' : 'Masuk ke Akun Anda' ?></h2>
      <p><?= $mode === 'register' ? 'Isi informasi di bawah ini untuk membuat akun penumpang baru.' : 'Gunakan username atau email Anda untuk masuk ke sistem ALS.' ?></p>

      <?php if (!empty($error)): ?>
        <div class="alert-error">
          <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($success)): ?>
        <div class="alert-sukses">
          <i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($success) ?>
        </div>
      <?php endif; ?>

      <?php if ($mode === 'register'): ?>
        <form action="<?= BASEURL; ?>/index.php?controller=auth&action=register" method="POST">
          <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" required value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>" />
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required />
          </div>
          <div class="form-group">
            <label for="password2">Konfirmasi Password</label>
            <input type="password" id="password2" name="password2" required />
          </div>
          <button type="submit" class="btn-login"><i class="fa-solid fa-user-plus"></i> Daftar Sekarang</button>
        </form>
        <div class="auth-link">Sudah punya akun? <a href="<?= BASEURL; ?>/index.php?controller=auth&action=login">Masuk</a></div>
      <?php else: ?>
        <form action="<?= BASEURL; ?>/index.php?controller=auth&action=login" method="POST">
          <div class="form-group">
            <label for="credential">Username atau Email</label>
            <input type="text" id="credential" name="credential" required value="<?= htmlspecialchars($_POST['credential'] ?? '') ?>" />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required />
          </div>
          <button type="submit" class="btn-login"><i class="fa-solid fa-right-to-bracket"></i> Masuk</button>
        </form>
        <div class="auth-link">Belum punya akun? <a href="<?= BASEURL; ?>/index.php?controller=auth&action=register">Daftar</a></div>
      <?php endif; ?>
    </section>
  </div>
</body>
</html>
