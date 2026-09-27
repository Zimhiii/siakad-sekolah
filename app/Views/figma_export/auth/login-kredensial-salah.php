<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title ?? 'Login: Input Kredensial Salah - SIAKAD') ?></title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Google Fonts: Montserrat & Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/css/adminlte.min.css">

  <style>
    body, html {
      height: 100%;
      margin: 0;
    }
    body, p, span, td, th, label, input, select, textarea, .nav-link, .dropdown-item,
    .badge, .btn, .card-text, .small, small {
      font-family: 'Montserrat', system-ui, sans-serif;
    }

    h1, h2, h3, .page-title, .content-header h1, .brand-text {
      font-family: 'Poppins', 'Montserrat', sans-serif;
      font-weight: 700;
    }

    h4, h5, h6, .card-title {
      font-family: 'Montserrat', system-ui, sans-serif;
      font-weight: 600;
    }
    .split-left {
      background: #1E3A5F;
      color: #fff;
    }
    .text-light-accessible {
      color: rgba(255, 255, 255, 0.88) !important;
    }
    .text-secondary-accessible {
      color: #495057 !important;
    }
    .text-danger-accessible {
      color: #b02a37 !important;
    }
    .login-form-container {
      max-width: 420px;
      width: 100%;
    }
    .form-control, .btn {
      min-height: 44px;
    }
    .input-error-custom {
      border: 1.5px solid #b02a37 !important;
      background-color: #fff8f8;
      color: #212529;
    }
    .input-error-custom:focus {
      border-color: #b02a37 !important;
      box-shadow: 0 0 0 0.25rem rgba(176, 42, 55, 0.22) !important;
    }
    a:focus-visible, button:focus-visible, input:focus-visible {
      outline: 2px solid #1E3A5F !important;
      outline-offset: 2px !important;
    }
  </style>
</head>
<body class="bg-body-tertiary">
  <div class="container-fluid p-0 h-100">
    <div class="row g-0 h-100">
      
      <!-- Kolom Kiri: Informasi Sekolah (55% desktop) -->
      <div class="col-lg-7 d-none d-lg-flex flex-column justify-content-between p-5 split-left">
        <div>
          <div class="d-flex align-items-center gap-3">
            <div>
              <h4 class="mb-0 text-white">SIAKAD</h4>
              <p class="text-light-accessible small mb-0"><?= esc($sekolah['nama_sekolah'] ?? 'SMA IT Fithrah Insani') ?></p>
            </div>
          </div>
        </div>

        <div class="my-auto py-4">
          <h1 class="display-6 mb-3">Sistem Informasi Akademik</h1>
          <p class="text-light-accessible" style="max-width: 540px;">
            Sistem pengelolaan akademik sekolah untuk data kurikulum, penilaian siswa, perwalian kelas, dan administrasi sekolah.
          </p>
        </div>

        <div class="text-light-accessible small border-top border-white border-opacity-25 pt-3">
          <span>&copy; <?= date('Y') ?> <?= esc($sekolah['nama_sekolah'] ?? 'SMA IT Fithrah Insani') ?></span>
        </div>
      </div>

      <!-- Kolom Kanan: Form Login (45% desktop) -->
      <div class="col-lg-5 d-flex flex-column justify-content-between p-4 p-md-5 bg-body">
        
        <!-- Header Mobile Only -->
        <div class="d-lg-none d-flex align-items-center gap-2 mb-4">
          <span class="fs-5 fw-bold">SIAKAD</span>
        </div>

        <div class="my-auto d-flex justify-content-center">
          <div class="login-form-container">
            
            <div class="mb-4">
              <h3 class="mb-1">Masuk ke Akun</h3>
              <p class="text-secondary-accessible small">Masukkan username dan kata sandi akun Anda</p>
            </div>

            <!-- Error Alert for Figma Export -->
            <div class="alert alert-danger d-flex align-items-center mb-3 py-2 px-3 small border-danger-subtle shadow-sm" role="alert">
              <div class="text-danger-accessible fw-medium">Kombinasi username atau kata sandi tidak cocok. Silakan periksa kembali.</div>
            </div>

            <!-- Login Form -->
            <form action="<?= base_url('auth/login') ?>" method="post">
              <?= csrf_field() ?>

              <div class="mb-3">
                <label for="username" class="form-label small fw-semibold text-danger-accessible">
                  Username / NIP / NISN
                </label>
                <input type="text" class="form-control is-invalid input-error-custom fw-medium" id="username" name="username" value="guru.salah" placeholder="Masukkan username atau NISN/NIP" aria-invalid="true" aria-describedby="username-feedback" required>
                <div id="username-feedback" class="invalid-feedback d-block small text-danger-accessible fw-medium">
                  Username tidak terdaftar pada sistem akademik sekolah.
                </div>
              </div>

              <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                  <label for="password" class="form-label small fw-semibold text-danger-accessible mb-0">
                    Password
                  </label>
                  <a href="#" class="text-decoration-none small text-primary fw-medium" data-bs-toggle="modal" data-bs-target="#modalLupaPassword">Lupa Password?</a>
                </div>
                <div class="input-group mt-1 has-validation">
                  <input type="password" class="form-control is-invalid input-error-custom" id="password" name="password" value="passwordsalah" placeholder="Masukkan password" aria-invalid="true" aria-describedby="password-feedback" required>
                  <button class="btn btn-outline-danger" type="button" id="btnTogglePassword" aria-label="Tampilkan atau sembunyikan kata sandi"><i class="bi bi-eye" id="eyeIcon"></i></button>
                </div>
                <div id="password-feedback" class="invalid-feedback d-block small text-danger-accessible fw-medium">
                  Kata sandi yang Anda masukkan salah. Periksa tombol Caps Lock.
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                  <label class="form-check-label small text-secondary-accessible" for="rememberMe">
                    Ingat saya di perangkat ini
                  </label>
                </div>
              </div>

              <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold d-flex align-items-center justify-content-center">
                Masuk ke SIAKAD
              </button>
            </form>

          </div>
        </div>

        <div class="text-center text-secondary-accessible small pt-3">
          Layanan Bantuan SIAKAD Sekolah: it-support@fithrahinsani.sch.id
        </div>
      </div>

    </div>
  </div>

  <!-- Modal Lupa Password -->
  <div class="modal fade" id="modalLupaPassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow border-0">
        <div class="modal-header border-bottom px-4 py-3 bg-body">
          <div>
            <h5 class="modal-title fw-bold mb-0">Bantuan Lupa Kata Sandi</h5>
            <small class="text-secondary">Prosedur Pemulihan Akun SIAKAD</small>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <p class="small text-secondary mb-3">
            Untuk menjamin kerahasiaan dan keamanan data akademik serta privasi peserta didik, reset kata sandi dilakukan melalui verifikasi oleh Bagian Tata Usaha (TU) atau Admin Sistem Sekolah.
          </p>

          <div class="card border bg-body-tertiary mb-3">
            <div class="card-body p-3">
              <h6 class="fw-semibold text-body mb-2 small">Prosedur Reset Kata Sandi:</h6>
              <ol class="small text-secondary ps-3 mb-0">
                <li class="mb-1"><strong>Siswa:</strong> Hubungi Wali Kelas masing-masing atau datang ke Bagian Tata Usaha dengan menunjukkan Kartu Pelajar.</li>
                <li class="mb-1"><strong>Guru &amp; Staf:</strong> Konfirmasi langsung ke Admin IT Sekolah atau Kepala Tata Usaha.</li>
                <li>Admin akan memverifikasi identitas dan me-reset kata sandi akun Anda ke kata sandi sementara.</li>
              </ol>
            </div>
          </div>

          <div class="bg-primary-subtle border border-primary-subtle rounded p-3 text-primary-emphasis small">
            <div class="fw-bold mb-1"><i class="bi bi-headset me-1"></i> Kontak Layanan Helpdesk IT:</div>
            <div>Ruang Tata Usaha Gedung A, Lantai 1 (07.30 - 15.30 WIB)</div>
            <div>Email: <span class="font-monospace text-primary">it-support@fithrahinsani.sch.id</span></div>
            <div>WhatsApp Layanan: <span class="font-monospace text-primary">+62 812-2334-4551</span></div>
          </div>
        </div>
        <div class="modal-footer px-4 py-3 bg-body border-top">
          <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
          <a href="https://wa.me/6281223344551" target="_blank" class="btn btn-success btn-sm px-3 d-inline-flex align-items-center gap-1">
            <i class="bi bi-whatsapp"></i> Hubungi WhatsApp TU
          </a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const btnToggle = document.getElementById('btnTogglePassword');
    const pwdInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    if (btnToggle && pwdInput) {
      btnToggle.addEventListener('click', () => {
        if (pwdInput.type === 'password') {
          pwdInput.type = 'text';
          eyeIcon.classList.remove('bi-eye');
          eyeIcon.classList.add('bi-eye-slash');
        } else {
          pwdInput.type = 'password';
          eyeIcon.classList.remove('bi-eye-slash');
          eyeIcon.classList.add('bi-eye');
        }
      });
    }
  </script>
</body>
</html>
