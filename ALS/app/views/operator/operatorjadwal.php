<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Jadwal Operator</title>
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
            <a href="/gantiALS/index.php?page=operatorDashboard">
                <span>Dashboard</span>
            </a>
            <a href="/gantiALS/index.php?page=operatorBus">
                <span>Kelola Bus</span>
            </a>
            <a href="/gantiALS/index.php?page=operatorJadwal" class="active">
                <span>Kelola Jadwal</span>
            </a>
            <a href="/gantiALS/index.php?page=operatorPemesanan">
=======
            <a href="/gantiALS/ALS/index.php?controller=operator&action=dashboard">
                <span>Dashboard</span>
            </a>
            <a href="/gantiALS/ALS/index.php?controller=operator&action=bilList">
                <span>Kelola Bus</span>
            </a>
            <a href="/gantiALS/ALS/index.php?controller=operator&action=jadwalList" class="active">
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
        <h2>Kelola Jadwal</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="card">
            <h3 id="formTitle">Tambah Jadwal</h3>
<<<<<<< HEAD
            <form id="jadwalForm" action="/gantiALS/index.php?page=operatorJadwal&action=add" method="POST">
=======
            <form id="jadwalForm" action="/gantiALS/ALS/index.php?controller=operator&action=jadwalAdd" method="POST">
>>>>>>> b707894dbeeb19f3b91a36119529d92c5c40b53a
                <div class="form-group">
                    <label>Bus</label>
                    <select name="bus_id" id="bus_id" required>
                        <option value="">-- Pilih Bus --</option>
                        <?php foreach ($busListOptions as $busOp): ?>
                            <option value="<?= $busOp['id'] ?>"><?= htmlspecialchars($busOp['no_polisi']) ?> (<?= htmlspecialchars($busOp['kelas_bus']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Asal</label>
                    <input type="text" name="asal" id="asal" required>
                </div>
                <div class="form-group">
                    <label>Tujuan</label>
                    <input type="text" name="tujuan" id="tujuan" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Keberangkatan</label>
                    <input type="date" name="tanggal_keberangkatan" id="tanggal_keberangkatan" required>
                </div>
                <div class="form-group">
                    <label>Jam Keberangkatan</label>
                    <input type="time" name="jam_keberangkatan" id="jam_keberangkatan" required>
                </div>
                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" id="harga" required min="1">
                </div>
                <div class="form-group">
                    <label>Jumlah Kursi Tersedia</label>
                    <input type="number" name="kursi_tersedia" id="kursi_tersedia" required min="0">
                </div>
                <button type="submit" class="btn btn-success" id="btnSubmit">Simpan Jadwal</button>
                <button type="button" class="btn btn-warning" onclick="resetForm()" style="display:none;" id="btnBatal">Batal Edit</button>
            </form>
        </div>

        <div class="card">
            <h3>Daftar Jadwal</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Bus</th>
                        <th>Rute</th>
                        <th>Waktu</th>
                        <th>Harga</th>
                        <th>Kursi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($jadwalList)): ?>
                        <?php foreach ($jadwalList as $jadwal): ?>
                        <tr>
                            <td><?= $jadwal['id'] ?></td>
                            <td><?= htmlspecialchars($jadwal['no_polisi']) ?></td>
                            <td><?= htmlspecialchars($jadwal['asal']) ?> - <?= htmlspecialchars($jadwal['tujuan']) ?></td>
                            <td><?= htmlspecialchars($jadwal['tanggal_keberangkatan']) ?> <br> <?= htmlspecialchars($jadwal['jam_keberangkatan']) ?></td>
                            <td>Rp <?= number_format($jadwal['harga'], 0, ',', '.') ?></td>
                            <td><?= isset($jadwal['kursi_tersedia']) ? $jadwal['kursi_tersedia'] : '-' ?></td>
                            <td>
                                <button class="btn btn-warning" onclick="editJadwal(<?= $jadwal['id'] ?>, <?= $jadwal['bus_id'] ?>, '<?= htmlspecialchars($jadwal['asal']) ?>', '<?= htmlspecialchars($jadwal['tujuan']) ?>', '<?= $jadwal['tanggal_keberangkatan'] ?>', '<?= $jadwal['jam_keberangkatan'] ?>', <?= $jadwal['harga'] ?>, <?= isset($jadwal['kursi_tersedia']) ? $jadwal['kursi_tersedia'] : 0 ?>)">Edit</button>
<<<<<<< HEAD
                                <a href="/gantiALS/index.php?page=operatorJadwal&action=delete&id=<?= $jadwal['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus jadwal ini?')">Hapus</a>
=======
                                <a href="/gantiALS/ALS/index.php?controller=operator&action=jadwalDelete&id=<?= $jadwal['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus jadwal ini?')">Hapus</a>
>>>>>>> b707894dbeeb19f3b91a36119529d92c5c40b53a
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7">Belum ada data jadwal.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function editJadwal(id, busId, asal, tujuan, tanggal, jam, harga, kursi) {
            document.getElementById('formTitle').innerText = 'Edit Jadwal';
<<<<<<< HEAD
            document.getElementById('jadwalForm').action = '/gantiALS/index.php?page=operatorJadwal&action=edit&id=' + id;
=======
            document.getElementById('jadwalForm').action = '/gantiALS/ALS/index.php?controller=operator&action=jadwalEdit&id=' + id;
>>>>>>> b707894dbeeb19f3b91a36119529d92c5c40b53a
            document.getElementById('bus_id').value = busId;
            document.getElementById('asal').value = asal;
            document.getElementById('tujuan').value = tujuan;
            document.getElementById('tanggal_keberangkatan').value = tanggal;
            document.getElementById('jam_keberangkatan').value = jam;
            document.getElementById('harga').value = harga;
            document.getElementById('kursi_tersedia').value = kursi;
            document.getElementById('btnSubmit').innerText = 'Update Jadwal';
            document.getElementById('btnBatal').style.display = 'inline-block';
            window.scrollTo(0, 0);
        }

        function resetForm() {
            document.getElementById('formTitle').innerText = 'Tambah Jadwal';
<<<<<<< HEAD
            document.getElementById('jadwalForm').action = '/gantiALS/index.php?page=operatorJadwal&action=add';
=======
            document.getElementById('jadwalForm').action = '/gantiALS/ALS/index.php?controller=operator&action=jadwalAdd';
>>>>>>> b707894dbeeb19f3b91a36119529d92c5c40b53a
            document.getElementById('jadwalForm').reset();
            document.getElementById('btnSubmit').innerText = 'Simpan Jadwal';
            document.getElementById('btnBatal').style.display = 'none';
        }
    </script>
</body>
</html>