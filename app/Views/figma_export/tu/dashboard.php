<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">Dashboard Tata Usaha</h4>
    <p class="text-secondary small mb-0">Kelola persuratan, arsip digital, dan buku agenda sekolah</p>
  </div>
</div>

<!-- 4 Metrik Ringkasan Surat -->
<div class="card border mb-3">
  <div class="card-body p-0">
    <div class="row g-0 text-center">
      <div class="col-6 col-md-3 border-end py-3 px-2">
        <span class="text-secondary small d-block">Surat Masuk Bulan Ini</span>
        <div class="fs-4 fw-bold text-body font-monospace mt-1"><?= esc($stats['surat_masuk_bulan_ini']) ?></div>
        <a href="<?= base_url('tu/surat-masuk') ?>" class="text-secondary small text-decoration-none">Lihat Surat Masuk &rarr;</a>
      </div>
      <div class="col-6 col-md-3 border-end py-3 px-2">
        <span class="text-secondary small d-block">Menunggu Disposisi</span>
        <div class="fs-4 fw-bold text-warning font-monospace mt-1"><?= esc($stats['menunggu_disposisi']) ?></div>
        <a href="<?= base_url('tu/surat-masuk') ?>" class="text-secondary small text-decoration-none">Proses Disposisi &rarr;</a>
      </div>
      <div class="col-6 col-md-3 border-end py-3 px-2">
        <span class="text-secondary small d-block">Menunggu Tanda Tangan</span>
        <div class="fs-4 fw-bold text-primary font-monospace mt-1"><?= esc($stats['menunggu_ttd']) ?></div>
        <a href="<?= base_url('tu/surat-keluar') ?>" class="text-secondary small text-decoration-none">Cek Surat Keluar &rarr;</a>
      </div>
      <div class="col-6 col-md-3 py-3 px-2">
        <span class="text-secondary small d-block">Surat Keluar Terkirim</span>
        <div class="fs-4 fw-bold text-success font-monospace mt-1"><?= esc($stats['surat_keluar_terkirim']) ?></div>
        <a href="<?= base_url('tu/surat-keluar') ?>" class="text-secondary small text-decoration-none">Riwayat Pengiriman &rarr;</a>
      </div>
    </div>
  </div>
</div>

<!-- Tabel Disposisi Mendekati Deadline -->
<div class="card border mb-4">
  <div class="card-header bg-body py-2 px-3 d-flex justify-content-between align-items-center">
    <div>
      <h6 class="card-title fw-semibold mb-0">
        Disposisi Surat Mendekati / Melewati Batas Waktu
      </h6>
    </div>
    <a href="<?= base_url('tu/surat-masuk/tambah') ?>" class="btn btn-primary btn-sm">
      + Catat Surat Masuk
    </a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 140px;">Nomor Agenda</th>
            <th>Pengirim Asal</th>
            <th>Penerima Disposisi</th>
            <th style="width: 130px;">Batas Waktu</th>
            <th style="width: 150px;">Status Tindak Lanjut</th>
            <th class="text-end" style="width: 100px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($disposisiDeadline as $dd): ?>
            <tr>
              <td><span class="font-monospace small fw-medium text-body"><?= esc($dd['nomor_agenda']) ?></span></td>
              <td class="small"><?= esc($dd['pengirim']) ?></td>
              <td class="fw-medium small text-body"><?= esc($dd['penerima']) ?></td>
              <td class="small text-secondary"><?= date('d M Y', strtotime($dd['batas_waktu'])) ?></td>
              <td><span class="badge bg-secondary-subtle text-secondary border"><?= esc($dd['status']) ?></span></td>
              <td class="text-end">
                <a href="<?= base_url('tu/surat-masuk/detail/1') ?>" class="btn btn-outline-secondary btn-sm py-0 px-2">
                  Detail
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
