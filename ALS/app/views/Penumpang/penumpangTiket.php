<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-Tiket Anda - PT. Antar Lintas Sumatera</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link rel="stylesheet" href="<?= BASEURL; ?>/ALS/public/css/penumpang.css" />
  </head>
  <body>
    <nav class="navbar ticket-nav">
      <div class="container">
        <div class="logo">
          <img src="<?= BASEURL; ?>/ALS/public/gambar/logo als.jpg" alt="Logo ALS" width="58" height="58" />
          <div class="logo-text">
            <h1>ALS</h1>
            <p>Bekerjasama Dan Sama-Sama Bekerja</p>
          </div>
        </div>
        <div class="nav-menu">
          <a href="<?= BASEURL; ?>/index.php?page=home">Tiket Bus</a>
        </div>
      </div>
    </nav>

    <main class="container">
        <div class="ticket-container">
            <div class="ticket-header">
                <h2><i class="fa-solid fa-ticket"></i> E-Tiket ALS</h2>
                <p>Kode Booking: <strong>ALS-<?= str_pad($tiket['id'], 5, '0', STR_PAD_LEFT) ?></strong></p>
            </div>
            <div class="ticket-body">
                <div class="ticket-row">
                    <div>
                        <div class="ticket-label">Nama Penumpang</div>
                        <div class="ticket-value"><?= htmlspecialchars($tiket['nama_pemesan']) ?></div>
                        <div class="ticket-label mt-10">Email / Telepon</div>
                        <div class="ticket-value teks-normal"><?= htmlspecialchars($tiket['email']) ?> <br> <?= htmlspecialchars($tiket['telepon']) ?></div>
                    </div>
                    <div class="teks-kanan">
                        <div class="ticket-label">Status</div>
                        <div class="ticket-value teks-hijau">
                            <?= ($tiket['status_pembayaran'] === 'Lunas' || $tiket['status_pembayaran'] === 'berhasil') ? 'LUNAS' : strtoupper($tiket['status_pembayaran']) ?>
                        </div>
                    </div>
                </div>
                <div class="ticket-row">
                    <div>
                        <div class="ticket-label">Keberangkatan</div>
                        <div class="ticket-value"><?= htmlspecialchars($tiket['asal']) ?></div>
                        <div class="ticket-label mt-10">Tanggal</div>
                        <div class="ticket-value"><?= date('d M Y', strtotime($tiket['tanggal'] ?? 'now')) ?></div>
                        <div class="ticket-label mt-10">Jam</div>
                        <div class="ticket-value"><?= isset($tiket['jam_berangkat']) ? substr($tiket['jam_berangkat'], 0, 5) : '-' ?> WIB</div>
                    </div>
                    <div class="teks-kanan">
                        <div class="ticket-label">Tujuan</div>
                        <div class="ticket-value"><?= htmlspecialchars($tiket['tujuan']) ?></div>
                        <div class="ticket-label mt-10">Kursi (<?= $tiket['jumlah'] ?? 0 ?>)</div>
                        <div class="ticket-value"><?= htmlspecialchars($tiket['kursi_dipesan']) ?></div>
                    </div>
                </div>

                <div class="ticket-row baris-bersih">
                    <div>
                        <div class="ticket-label">Total Pembayaran</div>
                        <div class="ticket-value teks-besar">Rp <?= number_format($tiket['total_harga'], 0, ',', '.') ?></div>
                    </div>
                </div>
            </div>
            <div class="ticket-footer">
                <button onclick="window.print()" class="btn-print"><i class="fa-solid fa-print"></i> Cetak Tiket</button>
                <a href="<?= BASEURL; ?>/index.php" class="btn-print btn-biru-kiri">Ke Beranda</a>
            </div>
        </div>
    </main>
  </body>
</html>
