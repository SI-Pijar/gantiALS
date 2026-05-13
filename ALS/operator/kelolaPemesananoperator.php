<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Kelola Pemesanan - Operator Panel ALS</title>

    <link rel="stylesheet" href="../../public/operator/operator.css" />

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
</head>

<body>

<div class="TataLetakAdmin">

    <aside class="SidebarNavigasi">

        <div class="LogoSidebar">
            <img src="../../public/operator/gambar/logo als.jpg" alt="Logo ALS" />
            <span>ALS OPERATOR</span>
        </div>

        <nav class="MenuNavigasi">

            <a href="../../public/index.php?page=dashboardOperator" class="ItemMenu">
                <i class="fa-solid fa-gauge-high"></i>
                <span>Dashboard</span>
            </a>

            <a href="../../public/index.php?page=kelolaPemesananOperator" class="ItemMenu aktif">
                <i class="fa-solid fa-ticket"></i>
                <span>Kelola Pemesanan</span>
            </a>

            <a href="../../public/index.php?page=kelolaJadwalOperator" class="ItemMenu">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Kelola Jadwal</span>
            </a>

            <a href="../../public/index.php?page=kelolaBusOperator" class="ItemMenu">
                <i class="fa-solid fa-bus"></i>
                <span>Kelola Bus</span>
            </a>

        </nav>

        <div class="AreaUserSidebar">

            <a href="../../public/index.php?page=loginOperator" class="TombolLogout">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Logout</span>
            </a>

        </div>

    </aside>

    <main class="KontenUtamaAdmin">

        <header class="HeaderKonten">

            <h1>Kelola Pemesanan & Verifikasi Penumpang</h1>

            <div class="ProfilAdmin">
                <span>
                    Selamat datang,
                    <strong>Operator Medan</strong>
                </span>

                <i class="fa-solid fa-user-tie"></i>
            </div>

        </header>

        <div class="KontenArea">

            <div class="KartuKontenBesar">

                <div class="HeaderKartu">

                    <h3>
                        <i class="fa-solid fa-ticket"></i>
                        Daftar Pemesanan
                    </h3>

                    <button class="TombolAksi">
                        <i class="fa-solid fa-search"></i>
                        Cari Pemesanan
                    </button>

                </div>

                <table class="TabelData">

                    <thead>

                        <tr>
                            <th>Kode Booking</th>
                            <th>Penumpang</th>
                            <th>Jadwal</th>
                            <th>Status Bayar</th>
                            <th>Status Verifikasi</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php while($row = $pemesanan->fetch(PDO::FETCH_ASSOC)) : ?>

                        <tr>

                            <td><?= $row['kode_booking']; ?></td>

                            <td><?= $row['nama_penumpang']; ?></td>

                            <td>
                                <?= $row['asal']; ?>
                                -
                                <?= $row['tujuan']; ?>
                                (<?= $row['jam_keberangkatan']; ?>)
                            </td>

                            <td>

                                <?php if($row['status_bayar'] == 'Lunas') : ?>

                                    <span class="StatusBadge berhasil">
                                        <?= $row['status_bayar']; ?>
                                    </span>

                                <?php else : ?>

                                    <span class="StatusBadge nonaktif">
                                        <?= $row['status_bayar']; ?>
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <?php if($row['status_verifikasi'] == 'Terverifikasi') : ?>

                                    <span class="StatusBadge berhasil">
                                        <?= $row['status_verifikasi']; ?>
                                    </span>

                                <?php else : ?>

                                    <span class="StatusBadge info">
                                        <?= $row['status_verifikasi']; ?>
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td class="KolomAksi">

                                <?php if($row['status_verifikasi'] != 'Terverifikasi') : ?>

                                    <a
                                        href="../../public/index.php?page=verifikasiPemesanan&id=<?= $row['id_pemesanan']; ?>"
                                        class="TombolAksiKecil"
                                    >
                                        Verifikasi
                                    </a>

                                <?php else : ?>

                                    -

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

</body>
</html>