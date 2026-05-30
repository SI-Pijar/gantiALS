<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Informasi Pemesanan Tiket - PT. Antar Lintas Sumatera</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
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
          <a href="<?= BASEURL; ?>/index.php?page=home" class="menu-aktif">Tiket Bus</a>
          <a href="#kelas">Kelas Armada</a>
          <a href="#agen">Jaringan Agen</a>
        </div>

        <div class="nav-auth">
          <?php if (isset($_SESSION['penumpang_id'])): ?>
            <a href="<?= BASEURL; ?>/index.php?page=riwayat" class="btn-outline">Pesanan Saya</a>
            <a href="<?= BASEURL; ?>/index.php?page=profil" class="btn-outline">Profil</a>
            <a href="<?= BASEURL; ?>/index.php?controller=auth&action=logout" class="btn-biru">Keluar</a>
          <?php else: ?>
            <a href="<?= BASEURL; ?>/index.php?controller=auth&action=login" class="btn-outline">Masuk</a>
            <a href="<?= BASEURL; ?>/index.php?controller=auth&action=register" class="btn-biru">Daftar</a>
          <?php endif; ?>
        </div>
      </div>
    </nav>

    <header class="hero hero-bg">
      <div class="container">
        <div class="hero-text">
          <h2>Jelajahi Nusantara dengan Nyaman</h2>
          <p>
            Nikmati kemudahan pesan tiket bus PO ALS secara daring. Tersedia
            berbagai pilihan kelas mulai dari Ekonomi hingga Super Executive
            untuk perjalanan lintas pulau Anda.
          </p>
        </div>
      </div>
    </header>

    <main>
      <div class="container">
        <div class="search-box">
          <div class="search-tab">
            <i class="fa-regular fa-calendar-check"></i> Pencarian Tiket Bus
          </div>

          <div class="search-form">
            <form action="<?= BASEURL; ?>/index.php" method="GET" class="form-layout">
              <input type="hidden" name="page" value="jadwal">
              <div class="form-row-1">
                <div class="input-oval">
                  <div class="input-icon">
                    <i class="fa-solid fa-location-dot"></i>
                  </div>

                  <div class="input-text">
                    <label class="input-label">Kota Asal</label>
                    <select name="asal" class="input-main" required>
                      <option value="" disabled selected>
                        Pilih Kota Keberangkatan
                      </option>
                      <?php foreach($asals as $a): ?>
                        <option value="<?= htmlspecialchars($a['asal']) ?>"><?= htmlspecialchars($a['asal']) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <i class="fa-solid fa-chevron-down icon-panah"></i>

                </div>

                <div class="input-oval">
                  <div class="input-icon">
                    <i class="fa-solid fa-location-crosshairs"></i>
                  </div>

                  <div class="input-text">
                    <label class="input-label">Kota Tujuan</label>
                    <select name="tujuan" class="input-main" required>
                      <option value="" disabled selected>
                        Pilih Destinasi Tujuan
                      </option>
                      <?php foreach($tujuans as $t): ?>
                        <option value="<?= htmlspecialchars($t['tujuan']) ?>"><?= htmlspecialchars($t['tujuan']) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <i class="fa-solid fa-chevron-down icon-panah"></i>

                </div>
              </div>

              <div class="form-row-2">
                <div class="input-oval">
                  <div class="input-icon">
                    <i class="fa-regular fa-calendar-days"></i>
                  </div>
                  <div class="input-text">
                    <label class="input-label">Tanggal Pergi</label>
                    <input type="date" name="tanggal" class="input-main" />
                  </div>
                </div>

                <div class="input-oval">
                  <div class="input-icon">
                    <i class="fa-solid fa-users"></i>
                  </div>
                  <div class="input-text">
                    <label class="input-label">Penumpang</label>
                    <input type="number" name="penumpang" min="1" max="4" value="1" class="input-main" />
                  </div>
                </div>

                <div class="input-oval">
                  <div class="input-icon">
                    <i class="fa-solid fa-bus"></i>
                  </div>
                  <div class="input-text">
                    <label class="input-label">Kelas Armada</label>
                    <select name="kelas" class="input-main">
                      <option value="">Semua Kelas</option>
                      <option value="Super Executive">Super Executive</option>
                      <option value="Executive Class">Executive Class</option>
                      <option value="Patas AC">Patas AC</option>
                      <option value="Ekonomi AC">Ekonomi AC</option>
                    </select>
                  </div>
                  <i class="fa-solid fa-chevron-down icon-panah"></i>
                </div>

                <button type="submit" class="btn-cari">
                  <i class="fa-solid fa-magnifying-glass"></i> CARI JADWAL
                </button>
              </div>
            </form>
          </div>
        </div>

        <section id="kelas">
          <div class="section-header">
            <h2>Layanan Kelas Armada ALS</h2>
            <p>
              Kami menghadirkan berbagai pilihan standar pelayanan untuk kenyamanan
              perjalanan jarak jauh Anda.
            </p>
          </div>

          <div class="armada-grid">
            <div class="armada-card">
              <div class="armada-icon">
                <i class="fa-solid fa-crown"></i>
              </div>
              <h4 class="armada-title">Super Executive</h4>
              <p class="armada-desc">
                Konfigurasi kursi 2-1 ekstra lega, fasilitas AC, Toilet, Bantal,
                Selimut, Leg Rest, & Snack perjalanan.
              </p>
            </div>

            <div class="armada-card">
              <div class="armada-icon">
                <i class="fa-solid fa-gem"></i>
              </div>
              <h4 class="armada-title">Executive Class</h4>
              <p class="armada-desc">
                Susunan kursi 2-2 yang empuk, AC dingin, Toilet bersih, Reclining
                Seat, serta hiburan Audio/Video.
              </p>
            </div>

            <div class="armada-card">
              <div class="armada-icon">
                <i class="fa-solid fa-snowflake"></i>
              </div>
              <h4 class="armada-title">Patas AC</h4>
              <p class="armada-desc">
                Kursi nyaman 2-2, penyejuk udara sentral, tanpa toilet dalam bus
                (berhenti di tempat istirahat resmi).
              </p>
            </div>

            <div class="armada-card">
              <div class="armada-icon">
                <i class="fa-solid fa-wind"></i>
              </div>
              <h4 class="armada-title">Ekonomi AC</h4>
              <p class="armada-desc">
                Pilihan armada hemat yang sudah dilengkapi penyejuk udara (AC)
                dengan susunan kursi baris 2-2 atau 2-3.
              </p>
            </div>

            <div class="armada-card">
              <div class="armada-icon">
                <i class="fa-solid fa-bus-simple"></i>
              </div>
              <h4 class="armada-title">Ekonomi Non-AC</h4>
              <p class="armada-desc">
                Tarif paling kompetitif dan terjangkau dengan sirkulasi udara alami
                untuk rute jarak menengah.
              </p>
            </div>
          </div>
        </section>

        <section id="agen">
          <div class="agen-header">
            <h2>Jaringan Agen Resmi</h2>
            <p>
              PT Antar Lintas Sumatera mengelola jaringan agen perwakilan yang
              tersebar luas melayani rute terpercaya dari Sumatera hingga Bali.
            </p>
          </div>

          <div class="agen-grid">
            <div class="agen-card">
              <div class="agen-info">
                <span class="agen-label">WILAYAH</span>
                <h4 class="agen-nama">Pulau Sumatera</h4>
                <div class="divider-orange"></div>
                <p class="agen-count">35 Lokasi Agen</p>
              </div>
              <img src="<?= BASEURL; ?>/ALS/public/gambar/foto1.jpg" class="agen-img" />
            </div>

            <div class="agen-card">
              <div class="agen-info">
                <span class="agen-label">WILAYAH</span>
                <h4 class="agen-nama">Pulau Jawa</h4>
                <div class="divider-orange"></div>
                <p class="agen-count">22 Lokasi Agen</p>
              </div>
              <img src="<?= BASEURL; ?>/ALS/public/gambar/foto2.jpg" class="agen-img" />
            </div>

            <div class="agen-card">
              <div class="agen-info">
                <span class="agen-label">WILAYAH</span>
                <h4 class="agen-nama">Jabodetabek</h4>
                <div class="divider-orange"></div>
                <p class="agen-count">15 Lokasi Agen</p>
              </div>
              <img src="<?= BASEURL; ?>/ALS/public/gambar/foto3.jpg" class="agen-img" />
            </div>

            <div class="agen-card">
              <div class="agen-info">
                <span class="agen-label">WILAYAH</span>
                <h4 class="agen-nama">Pulau Bali</h4>
                <div class="divider-orange"></div>
                <p class="agen-count">1 Lokasi Agen</p>
              </div>
              <img src="<?= BASEURL; ?>/ALS/public/gambar/foto4.jpg" class="agen-img" />
            </div>
          </div>
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
              <li><a href="#kelas">Super Executive</a></li>
              <li><a href="#kelas">Executive Class</a></li>
              <li><a href="#kelas">Patas AC</a></li>
              <li><a href="#kelas">Ekonomi</a></li>
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
