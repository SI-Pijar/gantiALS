<?php
// Tentukan halaman aktif dari query string
$halamanAktif = $_GET['page'] ?? 'dashboard';
?>
<aside class="SidebarNavigasi">
  <div class="LogoSidebar">
    <img src="public/gambar/logo als.jpg" alt="Logo ALS" />
    <span>ALS ADMIN</span>
  </div>

  <nav class="MenuNavigasi">
    <a href="index.php?page=dashboard"  class="ItemMenu <?= $halamanAktif === 'dashboard'  ? 'aktif' : '' ?>">
      <i class="fa-solid fa-gauge-high"></i>
      <span>Dashboard</span>
    </a>
    <a href="index.php?page=jadwal"     class="ItemMenu <?= $halamanAktif === 'jadwal'     ? 'aktif' : '' ?>">
      <i class="fa-solid fa-calendar-days"></i>
      <span>Kelola Jadwal</span>
    </a>
    <a href="index.php?page=Penumpang"   class="ItemMenu <?= $halamanAktif === 'Penumpang'   ? 'aktif' : '' ?>">
      <i class="fa-solid fa-users"></i>
      <span>Kelola Penumpang</span>
    </a>
    <a href="index.php?page=transaksi"  class="ItemMenu <?= $halamanAktif === 'transaksi'  ? 'aktif' : '' ?>">
      <i class="fa-solid fa-receipt"></i>
      <span>Laporan Transaksi</span>
    </a>
    <a href="index.php?page=pengaturan" class="ItemMenu <?= $halamanAktif === 'pengaturan' ? 'aktif' : '' ?>">
      <i class="fa-solid fa-gears"></i>
      <span>Pengaturan Sistem</span>
    </a>
    <a href="index.php?page=log"        class="ItemMenu <?= $halamanAktif === 'log'        ? 'aktif' : '' ?>">
      <i class="fa-solid fa-server"></i>
      <span>Log Sistem</span>
    </a>
  </nav>

  <div class="AreaUserSidebar">
    <a href="index.php?page=logout" class="TombolLogout">
      <i class="fa-solid fa-arrow-right-from-bracket"></i>
      <span>Logout</span>
    </a>
  </div>
</aside>
