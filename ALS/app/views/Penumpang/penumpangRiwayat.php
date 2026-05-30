<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Riwayat Pesanan - ALS</title>
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
        <a href="<?= BASEURL ?>/index.php?page=riwayat" class="btn-biru">Pesanan Saya</a>
        <a href="<?= BASEURL ?>/index.php?page=profil" class="btn-outline">Profil</a>
        <a href="<?= BASEURL ?>/index.php?controller=auth&action=logout" class="btn-outline">Keluar</a>
      </div>
    </div>
  </nav>

  <main class="container page-content">
    <h2 class="judul-halaman">Riwayat Pesanan Saya</h2>

    <?php if ($success): ?>
      <div class="alert-sukses"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if (empty($pesanans)): ?>
      <div class="kosong-tengah">
        <i class="fa-solid fa-ticket ikon-kosong"></i>
        <p>Belum ada pesanan. <a href="<?= BASEURL ?>/index.php" class="link-biru">Cari tiket sekarang</a></p>
      </div>
    <?php else: ?>
      <div class="daftar-riwayat">
        <?php foreach ($pesanans as $p): ?>
        <div class="kartu-riwayat">
          <div>
            <div class="kode-booking">
              ALS-<?= str_pad($p['id'], 5, '0', STR_PAD_LEFT) ?> &bull;
              <?= date('d M Y H:i', strtotime($p['tanggal_pesan'])) ?>
            </div>
            <div class="rute-riwayat">
              <?= htmlspecialchars($p['asal'] ?? '-') ?> &rarr; <?= htmlspecialchars($p['tujuan'] ?? '-') ?>
            </div>
            <div class="info-riwayat">
              <?= !empty($p['tanggal']) ? date('d M Y', strtotime($p['tanggal'])) : '-' ?>
              <?= !empty($p['jam_berangkat']) ? ' &bull; ' . substr($p['jam_berangkat'], 0, 5) . ' WIB' : '' ?>
              &bull; Kursi: <?= htmlspecialchars($p['kursi_dipesan'] ?? '-') ?>
            </div>
            <div class="harga-riwayat">
              Rp <?= number_format($p['total_harga'] ?? 0, 0, ',', '.') ?>
            </div>
          </div>
          <div class="kolom-kanan">
            <?php
              $statusClass = match($p['status_pembayaran'] ?? 'pending') {
                'Lunas', 'berhasil' => 'badge-lunas',
                'pending' => 'badge-pending',
                'Gagal' => 'badge-gagal',
                default => 'badge-batal',
              };
            ?>
            <span class="badge-status <?= $statusClass ?>">
              <?= ucfirst($p['status_pembayaran'] ?? 'pending') ?>
            </span>
            <?php if (($p['status_pembayaran'] ?? '') === 'Lunas' || ($p['status_pembayaran'] ?? '') === 'berhasil'): ?>
              <br><a href="<?= BASEURL ?>/index.php?page=tiket&id=<?= $p['id'] ?>" class="link-aksi">
                <i class="fa-solid fa-ticket"></i> Lihat Tiket
              </a>
            <?php elseif (($p['status_pembayaran'] ?? '') === 'pending'): ?>
              <br><a href="<?= BASEURL ?>/index.php?page=pembayaran&id=<?= $p['id'] ?>" class="link-aksi-orange">
                <i class="fa-solid fa-credit-card"></i> Bayar Sekarang
              </a>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>
</body>
</html>
