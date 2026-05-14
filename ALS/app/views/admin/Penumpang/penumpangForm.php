<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $user ? 'Edit' : 'Tambah' ?> Penumpang - Admin Panel ALS</title>
  <link rel="stylesheet" href="public/css/admin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="public/css/adminTambahan.css" />
</head>
<body>
<div class="TataLetakAdmin">

  <?php require_once __DIR__ . '/../sidebar.php'; ?>

  <main class="KontenUtamaAdmin">
    <header class="HeaderKonten">
      <h1><?= $user ? 'Edit' : 'Tambah' ?> Penumpang</h1>
      <div class="ProfilAdmin">
        <span>Selamat datang, <strong><?= htmlspecialchars($_SESSION['admin_nama']) ?></strong></span>
        <i class="fa-solid fa-user-shield"></i>
      </div>
    </header>

    <?php if (!empty($error)): ?>
      <div class="AlertError"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="KartuKontenBesar">
      <div class="HeaderKartu">
        <h3><i class="fa-solid fa-user-plus"></i> Form Penumpang</h3>
        <a href="index.php?page=Penumpang" class="TombolAksi TombolAbu">
          <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
      </div>

      <form method="POST" action="index.php?page=Penumpang&action=<?= $user ? 'simpanedit' : 'simpan' ?>">
        <?php if ($user): ?>
          <input type="hidden" name="id" value="<?= $user['id'] ?>" />
        <?php endif; ?>

        <div class="GridDuaKolom">
          <?php if (!$user): ?>
          <div class="GrupInput">
            <label>Username</label>
            <input type="text" name="username" required />
          </div>
          <?php endif; ?>

          <div class="GrupInput">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($user['nama_lengkap'] ?? '') ?>" required />
          </div>

          <div class="GrupInput">
            <label><?= $user ? 'Password Baru (kosongkan jika tidak diganti)' : 'Password' ?></label>
            <input type="password" name="password" <?= $user ? '' : 'required' ?> />
          </div>

          <div class="GrupInput">
            <label>Hak Akses (Role)</label>
            <select name="role">
              <option value="superadmin" <?= ($user['role'] ?? '') === 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
              <option value="operator"   <?= ($user['role'] ?? '') === 'operator'   ? 'selected' : '' ?>>Operator</option>
              <option value="Penumpang"   <?= ($user['role'] ?? 'Penumpang') === 'Penumpang' ? 'selected' : '' ?>>Penumpang</option>
            </select>
          </div>

          <div class="GrupInput">
            <label>Status</label>
            <select name="status">
              <option value="aktif"    <?= ($user['status'] ?? 'aktif') === 'aktif'    ? 'selected' : '' ?>>Aktif</option>
              <option value="nonaktif" <?= ($user['status'] ?? '') === 'nonaktif' ? 'selected' : '' ?>>Non-Aktif</option>
            </select>
          </div>
        </div>

        <button type="submit" class="TombolAksi MarginAtas10">
          <i class="fa-solid fa-floppy-disk"></i> Simpan
        </button>
      </form>
    </div>

  </main>
</div>
</body>
</html>
