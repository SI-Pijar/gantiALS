<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Operator</title>
    <link rel="stylesheet" href="<?= BASEURL; ?>/ALS/public/css/operator.css?v=4">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="<?= BASEURL; ?>/ALS/public/gambar/logo%20als.jpg" alt="Logo ALS">
            <span>Operator ALS</span>
        </div>
        <nav class="sidebar-nav">
<a href="<?= BASEURL; ?>/index.php?controller=operator&action=dashboard" class="active">
                <span>Dashboard</span>
            </a>
            <a href="<?= BASEURL; ?>/index.php?controller=operator&action=bilList">
                <span>Kelola Bus</span>
            </a>
            <a href="<?= BASEURL; ?>/index.php?controller=operator&action=jadwalList">
                <span>Kelola Jadwal</span>
            </a>
            <a href="<?= BASEURL; ?>/index.php?controller=operator&action=pemesananList">
                <span>Kelola Pemesanan</span>
            </a>
            <a href="<?= BASEURL; ?>/index.php?controller=operator&action=profil">
                <span>Profil Saya</span>
            </a>
        </nav>
        <div class="sidebar-footer">
<a href="<?= BASEURL; ?>/index.php?controller=operator&action=logout">

                <span>Logout</span>
            </a>
        </div>
    </div>
    <div class="content">
        <div class="card">
            <h2>Selamat datang, <?= htmlspecialchars($_SESSION['nama_operator'] ?? 'Operator') ?></h2>
            <p>Ini adalah halaman dashboard Anda.</p>
        </div>

        <div class="stats">
            <div class="stat-box stat-box-cyan">
                <h3>Jadwal Hari Ini</h3>
                <h2><?= $jadwalHariIni ?></h2>
            </div>
            <div class="stat-box stat-box-green">
                <h3>Penumpang Terverifikasi</h3>
                <h2><?= $penumpangTerverifikasi ?></h2>
            </div>
            <div class="stat-box stat-box-yellow">
                <h3>Belum Verifikasi</h3>
                <h2><?= $penumpangBelumVerifikasi ?></h2>
            </div>
            <div class="stat-box stat-box-red">
                <h3>Bus Aktif</h3>
                <h2><?= $busAktif ?></h2>
            </div>
        </div>

        <div class="card">
            <h3>Pemesanan Terbaru</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal Pesan</th>
                        <th>Kode Booking</th>
                        <th>Penumpang</th>
                        <th>Bus & Jadwal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pemesananTerbaru)): ?>
                        <?php foreach ($pemesananTerbaru as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['tanggal_pesan'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($p['kode_booking']) ?></td>
                            <td><?= htmlspecialchars($p['nama_penumpang']) ?></td>
                            <td><?= htmlspecialchars($p['no_polisi']) ?> (<?= htmlspecialchars($p['asal'] . ' - ' . $p['tujuan']) ?>)</td>
                            <td><?= htmlspecialchars($p['status_verifikasi']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5">Tidak ada pemesanan terbaru.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
