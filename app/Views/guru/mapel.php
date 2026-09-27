<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h4 class="fw-bold mb-1">Mata Pelajaran Saya</h4>
    <p class="text-secondary small mb-0">Daftar kelas pengajaran aktif pada Semester Ganjil TA 2025/2026</p>
  </div>
</div>

<div class="row g-4">
  <?php foreach ($pengajaranList as $p): ?>
    <div class="col-md-6 col-lg-4">
      <div class="card h-100 border">
        <div class="card-body p-3 d-flex flex-column justify-content-between">
          <div>
            <div class="d-flex justify-content-between align-items-start mb-2">
              <span class="badge bg-secondary-subtle text-secondary border fw-normal"><?= esc($p['kelas_nama']) ?></span>
              <span class="text-secondary small">KKM: <strong class="text-body"><?= number_format($p['kkm'], 0) ?></strong></span>
            </div>

            <h5 class="text-body fw-bold mb-1"><?= esc($p['mapel_nama']) ?></h5>
            <p class="text-secondary small mb-3">
              Total <?= esc($p['jumlah_siswa']) ?> Siswa Terdaftar &bull; Semester <?= esc($p['semester_nama']) ?> 2025/2026
            </p>
          </div>

          <div>
            <hr class="text-secondary opacity-25 my-2">

            <div class="d-flex flex-wrap gap-1">
              <a href="<?= base_url('guru/nilai/' . $p['id']) ?>" class="btn btn-primary btn-sm flex-fill">
                Nilai
              </a>
              <a href="<?= base_url('guru/presensi/' . $p['id']) ?>" class="btn btn-outline-secondary btn-sm flex-fill">
                Presensi
              </a>
              <a href="<?= base_url('guru/tugas/' . $p['id']) ?>" class="btn btn-outline-secondary btn-sm flex-fill">
                Tugas
              </a>
              <a href="<?= base_url('guru/analitik/' . $p['id']) ?>" class="btn btn-outline-secondary btn-sm flex-fill">
                Analitik
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?= $this->endSection() ?>

