<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hasil Pencarian Jadwal - PT. Antar Lintas Sumatera</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link rel="stylesheet" href="<?= BASEURL; ?>/ALS/public/css/penumpang.css?v=<?= time(); ?>" />
  </head>
  <body>
    <div class="topbar">
      <div class="container">
        <div>
          <i class="fa-solid fa-headset"></i>
          Layanan Pelanggan 24 Jam: <strong>0821-3825-9191</strong>
        </div>
        <div class="topbar-links">
          <?php if (isset($_SESSION['penumpang_id'])): ?>
            <span><i class="fa-solid fa-circle-user"></i> Halo, <?= htmlspecialchars($_SESSION['penumpang_name'] ?? '') ?></span>
          <?php else: ?>
            <a href="#"><i class="fa-solid fa-mobile-screen"></i> Unduh Aplikasi <span class="badge-baru">BARU</span></a>
            <a href="#">IDR - Rupiah</a>
            <a href="#">Pusat Bantuan</a>
            <a href="#">Cek Pesanan Saya</a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <nav class="navbar">
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
          <a href="<?= BASEURL; ?>/index.php?page=home#kelas">Kelas Armada</a>
          <a href="<?= BASEURL; ?>/index.php?page=home#agen">Jaringan Agen</a>
        </div>
        <div class="nav-auth">
          <?php if (isset($_SESSION['penumpang_id'])): ?>
            <a href="<?= BASEURL; ?>/index.php?page=riwayat" class="btn-outline">Pesanan Saya</a>
            <a href="<?= BASEURL; ?>/index.php?page=profil" class="btn-outline">Profil</a>
            <a href="<?= BASEURL; ?>/index.php?controller=auth&action=logout" class="btn-biru">Keluar</a>
          <?php else: ?>
            <a href="<?= BASEURL; ?>/index.php?controller=auth&action=register" class="btn-outline">Daftar Akun</a>
            <a href="<?= BASEURL; ?>/index.php?controller=auth&action=login" class="btn-biru">Masuk</a>
          <?php endif; ?>
        </div>
      </div>
    </nav>

    <main class="container page-content">
        <div class="section-header">
            <h2>Hasil Pencarian Jadwal Bus</h2>
            <p>Menampilkan jadwal untuk rute <strong><?= htmlspecialchars(!empty($_GET['asal']) ? $_GET['asal'] : 'Semua') ?> &rarr; <?= htmlspecialchars(!empty($_GET['tujuan']) ? $_GET['tujuan'] : 'Semua') ?></strong> pada tanggal <strong><?= !empty($_GET['tanggal']) ? date('d M Y', strtotime($_GET['tanggal'])) : 'Semua Tanggal' ?></strong>.</p>
            <a href="<?= BASEURL; ?>/index.php?page=home" class="btn-ubah-cari">
                <i class="fa-solid fa-pen-to-square"></i> Ubah Pencarian
            </a>
        </div>

        <div class="results-layout">
            <aside class="filter-panel">
                <div class="filter-card">
                    <h4><i class="fa-solid fa-filter"></i> Filter Hasil</h4>
                </div>

                <div class="filter-card">
                    <h4>Kelas Armada</h4>
                    <div class="filter-options">
                        <label><input type="checkbox" checked> Super Executive</label>
                        <label><input type="checkbox" checked> Executive Class</label>
                        <label><input type="checkbox" checked> Patas AC</label>
                        <label><input type="checkbox" checked> Ekonomi AC</label>
                        <label><input type="checkbox" checked> Ekonomi Non-AC</label>
                    </div>
                </div>

                <div class="filter-card">
                    <h4>Waktu Keberangkatan</h4>
                    <div class="filter-options">
                        <label><input type="checkbox"> Pagi (05:00 - 11:59)</label>
                        <label><input type="checkbox" checked> Siang (12:00 - 17:59)</label>
                        <label><input type="checkbox"> Malam (18:00 - 04:59)</label>
                    </div>
                </div>

                <button type="button" class="btn-filter">Terapkan Filter</button>
            </aside>

            <section class="results-list">
                <?php
                $rows = is_array($jadwals) ? $jadwals : [];
                if (empty($rows)):
                ?>
                <div class="jadwal-card">
                    <p class="no-result">Maaf, tidak ada jadwal yang tersedia untuk rute dan tanggal tersebut.</p>
                </div>
                <?php else: ?>
                <?php foreach ($rows as $j): ?>
                <div class="jadwal-card">
                    <div class="jadwal-info">
                        <div class="waktu-berangkat">
                            <p class="jam"><?= isset($j['jam_berangkat']) ? substr($j['jam_berangkat'], 0, 5) : '-' ?></p>
                            <p class="lokasi"><?= htmlspecialchars($j['asal']) ?></p>
                        </div>
                        <div class="durasi">
                            <i class="fa-solid fa-arrow-right-long"></i>
                            <p>Kursi: <?= htmlspecialchars($j['kursi_tersedia'] ?? '-') ?></p>
                        </div>
                        <div class="waktu-tiba">
                            <p class="jam">-</p>
                            <p class="lokasi"><?= htmlspecialchars($j['tujuan']) ?></p>
                        </div>
                    </div>
                    <?php
                    $fasilitasMap = [
                        'Super Executive' => 'Kursi 2-1 · AC · Toilet · Bantal · Selimut · Leg Rest',
                        'Executive Class' => 'Kursi 2-2 · AC · Toilet · Reclining Seat',
                        'Patas AC' => 'Kursi 2-2 · AC · Tanpa Toilet',
                        'Ekonomi AC' => 'Kursi 2-2 · AC · Tanpa Toilet',
                        'Ekonomi Non-AC' => 'Kursi 2-2/2-3 · Non-AC',
                    ];
                    $kelasLabel = $j['kelas_bus'] ?? 'Reguler';
                    $fasilitas = $fasilitasMap[$kelasLabel] ?? 'Fasilitas standar';
                    ?>
                    <div class="kelas-info info-col">
                        <i class="fa-solid fa-bus"></i>
                        <div>
                            <p class="kelas-nama"><?= htmlspecialchars($kelasLabel) ?></p>
                            <p class="fasilitas"><?= htmlspecialchars($fasilitas) ?></p>
                        </div>
                    </div>
                    <div class="harga-aksi info-col">
                        <div class="harga">
                            <p>Harga per kursi</p>
                            <p class="harga-angka">Rp <?= number_format($j['harga'], 0, ',', '.') ?></p>
                        </div>
                        <?php if (($j['kursi_tersedia'] ?? 0) > 0): ?>
                        <a href="<?= BASEURL; ?>/index.php?page=pemesanan&id=<?= $j['id'] ?>" class="btn-biru">Pilih Kursi</a>
                        <?php else: ?>
                        <button disabled class="btn-biru btn-penuh">Penuh</button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <footer class="footer">
      <div class="container">
        <div class="footer-grid">
          <div class="footer-brand">
            <h2>ALS Official</h2>
            <p class="footer-desc">
              Portal resmi sistem informasi dan pemesanan tiket PT. Antar Lintas
              Sumatera. Kami berkomitmen menyediakan layanan transportasi darat
              yang aman dan andal.
            </p>
          </div>
          <div class="footer-col">
            <h4>PRODUK & LAYANAN</h4>
            <ul>
              <li><a href="<?= BASEURL; ?>/index.php?page=home#kelas">Super Executive</a></li>
              <li><a href="<?= BASEURL; ?>/index.php?page=home#kelas">Executive Class</a></li>
              <li><a href="<?= BASEURL; ?>/index.php?page=home#kelas">Patas AC</a></li>
              <li><a href="<?= BASEURL; ?>/index.php?page=home#kelas">Ekonomi</a></li>
            </ul>
          </div>
          <div class="footer-col">
            <h4>PUSAT INFORMASI</h4>
            <ul>
              <li><a href="<?= BASEURL; ?>/index.php?page=pemesanan">Panduan Pemesanan</a></li>
              <li><a href="<?= BASEURL; ?>/index.php?page=pembayaran">Metode Pembayaran</a></li>
            </ul>
          </div>
          <div class="footer-col">
            <h4>KEAMANAN TRANSAKSI</h4>
            <div class="payment-icons">
              <i class="fa-brands fa-cc-visa"></i><i class="fa-brands fa-cc-mastercard"></i>
            </div>
          </div>
        </div>
        <div class="footer-copy">
          Copyright &copy; 2026 PT. Antar Lintas Sumatera.
        </div>
      </div>
    </footer>
  </body>
</html>
