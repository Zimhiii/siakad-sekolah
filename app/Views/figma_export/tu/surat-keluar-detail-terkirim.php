<?php $surat['status'] = 'terkirim'; ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
  <div>
    <a href="<?= base_url('tu/surat-keluar') ?>" class="text-decoration-none small text-secondary">
      Kembali ke Daftar Surat Keluar
    </a>
    <h4 class="fw-bold mb-1">
      <?= !empty($surat['nomor_surat']) ? 'Surat Keluar: <span class="font-monospace text-primary">' . esc($surat['nomor_surat']) . '</span>' : 'Draft Surat: <span class="font-monospace text-secondary">' . esc($surat['nomor_draft']) . '</span>' ?>
    </h4>
  </div>
  <div>
    <?php if ($surat['status'] === 'draft'): ?>
      <div class="d-flex gap-2">
        <a href="<?= base_url('tu/surat-keluar/ajukan-ttd/' . $surat['id']) ?>" class="btn btn-primary btn-sm px-3" onclick="return confirm('Ajukan draf surat ini untuk TTD Kepala Sekolah? Nomor surat resmi dinas akan diterbitkan secara otomatis.');">
          Ajukan TTD &amp; Terbitkan Nomor Resmi
        </a>
        <a href="<?= base_url('tu/surat-keluar/batalkan-draft/' . $surat['id']) ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Batalkan draft ini? Nomor dinas resmi tidak akan terbuang.');">
          Batalkan Draft
        </a>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php if ($surat['sifat'] === 'rahasia'): ?>
  <div class="alert alert-light border border-danger-subtle d-flex align-items-center mb-3">
    <div class="small">
      <strong class="text-danger">DOKUMEN RAHASIA / TERBATAS:</strong> Surat ini memiliki tingkat kerahasiaan tinggi (Sifat: Rahasia). Hanya staf berwenang, Kepala Tata Usaha, dan Pimpinan Sekolah yang diizinkan mengakses berkas ini.
    </div>
  </div>
<?php endif; ?>

<!-- Status Alur Surat Keluar -->
<div class="card mb-4">
  <div class="card-body p-3">
    <div class="row g-3 text-center">
      <div class="col-md-4 border-end">
        <div class="small text-secondary mb-1">Tahap 1: Draft Dibuat</div>
        <div class="fw-semibold text-body"><?= esc($surat['dibuat_oleh']) ?></div>
        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle mt-1">Selesai</span>
      </div>

      <div class="col-md-4 border-end">
        <div class="small text-secondary mb-1">Tahap 2: Tanda Tangan Pimpinan</div>
        <div class="fw-semibold text-body"><?= esc($surat['ditandatangani_oleh']) ?></div>
        <?php if ($surat['status'] === 'menunggu_ttd'): ?>
          <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle mt-1">Menunggu TTD (SLA: 2 Hari)</span>
        <?php elseif ($surat['status'] === 'terkirim'): ?>
          <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle mt-1">Sudah Ditandatangani</span>
        <?php else: ?>
          <span class="badge bg-secondary-subtle text-secondary-emphasis border mt-1">Menunggu Pengajuan</span>
        <?php endif; ?>
      </div>

      <div class="col-md-4">
        <div class="small text-secondary mb-1">Tahap 3: Pengiriman ke Tujuan</div>
        <div class="fw-semibold text-body"><?= $surat['tanggal_kirim'] ?? 'Belum dikirim' ?></div>
        <?php if ($surat['status'] === 'terkirim'): ?>
          <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle mt-1">Terkirim</span>
        <?php else: ?>
          <span class="badge bg-secondary-subtle text-secondary-emphasis border mt-1">Belum Terkirim</span>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-7">
    <!-- Info Surat Keluar -->
    <div class="card mb-4">
      <div class="card-header bg-body py-3">
        <h6 class="mb-0 fw-semibold">Informasi Surat Keluar</h6>
      </div>
      <div class="card-body p-4">
        <div class="row g-3 small">
          <div class="col-md-6 border-bottom pb-2">
            <span class="text-secondary d-block">Nomor Surat Resmi</span>
            <?php if (!empty($surat['nomor_surat'])): ?>
              <span class="text-primary font-monospace fw-semibold fs-6"><?= esc($surat['nomor_surat']) ?></span>
            <?php else: ?>
              <span class="badge bg-secondary-subtle text-secondary-emphasis border font-monospace">Belum Terbit (Draft)</span>
            <?php endif; ?>
          </div>
          <div class="col-md-6 border-bottom pb-2">
            <span class="text-secondary d-block">Nomor Referensi Draft</span>
            <span class="text-body font-monospace fw-semibold"><?= esc($surat['nomor_draft']) ?></span>
          </div>
          <div class="col-md-6 border-bottom pb-2">
            <span class="text-secondary d-block">Tujuan Surat</span>
            <span class="text-body fw-medium"><?= esc($surat['tujuan']) ?></span>
          </div>
          <div class="col-md-6 border-bottom pb-2">
            <span class="text-secondary d-block">Tanggal Surat</span>
            <span class="text-body"><?= date('d F Y', strtotime($surat['tanggal_surat'] ?? date('Y-m-d'))) ?></span>
          </div>
          <div class="col-md-6 border-bottom pb-2">
            <span class="text-secondary d-block mb-1">Kategori &amp; Sifat</span>
            <span class="badge bg-secondary-subtle text-secondary-emphasis border me-1"><?= esc($surat['kategori']) ?></span>
            <?php if ($surat['sifat'] === 'rahasia'): ?>
              <span class="badge bg-danger-subtle text-danger border border-danger-subtle">RAHASIA</span>
            <?php else: ?>
              <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle text-uppercase"><?= esc($surat['sifat']) ?></span>
            <?php endif; ?>
          </div>
          <div class="col-md-6 border-bottom pb-2">
            <span class="text-secondary d-block mb-1">Status Alur Persuratan</span>
            <?php if ($surat['status'] === 'terkirim'): ?>
              <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">Terkirim</span>
            <?php elseif ($surat['status'] === 'menunggu_ttd'): ?>
              <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">Menunggu TTD Pimpinan</span>
            <?php elseif ($surat['status'] === 'dibatalkan'): ?>
              <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Dibatalkan</span>
            <?php else: ?>
              <span class="badge bg-secondary-subtle text-secondary-emphasis border">Draft</span>
            <?php endif; ?>
          </div>
          <div class="col-12 border-bottom pb-2">
            <span class="text-secondary d-block">Perihal</span>
            <span class="text-body fw-medium fs-6"><?= esc($surat['perihal']) ?></span>
          </div>
          <?php if (!empty($surat['surat_masuk_id'])): ?>
            <div class="col-12 bg-body-tertiary p-3 rounded border">
              <div class="d-flex align-items-center justify-content-between">
                <div>
                  <span class="text-secondary small d-block">Rujukan Surat Masuk (Balasan Resmi):</span>
                  <span class="text-primary font-monospace fw-semibold">SM-2025-00142 - Surat Edaran Disdik Jabar</span>
                </div>
                <a href="<?= base_url('tu/surat-masuk/detail/' . $surat['surat_masuk_id']) ?>" class="btn btn-outline-primary btn-sm">
                  Buka Surat Masuk
                </a>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Aksi TTD & Pengiriman -->
    <div class="card">
      <div class="card-header bg-body py-3">
        <h6 class="mb-0 fw-semibold">Pembaruan Status Tanda Tangan &amp; Pengiriman</h6>
      </div>
      <form action="<?= base_url('tu/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Pembaruan Status Surat Keluar <?= esc($surat['nomor_surat'] ?? $surat['nomor_draft']) ?>">
        <input type="hidden" name="redirect_url" value="/tu/surat-keluar/detail/<?= $surat['id'] ?>">

        <div class="card-body p-4">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary">Pejabat Penandatangan Surat</label>
            <select class="form-select form-select-sm" name="ditandatangani_oleh">
              <option selected>Drs. H. Ahmad Fauzi, M.Pd. (Kepala Sekolah)</option>
              <option>M. Taufik Hidayat, S.Sos. (Kepala Tata Usaha)</option>
            </select>
          </div>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label small fw-semibold text-secondary">Tanggal Tanda Tangan</label>
              <input type="date" class="form-control form-control-sm" name="tanggal_ttd" value="<?= date('Y-m-d') ?>">
            </div>
            <div class="col-6">
              <label class="form-label small fw-semibold text-secondary">Tanggal Pengiriman Surat</label>
              <input type="date" class="form-control form-control-sm" name="tanggal_kirim" value="<?= date('Y-m-d') ?>">
            </div>
          </div>

          <div class="d-flex flex-wrap gap-2 mt-3">
            <button type="submit" class="btn btn-outline-primary btn-sm">
              Tandai Sudah Ditandatangani
            </button>
            <button type="submit" class="btn btn-success btn-sm">
              Tandai Terkirim ke Tujuan
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="card h-100">
      <div class="card-header bg-body py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold">Berkas Surat Dinas</h6>
        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.print()">Cetak</button>
      </div>
      <div class="card-body d-flex flex-column align-items-center justify-content-center bg-body-tertiary p-4 text-center">
        <div class="p-3 border rounded bg-body mb-3 w-100 text-start">
          <div class="text-secondary small">Nama Berkas:</div>
          <div class="font-monospace fw-medium text-break text-body"><?= esc($surat['file_dokumen']) ?></div>
          <div class="text-secondary small mt-1">Dokumen Resmi Surat Keluar</div>
        </div>
        <button type="button" class="btn btn-primary btn-sm px-4" onclick="window.print()">
          Cetak Lembar Surat
        </button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
