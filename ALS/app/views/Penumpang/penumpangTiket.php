<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-Tiket Anda - PT. Antar Lintas Sumatera</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/penumpang.css" />
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/penumpangTambahan.css" />
  </head>
  <body>
    <nav class="BatangNavigasiUtama NavigasiTiket">
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
        </div>
      </div>
    </nav>

    <main class="WadahPembatasLebarKonten">
        <div class="TicketContainer">
            <div class="TicketHeader">
                <h2><i class="fa-solid fa-ticket"></i> E-Tiket ALS</h2>
                <p>Kode Booking: <strong>ALS-<?= str_pad($tiket['id'], 5, '0', STR_PAD_LEFT) ?></strong></p>
            </div>
            <div class="TicketBody">
                <div class="TicketRow">
                    <div>
                        <div class="TicketLabel">Nama Penumpang</div>
                        <div class="TicketValue"><?= htmlspecialchars($tiket['nama_pemesan']) ?></div>
                        <div class="TicketLabel MarginAtas10">Email / Telepon</div>
                        <div class="TicketValue TeksNormal14"><?= htmlspecialchars($tiket['email']) ?> <br> <?= htmlspecialchars($tiket['telepon']) ?></div>
                    </div>
                    <div class="TeksKanan">
                        <div class="TicketLabel">Status</div>
                        <div class="TicketValue TeksHijau">
                            <?= $tiket['status_pembayaran'] === 'berhasil' ? 'LUNAS' : strtoupper($tiket['status_pembayaran']) ?>
                        </div>
                    </div>
                </div>
                <div class="TicketRow">
                    <div>
                        <div class="TicketLabel">Keberangkatan</div>
                        <div class="TicketValue"><?= htmlspecialchars($tiket['asal']) ?></div>
                        <div class="TicketLabel MarginAtas10">Tanggal</div>
                        <div class="TicketValue"><?= date('d M Y', strtotime($tiket['tanggal'])) ?></div>
                        <div class="TicketLabel MarginAtas10">Jam</div>
                        <div class="TicketValue"><?= substr($tiket['jam_berangkat'], 0, 5) ?> WIB</div>
                    </div>
                    <div class="TeksKanan">
                        <div class="TicketLabel">Tujuan</div>
                        <div class="TicketValue"><?= htmlspecialchars($tiket['tujuan']) ?></div>
                        <div class="TicketLabel MarginAtas10">Kursi (<?= $tiket['jumlah_kursi'] ?>)</div>
                        <div class="TicketValue"><?= htmlspecialchars($tiket['kursi_dipesan']) ?></div>
                    </div>
                </div>
                
                <div class="TicketRow BarisTanpaBatas">
                    <div>
                        <div class="TicketLabel">Total Pembayaran</div>
                        <div class="TicketValue TeksBesar22">Rp <?= number_format($tiket['total_harga'], 0, ',', '.') ?></div>
                    </div>
                </div>
            </div>
            <div class="TicketFooter">
                <button onclick="window.print()" class="BtnPrint"><i class="fa-solid fa-print"></i> Cetak Tiket</button>
                <a href="<?= BASEURL; ?>/index.php" class="BtnPrint TombolBiruMarginKiri">Ke Beranda</a>
            </div>
        </div>
    </main>
  </body>
</html>