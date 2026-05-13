<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kelola Pengguna - Admin Panel ALS</title>
  <link rel="stylesheet" href="public/css/admin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
<div class="TataLetakAdmin">

  <?php require_once __DIR__ . '/../sidebar.php'; ?>

  <main class="KontenUtamaAdmin">
    <header class="HeaderKonten">
      <h1>Kelola Pengguna &amp; Hak Akses</h1>
      <div class="ProfilAdmin">
        <span>Selamat datang, <strong><?= htmlspecialchars($_SESSION['admin_nama']) ?></strong></span>
        <i class="fa-solid fa-user-shield"></i>
      </div>
    </header>

    <?php if (!empty($success)): ?>
      <div class="AlertSuccess"><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
      <div class="AlertError"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="KartuKontenBesar">
      <div class="HeaderKartu">
        <h3><i class="fa-solid fa-users"></i> Daftar Pengguna Sistem</h3>
        <a href="index.php?page=pengguna&action=tambah" class="TombolAksi">
          <i class="fa-solid fa-plus"></i> Tambah Pengguna
        </a>
      </div>

      <table class="TabelData">
        <thead>
          <tr>
            <th>Username</th>
            <th>Nama Lengkap</th>
            <th>Hak Akses</th>
            <th>Status</th>
            <th>Dibuat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $rows = $pengguna->fetchAll(PDO::FETCH_ASSOC);
          if (empty($rows)):
          ?>
            <tr><td colspan="6" style="text-align:center;color:#64748b;">Belum ada pengguna.</td></tr>
          <?php else: ?>
            <?php foreach ($rows as $u): ?>
            <tr>
              <td><?= htmlspecialchars($u['username']) ?></td>
              <td><?= htmlspecialchars($u['nama_lengkap']) ?></td>
              <td>
                <span class="StatusBadge <?= $u['role'] ?>">
                  <?= ucfirst($u['role']) ?>
                </span>
              </td>
              <td>
                <span class="StatusBadge <?= $u['status'] === 'aktif' ? 'berhasil' : 'nonaktif' ?>">
                  <?= $u['status'] === 'aktif' ? 'Aktif' : 'Non-Aktif' ?>
                </span>
              </td>
              <td><?= date('d M Y', strtotime($u['created_at'])) ?></td>
              <td class="KolomAksi">
                <a href="index.php?page=pengguna&action=edit&id=<?= $u['id'] ?>" class="TombolIkon edit" title="Edit">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="index.php?page=pengguna&action=toggle&id=<?= $u['id'] ?>" class="TombolIkon" style="color:#0ea5e9;" title="Toggle Status">
                  <i class="fa-solid fa-power-off"></i>
                </a>
                <a href="index.php?page=pengguna&action=hapus&id=<?= $u['id'] ?>"
                   class="TombolIkon hapus" title="Hapus"
                   onclick="return confirm('Yakin hapus pengguna <?= htmlspecialchars($u['username']) ?>?')">
                  <i class="fa-solid fa-trash"></i>
                </a>
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
