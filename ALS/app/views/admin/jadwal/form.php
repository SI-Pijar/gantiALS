<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $jadwal ? 'Edit' : 'Tambah' ?> Jadwal - Admin Panel ALS</title>
  <link rel="stylesheet" href="public/css/admin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
<div class="TataLetakAdmin">

  <?php require_once __DIR__ . '/../sidebar.php'; ?>

  <main class="KontenUtamaAdmin">
    <header class="HeaderKonten">
      <h1><?= $jadwal ? 'Edit' : 'Tambah' ?> Jadwal</h1>
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
        <h3><i class="fa-solid fa-calendar-plus"></i> Form Jadwal</h3>
        <a href="index.php?page=jadwal" class="TombolAksi" style="background:#64748b;">
          <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
      </div>

      <form method="POST" action="index.php?page=jadwal&action=<?= $jadwal ? 'simpanedit' : 'simpan' ?>">
        <?php if ($jadwal): ?>
          <input type="hidden" name="id" value="<?= $jadwal['id'] ?>" />
        <?php endif; ?>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
          <div class="GrupInput">
            <label>Kota Asal</label>
            <input type="text" name="asal" value="<?= htmlspecialchars($jadwal['asal'] ?? '') ?>" required />
          </div>
          <div class="GrupInput">
            <label>Kota Tujuan</label>
            <input type="text" name="tujuan" value="<?= htmlspecialchars($jadwal['tujuan'] ?? '') ?>" required />
          </div>
          <div class="GrupInput">
            <label>Tanggal</label>
            <input type="date" name="tanggal" value="<?= $jadwal['tanggal'] ?? '' ?>" required />
          </div>
          <div class="GrupInput">
            <label>Jam Berangkat</label>
            <input type="time" name="jam_berangkat" value="<?= $jadwal['jam_berangkat'] ?? '' ?>" required />
          </div>
          <div class="GrupInput">
            <label>Jam Tiba</label>
            <input type="time" name="jam_tiba" value="<?= $jadwal['jam_tiba'] ?? '' ?>" required />
          </div>
          <div class="GrupInput">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" value="<?= $jadwal['harga'] ?? 0 ?>" min="0" required />
          </div>
          <div class="GrupInput">
            <label>Kursi Tersedia</label>
            <input type="number" name="kursi_tersedia" value="<?= $jadwal['kursi_tersedia'] ?? 0 ?>" min="0" required />
          </div>
          <div class="GrupInput">
            <label>Status</label>
            <select name="status">
              <option value="aktif"    <?= ($jadwal['status'] ?? '') === 'aktif'    ? 'selected' : '' ?>>Aktif</option>
              <option value="nonaktif" <?= ($jadwal['status'] ?? '') === 'nonaktif' ? 'selected' : '' ?>>Non-Aktif</option>
            </select>
          </div>
        </div>

        <button type="submit" class="TombolAksi" style="margin-top:10px;">
          <i class="fa-solid fa-floppy-disk"></i> Simpan
        </button>
      </form>
    </div>

  </main>
</div>
</body>
</html>
