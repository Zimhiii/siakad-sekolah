<?php $variant = 'mapel'; ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Switch Dashboard Varian Header -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
  <div>
    <h4 class="fw-bold mb-1">
      <?= ($variant === 'wali') ? 'Dashboard Wali Kelas (XI-MIPA-1)' : 'Dashboard Guru Mata Pelajaran' ?>
    </h4>
    <p class="text-secondary small mb-0">Selamat bertugas, <strong><?= esc($namaGuru) ?></strong></p>
  </div>
  <div class="btn-group btn-group-sm" role="group">
    <a href="<?= base_url('guru/dashboard/wali') ?>" class="btn <?= ($variant === 'wali') ? 'btn-primary' : 'btn-outline-secondary' ?>">
      Mode Wali Kelas
    </a>
    <a href="<?= base_url('guru/dashboard/mapel') ?>" class="btn <?= ($variant === 'mapel') ? 'btn-primary' : 'btn-outline-secondary' ?>">
      Mode Guru Mapel
    </a>
  </div>
</div>

<!-- Baris 1: 3 Kartu Ringkasan -->
<div class="card mb-4 border">
  <div class="card-body p-3">
    <div class="row g-3 text-center text-md-start">
      <div class="col-md-4 border-end-md">
        <div class="text-secondary small">Mata Pelajaran Diajar</div>
        <div class="fs-4 fw-bold text-body"><?= esc($stats['mapel_diajar']) ?></div>
        <div class="mt-1">
          <a href="<?= base_url('guru/mapel') ?>" class="small text-decoration-none">
            Lihat Mapel Saya &rarr;
          </a>
        </div>
      </div>
      <div class="col-md-4 border-end-md">
        <div class="text-secondary small">Kelas / Rombel Diajar</div>
        <div class="fs-4 fw-bold text-body"><?= esc($stats['kelas_diajar']) ?></div>
        <div class="mt-1">
          <a href="<?= base_url('guru/nilai') ?>" class="small text-decoration-none">
            Input Nilai Kelas &rarr;
          </a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="text-secondary small">Total Siswa Dibimbing</div>
        <div class="fs-4 fw-bold text-body"><?= esc($stats['total_siswa']) ?></div>
        <div class="mt-1">
          <a href="<?= base_url('guru/analitik') ?>" class="small text-decoration-none">
            Analitik Nilai &rarr;
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if ($variant === 'wali'): ?>
  <!-- Kartu Khusus Wali Kelas: Progress Kelengkapan Raport -->
  <div class="card mb-4 border">
    <div class="card-body p-3">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div>
          <div class="text-secondary small">Wali Kelas: <strong class="text-body">XI-MIPA-1</strong></div>
          <h5 class="fw-bold mb-0">Progress Kelengkapan &amp; Pengisian Raport Semester Ganjil</h5>
        </div>
        <div class="d-flex gap-2">
          <a href="<?= base_url('guru/perwalian') ?>" class="btn btn-outline-secondary btn-sm">
            Nilai Sikap &amp; Ekskul
          </a>
          <a href="<?= base_url('guru/raport/tinjau') ?>" class="btn btn-primary btn-sm">
            Tinjau Raport
          </a>
        </div>
      </div>

      <div class="d-flex justify-content-between small mb-1">
        <span class="text-secondary">Kelengkapan Data: 26 dari 31 Siswa Selesai Diinput</span>
        <span class="fw-semibold text-body"><?= $stats['raport_progress'] ?>%</span>
      </div>
      <div class="progress" style="height: 6px;">
        <div class="progress-bar bg-primary" style="width: <?= $stats['raport_progress'] ?>%;"></div>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- Baris 2: List Pengingat & Jadwal Mengajar -->
<div class="row g-3">
  <div class="col-lg-6">
    <div class="card h-100 border">
      <div class="card-header bg-body py-2 px-3">
        <span class="fw-semibold small text-secondary">
          Pengingat Tugas &amp; Nilai
        </span>
      </div>
      <div class="card-body p-0">
        <div class="list-group list-group-flush">
          <?php foreach ($pengingat as $p): ?>
            <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
              <div>
                <span class="text-body d-block small fw-medium"><?= esc($p['judul']) ?></span>
                <small class="text-secondary"><?= esc($p['status']) ?></small>
              </div>
              <a href="<?= base_url('guru/nilai') ?>" class="btn btn-outline-secondary btn-sm">
                Buka
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card h-100 border">
      <div class="card-header bg-body py-2 px-3">
        <span class="fw-semibold small text-secondary">
          Mata Pelajaran yang Diajarkan
        </span>
      </div>
      <div class="card-body p-0">
        <div class="list-group list-group-flush">
          <?php foreach ($mapelList as $mp): ?>
            <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
              <div>
                <span class="text-body fw-medium d-block small mb-1"><?= esc($mp['mapel_nama']) ?></span>
                <div class="text-secondary small">
                  Kelas: <strong class="text-body"><?= esc($mp['kelas_nama']) ?></strong>
                  &bull; KKM: <strong class="text-body"><?= number_format($mp['kkm'], 0) ?></strong>
                  &bull; <?= esc($mp['jumlah_siswa']) ?> Siswa
                </div>
              </div>
              <div class="d-flex gap-1">
                <a href="<?= base_url('guru/nilai/' . $mp['id']) ?>" class="btn btn-outline-primary btn-sm">Nilai</a>
                <a href="<?= base_url('guru/presensi/' . $mp['id']) ?>" class="btn btn-outline-secondary btn-sm">Presensi</a>
                <a href="<?= base_url('guru/analitik/' . $mp['id']) ?>" class="btn btn-outline-secondary btn-sm">Analitik</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

