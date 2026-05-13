<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Kelola Jadwal - Operator Panel ALS</title>

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

            <a href="../../public/index.php?page=kelolaPemesananOperator" class="ItemMenu">
                <i class="fa-solid fa-ticket"></i>
                <span>Kelola Pemesanan</span>
            </a>

            <a href="../../public/index.php?page=kelolaJadwalOperator" class="ItemMenu aktif">
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

            <h1>Kelola Jadwal Keberangkatan</h1>

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
                        <i class="fa-solid fa-calendar-days"></i>
                        Daftar Jadwal
                    </h3>

                    <button class="TombolAksi">
                        <i class="fa-solid fa-plus"></i>
                        Tambah Jadwal
                    </button>

                </div>

                <table class="TabelData">

                    <thead>

                        <tr>
                            <th>Asal</th>
                            <th>Tujuan</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Bus</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php while($row = $jadwal->fetch(PDO::FETCH_ASSOC)) : ?>

                        <tr>

                            <td><?= $row['asal']; ?></td>

                            <td><?= $row['tujuan']; ?></td>

                            <td><?= $row['tanggal_keberangkatan']; ?></td>

                            <td><?= $row['jam_keberangkatan']; ?></td>

                            <td><?= $row['nama_bus']; ?></td>

                            <td>
                                Rp <?= number_format($row['harga'], 0, ',', '.'); ?>
                            </td>

                            <td class="KolomAksi">

                                <a
                                    href="../../public/index.php?page=editJadwal&id=<?= $row['id_jadwal']; ?>"
                                    class="TombolIkon edit"
                                >
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <a
                                    href="../../public/index.php?page=hapusJadwal&id=<?= $row['id_jadwal']; ?>"
                                    class="TombolIkon hapus"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </a>

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