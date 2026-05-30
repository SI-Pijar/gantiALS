<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Jadwal Operator</title>
    <link rel="stylesheet" href="<?= BASEURL; ?>/ALS/public/css/operator.css?v=4">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="<?= BASEURL; ?>/ALS/public/gambar/logo%20als.jpg" alt="Logo ALS">
            <span>Operator ALS</span>
        </div>
        <nav class="sidebar-nav">
<a href="<?= BASEURL; ?>/index.php?controller=operator&action=dashboard">
                <span>Dashboard</span>
            </a>
            <a href="<?= BASEURL; ?>/index.php?controller=operator&action=bilList">
                <span>Kelola Bus</span>
            </a>
            <a href="<?= BASEURL; ?>/index.php?controller=operator&action=jadwalList" class="active">
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
        <h2>Kelola Jadwal</h2>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="card">
            <h3 id="formTitle">Tambah Jadwal</h3>
<form id="jadwalForm" action="<?= BASEURL; ?>/index.php?controller=operator&action=jadwalAdd" method="POST">

                <div class="form-group">
                    <label>Bus</label>
                    <select name="bus_id" id="bus_id" required onchange="autofillKursi()">
                        <option value="">-- Pilih Bus --</option>
                        <?php foreach ($busListOptions as $busOp): ?>
                            <option value="<?= $busOp['id'] ?>" data-kapasitas="<?= (int)$busOp['kapasitas'] ?>">
                                <?= htmlspecialchars($busOp['no_polisi']) ?> (<?= htmlspecialchars($busOp['kelas_bus']) ?>, <?= (int)$busOp['kapasitas'] ?> kursi)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Asal</label>
                    <select name="asal" id="asal" required>
                        <option value="">-- Pilih Kota Asal --</option>
                        <?php foreach ($ruteList as $rute): ?>
                            <option value="<?= htmlspecialchars($rute) ?>"><?= htmlspecialchars($rute) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tujuan</label>
                    <select name="tujuan" id="tujuan" required>
                        <option value="">-- Pilih Kota Tujuan --</option>
                        <?php foreach ($ruteList as $rute): ?>
                            <option value="<?= htmlspecialchars($rute) ?>"><?= htmlspecialchars($rute) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal Keberangkatan</label>
                    <input type="date" name="tanggal" id="tanggal" required>
                </div>
                <div class="form-group">
                    <label>Jam Keberangkatan</label>
                    <input type="time" name="jam_berangkat" id="jam_berangkat" required>
                </div>
                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" id="harga" required min="1">
                </div>
                <div class="form-group">
                    <label>Jumlah Kursi Tersedia</label>
                    <input type="number" name="kursi_tersedia" id="kursi_tersedia" min="0" readonly class="input-readonly">
                    <small class="info-kecil">Otomatis diisi dari kapasitas bus yang dipilih.</small>
                </div>
                <button type="submit" class="btn btn-success" id="btnSubmit">Simpan Jadwal</button>
                <button type="button" class="btn btn-warning tersembunyi" onclick="resetForm()" id="btnBatal">Batal Edit</button>
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
                            <td><?= htmlspecialchars($jadwal['tanggal']) ?> <br> <?= htmlspecialchars($jadwal['jam_berangkat']) ?></td>
                            <td>Rp <?= number_format($jadwal['harga'], 0, ',', '.') ?></td>
                            <td><?= isset($jadwal['kursi_tersedia']) ? $jadwal['kursi_tersedia'] : '-' ?></td>
                            <td>
                                <button class="btn btn-warning" onclick='editJadwal(<?= $jadwal['id'] ?>, <?= $jadwal['bus_id'] ?>, <?= json_encode($jadwal['asal']) ?>, <?= json_encode($jadwal['tujuan']) ?>, <?= json_encode($jadwal['tanggal']) ?>, <?= json_encode($jadwal['jam_berangkat']) ?>, <?= $jadwal['harga'] ?>, <?= isset($jadwal['kursi_tersedia']) ? $jadwal['kursi_tersedia'] : 0 ?>)'>Edit</button>
<a href="<?= BASEURL; ?>/index.php?controller=operator&action=jadwalDelete&id=<?= $jadwal['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus jadwal ini?')">Hapus</a>

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
        function autofillKursi() {
            const sel = document.getElementById('bus_id');
            const opt = sel.options[sel.selectedIndex];
            const kap = opt ? opt.dataset.kapasitas : '';
            document.getElementById('kursi_tersedia').value = kap || '';
        }

        function editJadwal(id, busId, asal, tujuan, tanggal, jam, harga, kursi) {
            document.getElementById('formTitle').innerText = 'Edit Jadwal';
            document.getElementById('jadwalForm').action = '<?= BASEURL; ?>/index.php?controller=operator&action=jadwalEdit&id=' + id;
            document.getElementById('bus_id').value = busId;
            autofillKursi();
            document.getElementById('asal').value = asal;
            document.getElementById('tujuan').value = tujuan;
            document.getElementById('tanggal').value = tanggal;
            document.getElementById('jam_berangkat').value = jam;
            document.getElementById('harga').value = harga;
            document.getElementById('btnSubmit').innerText = 'Update Jadwal';
            document.getElementById('btnBatal').style.display = 'inline-block';
            window.scrollTo(0, 0);
        }

        function resetForm() {
            document.getElementById('formTitle').innerText = 'Tambah Jadwal';
            document.getElementById('jadwalForm').action = '<?= BASEURL; ?>/index.php?controller=operator&action=jadwalAdd';
            document.getElementById('jadwalForm').reset();
            document.getElementById('kursi_tersedia').value = '';
            document.getElementById('btnSubmit').innerText = 'Simpan Jadwal';
            document.getElementById('btnBatal').style.display = 'none';
        }
    </script>
</body>
</html>
