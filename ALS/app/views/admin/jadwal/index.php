<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kelola Jadwal - Admin Panel ALS</title>
  <link rel="stylesheet" href="public/css/admin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
<div class="TataLetakAdmin">

  <?php require_once __DIR__ . '/../sidebar.php'; ?>

  <main class="KontenUtamaAdmin">
    <header class="HeaderKonten">
      <h1>Kelola Jadwal Keberangkatan</h1>
      <div class="ProfilAdmin">
        <span>Selamat datang, <strong><?= htmlspecialchars($_SESSION['admin_nama']) ?></strong></span>
        <i class="fa-solid fa-user-shield"></i>
      </div>
    </header>

    <?php if (!empty($success)): ?>
      <div class="AlertSuccess"><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
      <div class="AlertError"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="KartuKontenBesar">
      <div class="HeaderKartu">
        <h3><i class="fa-solid fa-calendar-days"></i> Daftar Jadwal</h3>
        <a href="index.php?page=jadwal&action=tambah" class="TombolAksi">
          <i class="fa-solid fa-plus"></i> Tambah Jadwal
        </a>
      </div>

      <table class="TabelData">
        <thead>
          <tr>
            <th>No</th>
            <th>Asal</th>
            <th>Tujuan</th>
            <th>Tanggal</th>
            <th>Berangkat</th>
            <th>Tiba</th>
            <th>Harga</th>
            <th>Kursi</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          $rows = $jadwals->fetchAll(PDO::FETCH_ASSOC);
          if (empty($rows)):
          ?>
            <tr><td colspan="10" style="text-align:center;color:#64748b;">Belum ada jadwal.</td></tr>
          <?php else: ?>
            <?php foreach ($rows as $j): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($j['asal']) ?></td>
              <td><?= htmlspecialchars($j['tujuan']) ?></td>
              <td><?= date('d M Y', strtotime($j['tanggal'])) ?></td>
              <td><?= substr($j['jam_berangkat'], 0, 5) ?></td>
              <td><?= substr($j['jam_tiba'], 0, 5) ?></td>
              <td>Rp <?= number_format($j['harga'], 0, ',', '.') ?></td>
              <td><?= $j['kursi_tersedia'] ?></td>
              <td>
                <span class="StatusBadge <?= $j['status'] === 'aktif' ? 'berhasil' : 'nonaktif' ?>">
                  <?= ucfirst($j['status']) ?>
                </span>
              </td>
              <td class="KolomAksi">
                <a href="index.php?page=jadwal&action=edit&id=<?= $j['id'] ?>" class="TombolIkon edit">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="index.php?page=jadwal&action=hapus&id=<?= $j['id'] ?>"
                   class="TombolIkon hapus"
                   onclick="return confirm('Yakin hapus jadwal ini?')">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </main>
</div>
</body>
</html>
