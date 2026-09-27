<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">Data Orang Tua & Wali Siswa</h4>
    <p class="text-secondary small mb-0">Daftar kontak, domisili, dan pekerjaan orang tua/wali siswa</p>
  </div>
</div>

<div class="card border">
  <div class="card-header bg-body py-2 px-3">
    <div class="row g-2 align-items-center">
      <div class="col-md-4">
        <input type="text" class="form-control form-control-sm" placeholder="Cari nama orang tua / nama siswa...">
      </div>
      <div class="col-md-8 text-md-end">
        <span class="text-secondary small"><?= count($ortuList) ?> kontak terdaftar</span>
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 60px;">No</th>
            <th>Nama Orang Tua / Wali</th>
            <th>Hubungan</th>
            <th>Nama Siswa (Anak)</th>
            <th>Kelas Siswa</th>
            <th>No. Handphone</th>
            <th>Pekerjaan</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($ortuList)): ?>
            <tr>
              <td colspan="7" class="text-center text-secondary small py-4">Belum ada data orang tua siswa</td>
            </tr>
          <?php else: ?>
            <?php $no = 1; foreach ($ortuList as $o): ?>
              <tr>
                <td class="font-monospace text-secondary small"><?= $no++ ?></td>
                <td class="fw-medium small"><?= esc($o['nama']) ?></td>
                <td><span class="badge bg-secondary-subtle text-secondary border"><?= esc($o['jenis']) ?></span></td>
                <td class="small"><?= esc($o['anak']) ?></td>
                <td><span class="badge bg-secondary-subtle text-secondary border"><?= esc($o['kelas']) ?></span></td>
                <td>
                  <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $o['telepon']) ?>" target="_blank" class="text-decoration-none font-monospace small">
                    <?= esc($o['telepon']) ?>
                  </a>
                </td>
                <td class="text-secondary small"><?= esc($o['pekerjaan']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
