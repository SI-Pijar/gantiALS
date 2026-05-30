<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Bus Operator</title>
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
            <a href="<?= BASEURL; ?>/index.php?controller=operator&action=bilList" class="active">
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
        <h2>Kelola Bus</h2>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="card">
            <h3 id="formTitle">Tambah Bus</h3>
<form id="busForm" action="<?= BASEURL; ?>/index.php?controller=operator&action=bilAdd" method="POST">

                <div class="form-group">
                    <label>No Polisi</label>
                    <input type="text" name="no_polisi" id="no_polisi" required>
                </div>
                <div class="form-group">
                    <label>Kelas Bus</label>
                    <select name="kelas_bus" id="kelas_bus" required onchange="updateKapasitas()">
                        <option value="">-- Pilih Kelas --</option>
                        <option value="Super Executive">Super Executive</option>
                        <option value="Executive Class">Executive Class</option>
                        <option value="Patas AC">Patas AC</option>
                        <option value="Ekonomi AC">Ekonomi AC</option>
                        <option value="Ekonomi Non-AC">Ekonomi Non-AC</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kapasitas Kursi</label>
                    <p id="kapasitas_info" class="kapasitas-info">—</p>
                    <small class="info-kecil">Ditentukan otomatis berdasarkan kelas bus.</small>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status_bus" id="status_bus">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success" id="btnSubmit">Simpan Bus</button>
                <button type="button" class="btn btn-warning tersembunyi" onclick="resetForm()" id="btnBatal">Batal Edit</button>
            </form>
        </div>

        <div class="card">
            <h3>Daftar Bus</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>No Polisi</th>
                        <th>Kelas</th>
                        <th>Kapasitas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($busList)): ?>
                        <?php foreach ($busList as $bus): ?>
                        <tr>
                            <td><?= $bus['id'] ?></td>
                            <td><?= htmlspecialchars($bus['no_polisi']) ?></td>
                            <td><?= htmlspecialchars($bus['kelas_bus']) ?></td>
                            <td><?= $bus['kapasitas'] ?></td>
                            <td><?= $bus['status_bus'] ?></td>
                            <td>
                                <button class="btn btn-warning" onclick='editBus(<?= $bus['id'] ?>, <?= json_encode($bus['no_polisi']) ?>, <?= json_encode($bus['kelas_bus']) ?>, <?= $bus['kapasitas'] ?>, <?= json_encode($bus['status_bus']) ?>)'>Edit</button>
<a href="<?= BASEURL; ?>/index.php?controller=operator&action=bilDelete&id=<?= $bus['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus bus ini?')">Hapus</a>

                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6">Belum ada data bus.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const KAPASITAS_TETAP = {
            'Super Executive': 22,
            'Executive Class': 30,
            'Patas AC': 38,
            'Ekonomi AC': 44,
            'Ekonomi Non-AC': 50,
        };

        function updateKapasitas() {
            const kelas = document.getElementById('kelas_bus').value;
            const info = document.getElementById('kapasitas_info');
            info.textContent = KAPASITAS_TETAP[kelas] ? KAPASITAS_TETAP[kelas] + ' kursi' : '—';
        }

        function editBus(id, noPolisi, kelas, kapasitas, status) {
            document.getElementById('formTitle').innerText = 'Edit Bus';
            document.getElementById('busForm').action = '<?= BASEURL; ?>/index.php?controller=operator&action=bilEdit&id=' + id;
            document.getElementById('no_polisi').value = noPolisi;
            document.getElementById('kelas_bus').value = kelas;
            updateKapasitas();
            document.getElementById('status_bus').value = status;
            document.getElementById('btnSubmit').innerText = 'Update Bus';
            document.getElementById('btnBatal').style.display = 'inline-block';
            window.scrollTo(0, 0);
        }

        function resetForm() {
            document.getElementById('formTitle').innerText = 'Tambah Bus';
            document.getElementById('busForm').action = '<?= BASEURL; ?>/index.php?controller=operator&action=bilAdd';
            document.getElementById('busForm').reset();
            document.getElementById('kapasitas_info').textContent = '—';
            document.getElementById('btnSubmit').innerText = 'Simpan Bus';
            document.getElementById('btnBatal').style.display = 'none';
        }
    </script>
</body>
</html>
