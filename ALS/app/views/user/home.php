<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Informasi Pemesanan Tiket - PT. Antar Lintas Sumatera</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
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
          <a href="<?= BASEURL; ?>/index.php?page=home" class="MenuSaatIni">Tiket Bus</a>
          <a href="#kelas">Kelas Armada</a>
          <a href="#agen">Jaringan Agen</a>
        </div>

        <div class="grup-tombol-pendaftaran">
          <a href="#" class="TombolTipeGarisTepi">Daftar Akun</a>
          <a href="#" class="TombolTipeWarnaBiru">Masuk</a>
        </div>
      </div>
    </nav>

    <header class="AreaBannerHeroUtama" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.3)), url('<?= BASEURL; ?>/gambar/foto5.jpg');">
      <div class="WadahPembatasLebarKonten">
        <div class="WadahTeksPromosiHero">
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
      <div class="WadahPembatasLebarKonten">
        <div class="AreaKotakPencarianInteraktif">
          <div class="LabelIdentitasTabPencarian">
            <i class="fa-regular fa-calendar-check"></i> Pencarian Tiket Bus
          </div>

          <div class="BingkaiPutihFormulirPencarian">
            <form action="<?= BASEURL; ?>/index.php" method="GET" class="TataLetakFormulirDuaBaris">
              <input type="hidden" name="page" value="jadwal">
              <div class="BarisFormulirKe1">
                <div class="DesainInputBentukLonjong">
                  <div class="WadahIkonDalamInput">
                    <i class="fa-solid fa-location-dot"></i>
                  </div>

                  <div class="WadahTeksDalamLonjong">
                    <label class="LabelKecilDiAtasInput">Kota Asal</label>
                    <select name="asal" class="ElemenInputFormUtama" required>
                      <option value="" disabled selected>
                        Pilih Kota Keberangkatan
                      </option>
                      <option value="Medan">Medan</option>
                      <option value="Padang">Padang</option>
                      <option value="Banda Aceh">Banda Aceh</option>
                      <option value="Pekanbaru">Pekanbaru</option>
                      <option value="Jakarta">Jakarta</option>
                    </select>
                  </div>

                  <i class="fa-solid fa-chevron-down IkonPanahKecil"></i>

                </div>

                <div class="DesainInputBentukLonjong">
                  <div class="WadahIkonDalamInput">
                    <i class="fa-solid fa-location-crosshairs"></i>
                  </div>

                  <div class="WadahTeksDalamLonjong">
                    <label class="LabelKecilDiAtasInput">Kota Tujuan</label>
                    <select name="tujuan" class="ElemenInputFormUtama" required>
                      <option value="" disabled selected>
                        Pilih Destinasi Tujuan
                      </option>
                      <option value="Jember">Jember</option>
                      <option value="Malang">Malang</option>
                      <option value="Yogyakarta">Yogyakarta</option>
                      <option value="Jakarta">Jakarta</option>
                      <option value="Bandung">Bandung</option>
                    </select>
                  </div>

                  <i class="fa-solid fa-chevron-down IkonPanahKecil"></i>

                </div>
              </div>
              
              <div class="BarisFormulirKe2">
                <div class="DesainInputBentukLonjong">
                  <div class="WadahIkonDalamInput">
                    <i class="fa-regular fa-calendar-days"></i>
                  </div>
                  <div class="WadahTeksDalamLonjong">
                    <label class="LabelKecilDiAtasInput">Tanggal Pergi</label>
                    <input type="date" name="tanggal" class="ElemenInputFormUtama" value="2026-04-28" required />
                  </div>
                </div>

                <div class="DesainInputBentukLonjong">
                  <div class="WadahIkonDalamInput">
                    <i class="fa-solid fa-chair"></i>
                  </div>
                  <div class="WadahTeksDalamLonjong">
                    <label class="LabelKecilDiAtasInput">Jumlah Kursi</label>
                    <select name="penumpang" class="ElemenInputFormUtama">
                      <option value="0">Jumlah Kursi</option>
                      <option value="1">1 Kursi Penumpang</option>
                      <option value="2">2 Kursi Penumpang</option>
                      <option value="3">3 Kursi Penumpang</option>
                      <option value="4">4 Kursi Penumpang</option>
                    </select>
                  </div>

                  <i class="fa-solid fa-chevron-down IkonPanahKecil"></i>

                </div>

                <div class="DesainInputBentukLonjong">
                  <div class="WadahIkonDalamInput">
                    <i class="fa-solid fa-bus-simple"></i>
                  </div>
                  <div class="WadahTeksDalamLonjong">
                    <label class="LabelKecilDiAtasInput">Pilih Kelas</label>
                    <select name="kelas" class="ElemenInputFormUtama">
                      <option value="semua">Tipe Armada</option>
                      <option value="super">Super Executive</option>
                      <option value="exec">Executive Class</option>
                      <option value="patas">Patas AC</option>
                      <option value="eko">Ekonomi AC</option>
                    </select>
                  </div>

                  <i class="fa-solid fa-chevron-down IkonPanahKecil"></i>

                </div>
                
                <button type="submit" class="TombolProsesPencarianOranye">
                  <i class="fa-solid fa-magnifying-glass"></i> CARI JADWAL BUS
                </button>
              </div>
            </form>
          </div>
        </div>

        <section id="kelas">
          <div class="KepalaSeksiTengah">
            <h2>Layanan Kelas Armada ALS</h2>
            <p>
              Kami menghadirkan berbagai pilihan standar pelayanan untuk kenyamanan
              perjalanan jarak jauh Anda.
            </p>
          </div>

          <div class="TataLetakGridArmada">
            <div class="KartuInformasiArmada">
              <div class="WadahIkonArmadaBulat">
                <i class="fa-solid fa-crown"></i>
              </div>
              <h4 class="JudulTeksArmada">Super Executive</h4>
              <p class="TeksKeteranganFasilitas">
                Konfigurasi kursi 2-1 ekstra lega, fasilitas AC, Toilet, Bantal,
                Selimut, Leg Rest, & Snack perjalanan.
              </p>
            </div>

            <div class="KartuInformasiArmada">
              <div class="WadahIkonArmadaBulat">
                <i class="fa-solid fa-gem"></i>
              </div>
              <h4 class="JudulTeksArmada">Executive Class</h4>
              <p class="TeksKeteranganFasilitas">
                Susunan kursi 2-2 yang empuk, AC dingin, Toilet bersih, Reclining
                Seat, serta hiburan Audio/Video.
              </p>
            </div>

            <div class="KartuInformasiArmada">
              <div class="WadahIkonArmadaBulat">
                <i class="fa-solid fa-snowflake"></i>
              </div>
              <h4 class="JudulTeksArmada">Patas AC</h4>
              <p class="TeksKeteranganFasilitas">
                Kursi nyaman 2-2, penyejuk udara sentral, tanpa toilet dalam bus
                (berhenti di tempat istirahat resmi).
              </p>
            </div>

            <div class="KartuInformasiArmada">
              <div class="WadahIkonArmadaBulat">
                <i class="fa-solid fa-wind"></i>
              </div>
              <h4 class="JudulTeksArmada">Ekonomi AC</h4>
              <p class="TeksKeteranganFasilitas">
                Pilihan armada hemat yang sudah dilengkapi penyejuk udara (AC)
                dengan susunan kursi baris 2-2 atau 2-3.
              </p>
            </div>

            <div class="KartuInformasiArmada">
              <div class="WadahIkonArmadaBulat">
                <i class="fa-solid fa-bus-simple"></i>
              </div>
              <h4 class="JudulTeksArmada">Ekonomi Non-AC</h4>
              <p class="TeksKeteranganFasilitas">
                Tarif paling kompetitif dan terjangkau dengan sirkulasi udara alami
                untuk rute jarak menengah.
              </p>
            </div>
          </div>
        </section>

        <section id="agen">
          <div class="BarisJudulSeksiAgen">
            <h2>Jaringan Agen Resmi</h2>
            <p>
              PT Antar Lintas Sumatera mengelola jaringan agen perwakilan yang
              tersebar luas melayani rute terpercaya dari Sumatera hingga Bali.
            </p>
          </div>

          <div class="TataLetakGridAgen">
            <div class="KartuWilayahAgen">
              <div class="KontenInformasiAgen">
                <span class="LabelIdentifikasiLokasi">WILAYAH</span>
                <h4 class="NamaAreaAgen">Pulau Sumatera</h4>
                <div class="GarisPembatasOranye"></div>
                <p class="JumlahTitikKantorAgen">35 Lokasi Agen</p>
              </div>
              <img src="<?= BASEURL; ?>/gambar/foto1.jpg" class="ElemenGambarWilayahAgen" />
            </div>

            <div class="KartuWilayahAgen">
              <div class="KontenInformasiAgen">
                <span class="LabelIdentifikasiLokasi">WILAYAH</span>
                <h4 class="NamaAreaAgen">Pulau Jawa</h4>
                <div class="GarisPembatasOranye"></div>
                <p class="JumlahTitikKantorAgen">22 Lokasi Agen</p>
              </div>
              <img src="<?= BASEURL; ?>/gambar/foto2.jpg" class="ElemenGambarWilayahAgen" />
            </div>

            <div class="KartuWilayahAgen">
              <div class="KontenInformasiAgen">
                <span class="LabelIdentifikasiLokasi">WILAYAH</span>
                <h4 class="NamaAreaAgen">Jabodetabek</h4>
                <div class="GarisPembatasOranye"></div>
                <p class="JumlahTitikKantorAgen">15 Lokasi Agen</p>
              </div>
              <img src="<?= BASEURL; ?>/gambar/foto3.jpg" class="ElemenGambarWilayahAgen" />
            </div>

            <div class="KartuWilayahAgen">
              <div class="KontenInformasiAgen">
                <span class="LabelIdentifikasiLokasi">WILAYAH</span>
                <h4 class="NamaAreaAgen">Pulau Bali</h4>
                <div class="GarisPembatasOranye"></div>
                <p class="JumlahTitikKantorAgen">1 Lokasi Agen</p>
              </div>
              <img src="<?= BASEURL; ?>/gambar/foto4.jpg" class="ElemenGambarWilayahAgen" />
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
              <li><a href="#kelas">Super Executive</a></li>
              <li><a href="#kelas">Executive Class</a></li>
              <li><a href="#kelas">Patas AC</a></li>
              <li><a href="#kelas">Ekonomi</a></li>
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