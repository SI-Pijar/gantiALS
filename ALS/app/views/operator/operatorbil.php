<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Bus Operator</title>
    <link rel="stylesheet" href="/gantiALS/ALS/public/css/operator.css?v=4">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="/gantiALS/ALS/public/gambar/logo%20als.jpg" alt="Logo ALS">
            <span>Operator ALS</span>
        </div>
        <nav class="sidebar-nav">
            <a href="/gantiALS/index.php?page=operatorDashboard">
                <span>Dashboard</span>
            </a>
            <a href="/gantiALS/index.php?page=operatorBus" class="active">
                <span>Kelola Bus</span>
            </a>
            <a href="/gantiALS/index.php?page=operatorJadwal">
                <span>Kelola Jadwal</span>
            </a>
            <a href="/gantiALS/index.php?page=operatorPemesanan">
                <span>Kelola Pemesanan</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="/gantiALS/index.php?page=operatorLogout">
                <span>Logout</span>
            </a>
        </div>
    </div>
    <div class="content">
        <h2>Kelola Bus</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="card">
            <h3 id="formTitle">Tambah Bus</h3>
            <form id="busForm" action="/gantiALS/index.php?page=operatorBus&action=add" method="POST">
                <div class="form-group">
                    <label>No Polisi</label>
                    <input type="text" name="no_polisi" id="no_polisi" required>
                </div>
                <div class="form-group">
                    <label>Kelas Bus</label>
                    <input type="text" name="kelas_bus" id="kelas_bus" required>
                </div>
                <div class="form-group">
                    <label>Kapasitas Kursi</label>
                    <input type="number" name="kapasitas" id="kapasitas" required min="1">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status_bus" id="status_bus">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success" id="btnSubmit">Simpan Bus</button>
                <button type="button" class="btn btn-warning" onclick="resetForm()" style="display:none;" id="btnBatal">Batal Edit</button>
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
                                <button class="btn btn-warning" onclick="editBus(<?= $bus['id'] ?>, '<?= htmlspecialchars($bus['no_polisi']) ?>', '<?= htmlspecialchars($bus['kelas_bus']) ?>', <?= $bus['kapasitas'] ?>, '<?= $bus['status_bus'] ?>')">Edit</button>
                                <a href="/gantiALS/index.php?page=operatorBus&action=delete&id=<?= $bus['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus bus ini?')">Hapus</a>
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
        function editBus(id, noPolisi, kelas, kapasitas, status) {
            document.getElementById('formTitle').innerText = 'Edit Bus';
            document.getElementById('busForm').action = '/gantiALS/index.php?page=operatorBus&action=edit&id=' + id;
            document.getElementById('no_polisi').value = noPolisi;
            document.getElementById('kelas_bus').value = kelas;
            document.getElementById('kapasitas').value = kapasitas;
            document.getElementById('status_bus').value = status;
            document.getElementById('btnSubmit').innerText = 'Update Bus';
            document.getElementById('btnBatal').style.display = 'inline-block';
            window.scrollTo(0, 0);
        }

        function resetForm() {
            document.getElementById('formTitle').innerText = 'Tambah Bus';
            document.getElementById('busForm').action = '/gantiALS/index.php?page=operatorBus&action=add';
            document.getElementById('busForm').reset();
            document.getElementById('btnSubmit').innerText = 'Simpan Bus';
            document.getElementById('btnBatal').style.display = 'none';
        }
    </script>
</body>
</html>