<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pilih Kursi & Detail Penumpang - PT. Antar Lintas Sumatera</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<<<<<<< HEAD
    <link rel="stylesheet" href="/gantiALS/ALS/public/css/penumpang.css" />
=======
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/penumpang.css" />
>>>>>>> b707894dbeeb19f3b91a36119529d92c5c40b53a
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
        <div class="KontenUtamaPemesanan">
            <div class="AreaPilihKursi">
                <form action="<?= BASEURL; ?>/index.php?page=proses_pemesanan" method="POST" id="formPemesanan">
                <input type="hidden" name="id_jadwal" value="<?= $jadwal['id'] ?>">
                <input type="hidden" name="kursi_dipesan" id="inputKursiDipesan" value="">
                <div class="KartuDenahKursi">
                    <h3>Pilih Kursi Anda</h3>
                    <div class="DenahKursi" id="DenahKursi">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <?php foreach (['A', 'B', 'C', 'D'] as $col): ?>
                                <?php 
                                $noKursi = $i . $col; 
                                $statusKursi = in_array($noKursi, $kursiTerisi) ? 'terisi' : 'tersedia';
                                ?>
                                <div class="kursi <?= $statusKursi ?>" data-nomor="<?= $noKursi ?>"><?= $noKursi ?></div>
                                <?php if ($col == 'B'): ?><div class="gang"></div><?php endif; ?>
                            <?php endforeach; ?>
                        <?php endfor; ?>
                    </div>
                    <div class="LegendaKursi">
                        <div class="ItemLegenda"><span class="KotakWarna tersedia"></span> Tersedia</div>
                        <div class="ItemLegenda"><span class="KotakWarna terpilih"></span> Pilihan Anda</div>
                        <div class="ItemLegenda"><span class="KotakWarna terisi"></span> Terisi</div> 
                    </div>
                </div>

                <div class="FormDetailPenumpang">
                        <h3>Detail Penumpang</h3>

                        <div class="GrupInputForm">
                            <label for="nama_lengkap">Nama Lengkap (sesuai KTP)</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap Anda" required>
                        </div>

                        <div class="GrupInputForm">
                            <label for="nomor_telepon">Nomor Telepon</label>
                            <input type="tel" id="nomor_telepon" name="nomor_telepon" placeholder="Contoh: 081234567890" required>
                        </div>

                        <div class="GrupInputForm">
                            <label for="email">Alamat Email</label>
                            <input type="email" id="email" name="email" placeholder="Untuk pengiriman e-tiket" required>
                        </div>
                        <button type="submit" class="TombolLanjutBayar TombolLebarPenuh">Lanjutkan ke Pembayaran</button>
                </div>
                </form>
            </div>

            <aside class="AreaRingkasanPesanan">
                <div class="KartuRingkasanPesanan">
                    <h4>Ringkasan Pesanan</h4>
                    <div class="DetailPerjalanan">
                        <p class="rute"><?= htmlspecialchars($jadwal['asal']) ?> &rarr; <?= htmlspecialchars($jadwal['tujuan']) ?></p>
                        <p class="tanggal-waktu"><?= date('d M Y', strtotime($jadwal['tanggal'])) ?>, <?= substr($jadwal['jam_berangkat'], 0, 5) ?> WIB</p>
                        <p class="NamaArmada"><i class="fa-solid fa-bus"></i> Reguler</p>
                    </div>

                    <div class="GarisPemisahRingkasan"></div>

                    <div class="DetailHarga">
                        <p>Kursi yang Dipilih (<span id="jumlahKursiText">0</span>)</p>
                        <div class="DaftarNomorKursi" id="daftarNomorKursi">-</div>
                    </div>

                    <div class="GarisPemisahRingkasan"></div>

                    <div class="TotalPembayaran">
                        <p>Total Harga</p>
                        <p class="HargaTotal" id="hargaTotalText">Rp 0</p>
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