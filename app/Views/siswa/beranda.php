<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Kartu Profil Siswa Full-Width -->
<div class="card mb-4">
  <div class="card-body p-4">
    <div class="d-flex flex-column flex-md-row align-items-center gap-4">
      <img src="<?= esc($siswa['foto_path']) ?>" alt="<?= esc($siswa['nama']) ?>" class="rounded-circle border" width="84" height="84">
      <div class="flex-grow-1 text-center text-md-start">
        <h4 class="fw-bold text-body mb-1">Assalamu'alaikum, <?= esc($siswa['nama']) ?>!</h4>
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start gap-2 text-secondary small">
          <span>NIS: <span class="font-monospace text-body fw-medium"><?= esc($siswa['nis']) ?></span></span>
          <span>&bull;</span>
          <span>NISN: <span class="font-monospace text-body fw-medium"><?= esc($siswa['nisn']) ?></span></span>
          <span>&bull;</span>
          <span>Rombel: <span class="badge bg-secondary-subtle text-secondary-emphasis border"><?= esc($siswa['kelas_nama']) ?></span></span>
        </div>
      </div>
      <div>
        <a href="<?= base_url('siswa/profil') ?>" class="btn btn-outline-primary btn-sm px-3">
          Profil Saya
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Grid 2 Kartu: TA Aktif & Ringkasan Nilai -->
<div class="row g-3 mb-4">
  <div class="col-lg-5">
    <div class="card h-100">
      <div class="card-header bg-body py-3">
        <h6 class="mb-0 fw-semibold">Tahun Ajaran & Semester Aktif</h6>
      </div>
      <div class="card-body p-4">
        <div class="p-3 border rounded bg-body-tertiary mb-3">
          <span class="text-secondary small d-block">Tahun Ajaran Berjalan</span>
          <h5 class="text-primary mb-0 fw-bold"><?= esc($taAktif) ?></h5>
        </div>
        <ul class="list-group list-group-flush small">
          <li class="list-group-item d-flex justify-content-between px-0">
            <span class="text-secondary">Wali Kelas:</span>
            <strong class="text-body">Ustadz Hendra Gunawan, M.Pd.</strong>
          </li>
          <li class="list-group-item d-flex justify-content-between px-0">
            <span class="text-secondary">Jumlah Mapel Diambil:</span>
            <strong class="text-body">15 Mata Pelajaran</strong>
          </li>
          <li class="list-group-item d-flex justify-content-between px-0">
            <span class="text-secondary">Status Siswa:</span>
            <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">Aktif Belajar</span>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="card h-100">
      <div class="card-header bg-body py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold">Ringkasan Nilai Capaian Tertinggi</h6>
        <a href="<?= base_url('siswa/nilai') ?>" class="text-decoration-none small">Lihat Semua Nilai</a>
      </div>
      <div class="card-body p-0">
        <div class="list-group list-group-flush">
          <?php foreach ($ringkasanNilai as $rn): ?>
            <div class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
              <span class="text-body fw-medium"><?= esc($rn['mapel']) ?></span>
              <div class="d-flex align-items-center gap-2">
                <span class="fw-bold font-monospace text-primary"><?= $rn['nilai'] ?></span>
                <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-2 py-1"><?= $rn['predikat'] ?></span>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Kartu Status Raport Full-Width -->
<div class="card">
  <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
    <div>
      <h5 class="fw-bold mb-1">Raport Digital Semester Ganjil (T.A. 2025/2026)</h5>
      <div class="d-flex flex-wrap align-items-center gap-2 mt-1">
        <?php if (($raport['status'] ?? '') === 'final'): ?>
          <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">Final / Diterbitkan</span>
          <span class="text-secondary small">Raport resmi telah diterbitkan</span>
        <?php elseif (($raport['status'] ?? '') === 'menunggu_persetujuan_kepsek'): ?>
          <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle">Menunggu Pengesahan Kepsek</span>
          <span class="text-secondary small">Dalam proses pengesahan sekolah</span>
        <?php else: ?>
          <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">Sedang Diproses Wali Kelas (Draft)</span>
          <span class="text-secondary small">Nilai berjalan sementara</span>
        <?php endif; ?>
      </div>
    </div>
    <div>
      <a href="<?= base_url('siswa/raport/preview/1') ?>" class="btn btn-primary px-4">
        Buka Lembar Raport
      </a>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
