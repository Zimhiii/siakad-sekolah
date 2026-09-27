<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Katalog Halaman Statis Per-Kondisi (Export to Figma) - SIAKAD</title>

  <!-- Bootstrap 5.3 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Google Fonts: Montserrat & Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Montserrat', system-ui, sans-serif;
      background-color: #f8fafc;
      color: #1e293b;
    }
    h1, h2, h3, h4, h5, .brand-title {
      font-family: 'Poppins', 'Montserrat', sans-serif;
      font-weight: 700;
    }
    .badge-condition {
      font-size: 0.72rem;
      font-weight: 500;
      letter-spacing: 0.02em;
    }
    .list-group-item:hover {
      background-color: #f1f5f9;
    }
    .role-card {
      transition: transform 0.15s ease, box-shadow 0.15s ease;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
    }
    .search-box {
      border-radius: 20px;
    }
  </style>
</head>
<body class="py-4">
<div class="container py-2">
  
  <!-- Header Banner -->
  <div class="card border-0 shadow-sm mb-4 bg-primary text-white rounded-3 p-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
      <div>
        <div class="d-flex align-items-center gap-2 mb-2">
          <i class="bi bi-box-arrow-up-right fs-3"></i>
          <h3 class="mb-0 fw-bold">Katalog Halaman Per-Kondisi (Figma Export)</h3>
        </div>
        <p class="mb-0 opacity-75 small">
          Pusat navigasi halaman statis yang siap di-convert ke Figma via <a href="https://htmltofigma.net/" target="_blank" class="text-white text-decoration-underline fw-semibold">HTML to Figma Converter</a>. Setiap URL menampilkan satu kondisi final langsung tanpa perlu interaksi klik.
        </p>
      </div>
      <div class="text-md-end flex-shrink-0">
        <span class="badge bg-white text-primary px-3 py-2 fs-7 fw-bold shadow-sm">
          Total 117 Halaman Statis
        </span>
      </div>
    </div>
  </div>

  <!-- Search & Quick Navigation Bar -->
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
      <div class="row g-3 align-items-center">
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search text-secondary"></i></span>
            <input type="text" id="filterInput" class="form-control border-start-0" placeholder="Cari halaman, role, atau kondisi... (contoh: modal, draft, remedial)">
          </div>
        </div>
        <div class="col-md-6">
          <div class="d-flex flex-wrap gap-2 justify-content-md-end">
            <a href="#sec-auth" class="btn btn-outline-secondary btn-sm">Auth (4)</a>
            <a href="#sec-admin" class="btn btn-outline-secondary btn-sm">Admin (53)</a>
            <a href="#sec-guru" class="btn btn-outline-secondary btn-sm">Guru (31)</a>
            <a href="#sec-tu" class="btn btn-outline-secondary btn-sm">Tata Usaha (16)</a>
            <a href="#sec-siswa" class="btn btn-outline-secondary btn-sm">Siswa (13)</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Section 1: Auth -->
  <div class="mb-4" id="sec-auth">
    <div class="card role-card shadow-sm">
      <div class="card-header bg-body py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-shield-lock-fill text-primary fs-5"></i>
          <h5 class="mb-0 fw-bold">1. Autentikasi &amp; Login</h5>
        </div>
        <span class="badge bg-primary-subtle text-primary border">4 Kondisi</span>
      </div>
      <div class="list-group list-group-flush" id="authList">
        <a href="<?= base_url('figma-export/auth/login-default') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div>
            <div class="fw-semibold text-body">Login: Default (Normal Form Siap Isi)</div>
            <small class="text-secondary font-monospace">/figma-export/auth/login-default</small>
          </div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default Clean Form</span>
        </a>
        <a href="<?= base_url('figma-export/auth/login-error') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div>
            <div class="fw-semibold text-body">Login: Pesan Error Username/Password Salah</div>
            <small class="text-secondary font-monospace">/figma-export/auth/login-error</small>
          </div>
          <span class="badge bg-danger-subtle text-danger border border-danger-subtle badge-condition">Alert Error Tampil</span>
        </a>
        <a href="<?= base_url('figma-export/auth/login-kredensial-salah') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div>
            <div class="fw-semibold text-body">Login: Input Berwarna Merah (Kredensial Tidak Valid)</div>
            <small class="text-secondary font-monospace">/figma-export/auth/login-kredensial-salah</small>
          </div>
          <span class="badge bg-danger-subtle text-danger border border-danger-subtle badge-condition">Border Input Merah</span>
        </a>
        <a href="<?= base_url('figma-export/auth/login-lupa-password') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div>
            <div class="fw-semibold text-body">Login: Bantuan Lupa Kata Sandi (Modal Pop-up Aktif)</div>
            <small class="text-secondary font-monospace">/figma-export/auth/login-lupa-password</small>
          </div>
          <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle badge-condition">Modal Pop-up Terbuka</span>
        </a>
      </div>
    </div>
  </div>

  <!-- Section 2: Admin -->
  <div class="mb-4" id="sec-admin">
    <div class="card role-card shadow-sm">
      <div class="card-header bg-body py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-gear-fill text-primary fs-5"></i>
          <h5 class="mb-0 fw-bold">2. Administrator Sekolah</h5>
        </div>
        <span class="badge bg-primary-subtle text-primary border">53 Halaman &amp; Kondisi</span>
      </div>
      <div class="list-group list-group-flush" id="adminList">
        
        <!-- Dashboard & Profil Sekolah -->
        <a href="<?= base_url('figma-export/admin/dashboard') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Dashboard Admin</div><small class="text-secondary font-monospace">/figma-export/admin/dashboard</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/sekolah') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Profil Sekolah &amp; Legalitas</div><small class="text-secondary font-monospace">/figma-export/admin/sekolah</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/tahun-ajaran-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Tahun Ajaran &amp; Semester (Daftar)</div><small class="text-secondary font-monospace">/figma-export/admin/tahun-ajaran-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>

        <!-- Wizard 6 Langkah -->
        <a href="<?= base_url('figma-export/admin/wizard-step1-terblokir') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Wizard Langkah 1: Terblokir (Prasyarat Pleno Belum Tuntas)</div><small class="text-secondary font-monospace">/figma-export/admin/wizard-step1-terblokir</small></div>
          <span class="badge bg-danger-subtle text-danger border border-danger-subtle badge-condition">Banner Gatekeeper</span>
        </a>
        <a href="<?= base_url('figma-export/admin/wizard-step1-siap-lanjut') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Wizard Langkah 1: Siap Lanjut (Semua Pleno Tuntas)</div><small class="text-secondary font-monospace">/figma-export/admin/wizard-step1-siap-lanjut</small></div>
          <span class="badge bg-success-subtle text-success border border-success-subtle badge-condition">Tombol Lanjut Aktif</span>
        </a>
        <a href="<?= base_url('figma-export/admin/wizard-step2') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Wizard Langkah 2: Kelas &amp; Kapasitas Siswa</div><small class="text-secondary font-monospace">/figma-export/admin/wizard-step2</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/wizard-step3') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Wizard Langkah 3: Penunjukan Wali Kelas</div><small class="text-secondary font-monospace">/figma-export/admin/wizard-step3</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/wizard-step4') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Wizard Langkah 4: Kenaikan Kelas &amp; Mutasi</div><small class="text-secondary font-monospace">/figma-export/admin/wizard-step4</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/wizard-step5') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Wizard Langkah 5: Penugasan Guru Mengajar</div><small class="text-secondary font-monospace">/figma-export/admin/wizard-step5</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/wizard-step6-belum-lengkap') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Wizard Langkah 6: Prasyarat Belum Lengkap (Tombol Disabled)</div><small class="text-secondary font-monospace">/figma-export/admin/wizard-step6-belum-lengkap</small></div>
          <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle badge-condition">Tombol Disabled</span>
        </a>
        <a href="<?= base_url('figma-export/admin/wizard-step6-lengkap') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Wizard Langkah 6: Semua Terverifikasi (Tombol Aktif)</div><small class="text-secondary font-monospace">/figma-export/admin/wizard-step6-lengkap</small></div>
          <span class="badge bg-success-subtle text-success border border-success-subtle badge-condition">Tombol Aktif</span>
        </a>
        <a href="<?= base_url('figma-export/admin/aktivasi-semester-genap') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Aktivasi Semester Genap (Transisi)</div><small class="text-secondary font-monospace">/figma-export/admin/aktivasi-semester-genap</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>

        <!-- Master Akademik -->
        <a href="<?= base_url('figma-export/admin/tingkatan-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Master Tingkatan Kelas (Daftar)</div><small class="text-secondary font-monospace">/figma-export/admin/tingkatan-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/tingkatan-modal-tambah') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Master Tingkatan Kelas: Modal Tambah Terbuka</div><small class="text-secondary font-monospace">/figma-export/admin/tingkatan-modal-tambah</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/admin/jurusan-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Master Jurusan / Peminatan (Daftar)</div><small class="text-secondary font-monospace">/figma-export/admin/jurusan-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/jurusan-modal-tambah') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Master Jurusan: Modal Tambah Terbuka</div><small class="text-secondary font-monospace">/figma-export/admin/jurusan-modal-tambah</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/admin/mapel-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Master Mata Pelajaran &amp; Kelompok (Daftar)</div><small class="text-secondary font-monospace">/figma-export/admin/mapel-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/mapel-modal-tambah') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Master Mapel: Modal Tambah Terbuka</div><small class="text-secondary font-monospace">/figma-export/admin/mapel-modal-tambah</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/admin/komponen-nilai-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Master Komponen Nilai &amp; Bobot (Daftar)</div><small class="text-secondary font-monospace">/figma-export/admin/komponen-nilai-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/komponen-nilai-modal-tambah') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Master Komponen Nilai: Modal Tambah Terbuka</div><small class="text-secondary font-monospace">/figma-export/admin/komponen-nilai-modal-tambah</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/admin/kriteria-penilaian-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">KKM &amp; Interval Predikat Kurikulum</div><small class="text-secondary font-monospace">/figma-export/admin/kriteria-penilaian-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/sikap-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Master Aspek Sikap (Daftar)</div><small class="text-secondary font-monospace">/figma-export/admin/sikap-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/sikap-modal-tambah') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Master Aspek Sikap: Modal Tambah Terbuka</div><small class="text-secondary font-monospace">/figma-export/admin/sikap-modal-tambah</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/admin/ekskul-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Master Ekstrakurikuler (Daftar)</div><small class="text-secondary font-monospace">/figma-export/admin/ekskul-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/ekskul-modal-tambah') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Master Ekstrakurikuler: Modal Tambah Terbuka</div><small class="text-secondary font-monospace">/figma-export/admin/ekskul-modal-tambah</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/admin/prestasi-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Master Kategori Prestasi (Daftar)</div><small class="text-secondary font-monospace">/figma-export/admin/prestasi-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/prestasi-modal-tambah') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Master Prestasi: Modal Tambah Terbuka</div><small class="text-secondary font-monospace">/figma-export/admin/prestasi-modal-tambah</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>

        <!-- Kelas & Penugasan -->
        <a href="<?= base_url('figma-export/admin/kelas-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Kelola Kelas / Rombel (Daftar)</div><small class="text-secondary font-monospace">/figma-export/admin/kelas-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/kelas-form-buka') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Form Buka Kelas Baru</div><small class="text-secondary font-monospace">/figma-export/admin/kelas-form-buka</small></div>
          <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle badge-condition">Form Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/admin/kelas-detail') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Detail Rombel &amp; Anggota Kelas</div><small class="text-secondary font-monospace">/figma-export/admin/kelas-detail</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/penugasan-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Penugasan Guru Mengajar (Matriks)</div><small class="text-secondary font-monospace">/figma-export/admin/penugasan-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/penugasan-modal-tambah') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Penugasan Guru: Modal Tambah Penugasan Terbuka</div><small class="text-secondary font-monospace">/figma-export/admin/penugasan-modal-tambah</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>

        <!-- Pengguna -->
        <a href="<?= base_url('figma-export/admin/guru-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Data Dewan Guru (Daftar)</div><small class="text-secondary font-monospace">/figma-export/admin/guru-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/guru-modal-nonaktifkan') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Data Guru: Modal Konfirmasi Nonaktifkan Terbuka</div><small class="text-secondary font-monospace">/figma-export/admin/guru-modal-nonaktifkan</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/admin/guru-form') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Form Tambah / Edit Data Guru</div><small class="text-secondary font-monospace">/figma-export/admin/guru-form</small></div>
          <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle badge-condition">Form Pengguna</span>
        </a>
        <a href="<?= base_url('figma-export/admin/siswa-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Data Siswa / Peserta Didik (Daftar)</div><small class="text-secondary font-monospace">/figma-export/admin/siswa-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/siswa-modal-nonaktifkan') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Data Siswa: Modal Konfirmasi Nonaktifkan Terbuka</div><small class="text-secondary font-monospace">/figma-export/admin/siswa-modal-nonaktifkan</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/admin/siswa-modal-mutasi') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Data Siswa: Modal Form Mutasi Terbuka</div><small class="text-secondary font-monospace">/figma-export/admin/siswa-modal-mutasi</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/admin/siswa-form') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Form Tambah / Edit Data Siswa</div><small class="text-secondary font-monospace">/figma-export/admin/siswa-form</small></div>
          <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle badge-condition">Form Pengguna</span>
        </a>
        <a href="<?= base_url('figma-export/admin/siswa-detail') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Detail Profil &amp; Riwayat Siswa</div><small class="text-secondary font-monospace">/figma-export/admin/siswa-detail</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/ortu-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Data Orang Tua / Wali Siswa</div><small class="text-secondary font-monospace">/figma-export/admin/ortu-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/staff-tu-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Akun Staf Tata Usaha (TU)</div><small class="text-secondary font-monospace">/figma-export/admin/staff-tu-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/staff-tu-modal-tambah') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Akun Staff TU: Modal Tambah Staff Terbuka</div><small class="text-secondary font-monospace">/figma-export/admin/staff-tu-modal-tambah</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>

        <!-- Raport & Surat & Arsip -->
        <a href="<?= base_url('figma-export/admin/raport-buka-kunci-ada-permohonan') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Otorisasi Buka Kunci Raport: Ada Permohonan Pending</div><small class="text-secondary font-monospace">/figma-export/admin/raport-buka-kunci-ada-permohonan</small></div>
          <span class="badge bg-danger-subtle text-danger border border-danger-subtle badge-condition">Ada Permohonan</span>
        </a>
        <a href="<?= base_url('figma-export/admin/raport-buka-kunci-kosong') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Otorisasi Buka Kunci Raport: Kondisi Kosong (Empty State)</div><small class="text-secondary font-monospace">/figma-export/admin/raport-buka-kunci-kosong</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Empty State</span>
        </a>
        <a href="<?= base_url('figma-export/admin/ujian-sekolah-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Ujian Sekolah &amp; Kelulusan Siswa</div><small class="text-secondary font-monospace">/figma-export/admin/ujian-sekolah-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/transkrip-cetak') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Cetak Transkrip Nilai Siswa (Format Resmi)</div><small class="text-secondary font-monospace">/figma-export/admin/transkrip-cetak</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Dokumen Cetak</span>
        </a>
        <a href="<?= base_url('figma-export/admin/kategori-surat-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Kategori Surat Dinas (Daftar)</div><small class="text-secondary font-monospace">/figma-export/admin/kategori-surat-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/kategori-surat-modal-tambah') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Kategori Surat: Modal Tambah Terbuka</div><small class="text-secondary font-monospace">/figma-export/admin/kategori-surat-modal-tambah</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/admin/format-surat-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Format &amp; Kode Penomoran Surat</div><small class="text-secondary font-monospace">/figma-export/admin/format-surat-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/format-surat-modal-tambah') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Format Surat: Modal Builder Pola Nomor Terbuka</div><small class="text-secondary font-monospace">/figma-export/admin/format-surat-modal-tambah</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/admin/arsip-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Pusat Arsip Dokumen Digital</div><small class="text-secondary font-monospace">/figma-export/admin/arsip-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/admin/audit-log-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Pusat Log Audit Aktivitas Sistem</div><small class="text-secondary font-monospace">/figma-export/admin/audit-log-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
      </div>
    </div>
  </div>

  <!-- Section 3: Guru -->
  <div class="mb-4" id="sec-guru">
    <div class="card role-card shadow-sm">
      <div class="card-header bg-body py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-person-video3 text-primary fs-5"></i>
          <h5 class="mb-0 fw-bold">3. Guru &amp; Wali Kelas</h5>
        </div>
        <span class="badge bg-primary-subtle text-primary border">31 Halaman &amp; Kondisi</span>
      </div>
      <div class="list-group list-group-flush" id="guruList">
        <a href="<?= base_url('figma-export/guru/dashboard-mode-wali') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Dashboard: Mode Wali Kelas</div><small class="text-secondary font-monospace">/figma-export/guru/dashboard-mode-wali</small></div>
          <span class="badge bg-primary-subtle text-primary border badge-condition">Mode Wali</span>
        </a>
        <a href="<?= base_url('figma-export/guru/dashboard-mode-mapel') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Dashboard: Mode Guru Mapel</div><small class="text-secondary font-monospace">/figma-export/guru/dashboard-mode-mapel</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Mode Mapel</span>
        </a>
        <a href="<?= base_url('figma-export/guru/mapel-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Mata Pelajaran yang Diampu</div><small class="text-secondary font-monospace">/figma-export/guru/mapel-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/guru/nilai-input-normal') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Input Nilai: Kondisi Normal</div><small class="text-secondary font-monospace">/figma-export/guru/nilai-input-normal</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Normal</span>
        </a>
        <a href="<?= base_url('figma-export/guru/nilai-input-remedial') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Input Nilai: Ada Remedial (Baris Merah &amp; Banner)</div><small class="text-secondary font-monospace">/figma-export/guru/nilai-input-remedial</small></div>
          <span class="badge bg-danger-subtle text-danger border border-danger-subtle badge-condition">Remedial Highlight</span>
        </a>
        <a href="<?= base_url('figma-export/guru/nilai-modal-import') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Input Nilai: Modal Import Excel Terbuka</div><small class="text-secondary font-monospace">/figma-export/guru/nilai-modal-import</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/guru/tugas-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Daftar Tugas Harian &amp; UH</div><small class="text-secondary font-monospace">/figma-export/guru/tugas-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/guru/tugas-modal-buat') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Daftar Tugas: Modal Buat Tugas / UH Terbuka</div><small class="text-secondary font-monospace">/figma-export/guru/tugas-modal-buat</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/guru/tugas-nilai') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Penilaian Lembar Tugas Siswa</div><small class="text-secondary font-monospace">/figma-export/guru/tugas-nilai</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/guru/analitik-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Analitik Nilai &amp; Grafik Capaian</div><small class="text-secondary font-monospace">/figma-export/guru/analitik-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/guru/presensi-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Presensi Kelas &amp; Jurnal KBM (Riwayat Pertemuan)</div><small class="text-secondary font-monospace">/figma-export/guru/presensi-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/guru/presensi-modal-tambah') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Presensi &amp; Jurnal KBM: Modal Tambah Pertemuan Terbuka</div><small class="text-secondary font-monospace">/figma-export/guru/presensi-modal-tambah</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/guru/presensi-input') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Input Presensi Pertemuan Hari Ini</div><small class="text-secondary font-monospace">/figma-export/guru/presensi-input</small></div>
          <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle badge-condition">Form Presensi</span>
        </a>
        <a href="<?= base_url('figma-export/guru/presensi-cetak') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Cetak Rekap Presensi &amp; Agenda KBM</div><small class="text-secondary font-monospace">/figma-export/guru/presensi-cetak</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Dokumen Cetak</span>
        </a>
        <a href="<?= base_url('figma-export/guru/perwalian-tab-sikap') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Perwalian: Tab Penilaian Sikap Aktif</div><small class="text-secondary font-monospace">/figma-export/guru/perwalian-tab-sikap</small></div>
          <span class="badge bg-primary-subtle text-primary border badge-condition">Tab Sikap</span>
        </a>
        <a href="<?= base_url('figma-export/guru/perwalian-tab-ekskul') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Perwalian: Tab Ekstrakurikuler Aktif</div><small class="text-secondary font-monospace">/figma-export/guru/perwalian-tab-ekskul</small></div>
          <span class="badge bg-primary-subtle text-primary border badge-condition">Tab Ekskul</span>
        </a>
        <a href="<?= base_url('figma-export/guru/perwalian-tab-prestasi') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Perwalian: Tab Catatan Prestasi Aktif</div><small class="text-secondary font-monospace">/figma-export/guru/perwalian-tab-prestasi</small></div>
          <span class="badge bg-primary-subtle text-primary border badge-condition">Tab Prestasi</span>
        </a>
        <a href="<?= base_url('figma-export/guru/perwalian-tab-absensi') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Perwalian: Tab Rekap Absensi Aktif</div><small class="text-secondary font-monospace">/figma-export/guru/perwalian-tab-absensi</small></div>
          <span class="badge bg-primary-subtle text-primary border badge-condition">Tab Absensi</span>
        </a>
        <a href="<?= base_url('figma-export/guru/leger-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Leger / Matriks Nilai Lengkap Kelas</div><small class="text-secondary font-monospace">/figma-export/guru/leger-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/guru/kenaikan-kelas-draft') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Kenaikan Kelas: Tahap Usulan / Draft</div><small class="text-secondary font-monospace">/figma-export/guru/kenaikan-kelas-draft</small></div>
          <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle badge-condition">Tahap Usulan</span>
        </a>
        <a href="<?= base_url('figma-export/guru/kenaikan-kelas-disahkan') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Kenaikan Kelas: Telah Disahkan Pleno</div><small class="text-secondary font-monospace">/figma-export/guru/kenaikan-kelas-disahkan</small></div>
          <span class="badge bg-success-subtle text-success border border-success-subtle badge-condition">Disahkan Resmi</span>
        </a>
        <a href="<?= base_url('figma-export/guru/raport-generate') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Generate Raport Digital Rombel</div><small class="text-secondary font-monospace">/figma-export/guru/raport-generate</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/guru/raport-tinjau-draft') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Tinjau Raport: Status DRAFT (Tombol Ajukan)</div><small class="text-secondary font-monospace">/figma-export/guru/raport-tinjau-draft</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Status: Draft</span>
        </a>
        <a href="<?= base_url('figma-export/guru/raport-tinjau-menunggu-kepsek') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Tinjau Raport: Status MENUNGGU PERSETUJUAN KEPSEK</div><small class="text-secondary font-monospace">/figma-export/guru/raport-tinjau-menunggu-kepsek</small></div>
          <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle badge-condition">Status: Menunggu</span>
        </a>
        <a href="<?= base_url('figma-export/guru/raport-tinjau-final') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Tinjau Raport: Status FINAL (Resmi &amp; Cetak)</div><small class="text-secondary font-monospace">/figma-export/guru/raport-tinjau-final</small></div>
          <span class="badge bg-success-subtle text-success border border-success-subtle badge-condition">Status: Final</span>
        </a>
        <a href="<?= base_url('figma-export/guru/raport-tinjau-modal-finalisasi') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Tinjau Raport: Modal Kunci &amp; Ajukan ke Kepsek Terbuka</div><small class="text-secondary font-monospace">/figma-export/guru/raport-tinjau-modal-finalisasi</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/guru/raport-tinjau-modal-pengesahan') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Tinjau Raport: Modal Pengesahan Tanda Tangan Kepsek Terbuka</div><small class="text-secondary font-monospace">/figma-export/guru/raport-tinjau-modal-pengesahan</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/guru/raport-tinjau-modal-tolak') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Tinjau Raport: Modal Kembalikan Raport ke Wali Kelas Terbuka</div><small class="text-secondary font-monospace">/figma-export/guru/raport-tinjau-modal-tolak</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/guru/raport-buka-kunci-ada-permohonan') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Permohonan Buka Kunci: Ada Riwayat Pengajuan</div><small class="text-secondary font-monospace">/figma-export/guru/raport-buka-kunci-ada-permohonan</small></div>
          <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle badge-condition">Ada Pengajuan</span>
        </a>
        <a href="<?= base_url('figma-export/guru/raport-buka-kunci-kosong') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Permohonan Buka Kunci: Kosong (Empty State)</div><small class="text-secondary font-monospace">/figma-export/guru/raport-buka-kunci-kosong</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Empty State</span>
        </a>
        <a href="<?= base_url('figma-export/guru/raport-buka-kunci-modal-ajukan') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Permohonan Buka Kunci: Modal Ajukan Buka Kunci Raport Terbuka</div><small class="text-secondary font-monospace">/figma-export/guru/raport-buka-kunci-modal-ajukan</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
      </div>
    </div>
  </div>

  <!-- Section 4: Tata Usaha -->
  <div class="mb-4" id="sec-tu">
    <div class="card role-card shadow-sm">
      <div class="card-header bg-body py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-envelope-paper-fill text-primary fs-5"></i>
          <h5 class="mb-0 fw-bold">4. Tata Usaha (Persuratan &amp; Agenda)</h5>
        </div>
        <span class="badge bg-primary-subtle text-primary border">16 Halaman &amp; Kondisi</span>
      </div>
      <div class="list-group list-group-flush" id="tuList">
        <a href="<?= base_url('figma-export/tu/dashboard') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Dashboard Tata Usaha</div><small class="text-secondary font-monospace">/figma-export/tu/dashboard</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/tu/surat-masuk-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Surat Masuk (Daftar &amp; Agenda)</div><small class="text-secondary font-monospace">/figma-export/tu/surat-masuk-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/tu/surat-masuk-form') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Form Catat Surat Masuk Baru</div><small class="text-secondary font-monospace">/figma-export/tu/surat-masuk-form</small></div>
          <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle badge-condition">Form Catat</span>
        </a>
        <a href="<?= base_url('figma-export/tu/surat-masuk-detail-biasa') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Detail Surat Masuk: Sifat Biasa</div><small class="text-secondary font-monospace">/figma-export/tu/surat-masuk-detail-biasa</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Sifat: Biasa</span>
        </a>
        <a href="<?= base_url('figma-export/tu/surat-masuk-detail-rahasia') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Detail Surat Masuk: Sifat Rahasia (Banner Peringatan)</div><small class="text-secondary font-monospace">/figma-export/tu/surat-masuk-detail-rahasia</small></div>
          <span class="badge bg-danger-subtle text-danger border border-danger-subtle badge-condition">Banner Rahasia</span>
        </a>
        <a href="<?= base_url('figma-export/tu/surat-masuk-detail-belum-disposisi') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Detail Surat Masuk: Belum Didisposisikan (Empty Table)</div><small class="text-secondary font-monospace">/figma-export/tu/surat-masuk-detail-belum-disposisi</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Belum Disposisi</span>
        </a>
        <a href="<?= base_url('figma-export/tu/surat-masuk-detail-sudah-disposisi') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Detail Surat Masuk: Sudah Didisposisikan (Tabel Terisi)</div><small class="text-secondary font-monospace">/figma-export/tu/surat-masuk-detail-sudah-disposisi</small></div>
          <span class="badge bg-success-subtle text-success border border-success-subtle badge-condition">Sudah Disposisi</span>
        </a>
        <a href="<?= base_url('figma-export/tu/surat-masuk-modal-disposisi') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Detail Surat Masuk: Modal Kirim Lembar Disposisi Terbuka</div><small class="text-secondary font-monospace">/figma-export/tu/surat-masuk-modal-disposisi</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/tu/surat-masuk-modal-pratinjau') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Detail Surat Masuk: Modal Pratinjau Dokumen Lampiran Terbuka</div><small class="text-secondary font-monospace">/figma-export/tu/surat-masuk-modal-pratinjau</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/tu/surat-keluar-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Surat Keluar (Daftar &amp; Status)</div><small class="text-secondary font-monospace">/figma-export/tu/surat-keluar-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/tu/surat-keluar-form') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Form Buat Surat Keluar Baru</div><small class="text-secondary font-monospace">/figma-export/tu/surat-keluar-form</small></div>
          <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle badge-condition">Form Surat</span>
        </a>
        <a href="<?= base_url('figma-export/tu/surat-keluar-detail-draft') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Detail Surat Keluar: Status DRAFT (Tombol Ajukan TTD)</div><small class="text-secondary font-monospace">/figma-export/tu/surat-keluar-detail-draft</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Status: Draft</span>
        </a>
        <a href="<?= base_url('figma-export/tu/surat-keluar-detail-menunggu-ttd') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Detail Surat Keluar: Status MENUNGGU TTD PIMPINAN</div><small class="text-secondary font-monospace">/figma-export/tu/surat-keluar-detail-menunggu-ttd</small></div>
          <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle badge-condition">Status: Menunggu TTD</span>
        </a>
        <a href="<?= base_url('figma-export/tu/surat-keluar-detail-terkirim') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Detail Surat Keluar: Status FINAL / TERKIRIM</div><small class="text-secondary font-monospace">/figma-export/tu/surat-keluar-detail-terkirim</small></div>
          <span class="badge bg-success-subtle text-success border border-success-subtle badge-condition">Status: Terkirim</span>
        </a>
        <a href="<?= base_url('figma-export/tu/arsip-index') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Arsip Surat Digital</div><small class="text-secondary font-monospace">/figma-export/tu/arsip-index</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/tu/buku-agenda') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Buku Agenda Surat Masuk &amp; Keluar (Siap Cetak)</div><small class="text-secondary font-monospace">/figma-export/tu/buku-agenda</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Dokumen Cetak</span>
        </a>
      </div>
    </div>
  </div>

  <!-- Section 5: Siswa -->
  <div class="mb-4" id="sec-siswa">
    <div class="card role-card shadow-sm">
      <div class="card-header bg-body py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-mortarboard-fill text-primary fs-5"></i>
          <h5 class="mb-0 fw-bold">5. Siswa &amp; Orang Tua</h5>
        </div>
        <span class="badge bg-primary-subtle text-primary border">13 Halaman &amp; Kondisi</span>
      </div>
      <div class="list-group list-group-flush" id="siswaList">
        <a href="<?= base_url('figma-export/siswa/beranda') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Beranda Portal Siswa</div><small class="text-secondary font-monospace">/figma-export/siswa/beranda</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/siswa/profil') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Profil Siswa &amp; Biodata Dapodik</div><small class="text-secondary font-monospace">/figma-export/siswa/profil</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Default</span>
        </a>
        <a href="<?= base_url('figma-export/siswa/nilai-pengetahuan') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Nilai Akademik: Tab Pengetahuan Aktif</div><small class="text-secondary font-monospace">/figma-export/siswa/nilai-pengetahuan</small></div>
          <span class="badge bg-primary-subtle text-primary border badge-condition">Tab Pengetahuan</span>
        </a>
        <a href="<?= base_url('figma-export/siswa/nilai-keterampilan') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Nilai Akademik: Tab Keterampilan Aktif</div><small class="text-secondary font-monospace">/figma-export/siswa/nilai-keterampilan</small></div>
          <span class="badge bg-primary-subtle text-primary border badge-condition">Tab Keterampilan</span>
        </a>
        <a href="<?= base_url('figma-export/siswa/raport-list') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Riwayat Raport: Multi Semester (Siswa Lama)</div><small class="text-secondary font-monospace">/figma-export/siswa/raport-list</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Multi Semester</span>
        </a>
        <a href="<?= base_url('figma-export/siswa/raport-list-baru') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Riwayat Raport: Baru 1 Semester (Siswa Baru Kelas 10)</div><small class="text-secondary font-monospace">/figma-export/siswa/raport-list-baru</small></div>
          <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle badge-condition">1 Semester</span>
        </a>
        <a href="<?= base_url('figma-export/siswa/raport-preview-draft') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Pratinjau Raport: Status DRAFT (Banner Capaian Sementara)</div><small class="text-secondary font-monospace">/figma-export/siswa/raport-preview-draft</small></div>
          <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle badge-condition">Status: Draft</span>
        </a>
        <a href="<?= base_url('figma-export/siswa/raport-preview-final') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Pratinjau Raport: Status FINAL (Banner Dokumen Resmi)</div><small class="text-secondary font-monospace">/figma-export/siswa/raport-preview-final</small></div>
          <span class="badge bg-success-subtle text-success border border-success-subtle badge-condition">Status: Final</span>
        </a>
        <a href="<?= base_url('figma-export/siswa/status-berjalan') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Status Akademik: Semester Berjalan (Aktif Belajar)</div><small class="text-secondary font-monospace">/figma-export/siswa/status-berjalan</small></div>
          <span class="badge bg-success-subtle text-success border border-success-subtle badge-condition">Aktif Belajar</span>
        </a>
        <a href="<?= base_url('figma-export/siswa/status-naik-kelas') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Status Akademik: Naik Kelas (Evaluasi Akhir Tahun)</div><small class="text-secondary font-monospace">/figma-export/siswa/status-naik-kelas</small></div>
          <span class="badge bg-primary-subtle text-primary border badge-condition">Naik Kelas</span>
        </a>
        <a href="<?= base_url('figma-export/siswa/status-lulus') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Status Akademik: Kelulusan Siswa (Tingkat XII)</div><small class="text-secondary font-monospace">/figma-export/siswa/status-lulus</small></div>
          <span class="badge bg-success-subtle text-success border border-success-subtle badge-condition">Lulus</span>
        </a>
        <a href="<?= base_url('figma-export/siswa/status-lulus-modal-skl') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Status Akademik: Modal Cetak SKL Terbuka</div><small class="text-secondary font-monospace">/figma-export/siswa/status-lulus-modal-skl</small></div>
          <span class="badge bg-primary text-white badge-condition">Modal Terbuka</span>
        </a>
        <a href="<?= base_url('figma-export/siswa/transkrip') ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-4 item-row">
          <div><div class="fw-semibold text-body">Transkrip Nilai Lengkap 6 Semester</div><small class="text-secondary font-monospace">/figma-export/siswa/transkrip</small></div>
          <span class="badge bg-secondary-subtle text-secondary border badge-condition">Dokumen Resmi</span>
        </a>
      </div>
    </div>
  </div>

  <!-- Footer Info -->
  <div class="text-center text-secondary small py-3">
    SIAKAD SMA IT Fithrah Insani &bull; Modul Ekspor Mockup ke Figma &bull; 117 Kondisi Visual Terdaftar
  </div>

</div>

<!-- Filter Javascript -->
<script>
  document.getElementById('filterInput').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    const rows = document.querySelectorAll('.item-row');
    rows.forEach(r => {
      const text = r.textContent.toLowerCase();
      r.style.display = text.includes(q) ? 'flex' : 'none';
    });
  });
</script>
</body>
</html>
