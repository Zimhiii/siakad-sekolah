<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$statusRaport = $raport['status'] ?? 'final';
$currentSiswaId = $currentSiswaId ?? ($raport['siswa']['id'] ?? 1);
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

    <?php if ($statusRaport === 'draft'): ?>
      <a href="<?= base_url('guru/raport/tinjau/' . $currentSiswaId) ?>" class="btn btn-primary btn-sm px-3">
        Edit Raport Siswa
      </a>
    <?php elseif ($statusRaport === 'final' && !empty($hasPendingRequest)): ?>
      <button type="button" class="btn btn-secondary btn-sm disabled" disabled title="Permohonan buka kunci sedang menunggu persetujuan Administrator">
        Menunggu Persetujuan Admin
      </button>
    <?php elseif ($statusRaport === 'final'): ?>
      <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalBukaKunciGuru">
        Ajukan Buka Kunci
      </button>
    <?php endif; ?>
  </div>
</div>

<!-- Kondisi 1: Status Raport Saat Ini DRAFT (Kunci Terbuka) -->
<?php if ($statusRaport === 'draft'): ?>
  <div class="card border-success-subtle bg-success-subtle bg-opacity-25 mb-4">
    <div class="card-body p-3">
      <div class="d-flex justify-content-between align-items-center mb-1">
        <h6 class="fw-bold mb-0 text-success">Status Raport: DRAFT (Kunci Terbuka untuk Diedit)</h6>
        <span class="badge bg-success-subtle text-success border border-success-subtle">Status: Terbuka</span>
      </div>
      <p class="small text-secondary mb-2">
        Raport ananda <strong><?= esc($raport['siswa']['nama']) ?></strong> saat ini berstatus <strong>Draft</strong>. Wali kelas dan guru mata pelajaran dapat langsung melakukan perbaikan nilai capaian atau catatan perkembangan tanpa perlu mengajukan buka kunci lagi.
      </p>
      <div class="d-flex gap-2 mt-2">
        <a href="<?= base_url('guru/raport/tinjau/' . $currentSiswaId) ?>" class="btn btn-primary btn-sm">
          Buka Halaman Tinjau &amp; Edit Raport
        </a>
        <a href="<?= base_url('guru/nilai') ?>" class="btn btn-outline-secondary btn-sm">
          Input Nilai Siswa
        </a>
      </div>
    </div>
  </div>

<!-- Kondisi 2: Status Raport Menunggu Persetujuan Kepsek -->
<?php elseif ($statusRaport === 'menunggu_persetujuan_kepsek'): ?>
  <div class="card border-warning-subtle bg-warning-subtle bg-opacity-25 mb-4">
    <div class="card-body p-3">
      <div class="d-flex justify-content-between align-items-center mb-1">
        <h6 class="fw-bold mb-0 text-body">Status Raport: Menunggu Pengesahan Kepala Sekolah</h6>
        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">Menunggu Kepsek</span>
      </div>
      <p class="small text-secondary mb-2">
        Raport ananda <strong><?= esc($raport['siswa']['nama']) ?></strong> telah diajukan oleh Wali Kelas dan sedang menunggu proses pengesahan tanda tangan oleh Kepala Sekolah.
      </p>
      <a href="<?= base_url('guru/raport/tinjau/' . $currentSiswaId) ?>" class="btn btn-outline-secondary btn-sm">
        Lihat Status di Tinjau Raport
      </a>
    </div>
  </div>

<!-- Kondisi 3: Status Raport FINAL dan ADA Permohonan Pending -->
<?php elseif ($statusRaport === 'final' && !empty($hasPendingRequest)): ?>
  <div class="card border-warning-subtle bg-warning-subtle bg-opacity-25 mb-4">
    <div class="card-body p-3">
      <div class="d-flex justify-content-between align-items-center mb-1">
        <h6 class="fw-bold mb-0 text-body">Permohonan Buka Kunci Sedang Menunggu Persetujuan Admin</h6>
        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">Status: Menunggu Konfirmasi</span>
      </div>
      <p class="small text-secondary mb-2">
        Permohonan revisi nilai raport untuk siswa <strong><?= esc($currentPending['siswa_nama'] ?? $raport['siswa']['nama']) ?></strong> telah diajukan ke Administrator Sekolah. Tombol buka kunci dikunci sementara hingga Admin menyetujui permohonan.
      </p>
      <div class="bg-body p-3 rounded border small mb-3">
        <div class="row g-2">
          <div class="col-md-7">
            <span class="text-secondary d-block fs-8">Alasan Pengajuan Revisi:</span>
            <span class="text-body fw-medium">"<?= esc($currentPending['alasan'] ?? 'Perbaikan kekeliruan data nilai') ?>"</span>
          </div>
          <div class="col-md-5 text-md-end">
            <span class="text-secondary d-block fs-8">Waktu Pengajuan:</span>
            <span class="text-secondary"><?= esc($currentPending['diminta_pada'] ?? date('Y-m-d H:i')) ?></span>
          </div>
        </div>
      </div>
      <div>
        <a href="<?= base_url('guru/raport/batal-buka-kunci/' . $currentSiswaId) ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin membatalkan permohonan buka kunci raport ini?')">
          Batalkan Permohonan
        </a>
      </div>
    </div>
  </div>

<!-- Kondisi 4: Status Raport FINAL dan BELUM ADA Permohonan -->
<?php else: ?>
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
<?php endif; ?>

<!-- Pratinjau Readonly Ringkasan Raport Siswa -->
<div class="card border mb-4">
  <div class="card-header bg-body py-3 d-flex justify-content-between align-items-center">
    <h6 class="mb-0 fw-semibold text-body">
      Pratinjau Ringkasan Dokumen Raport
    </h6>
    <span class="badge <?= $statusRaport === 'draft' ? 'bg-secondary-subtle text-secondary border' : ($statusRaport === 'menunggu_persetujuan_kepsek' ? 'bg-warning-subtle text-warning-emphasis border' : 'bg-danger-subtle text-danger border') ?>">
      Status: <?= strtoupper(str_replace('_', ' ', $statusRaport)) ?>
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

<!-- Modal Buka Kunci Guru -->
<div class="modal fade" id="modalBukaKunciGuru" tabindex="-1" aria-hidden="true">
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

<?= $this->endSection() ?>

