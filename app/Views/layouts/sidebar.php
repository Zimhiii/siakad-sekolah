<?php
$currentRole = session()->get('role') ?? ($role ?? 'admin');
$activeMenu = $menu ?? 'dashboard';
$activeSubmenu = $submenu ?? '';
$namaSekolah = $sekolah['nama_sekolah'] ?? 'SMA IT Fithrah Insani';
?>
<!-- Main Sidebar Container -->
<aside class="app-sidebar bg-body-secondary border-end">
  <!-- Sidebar Brand -->
  <div class="sidebar-brand d-flex align-items-center justify-content-between px-3 border-bottom">
    <a href="<?= base_url($currentRole) ?>" class="brand-link d-flex align-items-center gap-2 text-decoration-none">
      <div class="bg-primary text-white rounded-3 p-1 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
        <i class="bi bi-mortarboard-fill fs-5"></i>
      </div>
      <div class="brand-text d-flex flex-column text-body">
        <span class="fs-6 lh-1 fw-semibold">SIAKAD</span>
        <small class="text-secondary fs-8 text-truncate" style="max-width: 170px;">Fithrah Insani</small>
      </div>
    </a>
  </div>

  <!-- Sidebar Content -->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

        <?php if ($currentRole === 'admin'): ?>
          <!-- Admin Menu -->
          <li class="nav-header text-uppercase text-secondary fs-8 px-3 py-2">Utama</li>
          
          <li class="nav-item">
            <a href="<?= base_url('admin') ?>" class="nav-link <?= $activeMenu === 'dashboard' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-speedometer2"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('admin/sekolah') ?>" class="nav-link <?= $activeMenu === 'sekolah' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-building-gear"></i>
              <p>Data Sekolah</p>
            </a>
          </li>

          <li class="nav-header text-uppercase text-secondary fs-8 px-3 py-2 mt-2">Akademik & Penilaian</li>

          <li class="nav-item <?= in_array($activeMenu, ['master_akademik']) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?= $activeMenu === 'master_akademik' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-journal-bookmark"></i>
              <p>
                Master Akademik
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('admin/tahun-ajaran') ?>" class="nav-link <?= $activeSubmenu === 'tahun_ajaran' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Tahun Ajaran & Semester</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/tingkatan') ?>" class="nav-link <?= $activeSubmenu === 'tingkatan' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Tingkatan Kelas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/jurusan') ?>" class="nav-link <?= $activeSubmenu === 'jurusan' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Jurusan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/mapel') ?>" class="nav-link <?= $activeSubmenu === 'mapel' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Mata Pelajaran & Kelompok</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item <?= in_array($activeMenu, ['master_penilaian']) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?= $activeMenu === 'master_penilaian' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-award"></i>
              <p>
                Master Penilaian
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('admin/komponen-nilai') ?>" class="nav-link <?= $activeSubmenu === 'komponen_nilai' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Komponen Nilai & Bobot</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/kriteria-penilaian') ?>" class="nav-link <?= $activeSubmenu === 'kriteria_penilaian' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>KKM & Interval Predikat</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/sikap') ?>" class="nav-link <?= $activeSubmenu === 'sikap_ekskul_prestasi' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Sikap, Ekskul & Prestasi</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item <?= in_array($activeMenu, ['kelas_penugasan']) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?= $activeMenu === 'kelas_penugasan' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-diagram-3"></i>
              <p>
                Kelas & Penugasan
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('admin/kelas') ?>" class="nav-link <?= $activeSubmenu === 'kelas' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Kelola Kelas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/penugasan') ?>" class="nav-link <?= $activeSubmenu === 'penugasan' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Penugasan Guru Mengajar</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-header text-uppercase text-secondary fs-8 px-3 py-2 mt-2">Data Pengguna & Raport</li>

          <li class="nav-item <?= in_array($activeMenu, ['data_pengguna']) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?= $activeMenu === 'data_pengguna' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-people"></i>
              <p>
                Data Pengguna
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('admin/guru') ?>" class="nav-link <?= $activeSubmenu === 'guru' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Data Guru</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/siswa') ?>" class="nav-link <?= $activeSubmenu === 'siswa' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Data Siswa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/orang-tua') ?>" class="nav-link <?= $activeSubmenu === 'ortu' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Data Orang Tua / Wali</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/staff-tu') ?>" class="nav-link <?= $activeSubmenu === 'staff_tu' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Akun Staff TU</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('admin/raport/buka-kunci') ?>" class="nav-link <?= $activeMenu === 'raport' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-unlock"></i>
              <p>Buka Kunci Raport</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('admin/ujian-sekolah') ?>" class="nav-link <?= $activeMenu === 'ujian_sekolah' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-calculator"></i>
              <p>Ujian Sekolah &amp; Kelulusan</p>
            </a>
          </li>

          <li class="nav-header text-uppercase text-secondary fs-8 px-3 py-2 mt-2">Persuratan & Arsip</li>

          <li class="nav-item <?= in_array($activeMenu, ['modul_surat']) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?= $activeMenu === 'modul_surat' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-envelope-paper"></i>
              <p>
                Modul Surat
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('admin/kategori-surat') ?>" class="nav-link <?= $activeSubmenu === 'kategori_surat' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Kategori Surat</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/format-surat') ?>" class="nav-link <?= $activeSubmenu === 'format_surat' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Format Penomoran</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('admin/arsip') ?>" class="nav-link <?= $activeMenu === 'arsip' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-archive"></i>
              <p>Modul Arsip Terpadu</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('admin/log-audit') ?>" class="nav-link <?= (($activeSubmenu ?? '') === 'log_audit') ? 'active' : '' ?>">
              <i class="nav-icon bi bi-clock-history"></i>
              <p>Pusat Log Audit</p>
            </a>
          </li>

        <?php elseif ($currentRole === 'guru'): ?>
          <!-- Guru Menu -->
          <li class="nav-header text-uppercase text-secondary fs-8 px-3 py-2">Menu Pendidik</li>

          <li class="nav-item">
            <a href="<?= base_url('guru/dashboard/wali') ?>" class="nav-link <?= ($activeMenu === 'dashboard' && $activeSubmenu === 'wali') ? 'active' : '' ?>">
              <i class="nav-icon bi bi-speedometer2"></i>
              <p>Dashboard Wali Kelas</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('guru/dashboard/mapel') ?>" class="nav-link <?= ($activeMenu === 'dashboard' && $activeSubmenu === 'mapel') ? 'active' : '' ?>">
              <i class="nav-icon bi bi-pie-chart"></i>
              <p>Dashboard Guru Mapel</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('guru/mapel') ?>" class="nav-link <?= $activeMenu === 'mapel_saya' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-journal-text"></i>
              <p>Mata Pelajaran Saya</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('guru/nilai') ?>" class="nav-link <?= $activeMenu === 'input_nilai' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-pencil-square"></i>
              <p>Input Nilai Siswa</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('guru/tugas') ?>" class="nav-link <?= $activeMenu === 'tugas_harian' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-calendar2-check"></i>
              <p>Tugas Harian & UH</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('guru/presensi') ?>" class="nav-link <?= $activeMenu === 'presensi_kelas' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-clipboard2-check"></i>
              <p>Presensi & Jurnal KBM</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('guru/analitik') ?>" class="nav-link <?= $activeMenu === 'analitik' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-graph-up-arrow"></i>
              <p>Analitik Nilai</p>
            </a>
          </li>

          <li class="nav-header text-uppercase text-secondary fs-8 px-3 py-2 mt-2">Khusus Wali Kelas (XI-MIPA-1)</li>

          <li class="nav-item">
            <a href="<?= base_url('guru/perwalian') ?>" class="nav-link <?= $activeMenu === 'kelas_perwalian' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-person-lines-fill"></i>
              <p>Sikap, Ekskul & Absensi</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('guru/leger') ?>" class="nav-link <?= $activeMenu === 'leger_nilai' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-grid-3x3-gap"></i>
              <p>Matriks Nilai Kelas</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('guru/kenaikan-kelas') ?>" class="nav-link <?= $activeMenu === 'kenaikan_kelas' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-arrow-up-right-circle"></i>
              <p>Kenaikan Kelas / Lulus</p>
            </a>
          </li>

          <li class="nav-item <?= in_array($activeMenu, ['raport']) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?= $activeMenu === 'raport' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-file-earmark-text"></i>
              <p>
                Raport Digital
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('guru/raport/generate') ?>" class="nav-link <?= $activeSubmenu === 'generate' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Generate Raport</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('guru/raport/tinjau') ?>" class="nav-link <?= $activeSubmenu === 'tinjau' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Tinjau Raport Kertas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('guru/raport/buka-kunci') ?>" class="nav-link <?= $activeSubmenu === 'buka_kunci' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Buka Kunci Revisi</p>
                </a>
              </li>
            </ul>
          </li>

        <?php elseif ($currentRole === 'tu'): ?>
          <!-- TU Menu -->
          <li class="nav-header text-uppercase text-secondary fs-8 px-3 py-2">Tata Usaha & Surat</li>

          <li class="nav-item">
            <a href="<?= base_url('tu') ?>" class="nav-link <?= $activeMenu === 'dashboard' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-speedometer2"></i>
              <p>Dashboard TU</p>
            </a>
          </li>

          <li class="nav-item <?= in_array($activeMenu, ['surat_masuk']) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?= $activeMenu === 'surat_masuk' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-inbox"></i>
              <p>
                Surat Masuk
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('tu/surat-masuk') ?>" class="nav-link <?= $activeSubmenu === 'list' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Daftar Surat Masuk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tu/surat-masuk/tambah') ?>" class="nav-link <?= $activeSubmenu === 'tambah' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Catat Surat Masuk</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item <?= in_array($activeMenu, ['surat_keluar']) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?= $activeMenu === 'surat_keluar' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-send"></i>
              <p>
                Surat Keluar
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('tu/surat-keluar') ?>" class="nav-link <?= $activeSubmenu === 'list' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Daftar Surat Keluar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tu/surat-keluar/tambah') ?>" class="nav-link <?= $activeSubmenu === 'tambah' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-circle fs-8"></i>
                  <p>Buat Surat Keluar</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('tu/arsip') ?>" class="nav-link <?= $activeMenu === 'arsip_surat' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-archive"></i>
              <p>Arsip Surat</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('tu/agenda') ?>" class="nav-link <?= $activeMenu === 'buku_agenda' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-printer"></i>
              <p>Cetak Buku Agenda</p>
            </a>
          </li>

        <?php elseif ($currentRole === 'siswa'): ?>
          <!-- Siswa Menu -->
          <li class="nav-header text-uppercase text-secondary fs-8 px-3 py-2">Portal Siswa</li>

          <li class="nav-item">
            <a href="<?= base_url('siswa') ?>" class="nav-link <?= $activeMenu === 'beranda' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-house-door"></i>
              <p>Beranda</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('siswa/profil') ?>" class="nav-link <?= $activeMenu === 'profil' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-person-badge"></i>
              <p>Profil Saya</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('siswa/nilai') ?>" class="nav-link <?= $activeMenu === 'nilai' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-card-checklist"></i>
              <p>Nilai Akademik</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('siswa/status') ?>" class="nav-link <?= $activeMenu === 'status' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-check2-circle"></i>
              <p>Status Akademik</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('siswa/raport') ?>" class="nav-link <?= $activeMenu === 'raport' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-file-earmark-pdf"></i>
              <p>Raport Digital</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('siswa/transkrip') ?>" class="nav-link <?= $activeMenu === 'transkrip' ? 'active' : '' ?>">
              <i class="nav-icon bi bi-award-fill"></i>
              <p>Transkrip Nilai (6 Smt)</p>
            </a>
          </li>
        <?php endif; ?>

      </ul>
    </nav>
  </div>
</aside>
<!-- /.sidebar -->
