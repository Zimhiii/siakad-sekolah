<?php 
$riwayatRaport = [
    [
        "id" => 1,
        "tahun_ajaran" => "2025/2026",
        "semester" => "Ganjil",
        "kelas" => "X-MIPA-1",
        "status_label" => "Dalam Proses Penilaian",
        "is_ready" => false,
    ]
];
?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
  <div>
    <h4 class="fw-bold mb-1">Riwayat Raport Digital</h4>
    <p class="text-secondary small mb-0">Daftar buku raport digital yang telah diterbitkan per semester.</p>
  </div>
</div>

<div class="row g-3">
  <?php foreach ($riwayatRaport as $r): ?>
    <div class="col-12">
      <div class="card border">
        <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
          <div>
            <h5 class="fw-bold mb-1 text-dark">Semester <?= esc($r['semester']) ?> TA <?= esc($r['tahun_ajaran']) ?></h5>
            <div class="d-flex flex-wrap align-items-center gap-2 text-secondary small">
              <span>Rombel: <span class="badge bg-secondary-subtle text-secondary-emphasis border"><?= esc($r['kelas']) ?></span></span>
              <span>&bull;</span>
              <span>Status: 
                <?php if ($r['is_ready']): ?>
                  <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle"><?= esc($r['status_label']) ?></span>
                <?php else: ?>
                  <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle"><?= esc($r['status_label']) ?></span>
                <?php endif; ?>
              </span>
            </div>
          </div>

          <div class="d-flex gap-2 flex-shrink-0">
            <?php if ($r['is_ready']): ?>
              <a href="<?= base_url('siswa/raport/preview/' . $r['id']) ?>" class="btn btn-outline-primary btn-sm px-3">
                Pratinjau Raport
              </a>
              <a href="<?= base_url('siswa/raport/preview/' . $r['id']) ?>" class="btn btn-primary btn-sm px-3">
                Unduh PDF
              </a>
            <?php else: ?>
              <button class="btn btn-outline-secondary btn-sm px-3" disabled>
                Belum Siap Unduh
              </button>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
