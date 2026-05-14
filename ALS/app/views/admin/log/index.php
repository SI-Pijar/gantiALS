<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Log Sistem - Admin Panel ALS</title>
  <link rel="stylesheet" href="public/css/admin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
<div class="TataLetakAdmin">

  <?php require_once __DIR__ . '/../sidebar.php'; ?>

  <main class="KontenUtamaAdmin">
    <header class="HeaderKonten">
      <h1>Log Aktivitas dan Error Sistem</h1>
      <div class="ProfilAdmin">
        <span>Selamat datang, <strong><?= htmlspecialchars($_SESSION['admin_nama']) ?></strong></span>
        <i class="fa-solid fa-user-shield"></i>
      </div>
    </header>

    <?php if (!empty($success)): ?>
      <div class="AlertSuccess"><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="KartuKontenBesar">
      <div class="HeaderKartu">
        <h3><i class="fa-solid fa-server"></i> Riwayat Log</h3>
        <?php if ($_SESSION['admin_role'] === 'superadmin'): ?>
        <a href="index.php?page=log&action=hapus"
           class="TombolAksi" style="background:#ef4444;"
           onclick="return confirm('Yakin hapus semua log?')">
          <i class="fa-solid fa-trash"></i> Hapus Semua Log
        </a>
        <?php endif; ?>
      </div>

      <table class="TabelData">
        <thead>
          <tr>
            <th>Waktu</th>
            <th>Penumpang</th>
            <th>Aktivitas</th>
            <th>Level</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $rows = $logs->fetchAll(PDO::FETCH_ASSOC);
          if (empty($rows)):
          ?>
            <tr><td colspan="4" style="text-align:center;color:#64748b;">Belum ada log.</td></tr>
          <?php else: ?>
            <?php foreach ($rows as $log): ?>
            <tr>
              <td><?= date('d M Y H:i:s', strtotime($log['created_at'])) ?></td>
              <td><?= htmlspecialchars($log['username'] ?? '-') ?></td>
              <td><?= htmlspecialchars($log['aktivitas']) ?></td>
              <td>
                <?php
                $badge = match($log['level']) {
                    'berhasil' => 'berhasil',
                    'error'    => 'nonaktif',
                    default    => 'info',
                };
                ?>
                <span class="StatusBadge <?= $badge ?>"><?= ucfirst($log['level']) ?></span>
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
