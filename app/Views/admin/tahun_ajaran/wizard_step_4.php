<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Stepper Navigation -->
<div class="wizard-stepper mb-3">
  <div class="step-item completed">
    <div class="step-bubble">1</div>
    <span class="step-label">Info Tahun Ajaran</span>
  </div>
  <div class="step-item completed">
    <div class="step-bubble">2</div>
    <span class="step-label">Kelas &amp; Kapasitas</span>
  </div>
  <div class="step-item completed">
    <div class="step-bubble">3</div>
    <span class="step-label">Wali Kelas</span>
  </div>
  <div class="step-item active">
    <div class="step-bubble">4</div>
    <span class="step-label">Kenaikan Kelas</span>
  </div>
  <div class="step-item">
    <div class="step-bubble">5</div>
    <span class="step-label">Penugasan Guru</span>
  </div>
  <div class="step-item">
    <div class="step-bubble">6</div>
    <span class="step-label">Ringkasan</span>
  </div>
</div>

<?php
  // Hitung ringkasan hasil sidang pleno
  $totalSiswa = count($kenaikanList ?? []);
  $naikCount = 0;
  $tinggalCount = 0;
  $lulusCount = 0;
  foreach ($kenaikanList ?? [] as $k) {
    if (($k['status'] ?? '') === 'naik') $naikCount++;
    elseif (($k['status'] ?? '') === 'tinggal_kelas') $tinggalCount++;
    elseif (($k['status'] ?? '') === 'lulus') $lulusCount++;
  }
?>

<div class="card mb-4 border">
  <div class="card-header bg-body py-2 px-3 d-flex justify-content-between align-items-center">
    <div>
      <h6 class="card-title fw-semibold mb-0">
        Langkah 4/6: Rekapitulasi Hasil Sidang Pleno Kenaikan Kelas &amp; Kelulusan
      </h6>
    </div>
    <span class="text-secondary small">
      Hasil Resmi Pleno
    </span>
  </div>

  <div class="card-body p-3">
    <p class="text-secondary small mb-3">
      Data penempatan siswa di bawah bersumber langsung dari hasil Sidang Pleno Kenaikan Kelas dan Kelulusan yang telah disahkan:
    </p>

    <!-- Summary Metrics -->
    <div class="row g-3 mb-3 text-center">
      <div class="col-md-3 col-6">
        <div class="p-2.5 p-2 border rounded bg-light">
          <div class="fw-bold fs-5 text-body font-monospace"><?= $totalSiswa ?></div>
          <div class="text-secondary small">Total Siswa</div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="p-2 border rounded bg-light">
          <div class="fw-bold fs-5 text-success font-monospace"><?= $naikCount ?></div>
          <div class="text-secondary small">Naik Kelas</div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="p-2 border rounded bg-light">
          <div class="fw-bold fs-5 text-danger font-monospace"><?= $tinggalCount ?></div>
          <div class="text-secondary small">Tinggal Kelas</div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="p-2 border rounded bg-light">
          <div class="fw-bold fs-5 text-primary font-monospace"><?= $lulusCount ?></div>
          <div class="text-secondary small">Lulus / Alumni</div>
        </div>
      </div>
    </div>

    <!-- Tabel Rekapitulasi -->
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 50px;" class="text-center">No</th>
            <th>Nama Siswa</th>
            <th>NIS / NISN</th>
            <th>Kelas Asal</th>
            <th>Keputusan Pleno</th>
            <th>Alokasi Rombel Baru</th>
            <th>Tanggal Pleno</th>
            <th>Catatan Pleno</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($kenaikanList)): ?>
            <?php $no = 1; foreach ($kenaikanList as $k): ?>
              <tr>
                <td class="text-center font-monospace text-secondary small"><?= $no++ ?></td>
                <td>
                  <div class="fw-semibold small text-body"><?= esc($k['nama']) ?></div>
                  <span class="text-secondary small">Rata-rata: <strong class="text-body font-monospace"><?= number_format($k['rata_rata'], 1) ?></strong></span>
                </td>
                <td>
                  <div class="font-monospace small"><?= esc($k['nis']) ?></div>
                  <span class="text-secondary font-monospace small"><?= esc($k['nisn'] ?? '-') ?></span>
                </td>
                <td><span class="badge bg-secondary-subtle text-secondary border"><?= esc($k['kelas_asal']) ?></span></td>
                <td>
                  <?php if ($k['status'] === 'naik'): ?>
                    <span class="text-success small fw-medium">Naik Kelas</span>
                  <?php elseif ($k['status'] === 'tinggal_kelas'): ?>
                    <span class="text-danger small fw-medium">Tinggal Kelas</span>
                  <?php elseif ($k['status'] === 'lulus'): ?>
                    <span class="text-primary small fw-medium">Lulus</span>
                  <?php else: ?>
                    <span class="text-secondary small"><?= esc($k['status']) ?></span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($k['status'] === 'naik'): ?>
                    <span class="badge bg-secondary-subtle text-secondary border"><?= esc($k['kelas_tujuan']) ?></span>
                  <?php elseif ($k['status'] === 'tinggal_kelas'): ?>
                    <span class="badge bg-warning-subtle text-dark border"><?= esc($k['kelas_tujuan']) ?> (Tetap)</span>
                  <?php else: ?>
                    <span class="text-secondary small">Alumni</span>
                  <?php endif; ?>
                </td>
                <td>
                  <span class="font-monospace text-secondary small"><?= esc($k['tanggal_pleno'] ?? '2025-12-18') ?></span>
                </td>
                <td>
                  <span class="text-secondary small"><?= esc($k['catatan'] ?? '-') ?></span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="text-center text-secondary small py-4">Belum ada data rekapitulasi pleno kenaikan kelas.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="card-footer bg-body d-flex justify-content-between align-items-center py-2 px-3">
    <a href="<?= base_url('admin/wizard/3') ?>" class="btn btn-outline-secondary btn-sm">
      Kembali ke Langkah 3
    </a>
    <a href="<?= base_url('admin/wizard/5') ?>" class="btn btn-primary btn-sm px-3">
      Lanjut ke Langkah 5 &rarr;
    </a>
  </div>
</div>

<?= $this->endSection() ?>
