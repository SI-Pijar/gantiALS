<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pilih Kursi & Detail Penumpang - PT. Antar Lintas Sumatera</title>
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
        <div class="booking-layout">
            <div class="seat-panel">
                <form action="<?= BASEURL; ?>/index.php?page=proses_pemesanan" method="POST" id="formPemesanan">
                <input type="hidden" name="id_jadwal" value="<?= $jadwal['id'] ?>">
                <input type="hidden" name="kursi_dipesan" id="inputKursiDipesan" value="">
                <?php
                $SEAT_LAYOUTS = [
                    'Super Executive' => ['left'=>['A','B'],'right'=>['C'],'total'=>22,'full_rows'=>6],
                    'Executive Class' => ['left'=>['A','B'],'right'=>['C','D'],'total'=>30,'full_rows'=>7],
                    'Patas AC' => ['left'=>['A','B'],'right'=>['C','D'],'total'=>38,'full_rows'=>9],
                    'Ekonomi AC' => ['left'=>['A','B'],'right'=>['C','D'],'total'=>44,'full_rows'=>11],
                    'Ekonomi Non-AC' => ['left'=>['A','B'],'right'=>['C','D','E'],'total'=>50,'full_rows'=>10],
                ];
                $kelas = $jadwal['kelas_bus'] ?? 'Ekonomi AC';
                $layout = $SEAT_LAYOUTS[$kelas] ?? $SEAT_LAYOUTS['Ekonomi AC'];
                $leftCols = $layout['left'];
                $rightCols = $layout['right'];
                $fullRows = $layout['full_rows'];
                $totalSeats = $layout['total'];
                $seatsPerRow = count($leftCols) + count($rightCols);
                $partialSeats = $totalSeats - $fullRows * $seatsPerRow;
                $partialRows = $partialSeats > 0 ? (int)ceil($partialSeats / count($leftCols)) : 0;
                $totalRows = $fullRows + $partialRows;
                ?>
                <div class="seat-card">
                    <h3>Pilih Kursi Anda <small class="sub-judul">&mdash; <?= htmlspecialchars($kelas) ?></small></h3>
                    <?php $layoutClass = 'seat-layout-' . count($leftCols) . '-' . count($rightCols); ?>
                    <div class="seat-grid <?= $layoutClass ?>" id="seat-grid">
                        <?php
                        $seatCount = 0;
                        for ($row = 1; $row <= $totalRows; $row++):
                            $isPartial = $row > $fullRows;
                            foreach ($leftCols as $col):
                                if ($seatCount >= $totalSeats) break;
                                $no = "$row$col";
                                $st = in_array($no, $kursiTerisi) ? 'terisi' : 'tersedia';
                                echo "<div class=\"kursi $st\" data-nomor=\"$no\">$no</div>";
                                $seatCount++;
                            endforeach;
                            echo '<div class="gang"></div>';
                            if ($isPartial):
                                foreach ($rightCols as $col):
                                    echo '<div class="kursi-kosong"></div>';
                                endforeach;
                            else:
                                foreach ($rightCols as $col):
                                    $no = "$row$col";
                                    $st = in_array($no, $kursiTerisi) ? 'terisi' : 'tersedia';
                                    echo "<div class=\"kursi $st\" data-nomor=\"$no\">$no</div>";
                                    $seatCount++;
                                endforeach;
                            endif;
                        endfor;
                        ?>
                    </div>
                    <div class="seat-legend">
                        <div class="legend-item"><span class="color-dot tersedia"></span> Tersedia</div>
                        <div class="legend-item"><span class="color-dot terpilih"></span> Pilihan Anda</div>
                        <div class="legend-item"><span class="color-dot terisi"></span> Terisi</div>
                    </div>
                </div>

                <div class="passenger-form">
                        <h3>Detail Penumpang</h3>

                        <div class="input-group">
                            <label for="nama_lengkap">Nama Lengkap (sesuai KTP)</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap Anda" value="<?= htmlspecialchars($penumpangLogin['nama_lengkap'] ?? '') ?>" required>
                        </div>

                        <div class="input-group">
                            <label for="nomor_telepon">Nomor Telepon</label>
                            <input type="tel" id="nomor_telepon" name="nomor_telepon" placeholder="Contoh: 081234567890" required>
                        </div>

                        <div class="input-group">
                            <label for="email">Alamat Email</label>
                            <input type="email" id="email" name="email" placeholder="Untuk pengiriman e-tiket" value="<?= htmlspecialchars($penumpangLogin['email'] ?? '') ?>" required>
                        </div>
                        <button type="submit" class="btn-bayar btn-full">Lanjutkan ke Pembayaran</button>
                </div>
                </form>
            </div>

            <aside class="summary-panel">
                <div class="summary-card">
                    <h4>Ringkasan Pesanan</h4>
                    <div class="trip-info">
                        <p class="rute"><?= htmlspecialchars($jadwal['asal']) ?> &rarr; <?= htmlspecialchars($jadwal['tujuan']) ?></p>
                        <p class="tanggal-waktu"><?= date('d M Y', strtotime($jadwal['tanggal'] ?? 'now')) ?>, <?= isset($jadwal['jam_berangkat']) ? substr($jadwal['jam_berangkat'], 0, 5) : '-' ?> WIB</p>
                        <p class="bus-info"><i class="fa-solid fa-bus"></i> <?= htmlspecialchars($jadwal['kelas_bus'] ?? 'Reguler') ?></p>
                    </div>

                    <div class="divider"></div>

                    <div class="price-detail">
                        <p>Kursi yang Dipilih (<span id="jumlahKursiText">0</span>)</p>
                        <div class="seat-list" id="daftarNomorKursi">-</div>
                    </div>

                    <div class="divider"></div>

                    <div class="total-bayar">
                        <p>Total Harga</p>
                        <p class="total-harga" id="hargaTotalText">Rp 0</p>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <script>
        const kursis = document.querySelectorAll('.kursi.tersedia');
        const inputKursi = document.getElementById('inputKursiDipesan');
        const listKursiElem = document.getElementById('daftarNomorKursi');
        const jumlahKursiElem = document.getElementById('jumlahKursiText');
        const totalHargaElem = document.getElementById('hargaTotalText');
        const hargaPerKursi = <?= $jadwal['harga'] ?>;
        let kursiTerpilih = [];

        kursis.forEach(kursi => {
            kursi.addEventListener('click', () => {
                const nomor = kursi.getAttribute('data-nomor');
                if (kursi.classList.contains('terpilih')) {
                    kursi.classList.remove('terpilih');
                    kursiTerpilih = kursiTerpilih.filter(k => k !== nomor);
                } else {
                    kursi.classList.add('terpilih');
                    kursiTerpilih.push(nomor);
                }
                updateRingkasan();
            });
        });

        function updateRingkasan() {
            inputKursi.value = kursiTerpilih.join(',');
            listKursiElem.textContent = kursiTerpilih.length > 0 ? kursiTerpilih.join(', ') : '-';
            jumlahKursiElem.textContent = kursiTerpilih.length;

            const total = kursiTerpilih.length * hargaPerKursi;
            totalHargaElem.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        document.getElementById('formPemesanan').addEventListener('submit', function(e) {
            if (kursiTerpilih.length === 0) {
                e.preventDefault();
                alert('Silakan pilih minimal 1 kursi sebelum melanjutkan.');
            }
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
