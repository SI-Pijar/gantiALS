<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Metode Pembayaran - PT. Antar Lintas Sumatera</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/penumpang.css" />
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
        <div class="KontenUtamaPembayaran">
            <div class="AreaMetodePembayaran">
                <h3>Pilih Metode Pembayaran</h3>

                <div class="KartuPilihanPembayaran aktif" data-metode="bca">
                    <div class="LogoMetode"><i class="fa-solid fa-building-columns"></i></div>
                    <div class="InfoMetode">
                        <h4>Virtual Account BCA</h4>
                        <p>Bayar dengan transfer dari ATM atau m-Banking BCA.</p>
                    </div>
                    <i class="fa-solid fa-chevron-right PanahPilih"></i>
                </div>

                <div class="KartuPilihanPembayaran" data-metode="mandiri">
                    <div class="LogoMetode"><i class="fa-solid fa-building-columns"></i></div>
                    <div class="InfoMetode">
                        <h4>Virtual Account Mandiri</h4>
                        <p>Bayar dengan transfer dari ATM atau Livin' by Mandiri.</p>
                    </div>
                    <i class="fa-solid fa-chevron-right PanahPilih"></i>
                </div>
            </div>

            <aside class="AreaRingkasanPesanan">
                <div class="KartuRingkasanPesanan">
                    <div class="TimerPembayaran">
                        <i class="fa-regular fa-clock"></i>
                        Selesaikan pembayaran dalam <strong>23:59:10</strong>
                    </div>
                    <h4>Ringkasan Pesanan</h4>

                    <div class="DetailPerjalanan">
                        <p class="rute">Medan &rarr; Jakarta</p>
                        <p class="tanggal-waktu">28 April 2026, 14:00 WIB</p>
                        <p class="NamaArmada"><i class="fa-solid fa-crown"></i> Super Executive</p>
                    </div>

                    <div class="GarisPemisahRingkasan"></div>

                    <div class="DetailHarga">
                        <p>Kursi yang Dipilih (2)</p>
                        <div class="DaftarNomorKursi">4A, 5C</div>
                    </div>

                    <div class="GarisPemisahRingkasan"></div>

                    <div class="TotalPembayaran">
                        <p>Total Harga</p>
                        <p class="HargaTotal">Rp 1.500.000</p>
                    </div>

                    <a href="<?= BASEURL; ?>/index.php?page=home" class="TombolLanjutBayar">BAYAR SEKARANG</a>
                </div>
            </aside>
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
</html