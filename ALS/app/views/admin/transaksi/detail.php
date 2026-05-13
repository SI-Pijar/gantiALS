<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Detail Transaksi - Admin Panel ALS</title>
  <link rel="stylesheet" href="public/css/admin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
<div class="TataLetakAdmin">

  <?php require_once __DIR__ . '/../sidebar.php'; ?>

  <main class="KontenUtamaAdmin">
    <header class="HeaderKonten">
      <h1>Detail Transaksi</h1>
      <div class="ProfilAdmin">
        <span>Selamat datang, <strong><?= htmlspecialchars($_SESSION['admin_nama']) ?></strong></span>
        <i class="fa-solid fa-user-shield"></i>
      </div>
    </header>

    <div class="KartuKontenBesar">
      <div class="HeaderKartu">
        <h3><i class="fa-solid fa-file-invoice"></i> <?= htmlspecialchars($transaksi['nomor_invoice']) ?></h3>
        <a href="index.php?page=transaksi" class="TombolAksi" style="background:#64748b;">
          <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
      </div>

      <table class="TabelData">
        <tr><th>No. Invoice</th>    <td><?= htmlspecialchars($transaksi['nomor_invoice']) ?></td></tr>
        <tr><th>Nama Penumpang</th> <td><?= htmlspecialchars($transaksi['nama_penumpang']) ?></td></tr>
        <tr><th>Pengguna</th>       <td><?= htmlspecialchars($transaksi['nama_pengguna'] ?? '-') ?></td></tr>
        <tr><th>Rute</th>           <td><?= htmlspecialchars($transaksi['asal'] . ' → ' . $transaksi['tujuan']) ?></td></tr>
        <tr><th>Tanggal Jadwal</th> <td><?= date('d M Y', strtotime($transaksi['tanggal'])) ?></td></tr>
        <tr><th>Jam Berangkat</th>  <td><?= substr($transaksi['jam_berangkat'], 0, 5) ?></td></tr>
        <tr><th>Jam Tiba</th>       <td><?= substr($transaksi['jam_tiba'], 0, 5) ?></td></tr>
        <tr><th>Total Harga</th>    <td><strong>Rp <?= number_format($transaksi['total_harga'], 0, ',', '.') ?></strong></td></tr>
        <tr><th>Status</th>
          <td>
            <?php
            $badge = match($transaksi['status']) {
                'berhasil' => 'berhasil',
                'pending'  => 'info',
                default    => 'nonaktif',
            };
            ?>
            <span class="StatusBadge <?= $badge ?>"><?= ucfirst($transaksi['status']) ?></span>
          </td>
        </tr>
        <tr><th>Tanggal Transaksi</th><td><?= date('d M Y H:i', strtotime($transaksi['created_at'])) ?></td></tr>
      </table>
    </div>

  </main>
</div>
</body>
</html>
