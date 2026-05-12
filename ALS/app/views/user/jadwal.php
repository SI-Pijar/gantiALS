<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hasil Pencarian Jadwal - PT. Antar Lintas Sumatera</title>
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
        <div class="KepalaSeksiTengah">
            <h2>Hasil Pencarian Jadwal Bus</h2>
            <p>Menampilkan jadwal untuk rute <strong>Medan &rarr; Jakarta</strong> pada tanggal <strong>28 April 2026</strong>.</p>
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
                <div class="KartuHasilJadwal">
                    <div class="InfoUtamaJadwal">
                        <div class="WaktuKeberangkatan">
                            <p class="jam">14:00</p>
                            <p class="lokasi">Terminal Amplas</p>
                        </div>
                        <div class="DurasiPerjalanan">
                            <i class="fa-solid fa-arrow-right-long"></i>
                            <p>Est. 52 Jam</p>
                        </div>
                        <div class="WaktuKedatangan">
                            <p class="jam">18:00 <span class="InfoHariPlus">(+2)</span></p>
                            <p class="lokasi">Terminal Pulo Gebang</p>
                        </div>
                    </div>
                    <div class="InfoKelasArmada InfoKolom">
                        <i class="fa-solid fa-crown"></i>
                        <div>
                            <p class="NamaKelas">Super Executive</p>
                            <p class="FasilitasSingkat">Kursi 2-1, AC, Toilet</p>
                        </div>
                    </div>
                    <div class="InfoHargaDanAksi InfoKolom">
                        <div class="Harga">
                            <p>Harga mulai dari</p>
                            <p class="HargaAngka">Rp 750.000</p>
                        </div>
                        <a href="<?= BASEURL; ?>/index.php?page=pemesanan" class="TombolTipeWarnaBiru">Pilih Kursi</a>
                    </div>
                </div>

                <div class="KartuHasilJadwal">
                    <div class="InfoUtamaJadwal">
                        <div class="WaktuKeberangkatan">
                            <p class="jam">15:30</p>
                            <p class="lokasi">Terminal Amplas</p>
                        </div>
                        <div class="DurasiPerjalanan">
                            <i class="fa-solid fa-arrow-right-long"></i>
                            <p>Est. 54 Jam</p>
                        </div>
                        <div class="WaktuKedatangan">
                            <p class="jam">21:30 <span class="InfoHariPlus">(+2)</span></p>
                            <p class="lokasi">Terminal Pulo Gebang</p>
                        </div>
                    </div>
                    <div class="InfoKelasArmada InfoKolom">
                        <i class="fa-solid fa-gem"></i>
                        <div>
                            <p class="NamaKelas">Executive Class</p>
                            <p class="FasilitasSingkat">Kursi 2-2, AC, Toilet</p>
                        </div>
                    </div>
                    <div class="InfoHargaDanAksi InfoKolom">
                        <div class="Harga">
                            <p>Harga mulai dari</p>
                            <p class="HargaAngka">Rp 680.000</p>
                        </div>
                        <a href="<?= BASEURL; ?>/index.php?page=pemesanan" class="TombolTipeWarnaBiru">Pilih Kursi</a>
                    </div>
                </div>
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