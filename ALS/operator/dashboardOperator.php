<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Dashboard Operator - Admin Panel ALS</title>

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

            <a href="../../public/index.php?page=dashboardOperator" class="ItemMenu aktif">
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

            <h1>Dashboard Operasional</h1>

            <div class="ProfilAdmin">
                <span>
                    Selamat datang,
                    <strong>Operator Medan</strong>
                </span>

                <i class="fa-solid fa-user-tie"></i>
            </div>

        </header>

        <div class="KontenArea">

            <div class="GridStatistik">

                <div class="KartuStatistik">

                    <div class="IkonKartu" style="background-color: #e0f2fe">
                        <i class="fa-solid fa-calendar-check" style="color: #0ea5e9"></i>
                    </div>

                    <div class="InfoKartu">
                        <p>Jadwal Hari Ini</p>
                        <span>5 Keberangkatan</span>
                    </div>

                </div>

                <div class="KartuStatistik">

                    <div class="IkonKartu" style="background-color: #f0fdf4">
                        <i class="fa-solid fa-user-check" style="color: #22c55e"></i>
                    </div>

                    <div class="InfoKartu">
                        <p>Penumpang Terverifikasi</p>
                        <span>12 Penumpang</span>
                    </div>

                </div>

                <div class="KartuStatistik">

                    <div class="IkonKartu" style="background-color: #fffbeb">
                        <i class="fa-solid fa-user-clock" style="color: #f59e0b"></i>
                    </div>

                    <div class="InfoKartu">
                        <p>Perlu Verifikasi</p>
                        <span>3 Penumpang</span>
                    </div>

                </div>

                <div class="KartuStatistik">

                    <div class="IkonKartu" style="background-color: #f1f5f9">
                        <i class="fa-solid fa-bus-simple" style="color: #475569"></i>
                    </div>

                    <div class="InfoKartu">
                        <p>Bus Beroperasi</p>
                        <span>8 Bus</span>
                    </div>

                </div>

            </div>

            <div class="KartuKontenBesar">

                <h3>
                    <i class="fa-solid fa-ticket"></i>
                    Pemesanan Terbaru (Perlu Verifikasi)
                </h3>

                <table class="TabelData">

                    <thead>
                        <tr>
                            <th>Kode Booking</th>
                            <th>Nama Penumpang</th>
                            <th>Jadwal</th>
                            <th>Kursi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>ALS-1A2B3C</td>
                            <td>Budi Santoso</td>
                            <td>Medan - Jakarta (14:00)</td>
                            <td>4A, 4B</td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

</body>
</html>