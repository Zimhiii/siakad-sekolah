<?php
$currentRole = session()->get('role') ?? ($role ?? 'admin');
$namaUser = session()->get('nama_user') ?? match($currentRole) {
    'admin' => 'Administrator Sekolah',
    'guru' => 'Ustadz Hendra Gunawan, M.Pd.',
    'tu' => 'M. Taufik Hidayat, S.Sos.',
    'siswa' => 'Muhammad Raihan Pratama',
    default => 'Pengguna SIAKAD'
};
$isFigmaExportMode = !empty($isFigmaExport) || str_contains(uri_string(), 'figma-export');
?>
<!-- Navbar -->
<nav class="app-header navbar navbar-expand bg-body shadow-sm">
  <div class="container-fluid">
    <!-- Left navbar links -->
    <ul class="navbar-nav align-items-center">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
          <i class="bi bi-list fs-4"></i>
        </a>
      </li>
      <li class="nav-item d-none d-md-block ms-2">
        <span class="badge bg-primary px-2.5 py-1.5">
          <?= esc($taAktif ?? '2025/2026 - Ganjil (Aktif)') ?>
        </span>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ms-auto align-items-center gap-2">
      <?php if (!$isFigmaExportMode): ?>
      <!-- Quick Role Switcher (Mode Development Saja) -->
      <li class="nav-item dropdown">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-1 px-3 py-1.5" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="d-none d-sm-inline text-capitalize">Peran: <?= esc($currentRole) ?></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
          <li><h6 class="dropdown-header text-uppercase fs-7">Ganti Peran:</h6></li>
          <li><a class="dropdown-item <?= $currentRole === 'admin' ? 'active' : '' ?>" href="<?= base_url('auth/switch/admin') ?>">Admin Sekolah</a></li>
          <li><a class="dropdown-item <?= $currentRole === 'guru' ? 'active' : '' ?>" href="<?= base_url('auth/switch/guru') ?>">Guru & Wali Kelas</a></li>
          <li><a class="dropdown-item <?= $currentRole === 'tu' ? 'active' : '' ?>" href="<?= base_url('auth/switch/tu') ?>">Tata Usaha (TU)</a></li>
          <li><a class="dropdown-item <?= $currentRole === 'siswa' ? 'active' : '' ?>" href="<?= base_url('auth/switch/siswa') ?>">Siswa / Orang Tua</a></li>
        </ul>
      </li>
      <?php endif; ?>

      <!-- Dark Mode Toggle Button -->
      <li class="nav-item">
        <button class="btn btn-icon btn-ghost-secondary rounded-circle" id="theme-toggle-btn" title="Toggle Tema Gelap / Terang">
          <i class="bi bi-moon-stars fs-5" id="theme-icon"></i>
        </button>
      </li>

      <!-- User Dropdown Menu -->
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
          <img src="https://ui-avatars.com/api/?name=<?= urlencode($namaUser) ?>&background=1E3A5F&color=fff&size=64" class="user-image rounded-circle flex-shrink-0" alt="User Image" width="34" height="34" style="width: 34px; height: 34px; object-fit: cover;">
          <span class="d-none d-md-inline"><?= esc($namaUser) ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
          <!-- User image -->
          <li class="user-header bg-primary text-white p-3 text-center rounded-top">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($namaUser) ?>&background=ffffff&color=1E3A5F&size=128" class="rounded-circle mb-2" alt="User Image" width="60" height="60">
            <p class="mb-0"><?= esc($namaUser) ?></p>
            <small class="text-white-50 text-capitalize"><?= esc($currentRole) ?> - SMA IT Fithrah Insani</small>
          </li>
          <!-- Menu Footer-->
          <li class="user-footer p-2 d-flex justify-content-between align-items-center bg-body-tertiary">
            <a href="<?= base_url($currentRole === 'siswa' ? 'siswa/profil' : ($currentRole === 'admin' ? 'admin/sekolah' : ($currentRole === 'tu' ? 'tu/dashboard' : 'guru/mapel'))) ?>" class="btn btn-default btn-sm">Profil Akun</a>
            <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-danger btn-sm">Keluar</a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
<!-- /.navbar -->
