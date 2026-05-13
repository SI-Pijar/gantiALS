<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Kelola Bus - Operator Panel ALS</title>

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

            <a href="../../public/index.php?page=kelolaJadwalOperator" class="ItemMenu">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Kelola Jadwal</span>
            </a>

            <a href="../../public/index.php?page=kelolaBusOperator" class="ItemMenu aktif">
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

            <h1>Kelola Data Bus</h1>

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
                        <i class="fa-solid fa-bus"></i>
                        Daftar Bus
                    </h3>

                    <button class="TombolAksi">
                        <i class="fa-solid fa-plus"></i>
                        Tambah Bus
                    </button>

                </div>

                <table class="TabelData">

                    <thead>

                        <tr>
                            <th>No. Polisi</th>
                            <th>Kelas</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php while($row = $bus->fetch(PDO::FETCH_ASSOC)) : ?>

                        <tr>

                            <td><?= $row['no_polisi']; ?></td>

                            <td><?= $row['kelas_bus']; ?></td>

                            <td><?= $row['kapasitas']; ?> Kursi</td>

                            <td>

                                <?php if($row['status_bus'] == 'Aktif') : ?>

                                    <span class="StatusBadge berhasil">
                                        <?= $row['status_bus']; ?>
                                    </span>

                                <?php else : ?>

                                    <span class="StatusBadge nonaktif">
                                        <?= $row['status_bus']; ?>
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td class="KolomAksi">

                                <a
                                    href="../../public/index.php?page=editBus&id=<?= $row['id_bus']; ?>"
                                    class="TombolIkon edit"
                                >
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <a
                                    href="../../public/index.php?page=hapusBus&id=<?= $row['id_bus']; ?>"
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