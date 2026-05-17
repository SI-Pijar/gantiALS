<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pemesanan Operator</title>
    <link rel="stylesheet" href="/gantiALS/ALS/public/css/operator.css?v=4">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="/gantiALS/ALS/public/gambar/logo%20als.jpg" alt="Logo ALS">
            <span>Operator ALS</span>
        </div>
        <nav class="sidebar-nav">
            <a href="/gantiALS/ALS/index.php?controller=operator&action=dashboard">
                <span>Dashboard</span>
            </a>
            <a href="/gantiALS/ALS/index.php?controller=operator&action=bilList">
                <span>Kelola Bus</span>
            </a>
            <a href="/gantiALS/ALS/index.php?controller=operator&action=jadwalList">
                <span>Kelola Jadwal</span>
            </a>
            <a href="/gantiALS/ALS/index.php?controller=operator&action=pemesananList" class="active">
                <span>Kelola Pemesanan</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="/gantiALS/ALS/index.php?controller=operator&action=logout">
                <span>Logout</span>
            </a>
        </div>
    </div>
    <div class="content">
        <h2>Kelola Pemesanan</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="card">
            <h3>Daftar Pemesanan</h3>
            <table>
                <thead>
                    <tr>
                        <th>Kode Booking</th>
                        <th>Penumpang</th>
                        <th>Rute & Jadwal</th>
                        <th>No Kursi</th>
                        <th>Status Bayar</th>
                        <th>Status Verifikasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pemesananList)): ?>
                        <?php foreach ($pemesananList as $pemesanan): ?>
                        <tr>
                            <td><?= htmlspecialchars($pemesanan['kode_booking']) ?></td>
                            <td><?= htmlspecialchars($pemesanan['nama_penumpang']) ?><br><small><?= htmlspecialchars($pemesanan['telepon']) ?></small></td>
                            <td><?= htmlspecialchars($pemesanan['asal']) ?> - <?= htmlspecialchars($pemesanan['tujuan']) ?><br><small><?= htmlspecialchars($pemesanan['tanggal_keberangkatan']) ?> <?= htmlspecialchars($pemesanan['jam_keberangkatan']) ?></small></td>
                            <td><?= $pemesanan['nomor_kursi'] ?></td>
                            <td>
                                <?php
                                    $bayarClass = 'badge-pending';
                                    if ($pemesanan['status_pembayaran'] == 'Lunas') $bayarClass = 'badge-lunas';
                                    if ($pemesanan['status_pembayaran'] == 'Gagal') $bayarClass = 'badge-gagal';
                                ?>
                                <span class="badge <?= $bayarClass ?>"><?= $pemesanan['status_pembayaran'] ?></span>
                            </td>
                            <td>
                                <?php
                                    $verClass = 'badge-belum';
                                    if ($pemesanan['status_verifikasi'] == 'Terverifikasi') $verClass = 'badge-terverifikasi';
                                    if ($pemesanan['status_verifikasi'] == 'Ditolak') $verClass = 'badge-ditolak';
                                ?>
                                <span class="badge <?= $verClass ?>"><?= $pemesanan['status_verifikasi'] ?></span>
                            </td>
                            <td>
                                <?php if ($pemesanan['status_verifikasi'] == 'Belum' || $pemesanan['status_verifikasi'] == 'Ditolak'): ?>
                                    <a href="/gantiALS/ALS/index.php?controller=operator&action=pemesananVerifikasi&id=<?= $pemesanan['id'] ?>" class="btn btn-success" onclick="return confirm('Verifikasi pesanan ini?')">Verifikasi</a>
                                <?php endif; ?>
                                
                                <?php if ($pemesanan['status_verifikasi'] == 'Belum' || $pemesanan['status_verifikasi'] == 'Terverifikasi'): ?>
                                    <a href="/gantiALS/ALS/index.php?controller=operator&action=pemesananTolak&id=<?= $pemesanan['id'] ?>" class="btn btn-danger" onclick="return confirm('Tolak pesanan ini?')">Tolak</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7">Belum ada pemesanan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>