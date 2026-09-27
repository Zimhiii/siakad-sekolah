<?php $surat['disposisi'] = []; ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
  <div>
    <a href="<?= base_url('tu/surat-masuk') ?>" class="text-decoration-none small text-secondary">
      Kembali ke Daftar Surat Masuk
    </a>
    <h4 class="fw-bold mb-1">Agenda: <span class="font-monospace"><?= esc($surat['nomor_agenda']) ?></span></h4>
  </div>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahDisposisi">
    + Tambah Lembar Disposisi
  </button>
</div>

<div class="row g-4">
  <!-- Kolom Kiri: Info Surat & Tabel Disposisi -->
  <div class="col-lg-7">
    
    <!-- Info Surat Card -->
    <div class="card mb-4">
      <div class="card-header bg-body py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold">Informasi Surat Masuk</h6>
        <span class="badge bg-secondary-subtle text-secondary-emphasis border text-uppercase"><?= esc($surat['sifat']) ?></span>
      </div>
      <div class="card-body p-4">
        <div class="row g-3 small">
          <div class="col-md-6 border-bottom pb-2">
            <span class="text-secondary d-block">Nomor Surat Asal</span>
            <span class="text-body font-monospace fw-medium"><?= esc($surat['nomor_surat']) ?></span>
          </div>
          <div class="col-md-6 border-bottom pb-2">
            <span class="text-secondary d-block">Instansi Pengirim</span>
            <span class="text-body fw-medium"><?= esc($surat['pengirim']) ?></span>
          </div>
          <div class="col-md-6 border-bottom pb-2">
            <span class="text-secondary d-block">Tanggal Surat / Diterima</span>
            <span class="text-body"><?= date('d M Y', strtotime($surat['tanggal_surat'])) ?> / <strong><?= date('d M Y', strtotime($surat['tanggal_diterima'])) ?></strong></span>
          </div>
          <div class="col-md-6 border-bottom pb-2">
            <span class="text-secondary d-block mb-1">Kategori & Status</span>
            <span class="badge bg-secondary-subtle text-secondary-emphasis border me-1"><?= esc($surat['kategori']) ?></span>
            <span class="badge bg-success-subtle text-success-emphasis border"><?= esc($surat['status']) ?></span>
          </div>
          <div class="col-12">
            <span class="text-secondary d-block">Perihal</span>
            <span class="text-body fw-medium fs-6"><?= esc($surat['perihal']) ?></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Section Disposisi -->
    <div class="card">
      <div class="card-header bg-body py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold">Histori Tindak Lanjut Disposisi</h6>
        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahDisposisi">
          Disposisikan
        </button>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light">
              <tr>
                <th>Ditujukan Kepada</th>
                <th>Instruksi / Arahan</th>
                <th>Batas Waktu</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($surat['disposisi'])): ?>
                <tr>
                  <td colspan="4" class="text-center py-4 text-secondary">Surat ini belum didisposisikan.</td>
                </tr>
              <?php else: ?>
                <?php foreach ($surat['disposisi'] as $disp): ?>
                  <tr>
                    <td class="text-body fw-medium"><?= esc($disp['ditujukan_kepada']) ?></td>
                    <td><?= esc($disp['instruksi']) ?></td>
                    <td><span class="text-secondary"><?= date('d M Y', strtotime($disp['batas_waktu'])) ?></span></td>
                    <td>
                      <?php if ($disp['status'] === 'selesai'): ?>
                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">Selesai</span>
                      <?php elseif ($disp['status'] === 'sedang_diproses'): ?>
                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">Sedang Diproses</span>
                      <?php else: ?>
                        <span class="badge bg-secondary-subtle text-secondary-emphasis border">Belum Ditindak</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

  <!-- Kolom Kanan: File Preview -->
  <div class="col-lg-5">
    <div class="card h-100">
      <div class="card-header bg-body py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold">Lampiran Dokumen Surat</h6>
        <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">Cetak</button>
      </div>
      <div class="card-body d-flex flex-column align-items-center justify-content-center bg-body-tertiary p-4 text-center">
        <div class="p-3 border rounded bg-body mb-3 w-100 text-start">
          <div class="text-secondary small">Nama Berkas:</div>
          <div class="font-monospace fw-medium text-break text-body"><?= esc($surat['file_lampiran']) ?></div>
          <div class="text-secondary small mt-1">Dokumen Hasil Scan Surat Masuk</div>
        </div>
        <button class="btn btn-primary btn-sm px-4" data-bs-toggle="modal" data-bs-target="#modalPratinjauSurat">
          Pratinjau Dokumen Lengkap
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Disposisi -->
<div class="modal fade" id="modalTambahDisposisi" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-sm">
      <div class="modal-header">
        <h5 class="modal-title">Kirim Lembar Disposisi Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="small text-secondary">Form penugasan disposisi.</p>
      </div>
    </div>
  </div>
</div>

<!-- Modal Pratinjau Dokumen Lengkap (OPEN STATE) -->
<div class="modal show" id="modalPratinjauSurat" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-sm">
      <div class="modal-header">
        <h5 class="modal-title">Pratinjau Dokumen Lampiran Surat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center py-4 bg-body-tertiary">
        <div class="p-3 bg-body border rounded text-start mb-3 mx-auto" style="max-width: 600px;">
          <div class="small text-secondary mb-1">Nama Dokumen:</div>
          <div class="font-monospace fw-semibold mb-2"><?= esc($surat['file_lampiran']) ?></div>
          <div class="small text-secondary">
            Asal Surat: <strong class="text-body"><?= esc($surat['pengirim']) ?></strong> &bull; Nomor: <span class="font-monospace text-body"><?= esc($surat['nomor_surat']) ?></span>
          </div>
        </div>

        <div class="p-4 border rounded bg-white shadow-sm mx-auto text-start" style="max-width: 600px; min-height: 280px; font-family: 'Times New Roman', serif;">
          <div class="text-center border-bottom pb-2 mb-3">
            <h6 class="fw-bold mb-0 text-uppercase"><?= esc($surat['pengirim']) ?></h6>
            <small class="text-secondary">Jl. Raya Pendidikan No. 45, Bandung Barat &bull; Telp. (022) 6868123</small>
          </div>
          <div class="row g-2 small mb-3">
            <div class="col-8">
              <div>Nomor : <?= esc($surat['nomor_surat']) ?></div>
              <div>Perihal : <strong><?= esc($surat['perihal']) ?></strong></div>
            </div>
            <div class="col-4 text-end">
              <div><?= date('d F Y', strtotime($surat['tanggal_surat'])) ?></div>
            </div>
          </div>
          <p class="small text-secondary mb-3">
            Kepada Yth.<br>
            Kepala SMA IT Fithrah Insani<br>
            di Tempat
          </p>
          <p class="small text-secondary mb-2" style="text-align: justify; line-height: 1.6;">
            Sehubungan dengan pelaksanaan program peningkatan mutu pembelajaran semester berjalan, kami mengundang perwakilan tenaga pendidik untuk berpartisipasi aktif dalam kegiatan koordinasi teknis yang akan diselenggarakan sesuai jadwal terlampir.
          </p>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.print()">
          Cetak Lembar Dokumen
        </button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Static Modal Backdrop for Figma Export -->
<div class="modal-backdrop show"></div>
<style>body { overflow: hidden; }</style>

<?= $this->endSection() ?>
