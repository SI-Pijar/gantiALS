<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Laporan Transaksi - Admin Panel ALS</title>
  <link rel="stylesheet" href="public/css/admin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="public/css/adminTambahan.css" />
</head>
<body>
<div class="TataLetakAdmin">

  <?php require_once __DIR__ . '/../sidebar.php'; ?>

  <main class="KontenUtamaAdmin">
    <header class="HeaderKonten">
      <h1>Laporan Transaksi</h1>
      <div class="ProfilAdmin">
        <span>Selamat datang, <strong><?= htmlspecialchars($_SESSION['admin_nama']) ?></strong></span>
        <i class="fa-solid fa-user-shield"></i>
      </div>
    </header>

    <div class="KartuKontenBesar MarginBawah20">
      <form method="POST" action="index.php?page=transaksi&action=filter" class="FlexFilter">
        <div class="GrupInput GrupInputFilter">
          <label>Dari Tanggal</label>
          <input type="date" name="dari" value="<?= htmlspecialchars($dari ?? '') ?>" />
        </div>
        <div class="GrupInput GrupInputFilter">
          <label>Sampai Tanggal</label>
          <input type="date" name="sampai" value="<?= htmlspecialchars($sampai ?? '') ?>" />
        </div>
        <div class="GrupInput GrupInputFilter">
          <label>Status</label>
          <select name="status">
            <option value="">Semua</option>
            <option value="berhasil" <?= ($status ?? '') === 'berhasil' ? 'selected' : '' ?>>Berhasil</option>
            <option value="pending"  <?= ($status ?? '') === 'pending'  ? 'selected' : '' ?>>Pending</option>
            <option value="gagal"    <?= ($status ?? '') === 'gagal'    ? 'selected' : '' ?>>Gagal</option>
          </select>
        </div>
        <button type="submit" class="TombolAksi"><i class="fa-solid fa-filter"></i> Filter</button>
        <a href="index.php?page=transaksi" class="TombolAksi TombolAbu">Reset</a>
      </form>
    </div>

    <div class="KartuKontenBesar">
      <div class="HeaderKartu">
        <h3><i class="fa-solid fa-receipt"></i> Data Transaksi</h3>
      </div>

      <table class="TabelData">
        <thead>
          <tr>
            <th>No. Invoice</th>
            <th>Penumpang</th>
            <th>Penumpang</th>
            <th>Rute</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $rows = $transaksis->fetchAll(PDO::FETCH_ASSOC);
          if (empty($rows)):
          ?>
            <tr><td colspan="8" class="TeksTengahAbu">Tidak ada data transaksi.</td></tr>
          <?php else: ?>
            <?php foreach ($rows as $t): ?>
            <tr>
              <td><?= htmlspecialchars($t['nomor_invoice']) ?></td>
              <td><?= htmlspecialchars($t['nama_penumpang']) ?></td>
              <td><?= htmlspecialchars($t['nama_Penumpang'] ?? '-') ?></td>
              <td><?= htmlspecialchars($t['asal'] . ' - ' . $t['tujuan']) ?></td>
              <td><?= date('d M Y', strtotime($t['tanggal_transaksi'])) ?></td>
              <td>Rp <?= number_format($t['total_harga'], 0, ',', '.') ?></td>
              <td>
                <?php
                $badge = match($t['status']) {
                    'berhasil' => 'berhasil',
                    'pending'  => 'info',
                    default    => 'nonaktif',
                };
                ?>
                <span class="StatusBadge <?= $badge ?>"><?= ucfirst($t['status']) ?></span>
              </td>
              <td>
                <a href="index.php?page=transaksi&action=detail&id=<?= $t['id'] ?>" class="TombolIkon IkonBiru">
                  <i class="fa-solid fa-eye"></i>
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
