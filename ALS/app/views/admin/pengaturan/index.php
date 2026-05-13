<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pengaturan Sistem - Admin Panel ALS</title>
  <link rel="stylesheet" href="public/css/admin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
<div class="TataLetakAdmin">

  <?php require_once __DIR__ . '/../sidebar.php'; ?>

  <main class="KontenUtamaAdmin">
    <header class="HeaderKonten">
      <h1>Pengaturan Sistem</h1>
      <div class="ProfilAdmin">
        <span>Selamat datang, <strong><?= htmlspecialchars($_SESSION['admin_nama']) ?></strong></span>
        <i class="fa-solid fa-user-shield"></i>
      </div>
    </header>

    <?php if (!empty($success)): ?>
      <div class="AlertSuccess"><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="KartuKontenBesar">
      <h3><i class="fa-solid fa-gears"></i> Konfigurasi Umum</h3>

      <form method="POST" action="index.php?page=pengaturan&action=simpan">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
          <div class="GrupInput">
            <label>Nama Aplikasi</label>
            <input type="text" name="nama_aplikasi" value="<?= htmlspecialchars($pengaturan['nama_aplikasi'] ?? '') ?>" />
          </div>
          <div class="GrupInput">
            <label>Tarif Dasar (Rp)</label>
            <input type="number" name="tarif_dasar" value="<?= htmlspecialchars($pengaturan['tarif_dasar'] ?? '0') ?>" min="0" />
          </div>
          <div class="GrupInput">
            <label>Email Notifikasi</label>
            <input type="email" name="email_notifikasi" value="<?= htmlspecialchars($pengaturan['email_notifikasi'] ?? '') ?>" />
          </div>
          <div class="GrupInput">
            <label>Mode Maintenance</label>
            <select name="maintenance_mode">
              <option value="0" <?= ($pengaturan['maintenance_mode'] ?? '0') === '0' ? 'selected' : '' ?>>Nonaktif</option>
              <option value="1" <?= ($pengaturan['maintenance_mode'] ?? '0') === '1' ? 'selected' : '' ?>>Aktif</option>
            </select>
          </div>
        </div>

        <button type="submit" class="TombolAksi" style="margin-top:10px;">
          <i class="fa-solid fa-floppy-disk"></i> Simpan Pengaturan
        </button>
      </form>
    </div>

  </main>
</div>
</body>
</html>
