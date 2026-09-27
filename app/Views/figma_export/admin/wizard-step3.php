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
  <div class="step-item active">
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

<div class="card mb-4 border">
  <div class="card-header bg-body py-2 px-3">
    <h6 class="card-title fw-semibold mb-0">
      Langkah 3/6: Penunjukan Wali Kelas
    </h6>
  </div>

  <form action="<?= base_url('admin/wizard/4') ?>" method="get">
    <div class="card-body p-3">
      <p class="text-secondary small mb-3">
        Tentukan guru pembimbing yang ditugaskan sebagai Wali Kelas untuk setiap rombel baru Tahun Ajaran 2026/2027:
      </p>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 60px;" class="text-center">No</th>
              <th style="width: 220px;">Nama Rombel</th>
              <th style="width: 220px;">Tingkatan &amp; Jurusan</th>
              <th>Wali Kelas Ditugaskan</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($kelas as $k): ?>
              <tr>
                <td class="text-center font-monospace text-secondary small"><?= $no++ ?></td>
                <td class="fw-semibold small text-body">
                  <?= esc($k['nama_kelas']) ?>
                </td>
                <td>
                  <span class="badge bg-secondary-subtle text-secondary border"><?= esc($k['tingkatan_nama']) ?></span>
                  <span class="badge bg-secondary-subtle text-secondary border"><?= esc($k['jurusan_kode'] ?? 'Umum') ?></span>
                </td>
                <td>
                  <select class="form-select form-select-sm" name="wali_kelas_<?= $k['id'] ?>" required>
                    <option value="">-- Pilih Guru Wali Kelas --</option>
                    <?php foreach ($guru as $g): ?>
                      <option value="<?= $g['id'] ?>" <?= ($k['wali_kelas_id'] == $g['id']) ? 'selected' : '' ?>>
                        <?= esc($g['nama']) ?> (NIP: <?= esc($g['nip']) ?>)
                      </option>
                    <?php endforeach; ?>
                  </select>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="card-footer bg-body d-flex justify-content-between align-items-center py-2 px-3">
      <a href="<?= base_url('admin/wizard/2') ?>" class="btn btn-outline-secondary btn-sm">
        Kembali ke Langkah 2
      </a>
      <button type="submit" class="btn btn-primary btn-sm px-3">
        Lanjut ke Langkah 4 &rarr;
      </button>
    </div>
  </form>
</div>

<?= $this->endSection() ?>
