<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3 btn-no-print">
  <div>
    <h4 class="fw-bold mb-1">Cetak Buku Agenda Surat</h4>
    <p class="text-secondary small mb-0">Buku agenda rekapitulasi surat masuk dan keluar untuk pengesahan pimpinan</p>
  </div>
  <div class="d-flex gap-2">
    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.print()">
      Unduh PDF
    </button>
    <button type="button" class="btn btn-primary btn-sm" onclick="window.print()">
      Cetak Lembar Agenda
    </button>
  </div>
</div>

<!-- Filter Periode (No Print) -->
<div class="card border mb-3 btn-no-print">
  <div class="card-body p-3">
    <div class="row g-2 align-items-center">
      <div class="col-md-4">
        <label class="form-label small fw-semibold text-secondary mb-1">Filter Periode Semester</label>
        <select class="form-select form-select-sm">
          <option selected>Semester Ganjil TA 2025/2026 (Juli - Desember 2025)</option>
          <option>Semester Genap TA 2024/2025 (Januari - Juni 2025)</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label small fw-semibold text-secondary mb-1">Jenis Agenda</label>
        <select class="form-select form-select-sm">
          <option selected>Semua (Surat Masuk &amp; Keluar)</option>
          <option>Hanya Surat Masuk</option>
          <option>Hanya Surat Keluar</option>
        </select>
      </div>
    </div>
  </div>
</div>

<!-- Dokumen Kertas Buku Agenda -->
<div class="card border mb-5">
  <div class="card-body p-4 p-md-5">
    
    <!-- KOP Surat Agenda -->
    <div class="text-center border-bottom pb-3 mb-4">
      <h6 class="text-uppercase mb-1 small fw-semibold text-secondary">Buku Agenda Surat Masuk &amp; Surat Keluar</h6>
      <h5 class="fw-bold mb-1"><?= esc($sekolah['nama_sekolah']) ?></h5>
      <p class="text-secondary small mb-0">Periode: <strong><?= esc($periode) ?></strong></p>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered align-middle mb-0">
        <thead class="table-light text-center">
          <tr>
            <th style="width: 50px;">No</th>
            <th style="width: 110px;">Jenis</th>
            <th style="width: 130px;">No. Agenda</th>
            <th style="width: 170px;">Nomor Surat</th>
            <th style="width: 110px;">Tanggal</th>
            <th style="width: 200px;">Pengirim / Tujuan</th>
            <th>Perihal / Ringkasan Isi</th>
            <th style="width: 100px;">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($agendaItems as $item): ?>
            <tr>
              <td class="text-center font-monospace small text-secondary"><?= $item['no'] ?></td>
              <td class="text-center small fw-medium"><?= esc($item['jenis']) ?></td>
              <td class="text-center font-monospace small"><?= esc($item['nomor_agenda']) ?></td>
              <td class="font-monospace small"><?= esc($item['nomor_surat']) ?></td>
              <td class="text-center small"><?= date('d/m/Y', strtotime($item['tanggal'])) ?></td>
              <td class="small"><?= esc($item['pengirim_tujuan']) ?></td>
              <td class="small"><?= esc($item['perihal']) ?></td>
              <td class="text-center small"><?= esc($item['status']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Tanda Tangan Footer Buku Agenda -->
    <div class="row text-center mt-5 pt-3" style="font-size: 13px;">
      <div class="col-6">
        <p class="mb-0">Mengetahui,</p>
        <p class="fw-bold mb-0">Kepala Sekolah</p>
        <div style="height: 65px;"></div>
        <p class="fw-bold mb-0 text-decoration-underline"><?= esc($sekolah['kepala_sekolah']) ?></p>
        <small class="text-secondary">NIP. 19740512 199903 1 002</small>
      </div>
      <div class="col-6">
        <p class="mb-0">Bandung Barat, <?= date('d F Y') ?></p>
        <p class="fw-bold mb-0">Kepala Tata Usaha</p>
        <div style="height: 65px;"></div>
        <p class="fw-bold mb-0 text-decoration-underline"><?= esc($namaTu) ?></p>
        <small class="text-secondary">NIP. 19820815 200801 1 014</small>
      </div>
    </div>

  </div>
</div>

<?= $this->endSection() ?>
