<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$statusRaport = 'final';
$currentSiswaId = $currentSiswaId ?? ($raport['siswa']['id'] ?? 1);
$hasPendingRequest = false;
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <a href="<?= base_url('guru/raport/tinjau/' . $currentSiswaId) ?>" class="text-decoration-none small text-secondary">
      Kembali ke Tinjau Raport
    </a>
    <h4 class="fw-bold mb-0 mt-1">Buka Kunci Raport: <?= esc($raport['siswa']['nama']) ?></h4>
  </div>

  <!-- Pemilih Siswa Cepat -->
  <div class="d-flex align-items-center gap-2">
    <?php if (!empty($siswaList)): ?>
      <div class="dropdown">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Pilih Siswa: <?= esc($raport['siswa']['nama']) ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="max-height: 280px; overflow-y: auto;">
          <?php foreach ($siswaList as $s): ?>
            <?php
              $sSt = session()->get('raport_status_' . $s['id']) ?? 'final';
              $isCurrent = ($s['id'] == $currentSiswaId);
            ?>
            <li>
              <a class="dropdown-item d-flex justify-content-between align-items-center py-2 <?= $isCurrent ? 'active' : '' ?>" href="<?= base_url('guru/raport/buka-kunci/' . $s['id']) ?>">
                <div>
                  <div class="fw-medium"><?= esc($s['nama']) ?></div>
                  <small class="text-secondary fs-8">NIS: <?= esc($s['nis']) ?></small>
                </div>
                <span class="badge ms-2 <?= $sSt === 'draft' ? 'bg-secondary-subtle text-secondary border' : ($sSt === 'menunggu_persetujuan_kepsek' ? 'bg-warning-subtle text-warning-emphasis border' : 'bg-danger-subtle text-danger border') ?>">
                  <?= $sSt === 'draft' ? 'Draft' : ($sSt === 'menunggu_persetujuan_kepsek' ? 'Menunggu' : 'Final') ?>
                </span>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalBukaKunciGuru">
      Ajukan Buka Kunci
    </button>
  </div>
</div>

<div class="card bg-body-tertiary border mb-4">
  <div class="card-body p-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
      <div class="fw-semibold text-body mb-1">Raport Berstatus FINAL (Terkunci Resmi)</div>
      <div class="small text-secondary">
        Raport ananda <strong><?= esc($raport['siswa']['nama']) ?></strong> telah disahkan secara resmi oleh Kepala Sekolah. Untuk melakukan koreksi nilai atau deskripsi capaian, silakan ajukan permohonan buka kunci kepada Administrator Sekolah.
      </div>
    </div>
    <div class="flex-shrink-0">
      <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalBukaKunciGuru">
        Ajukan Buka Kunci
      </button>
    </div>
  </div>
</div>

<!-- Pratinjau Readonly Ringkasan Raport Siswa -->
<div class="card border mb-4">
  <div class="card-header bg-body py-3 d-flex justify-content-between align-items-center">
    <h6 class="mb-0 fw-semibold text-body">
      Pratinjau Ringkasan Dokumen Raport
    </h6>
    <span class="badge bg-danger-subtle text-danger border">
      Status: FINAL
    </span>
  </div>
  <div class="card-body p-4">
    <div class="row g-3 pb-3 border-bottom mb-3">
      <div class="col-md-3">
        <small class="text-secondary d-block">Nama Lengkap Siswa:</small>
        <strong><?= esc($raport['siswa']['nama']) ?></strong>
      </div>
      <div class="col-md-3">
        <small class="text-secondary d-block">NIS / NISN:</small>
        <span><?= esc($raport['siswa']['nis']) ?> / <?= esc($raport['siswa']['nisn'] ?? '-') ?></span>
      </div>
      <div class="col-md-3">
        <small class="text-secondary d-block">Kelas &amp; Semester:</small>
        <span><?= esc($raport['siswa']['kelas']) ?> &bull; <?= esc($raport['siswa']['semester']) ?></span>
      </div>
      <div class="col-md-3">
        <small class="text-secondary d-block">Wali Kelas:</small>
        <span><?= esc($raport['siswa']['wali_kelas']) ?></span>
      </div>
    </div>

    <!-- Tabel Rincian Nilai Mata Pelajaran -->
    <h6 class="fw-semibold text-body mb-2 small text-uppercase">Daftar Nilai Akademik Siswa</h6>
    <div class="table-responsive">
      <table class="table table-sm table-bordered align-middle mb-0">
        <thead class="table-light text-center small">
          <tr>
            <th style="width: 48px;">No</th>
            <th class="text-start">Mata Pelajaran</th>
            <th style="width: 60px;">KKM</th>
            <th style="width: 90px;">Pengetahuan</th>
            <th style="width: 90px;">Keterampilan</th>
            <th style="width: 70px;">Predikat</th>
            <th style="width: 90px;">Status</th>
          </tr>
        </thead>
        <tbody class="small">
          <?php if (!empty($raport['akademik'])): ?>
            <?php $no = 1; foreach ($raport['akademik'] as $ak): ?>
              <tr>
                <td class="text-center text-secondary"><?= $no++ ?></td>
                <td><?= esc($ak['mapel']) ?></td>
                <td class="text-center text-secondary"><?= esc($ak['kkm']) ?></td>
                <td class="text-center fw-semibold <?= ($ak['pengetahuan']['nilai'] < $ak['kkm']) ? 'text-danger' : 'text-body' ?>">
                  <?= esc($ak['pengetahuan']['nilai']) ?>
                </td>
                <td class="text-center fw-semibold <?= ($ak['keterampilan']['nilai'] < $ak['kkm']) ? 'text-danger' : 'text-body' ?>">
                  <?= esc($ak['keterampilan']['nilai']) ?>
                </td>
                <td class="text-center">
                  <span class="text-body fw-medium"><?= esc($ak['pengetahuan']['predikat']) ?></span>
                </td>
                <td class="text-center">
                  <?php if ($ak['pengetahuan']['nilai'] >= $ak['kkm']): ?>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Tuntas</span>
                  <?php else: ?>
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Remedial</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center text-secondary py-3">Data nilai belum tersedia.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Catatan Wali Kelas -->
    <?php if (!empty($raport['catatan_wali'])): ?>
      <div class="mt-3 p-3 bg-body-tertiary rounded border small">
        <span class="text-secondary fw-semibold d-block mb-1">Catatan Wali Kelas:</span>
        <p class="mb-0 text-body fst-italic">"<?= esc($raport['catatan_wali']) ?>"</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Modal Buka Kunci Guru (Open State) -->
<div class="modal show" id="modalBukaKunciGuru" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('guru/raport/ajukan-buka-kunci/' . $currentSiswaId) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="siswa_id" value="<?= esc($currentSiswaId) ?>">
        <input type="hidden" name="redirect_url" value="/guru/raport/buka-kunci/<?= esc($currentSiswaId) ?>">

        <div class="modal-header">
          <h5 class="modal-title fw-semibold text-danger">
            Permohonan Buka Kunci Raport
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="small text-secondary mb-3">
            Masukkan rincian alasan mengapa raport ananda <strong><?= esc($raport['siswa']['nama']) ?></strong> perlu dibuka kembali oleh Administrator:
          </p>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Alasan Pembukaan Kunci / Revisi Nilai (Wajib Diisi)</label>
            <textarea class="form-control" name="alasan_revisi" rows="3" placeholder="Contoh: Perbaikan kekeliruan input nilai tugas praktik Biologi dan penambahan deskripsi capaian..." required></textarea>
            <div class="form-text fs-8">Permohonan akan langsung masuk ke antrean persetujuan pada Dashboard Administrator.</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-3">
            Kirim Permohonan ke Admin
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Static Modal Backdrop for Figma Export -->
<div class="modal-backdrop show"></div>
<style>body { overflow: hidden; }</style>

<?= $this->endSection() ?>
