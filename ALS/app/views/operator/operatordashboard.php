<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Operator</title>
    <link rel="stylesheet" href="/gantiALS/ALS/public/css/operator.css?v=4">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="/gantiALS/ALS/public/gambar/logo%20als.jpg" alt="Logo ALS">
            <span>Operator ALS</span>
        </div>
        <nav class="sidebar-nav">
<<<<<<< HEAD
            <a href="/gantiALS/index.php?page=operatorDashboard" class="active">
                <span>Dashboard</span>
            </a>
            <a href="/gantiALS/index.php?page=operatorBus">
                <span>Kelola Bus</span>
            </a>
            <a href="/gantiALS/index.php?page=operatorJadwal">
                <span>Kelola Jadwal</span>
            </a>
            <a href="/gantiALS/index.php?page=operatorPemesanan">
=======
            <a href="/gantiALS/ALS/index.php?controller=operator&action=dashboard" class="active">
                <span>Dashboard</span>
            </a>
            <a href="/gantiALS/ALS/index.php?controller=operator&action=bilList">
                <span>Kelola Bus</span>
            </a>
            <a href="/gantiALS/ALS/index.php?controller=operator&action=jadwalList">
                <span>Kelola Jadwal</span>
            </a>
            <a href="/gantiALS/ALS/index.php?controller=operator&action=pemesananList">
>>>>>>> b707894dbeeb19f3b91a36119529d92c5c40b53a
                <span>Kelola Pemesanan</span>
            </a>
        </nav>
        <div class="sidebar-footer">
<<<<<<< HEAD
            <a href="/gantiALS/index.php?page=operatorLogout">
=======
            <a href="/gantiALS/ALS/index.php?controller=operator&action=logout">
>>>>>>> b707894dbeeb19f3b91a36119529d92c5c40b53a
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
            <div class="stat-box" style="background: #17a2b8;">
                <h3>Jadwal Hari Ini</h3>
                <h2><?= $jadwalHariIni ?></h2>
            </div>
            <div class="stat-box" style="background: #28a745;">
                <h3>Penumpang Terverifikasi</h3>
                <h2><?= $penumpangTerverifikasi ?></h2>
            </div>
            <div class="stat-box" style="background: #ffc107;">
                <h3>Belum Verifikasi</h3>
                <h2><?= $penumpangBelumVerifikasi ?></h2>
            </div>
            <div class="stat-box" style="background: #dc3545;">
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
                            <td><?= htmlspecialchars($p['created_at']) ?></td>
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