<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Metode Pembayaran - PT. Antar Lintas Sumatera</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link rel="stylesheet" href="<?= BASEURL; ?>/ALS/public/css/penumpang.css" />
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
        <div class="payment-layout">
            <div class="payment-method">
                <form action="<?= BASEURL; ?>/index.php?page=proses_pembayaran" method="POST" id="formBayar">
                <input type="hidden" name="id_pemesanan" value="<?= $pesanan['id'] ?>">
                <input type="hidden" name="metode_pembayaran" id="metodePembayaran" value="bca">
                <h3>Pilih Metode Pembayaran</h3>

                <div class="payment-card aktif" data-metode="bca">
                    <div class="payment-logo"><i class="fa-solid fa-building-columns"></i></div>
                    <div class="payment-info">
                        <h4>Virtual Account BCA</h4>
                        <p>Bayar dengan transfer dari ATM atau m-Banking BCA.</p>
                    </div>
                    <i class="fa-solid fa-chevron-right panah-pilih"></i>
                </div>

                <div class="payment-card" data-metode="mandiri">
                    <div class="payment-logo"><i class="fa-solid fa-building-columns"></i></div>
                    <div class="payment-info">
                        <h4>Virtual Account Mandiri</h4>
                        <p>Bayar dengan transfer dari ATM atau Livin' by Mandiri.</p>
                    </div>
                    <i class="fa-solid fa-chevron-right panah-pilih"></i>
                </div>
            </div>

            <aside class="summary-panel">
                <div class="summary-card">
                    <div class="payment-timer">
                        <i class="fa-regular fa-clock"></i>
                        Selesaikan pembayaran dalam <strong>23:59:10</strong>
                    </div>
                    <h4>Ringkasan Pesanan</h4>

                    <div class="trip-info">
                        <p class="rute"><?= htmlspecialchars($pesanan['asal']) ?> &rarr; <?= htmlspecialchars($pesanan['tujuan']) ?></p>
                        <p class="tanggal-waktu"><?= date('d M Y', strtotime($pesanan['tanggal'] ?? 'now')) ?>, <?= isset($pesanan['jam_berangkat']) ? substr($pesanan['jam_berangkat'], 0, 5) : '-' ?> WIB</p>
                        <p class="bus-info"><i class="fa-solid fa-bus"></i> Reguler</p>
                    </div>

                    <div class="divider"></div>

                    <div class="price-detail">
                        <p>Kursi yang Dipilih (<?= $pesanan['jumlah'] ?? 0 ?>)</p>
                        <div class="seat-list"><?= htmlspecialchars($pesanan['kursi_dipesan']) ?></div>
                    </div>

                    <div class="divider"></div>

                    <div class="total-bayar">
                        <p>Total Harga</p>
                        <p class="total-harga">Rp <?= number_format($pesanan['total_harga'], 0, ',', '.') ?></p>
                    </div>

                    <button type="submit" class="btn-bayar btn-full-click">BAYAR SEKARANG</button>
                </div>
                </form>
            </aside>
        </div>
    </main>

    <script>
        const kartuMetode = document.querySelectorAll('.payment-card');
        const inputMetode = document.getElementById('metodePembayaran');

        kartuMetode.forEach(kartu => {
            kartu.addEventListener('click', () => {
                kartuMetode.forEach(k => k.classList.remove('aktif'));
                kartu.classList.add('aktif');
                inputMetode.value = kartu.getAttribute('data-metode');
            });
        });
    </script>
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
