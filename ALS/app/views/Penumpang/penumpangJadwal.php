<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hasil Pencarian Jadwal - PT. Antar Lintas Sumatera</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="/gantiALS/ALS/public/css/penumpang.css" />
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/penumpangTambahan.css" />
  </head>
  <body>
    <div class="BagianPalingAtasHalaman">
      <div class="WadahPembatasLebarKonten">
        <div>
          <i class="fa-solid fa-headset"></i>
          Layanan Pelanggan 24 Jam: <strong>0821-3825-9191</strong>
        </div>
        <div class="GrupLinkNavigasiKecil">
          <a href="#">
            <i class="fa-solid fa-mobile-screen"></i> Unduh Aplikasi
            <span class="BadgeBaru">BARU</span>
          </a>
          <a href="#">IDR - Rupiah</a>
          <a href="#">Pusat Bantuan</a>
          <a href="#">Cek Pesanan Saya</a>
        </div>
      </div>
    </div>

    <nav class="BatangNavigasiUtama">
      <div class="WadahPembatasLebarKonten">
        <div class="ElemenLogoPerusahaan">
          <img src="<?= BASEURL; ?>/gambar/logo als.jpg" alt="Logo ALS" width="58" height="58" />
          <div class="WadahTeksLogo">
            <h1>ALS</h1>
            <p>Bekerjasama Dan Sama-Sama Bekerja</p>
          </div>
        </div>
        <div class="DaftarMenuNavigasi">
          <a href="<?= BASEURL; ?>/index.php?page=home">Tiket Bus</a>
          <a href="<?= BASEURL; ?>/index.php?page=home#kelas">Kelas Armada</a>
          <a href="<?= BASEURL; ?>/index.php?page=home#agen">Jaringan Agen</a>
        </div>
        <div class="grup-tombol-pendaftaran">
          <a href="#" class="TombolTipeGarisTepi">Daftar Akun</a>
          <a href="#" class="TombolTipeWarnaBiru">Masuk</a>
        </div>
      </div>
    </nav>

    <main class="WadahPembatasLebarKonten KontenHalaman">
        <div class="KepalaSeksiTengah">
            <h2>Hasil Pencarian Jadwal Bus</h2>
            <p>Menampilkan jadwal untuk rute <strong><?= htmlspecialchars($_GET['asal'] ?? 'Semua') ?> &rarr; <?= htmlspecialchars($_GET['tujuan'] ?? 'Semua') ?></strong> pada tanggal <strong><?= !empty($_GET['tanggal']) ? date('d M Y', strtotime($_GET['tanggal'])) : 'Semua Tanggal' ?></strong>.</p>
            <a href="<?= BASEURL; ?>/index.php?page=home" class="TombolUbahPencarian">
                <i class="fa-solid fa-pen-to-square"></i> Ubah Pencarian
            </a>
        </div>

        <div class="KontenUtamaHasil">
            <aside class="AreaFilterPencarian">
                <div class="KartuFilter">
                    <h4><i class="fa-solid fa-filter"></i> Filter Hasil</h4>
                </div>

                <div class="KartuFilter">
                    <h4>Kelas Armada</h4>
                    <div class="GrupPilihanFilter">
                        <label><input type="checkbox" checked> Super Executive</label>
                        <label><input type="checkbox" checked> Executive Class</label>
                        <label><input type="checkbox"> Patas AC</label>
                        <label><input type="checkbox"> Ekonomi AC</label>
                    </div>
                </div>

                <div class="KartuFilter">
                    <h4>Waktu Keberangkatan</h4>
                    <div class="GrupPilihanFilter">
                        <label><input type="checkbox"> Pagi (05:00 - 11:59)</label>
                        <label><input type="checkbox" checked> Siang (12:00 - 17:59)</label>
                        <label><input type="checkbox"> Malam (18:00 - 04:59)</label>
                    </div>
                </div>

                <button type="button" class="TombolTerapkanFilter">Terapkan Filter</button>
            </aside>

            <section class="AreaHasilPencarian">
                <?php
                $rows = $jadwals->fetchAll(PDO::FETCH_ASSOC);
                if (empty($rows)):
                ?>
                <div class="KartuHasilJadwal">
                    <p class="PesanTidakTersedia">Maaf, tidak ada jadwal yang tersedia untuk rute dan tanggal tersebut.</p>
                </div>
                <?php else: ?>
                <?php foreach ($rows as $j): ?>
                <div class="KartuHasilJadwal">
                    <div class="InfoUtamaJadwal">
                        <div class="WaktuKeberangkatan">
                            <p class="jam"><?= substr($j['jam_berangkat'], 0, 5) ?></p>
                            <p class="lokasi"><?= htmlspecialchars($j['asal']) ?></p>
                        </div>
                        <div class="DurasiPerjalanan">
                            <i class="fa-solid fa-arrow-right-long"></i>
                            <p>Kursi: <?= $j['kursi_tersedia'] ?></p>
                        </div>
                        <div class="WaktuKedatangan">
                            <p class="jam"><?= substr($j['jam_tiba'], 0, 5) ?></p>
                            <p class="lokasi"><?= htmlspecialchars($j['tujuan']) ?></p>
                        </div>
                    </div>
                    <div class="InfoKelasArmada InfoKolom">
                        <i class="fa-solid fa-bus"></i>
                        <div>
                            <p class="NamaKelas">Reguler</p>
                            <p class="FasilitasSingkat">Sesuai Ketersediaan</p>
                        </div>
                    </div>
                    <div class="InfoHargaDanAksi InfoKolom">
                        <div class="Harga">
                            <p>Harga per kursi</p>
                            <p class="HargaAngka">Rp <?= number_format($j['harga'], 0, ',', '.') ?></p>
                        </div>
                        <?php if ($j['kursi_tersedia'] > 0): ?>
                        <a href="<?= BASEURL; ?>/index.php?page=pemesanan&id=<?= $j['id'] ?>" class="TombolTipeWarnaBiru">Pilih Kursi</a>
                        <?php else: ?>
                        <button disabled class="TombolTipeWarnaBiru TombolPenuh">Penuh</button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <footer class="ElemenFooterPalingBawah">
      <div class="WadahPembatasLebarKonten">
        <div class="TataLetakGridFooter">
          <div class="WadahBrandDiFooter">
            <h2>ALS Official</h2>
            <p class="TeksDeskripsiFooter">
              Portal resmi sistem informasi dan pemesanan tiket PT. Antar Lintas
              Sumatera. Kami berkomitmen menyediakan layanan transportasi darat
              yang aman dan andal.
            </p>
          </div>
          <div class="KolomInformasiFooter">
            <h4>PRODUK & LAYANAN</h4>
            <ul>
              <li><a href="<?= BASEURL; ?>/index.php?page=home#kelas">Super Executive</a></li>
              <li><a href="<?= BASEURL; ?>/index.php?page=home#kelas">Executive Class</a></li>
              <li><a href="<?= BASEURL; ?>/index.php?page=home#kelas">Patas AC</a></li>
              <li><a href="<?= BASEURL; ?>/index.php?page=home#kelas">Ekonomi</a></li>
            </ul>
          </div>
          <div class="KolomInformasiFooter">
            <h4>PUSAT INFORMASI</h4>
            <ul>
              <li><a href="<?= BASEURL; ?>/index.php?page=pemesanan">Panduan Pemesanan</a></li>
              <li><a href="<?= BASEURL; ?>/index.php?page=pembayaran">Metode Pembayaran</a></li>
            </ul>
          </div>
          <div class="KolomInformasiFooter">
            <h4>KEAMANAN TRANSAKSI</h4>
            <div class="IkonPembayaran">
              <i class="fa-brands fa-cc-visa"></i><i class="fa-brands fa-cc-mastercard"></i>
            </div>
          </div>
        </div>
        <div class="WadahHakCiptaBawah">
          Copyright &copy; 2026 PT. Antar Lintas Sumatera.
        </div>
      </div>
    </footer>
  </body>
</html>