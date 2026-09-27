<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
  <div>
    <h4 class="fw-bold mb-1">Daftar Surat Keluar</h4>
    <p class="text-secondary small mb-0">Pengelolaan surat dinas keluar, penomoran berurutan anti-bolong, pengajuan TTD pimpinan, dan relasi balasan surat masuk.</p>
  </div>
  <a href="<?= base_url('tu/surat-keluar/tambah') ?>" class="btn btn-primary">
    + Buat Surat Keluar
  </a>
</div>

<!-- Alert Informasi Alur Persuratan Anti-Bolong -->
<div class="alert alert-light border mb-3">
  <div class="small text-secondary">
    <strong class="text-body">Kebijakan Penomoran Surat Anti-Bolong:</strong> Draft surat menggunakan kode sementara <code>DFT-...</code>. Nomor dinas resmi (misal: <code>104/SMA-FI/TU/XII/2025</code>) baru diterbitkan secara otomatis dan berurutan saat diajukan untuk TTD Pimpinan. Pembatalan draft tidak akan melompati nomor urut dinas.
  </div>
</div>

<div class="card">
  <div class="card-header bg-body py-3">
    <div class="row g-2 align-items-center">
      <div class="col-md-3">
        <select class="form-select form-select-sm">
          <option>Semua Status Alur</option>
          <option>Draft (Belum Bernomor)</option>
          <option>Menunggu TTD Pimpinan</option>
          <option>Terkirim ke Tujuan</option>
          <option>Dibatalkan</option>
        </select>
      </div>
      <div class="col-md-3">
        <select class="form-select form-select-sm">
          <option>Semua Kategori</option>
          <?php foreach ($kategoriList as $k): ?>
            <option value="<?= $k['id'] ?>"><?= esc($k['nama']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6">
        <input type="text" class="form-control form-control-sm" placeholder="Cari nomor surat / nomor draft / tujuan / perihal...">
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="min-width: 170px;">Nomor Surat Resmi / Draft</th>
            <th style="width: 110px;">Tanggal</th>
            <th style="min-width: 180px;">Tujuan Surat</th>
            <th style="min-width: 200px;">Perihal &amp; Relasi</th>
            <th style="width: 100px;">Sifat</th>
            <th style="width: 140px;">Status Alur</th>
            <th class="text-end" style="min-width: 160px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($suratKeluarList as $sk): ?>
            <tr>
              <td>
                <?php if (!empty($sk['nomor_surat'])): ?>
                  <a href="<?= base_url('tu/surat-keluar/detail/' . $sk['id']) ?>" class="fw-semibold text-primary text-decoration-none font-monospace">
                    <?= esc($sk['nomor_surat']) ?>
                  </a>
                  <div class="small text-secondary font-monospace">Ref: <?= esc($sk['nomor_draft']) ?></div>
                <?php elseif ($sk['status'] === 'dibatalkan'): ?>
                  <span class="badge bg-danger-subtle text-danger border border-danger-subtle font-monospace">
                    <?= esc($sk['nomor_draft']) ?> (Dibatalkan)
                  </span>
                  <div class="small text-secondary">Nomor resmi tidak terbit</div>
                <?php else: ?>
                  <span class="badge bg-secondary-subtle text-secondary-emphasis border font-monospace">
                    <?= esc($sk['nomor_draft']) ?>
                  </span>
                  <div class="small text-secondary">Draft Belum Bernomor</div>
                <?php endif; ?>
              </td>
              <td><span class="text-secondary"><?= date('d M Y', strtotime($sk['tanggal_surat'] ?? date('Y-m-d'))) ?></span></td>
              <td class="text-body fw-medium">
                <?= esc($sk['tujuan']) ?>
              </td>
              <td>
                <div class="text-body"><?= esc($sk['perihal']) ?></div>
                <?php if (!empty($sk['surat_masuk_id'])): ?>
                  <a href="<?= base_url('tu/surat-masuk/detail/' . $sk['surat_masuk_id']) ?>" class="badge bg-info-subtle text-info-emphasis border border-info-subtle text-decoration-none mt-1 d-inline-block" title="Klik untuk membuka surat masuk rujukan">
                    Balasan SM-2025-00142
                  </a>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($sk['sifat'] === 'rahasia'): ?>
                  <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Rahasia</span>
                <?php elseif ($sk['sifat'] === 'penting'): ?>
                  <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">Penting</span>
                <?php else: ?>
                  <span class="badge bg-secondary-subtle text-secondary-emphasis border">Biasa</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($sk['status'] === 'terkirim'): ?>
                  <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">Terkirim</span>
                <?php elseif ($sk['status'] === 'menunggu_ttd'): ?>
                  <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">Menunggu TTD</span>
                  <div class="small text-secondary mt-0.5">SLA: 2 Hari Kerja</div>
                <?php elseif ($sk['status'] === 'dibatalkan'): ?>
                  <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Dibatalkan</span>
                <?php else: ?>
                  <span class="badge bg-secondary-subtle text-secondary-emphasis border">Draft</span>
                <?php endif; ?>
              </td>
              <td class="text-end">
                <div class="d-inline-flex gap-1">
                  <a href="<?= base_url('tu/surat-keluar/detail/' . $sk['id']) ?>" class="btn btn-outline-primary btn-sm">
                    Detail
                  </a>
                  <?php if ($sk['status'] === 'draft'): ?>
                    <a href="<?= base_url('tu/surat-keluar/ajukan-ttd/' . $sk['id']) ?>" class="btn btn-outline-success btn-sm" onclick="return confirm('Ajukan draf surat ini untuk TTD Kepala Sekolah? Nomor surat resmi dinas akan diterbitkan secara otomatis.');">
                      Ajukan
                    </a>
                    <a href="<?= base_url('tu/surat-keluar/batalkan-draft/' . $sk['id']) ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah Anda yakin membatalkan draf ini? Nomor surat resmi tidak akan dipakai/bolong.');">
                      Batal
                    </a>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
