<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
  <div>
    <h4 class="fw-bold mb-1">Generate Raport Digital Semester Ganjil</h4>
    <p class="text-secondary small mb-0">Kelas Perwalian: <?= esc($kelasWali) ?> &bull; <?= esc($totalSiswa) ?> Peserta Didik</p>
  </div>
  <div>
    <a href="<?= base_url('guru/dashboard/wali') ?>" class="btn btn-outline-secondary btn-sm">
      Kembali ke Dashboard
    </a>
  </div>
</div>

<?php 
  $isSiapGenerate = ($kelengkapanInfo['persen'] ?? 0) >= 100 && ($kelengkapanInfo['boleh_generate'] ?? false);
?>

<?php if (!$isSiapGenerate): ?>
  <!-- Status Kesiapan Nilai (Terkunci) -->
  <div class="card border-warning-subtle bg-warning-subtle bg-opacity-25 mb-3">
    <div class="card-body p-3">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
        <div>
          <div class="fw-semibold text-body mb-1">Raport Belum Siap Digenerate &bull; Kelengkapan Nilai: <?= esc($kelengkapanInfo['persen']) ?>%</div>
          <div class="text-secondary small">
            Semua mata pelajaran wajib terisi 100% dan tervalidasi sebelum proses generate draf raport dibuka.
          </div>
        </div>
        <div class="text-md-end">
          <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2">
            <?= count($kelengkapanInfo['mapel_belum'] ?? []) ?> Mapel Belum Lengkap
          </span>
        </div>
      </div>
      <?php if (!empty($kelengkapanInfo['mapel_belum'])): ?>
        <div class="mt-2 pt-2 border-top border-warning-subtle small text-secondary">
          <span class="fw-medium text-body">Mata pelajaran tertunda:</span>
          <?= esc(implode(', ', $kelengkapanInfo['mapel_belum'])) ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
<?php else: ?>
  <!-- Status Kesiapan Nilai (Siap) -->
  <div class="card border-success-subtle bg-success-subtle bg-opacity-25 mb-3">
    <div class="card-body p-3">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
        <div>
          <div class="fw-semibold text-success mb-1">Seluruh Nilai Telah Lengkap (100%)</div>
          <div class="text-secondary small">
            Semua mata pelajaran telah divalidasi. Draf raport kelas <?= esc($kelasWali) ?> siap digenerate.
          </div>
        </div>
        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
          Siap Generate
        </span>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- Checklist Kelengkapan Nilai -->
<div class="card mb-3 border">
  <div class="card-header bg-body py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
    <div>
      <h6 class="mb-0 fw-semibold text-body">Kelengkapan Nilai Mata Pelajaran</h6>
      <div class="text-secondary small">Pemantauan status pengisian dan validasi nilai oleh guru mata pelajaran.</div>
    </div>
    <div>
      <span class="badge <?= $isSiapGenerate ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border' ?>">
        Progres: <?= esc($kelengkapanInfo['persen']) ?>% Terisi
      </span>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 48px;" class="text-center">No</th>
            <th style="min-width: 200px;">Mata Pelajaran</th>
            <th style="min-width: 220px;">Guru Pengampu</th>
            <th style="width: 180px;">Status Nilai</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($mapelList as $idx => $m): ?>
            <?php $isLengkap = ($m['status'] === 'lengkap'); ?>
            <tr>
              <td class="text-center text-secondary"><?= $no++ ?></td>
              <td class="fw-medium text-body"><?= esc($m['mapel']) ?></td>
              <td class="text-secondary"><?= esc($m['guru']) ?></td>
              <td>
                <?php if ($isLengkap): ?>
                  <span class="badge bg-success-subtle text-success border border-success-subtle fw-normal">
                    Lengkap (<?= $m['terisi'] ?>/<?= $m['total'] ?>)
                  </span>
                <?php elseif ($m['status'] === 'belum_lengkap'): ?>
                  <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-normal">
                    Belum Lengkap (<?= $m['terisi'] ?>/<?= $m['total'] ?>)
                  </span>
                <?php else: ?>
                  <span class="badge bg-secondary-subtle text-secondary border fw-normal">
                    Belum Ada Penugasan
                  </span>
                <?php endif; ?>
              </td>
              <td class="small text-secondary">
                <?php if ($isLengkap): ?>
                  <span class="text-success">Nilai akhir tervalidasi</span>
                <?php elseif ($m['status'] === 'belum_lengkap'): ?>
                  <span class="text-danger fw-medium">Siswa belum selesai dinilai</span>
                <?php else: ?>
                  <span>Guru pengampu belum ditugaskan</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Aksi Generate Raport -->
<div class="card bg-body-tertiary border p-3 mb-4 rounded-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
  <div>
    <div class="fw-semibold text-body mb-1">
      <?= $isSiapGenerate ? 'Kompilasi Draf Raport' : 'Proses Generate Belum Tersedia' ?>
    </div>
    <div class="small text-secondary">
      <?= $isSiapGenerate 
        ? 'Klik tombol generate untuk mengompilasi raport seluruh siswa ke dalam format draf tinjauan.' 
        : 'Proses generate dapat dilakukan setelah seluruh mata pelajaran berstatus lengkap (100%).' ?>
    </div>
  </div>
  <div>
    <?php if ($isSiapGenerate): ?>
      <a href="<?= base_url('guru/raport/tinjau') ?>" class="btn btn-primary btn-sm px-3">
        Generate Raport Kelas <?= esc($kelasWali) ?>
      </a>
    <?php else: ?>
      <button type="button" class="btn btn-secondary btn-sm px-3" disabled>
        Generate Raport (Terkunci)
      </button>
    <?php endif; ?>
  </div>
</div>

<?= $this->endSection() ?>

