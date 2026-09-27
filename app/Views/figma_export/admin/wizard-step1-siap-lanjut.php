<?php $isSemuaPlenoSelesai = true; ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Stepper Navigation -->
<div class="wizard-stepper mb-3">
  <div class="step-item active">
    <div class="step-bubble">1</div>
    <span class="step-label">Info Tahun Ajaran</span>
  </div>
  <div class="step-item">
    <div class="step-bubble">2</div>
    <span class="step-label">Kelas &amp; Kapasitas</span>
  </div>
  <div class="step-item">
    <div class="step-bubble">3</div>
    <span class="step-label">Wali Kelas</span>
  </div>
  <div class="step-item">
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

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card border">
      <div class="card-header bg-body py-2 px-3">
        <h6 class="card-title fw-semibold mb-0">
          Langkah 1/6: Informasi Tahun Ajaran &amp; Rentang Semester
        </h6>
      </div>

      <form action="<?= base_url('admin/wizard/2') ?>" method="get">
        <div class="card-body p-3">

          <?php if (!$isSemuaPlenoSelesai): ?>
            <!-- Alert Prasyarat Pleno -->
            <div class="alert alert-danger mb-3 py-2 px-3" role="alert">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-semibold small">Prasyarat Sidang Pleno Belum Lengkap</span>
                <span class="badge bg-danger">Tertahan</span>
              </div>
              <p class="small mb-2">
                Tahun ajaran baru memerlukan seluruh rombel menyelesaikan Sidang Pleno Kenaikan Kelas &amp; Kelulusan. Terdapat <strong><?= count($belumPleno) ?> rombel</strong> yang belum tuntas:
              </p>
              <div class="list-group list-group-flush border rounded bg-body mb-2">
                <?php foreach ($belumPleno as $bp): ?>
                  <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3 small">
                    <div>
                      <strong>Kelas <?= esc($bp['nama_kelas']) ?></strong> 
                      <span class="text-secondary ms-2">Wali: <?= esc($bp['wali_kelas']) ?></span>
                    </div>
                    <span class="badge <?= $bp['status_pleno'] === 'sedang_berlangsung' ? 'bg-secondary-subtle text-secondary border' : 'bg-light text-dark border' ?>">
                      <?= $bp['status_pleno'] === 'sedang_berlangsung' ? 'Sedang Berlangsung' : 'Belum Mulai' ?>
                    </span>
                  </div>
                <?php endforeach; ?>
              </div>
              <div>
                <a href="<?= base_url('guru/kenaikan-kelas') ?>" class="btn btn-sm btn-outline-danger">
                  Buka Menu Sidang Pleno &rarr;
                </a>
              </div>
            </div>
          <?php else: ?>
            <div class="alert alert-light border mb-3 py-2 px-3 small">
              <span class="text-success fw-semibold">Siap dikonfigurasi:</span> Seluruh rombel telah menyelesaikan Sidang Pleno Kenaikan Kelas &amp; Kelulusan.
            </div>
          <?php endif; ?>

          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Nama Tahun Ajaran Baru</label>
            <input type="text" class="form-control form-control-sm" name="nama_ta" value="2026/2027" placeholder="Contoh: 2026/2027" required <?= (!$isSemuaPlenoSelesai) ? 'disabled' : '' ?>>
            <span class="text-secondary small d-block mt-1">Format standar: 4 digit tahun / 4 digit tahun (mis. 2026/2027)</span>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <div class="p-3 border rounded bg-light">
                <div class="fw-semibold small text-body mb-2 pb-1 border-bottom">Semester Ganjil</div>
                <div class="mb-2">
                  <label class="form-label small fw-semibold text-secondary mb-1">Mulai Semester Ganjil</label>
                  <input type="date" class="form-control form-control-sm" name="ganjil_mulai" value="2026-07-13" required>
                </div>
                <div>
                  <label class="form-label small fw-semibold text-secondary mb-1">Selesai Semester Ganjil</label>
                  <input type="date" class="form-control form-control-sm" name="ganjil_selesai" value="2026-12-18" required>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="p-3 border rounded bg-light">
                <div class="fw-semibold small text-body mb-2 pb-1 border-bottom">Semester Genap</div>
                <div class="mb-2">
                  <label class="form-label small fw-semibold text-secondary mb-1">Mulai Semester Genap</label>
                  <input type="date" class="form-control form-control-sm" name="genap_mulai" value="2027-01-04" required>
                </div>
                <div>
                  <label class="form-label small fw-semibold text-secondary mb-1">Selesai Semester Genap</label>
                  <input type="date" class="form-control form-control-sm" name="genap_selesai" value="2027-06-18" required>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card-footer bg-body d-flex justify-content-between align-items-center py-2 px-3">
          <a href="<?= base_url('admin/tahun-ajaran') ?>" class="btn btn-outline-secondary btn-sm">
            Batal
          </a>
          <button type="submit" class="btn btn-primary btn-sm px-3" <?= (!$isSemuaPlenoSelesai) ? 'disabled' : '' ?>>
            Lanjut ke Langkah 2 &rarr;
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
