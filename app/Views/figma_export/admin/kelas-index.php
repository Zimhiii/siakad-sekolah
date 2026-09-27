<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
  <div>
    <h4 class="fw-bold mb-1">Kelola Kelas (Rombel)</h4>
    <p class="text-secondary small mb-0">Daftar rombongan belajar aktif, daya tampung, dan penetapan wali kelas</p>
  </div>
  <a href="<?= base_url('admin/kelas/buka') ?>" class="btn btn-primary btn-sm">
    + Buka Kelas Baru
  </a>
</div>

<div class="card border">
  <div class="card-header bg-body py-2 px-3">
    <div class="row align-items-center g-2">
      <div class="col-md-4">
        <input type="text" class="form-control form-control-sm" placeholder="Cari nama kelas atau wali kelas...">
      </div>
      <div class="col-md-8 text-md-end">
        <span class="text-secondary small">T.A. 2025/2026 Ganjil (Aktif)</span>
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 130px;">Nama Kelas</th>
            <th>Tingkatan</th>
            <th>Jurusan</th>
            <th>Wali Kelas Pengampu</th>
            <th style="width: 200px;">Keterisian Siswa</th>
            <th class="text-end" style="width: 140px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($kelasList)): ?>
            <tr>
              <td colspan="6" class="text-center text-secondary py-4">Belum ada data rombel kelas</td>
            </tr>
          <?php else: ?>
            <?php foreach ($kelasList as $k): ?>
              <?php 
                $persen = round(($k['jumlah_siswa'] / $k['kapasitas_max']) * 100);
                $barColor = ($persen >= 100) ? 'bg-danger' : (($persen >= 85) ? 'bg-primary' : 'bg-success');
              ?>
              <tr>
                <td class="fw-medium text-body">
                  <?= esc($k['nama_kelas']) ?>
                </td>
                <td>
                  <span class="text-secondary small"><?= esc($k['tingkatan_nama']) ?></span>
                </td>
                <td>
                  <span class="text-secondary small"><?= esc($k['jurusan_kode'] ?? 'Umum') ?></span>
                </td>
                <td>
                  <?php if ($k['wali_kelas_id']): ?>
                    <span class="text-body"><?= esc($k['wali_kelas_nama']) ?></span>
                  <?php else: ?>
                    <span class="text-warning-emphasis small fw-medium">Belum Ditentukan</span>
                  <?php endif; ?>
                </td>
                <td>
                  <div class="d-flex justify-content-between small mb-1">
                    <span class="text-secondary"><?= $k['jumlah_siswa'] ?> / <?= $k['kapasitas_max'] ?> Siswa</span>
                    <span class="fw-semibold text-body"><?= $persen ?>%</span>
                  </div>
                  <div class="progress" style="height: 5px;">
                    <div class="progress-bar <?= $barColor ?>" style="width: <?= $persen ?>%;"></div>
                  </div>
                </td>
                <td class="text-end">
                  <a href="<?= base_url('admin/kelas/detail/' . $k['id']) ?>" class="btn btn-outline-primary btn-sm">
                    Detail Rombel
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

