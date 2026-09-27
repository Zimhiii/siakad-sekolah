<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <a href="<?= base_url('admin/tahun-ajaran') ?>" class="text-decoration-none small text-secondary">
      &larr; Kembali ke Tahun Ajaran &amp; Semester
    </a>
    <h4 class="fw-bold mb-1">Aktivasi Semester Genap <?= esc($taAktif) ?></h4>
  </div>
</div>

<div class="row justify-content-center py-2">
  <div class="col-lg-8">
    <div class="card border mb-4">
      
      <div class="card-header bg-body py-2 px-3 d-flex align-items-center justify-content-between">
        <div>
          <h6 class="mb-0 fw-semibold text-body">Konfirmasi Transisi Semester</h6>
          <span class="text-secondary small">Tahun Ajaran <?= esc($taAktif) ?></span>
        </div>
        <span class="badge bg-secondary-subtle text-secondary border">Transisi Semester</span>
      </div>

      <form action="<?= base_url('admin/aktivasi-semester-genap') ?>" method="post">
        <?= csrf_field() ?>

        <div class="card-body p-3">
          
          <div class="alert alert-light border mb-3 py-2 px-3 small" role="alert">
            <strong class="d-block text-body mb-1">Alur Transisi Semester:</strong>
            Langkah ini akan menutup <strong>Semester Ganjil</strong> dan secara resmi membuka <strong>Semester Genap</strong> pada Tahun Ajaran <?= esc($taAktif) ?> yang sama. Struktur rombel kelas akan dipertahankan, dan seluruh data penugasan guru mengajar dari semester ganjil akan disalin otomatis untuk semester genap.
          </div>

          <!-- Checklist Prasyarat Transisi -->
          <div class="card border mb-3">
            <div class="card-header bg-body py-2 px-3">
              <span class="small fw-semibold text-body">Checklist Prasyarat Transisi Semester:</span>
            </div>
            <div class="list-group list-group-flush">
              
              <!-- Item 1: Raport Ganjil Semua Kelas Final -->
              <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                <div>
                  <span class="fw-medium text-body small d-block">Raport Semester Ganjil semua kelas sudah final (<?= esc($raportGanjilFinalCount) ?>/<?= esc($totalKelas) ?> kelas)</span>
                  <a href="#" class="small text-primary text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalDetailRaportGanjil">
                    Lihat detail kelas &rarr;
                  </a>
                </div>
                <span class="text-success small fw-medium">100% Final</span>
              </div>

              <!-- Item 2: Tidak ada unlock request pending -->
              <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                <div>
                  <?php if ($unlockPendingCount === 0): ?>
                    <span class="fw-medium text-body small d-block">Tidak ada permohonan buka kunci raport yang pending</span>
                    <span class="text-secondary small">Seluruh permohonan revisi nilai telah diselesaikan</span>
                  <?php else: ?>
                    <span class="fw-medium text-body small d-block">Terdapat permohonan buka kunci raport yang pending (<?= $unlockPendingCount ?> permohonan)</span>
                    <a href="<?= base_url('admin/raport/buka-kunci') ?>" class="small text-warning text-decoration-none">
                      Buka halaman otorisasi raport &rarr;
                    </a>
                  <?php endif; ?>
                </div>
                <?php if ($unlockPendingCount === 0): ?>
                  <span class="text-success small fw-medium">Clear</span>
                <?php else: ?>
                  <span class="badge bg-warning-subtle text-dark border"><?= $unlockPendingCount ?> Menunggu</span>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- Review Pengecualian Guru & Siswa Antar-Semester -->
          <div class="card border mb-3">
            <div class="card-header bg-body py-2 px-3 d-flex justify-content-between align-items-center">
              <span class="small fw-semibold text-body">Tinjauan Pengecualian Guru &amp; Siswa Antar-Semester:</span>
              <span class="text-secondary small">2 Catatan Pengecualian</span>
            </div>
            <div class="table-responsive">
              <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Entitas / Nama</th>
                    <th>Status Perubahan</th>
                    <th>Catatan &amp; Tindakan Sistem</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($pengecualianGuru as $pg): ?>
                    <tr>
                      <td class="fw-semibold small">
                        <?= esc($pg['nama']) ?>
                        <span class="text-secondary small d-block"><?= esc($pg['mapel']) ?></span>
                      </td>
                      <td><span class="badge bg-secondary-subtle text-secondary border"><?= esc($pg['status']) ?></span></td>
                      <td class="text-secondary small"><?= esc($pg['rekomendasi']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                  <?php foreach ($pengecualianSiswa as $ps): ?>
                    <tr>
                      <td class="fw-semibold small">
                        <?= esc($ps['nama']) ?> (<?= esc($ps['nis']) ?>)
                        <span class="text-secondary small d-block">Kelas Asal: <?= esc($ps['kelas_asal']) ?></span>
                      </td>
                      <td><span class="badge bg-secondary-subtle text-secondary border"><?= esc($ps['status']) ?></span></td>
                      <td class="text-secondary small"><?= esc($ps['keterangan']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Ringkasan Dampak Sistem -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <div class="p-3 border rounded bg-light">
                <span class="text-secondary small d-block">Semester Baru yang Dibuka:</span>
                <span class="text-body fw-bold small d-block mt-1">Semester Genap <?= esc($taAktif) ?></span>
                <span class="text-secondary small">Periode: 05 Jan 2026 - 19 Jun 2026</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="p-3 border rounded bg-light">
                <span class="text-secondary small d-block">Status Penugasan Mengajar:</span>
                <span class="text-body fw-bold small d-block mt-1">Salin Otomatis</span>
                <span class="text-secondary small">24 matriks pengajaran ganjil langsung direplikasi</span>
              </div>
            </div>
          </div>

          <!-- Tombol Aksi -->
          <div class="text-center pt-2 pb-2">
            <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
              Aktifkan Semester Genap <?= esc($taAktif) ?>
            </button>
            <div class="mt-2">
              <a href="<?= base_url('admin/tahun-ajaran') ?>" class="text-secondary small text-decoration-none">
                Batalkan &amp; Kembali
              </a>
            </div>
          </div>

        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Detail Status Raport Ganjil Per Rombel -->
<div class="modal fade" id="modalDetailRaportGanjil" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border shadow-sm">
      <div class="modal-header">
        <h6 class="modal-title fw-semibold text-body">
          Detail Status Raport Semester Ganjil Seluruh Rombel
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width: 50px;">No</th>
                <th>Rombongan Belajar</th>
                <th>Wali Kelas</th>
                <th>Jumlah Siswa</th>
                <th>Status Raport</th>
                <th>Tanggal Finalisasi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($kelasList as $k): ?>
                <tr>
                  <td class="font-monospace text-secondary small"><?= $no++ ?></td>
                  <td class="fw-semibold small text-body"><?= esc($k['nama_kelas']) ?></td>
                  <td class="small"><?= esc($k['wali_kelas_nama']) ?></td>
                  <td class="small"><?= esc($k['jumlah_siswa']) ?> Siswa</td>
                  <td>
                    <span class="text-success small fw-medium">
                      Final &amp; Terkunci
                    </span>
                  </td>
                  <td class="text-secondary small">19 Des 2025</td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
