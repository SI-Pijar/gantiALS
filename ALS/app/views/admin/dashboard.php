<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - Admin Panel ALS</title>
  <link rel="stylesheet" href="public/css/admin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
<div class="TataLetakAdmin">

  <?php require_once __DIR__ . '/sidebar.php'; ?>

  <main class="KontenUtamaAdmin">
    <header class="HeaderKonten">
      <h1>Dashboard</h1>
      <div class="ProfilAdmin">
        <span>Selamat datang, <strong><?= htmlspecialchars($_SESSION['admin_nama']) ?></strong></span>
        <i class="fa-solid fa-user-shield"></i>
      </div>
    </header>

    <!-- Kartu Statistik -->
    <div class="GridStatistik">
      <div class="KartuStatistik">
        <div class="IkonKartu" style="background-color:#e0f2fe">
          <i class="fa-solid fa-wallet" style="color:#0ea5e9"></i>
        </div>
        <div class="InfoKartu">
          <p>Total Transaksi (Hari Ini)</p>
          <span>Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></span>
        </div>
      </div>

      <div class="KartuStatistik">
        <div class="IkonKartu" style="background-color:#f0fdf4">
          <i class="fa-solid fa-ticket" style="color:#22c55e"></i>
        </div>
        <div class="InfoKartu">
          <p>Tiket Terjual (Hari Ini)</p>
          <span><?= $tiketTerjual ?> Tiket</span>
        </div>
      </div>

      <div class="KartuStatistik">
        <div class="IkonKartu" style="background-color:#fffbeb">
          <i class="fa-solid fa-users" style="color:#f59e0b"></i>
        </div>
        <div class="InfoKartu">
          <p>Pengguna Terdaftar</p>
          <span><?= $totalPengguna ?></span>
        </div>
      </div>

      <div class="KartuStatistik">
        <div class="IkonKartu" style="background-color:#fef2f2">
          <i class="fa-solid fa-triangle-exclamation" style="color:#ef4444"></i>
        </div>
        <div class="InfoKartu">
          <p>Gangguan Sistem</p>
          <span><?= $gangguanSistem ?> Laporan</span>
        </div>
      </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="KartuKontenBesar">
      <h3><i class="fa-solid fa-list-check"></i> Aktivitas Sistem Terbaru</h3>
      <table class="TabelData">
        <thead>
          <tr>
            <th>Waktu</th>
            <th>Pengguna</th>
            <th>Aktivitas</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($aktivitasTerbaru)): ?>
            <tr><td colspan="4" style="text-align:center;color:#64748b;">Belum ada aktivitas.</td></tr>
          <?php else: ?>
            <?php foreach ($aktivitasTerbaru as $log): ?>
            <tr>
              <td><?= date('d M Y H:i', strtotime($log['created_at'])) ?></td>
              <td><?= htmlspecialchars($log['username'] ?? '-') ?></td>
              <td><?= htmlspecialchars($log['aktivitas']) ?></td>
              <td>
                <span class="StatusBadge <?= $log['level'] === 'berhasil' ? 'berhasil' : ($log['level'] === 'error' ? 'nonaktif' : 'info') ?>">
                  <?= ucfirst($log['level']) ?>
                </span>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </main>
</div>
</body>
</html>
