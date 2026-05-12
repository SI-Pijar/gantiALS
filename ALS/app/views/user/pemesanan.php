<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pilih Kursi & Detail Penumpang - PT. Antar Lintas Sumatera</title>
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
        <div class="KontenUtamaPemesanan">
            <div class="AreaPilihKursi">
                <div class="KartuDenahKursi">
                    <h3>Pilih Kursi Anda</h3>
                    <div class="DenahKursi">
                        <div class="kursi tersedia" data-nomor="1A">1A</div>
                        <div class="kursi tersedia" data-nomor="1B">1B</div>
                        <div class="gang"></div>
                        <div class="kursi tersedia" data-nomor="1C">1C</div>
                        <div class="kursi terisi" data-nomor="1D">1D</div>
                        <div class="kursi tersedia" data-nomor="2A">2A</div>
                        <div class="kursi tersedia" data-nomor="2B">2B</div>
                        <div class="gang"></div>
                        <div class="kursi tersedia" data-nomor="2C">2C</div>
                        <div class="kursi tersedia" data-nomor="2D">2D</div>
                        <div class="kursi tersedia" data-nomor="3A">3A</div>
                        <div class="kursi terisi" data-nomor="3B">3B</div>
                        <div class="gang"></div>
                        <div class="kursi tersedia" data-nomor="3C">3C</div>
                        <div class="kursi tersedia" data-nomor="3D">3D</div>
                        <div class="kursi terpilih" data-nomor="4A">4A</div>
                        <div class="kursi tersedia" data-nomor="4B">4B</div>
                        <div class="gang"></div>
                        <div class="kursi tersedia" data-nomor="4C">4C</div>
                        <div class="kursi terisi" data-nomor="4D">4D</div>
                        <div class="kursi tersedia" data-nomor="5A">5A</div>
                        <div class="kursi tersedia" data-nomor="5B">5B</div>
                        <div class="gang"></div>
                        <div class="kursi terpilih" data-nomor="5C">5C</div>
                        <div class="kursi tersedia" data-nomor="5D">5D</div>
                        <div class="kursi tersedia" data-nomor="6A">6A</div>
                        <div class="kursi tersedia" data-nomor="6B">6B</div>
                        <div class="gang"></div>
                        <div class="kursi tersedia" data-nomor="6C">6C</div>
                        <div class="kursi tersedia" data-nomor="6D">6D</div>
                    </div>
                    <div class="LegendaKursi">
                        <div class="ItemLegenda"><span class="KotakWarna tersedia"></span> Tersedia</div>
                        <div class="ItemLegenda"><span class="KotakWarna terpilih"></span> Pilihan Anda</div>
                        <div class="ItemLegenda"><span class="KotakWarna terisi"></span> Terisi</div> 
                    </div>
                </div>

                <div class="FormDetailPenumpang">
                    <form action="<?= BASEURL; ?>/index.php?page=pembayaran" method="POST">
                        <h3>Detail Penumpang</h3>

                        <div class="GrupInputForm">
                            <label for="nama-lengkap">Nama Lengkap (sesuai KTP)</label>
                            <input type="text" id="nama-lengkap" name="nama-lengkap" placeholder="Masukkan nama lengkap Anda" required>
                        </div>

                        <div class="GrupInputForm">
                            <label for="nomor-telepon">Nomor Telepon</label>
                            <input type="tel" id="nomor-telepon" name="nomor-telepon" placeholder="Contoh: 081234567890" required>
                        </div>

                        <div class="GrupInputForm">
                            <label for="email">Alamat Email</label>
                            <input type="email" id="email" name="email" placeholder="Untuk pengiriman e-tiket" required>
                        </div>
                        <button type="submit" class="TombolLanjutBayar" style="border:none;">Lanjutkan ke Pembayaran</button>
                    </form>
                </div>
            </div>

            <aside class="AreaRingkasanPesanan">
                <div class="KartuRingkasanPesanan">
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
</html>