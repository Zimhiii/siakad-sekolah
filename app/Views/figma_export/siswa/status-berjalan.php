<?php $variant = 'berjalan'; ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
  <div>
    <h4 class="fw-bold mb-1">Status Akademik Peserta Didik</h4>
    <p class="text-secondary small mb-0">Informasi status keaktifan semester berjalan dan pengumuman evaluasi akhir tahun ajaran.</p>
  </div>
  <div class="btn-group btn-group-sm">
    <a href="<?= base_url('siswa/status/berjalan') ?>" class="btn px-3 py-2 <?= ($variant === 'berjalan') ? 'btn-primary fw-medium' : 'btn-outline-secondary' ?>">
      Semester Ganjil (Aktif)
    </a>
    <a href="<?= base_url('siswa/status/kenaikan') ?>" class="btn px-3 py-2 <?= ($variant === 'kenaikan') ? 'btn-primary fw-medium' : 'btn-outline-secondary' ?>">
      Kenaikan Kelas (Genap)
    </a>
    <a href="<?= base_url('siswa/status/kelulusan') ?>" class="btn px-3 py-2 <?= ($variant === 'kelulusan') ? 'btn-primary fw-medium' : 'btn-outline-secondary' ?>">
      Kelulusan Siswa (Kelas XII)
    </a>
  </div>
</div>

<?php if ($variant === 'berjalan'): ?>
  <!-- KONDISI 1: STATUS AKADEMIK SEMESTER BERJALAN -->
  <div class="row g-4 align-items-stretch">
    <!-- Kolom Kiri: Kartu Profil & Status Keaktifan -->
    <div class="col-lg-4">
      <div class="card border h-100">
        <div class="card-body p-4 d-flex flex-column justify-content-between">
          <div>
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-3 py-1.5 fw-semibold">
                Aktif Belajar
              </span>
              <span class="text-secondary small fw-medium">T.A. <?= esc($statusBerjalan['tahun_ajaran']) ?></span>
            </div>

            <h4 class="fw-bold text-body mb-1"><?= esc($statusBerjalan['status']) ?></h4>
            <p class="text-secondary small mb-4"><?= esc($statusBerjalan['semester']) ?></p>

            <div class="bg-body-tertiary rounded p-3 mb-4 border">
              <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <span class="text-secondary small">Rombongan Belajar</span>
                <span class="fw-bold text-primary small"><?= esc($statusBerjalan['rombel']) ?></span>
              </div>
              <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <span class="text-secondary small">Tingkatan</span>
                <span class="fw-semibold text-body small"><?= esc($statusBerjalan['tingkatan']) ?></span>
              </div>
              <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <span class="text-secondary small">Wali Kelas</span>
                <span class="fw-semibold text-body small text-end"><?= esc($statusBerjalan['wali_kelas']) ?></span>
              </div>
              <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <span class="text-secondary small">Beban Mapel</span>
                <span class="fw-semibold text-body small"><?= esc($statusBerjalan['total_mapel']) ?> Mata Pelajaran</span>
              </div>
              <div class="pt-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="text-secondary small">Kehadiran Efektif</span>
                  <span class="fw-bold text-success small font-monospace"><?= esc($statusBerjalan['kehadiran_persen']) ?>%</span>
                </div>
                <div class="progress mb-1" style="height: 6px;">
                  <div class="progress-bar bg-success" role="progressbar" style="width: <?= esc($statusBerjalan['kehadiran_persen']) ?>%" aria-valuenow="<?= esc($statusBerjalan['kehadiran_persen']) ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="text-secondary small mt-1">Batas minimal kehadiran: 85%</div>
              </div>
            </div>
          </div>

          <div class="d-grid gap-2 pt-3 border-top">
            <a href="<?= base_url('siswa/raport') ?>" class="btn btn-primary py-2 fw-medium">
              Buka Raport Semester Ini
            </a>
            <a href="<?= base_url('siswa/nilai') ?>" class="btn btn-outline-secondary py-2 fw-medium">
              Pantau Nilai Akademik
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Kolom Kanan: Detail Informasi & Riwayat -->
    <div class="col-lg-8 d-flex flex-column gap-4">
      <!-- Informasi Akademik Semester Berjalan -->
      <div class="card border">
        <div class="card-header bg-body px-4 py-3 border-bottom">
          <h6 class="fw-semibold mb-0 text-body">
            Informasi Akademik Semester Berjalan
          </h6>
        </div>
        <div class="card-body p-4">
          <p class="text-secondary mb-4 lh-base">
            <?= esc($statusBerjalan['keterangan']) ?>
          </p>

          <div class="row g-3">
            <div class="col-md-6">
              <div class="p-3 border rounded bg-body-tertiary h-100">
                <span class="text-secondary small d-block mb-1 fw-medium">
                  Jadwal Evaluasi Kenaikan Kelas
                </span>
                <div class="fw-bold text-body fs-6"><?= esc($statusBerjalan['jadwal_kenaikan']) ?></div>
                <small class="text-secondary mt-1 d-block">Diumumkan setelah seluruh penilaian semester lengkap.</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 border rounded bg-body-tertiary h-100">
                <span class="text-secondary small d-block mb-1 fw-medium">
                  Catatan Kedisiplinan &amp; Perilaku
                </span>
                <div class="fw-bold text-success fs-6"><?= esc($statusBerjalan['catatan_disiplin']) ?></div>
                <small class="text-secondary mt-1 d-block">Memenuhi standar ketertiban sekolah.</small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Riwayat Penetapan Sebelumnya -->
      <div class="card border">
        <div class="card-header bg-body px-4 py-3 border-bottom">
          <h6 class="fw-semibold mb-0 text-body">
            Riwayat Status Semester Sebelumnya
          </h6>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table align-middle mb-0 small">
              <thead class="table-light border-bottom">
                <tr class="text-secondary">
                  <th class="px-4 py-3" style="width: 28%;">Periode</th>
                  <th class="px-3 py-3" style="width: 46%;">Keterangan Penetapan</th>
                  <th class="px-4 py-3 text-end" style="width: 26%;">Keputusan</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="px-4 py-3">
                    <div class="fw-bold text-body"><?= esc($statusBerjalan['status_lalu']['periode']) ?></div>
                  </td>
                  <td class="px-3 py-3">
                    <div class="text-body fw-medium"><?= esc($statusBerjalan['status_lalu']['keterangan']) ?></div>
                  </td>
                  <td class="px-4 py-3 text-end">
                    <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-3 py-1.5 fw-semibold">
                      <?= esc($statusBerjalan['status_lalu']['keputusan']) ?>
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php elseif ($variant === 'kenaikan'): ?>
  <!-- KONDISI 2: HASIL KENAIKAN KELAS -->
  <div class="row g-4 align-items-stretch">
    <!-- Kolom Kiri: Keputusan Kenaikan -->
    <div class="col-lg-4">
      <div class="card border h-100">
        <div class="card-body p-4 d-flex flex-column justify-content-between">
          <div>
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-3 py-1.5 fw-semibold">
                Status Ditetapkan
              </span>
              <span class="text-secondary small fw-medium">T.A. <?= esc($statusKenaikan['tahun_ajaran']) ?></span>
            </div>

            <h4 class="fw-bold text-success mb-1"><?= esc($statusKenaikan['status']) ?></h4>
            <p class="text-secondary small mb-4">Ditetapkan pada: <?= esc($statusKenaikan['tanggal_keputusan']) ?></p>

            <div class="bg-body-tertiary rounded p-3 mb-4 border">
              <span class="text-secondary small d-block mb-1">Rombel Penempatan Baru:</span>
              <div class="fs-4 fw-bold text-primary mb-2">Kelas <?= esc($statusKenaikan['kelas_tujuan']) ?></div>
              <div class="border-top pt-2 mt-2">
                <span class="text-secondary small d-block mb-1 fw-medium">Catatan Wali Kelas:</span>
                <p class="text-body small mb-0 fst-italic lh-base">"<?= esc($statusKenaikan['catatan']) ?>"</p>
              </div>
            </div>
          </div>

          <div class="d-grid gap-2 pt-3 border-top">
            <a href="<?= base_url('siswa/raport') ?>" class="btn btn-primary py-2 fw-medium">
              Buka Lembar Raport Terkait
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Kolom Kanan: Evaluasi Syarat Kenaikan -->
    <div class="col-lg-8">
      <div class="card border h-100">
        <div class="card-header bg-body px-4 py-3 border-bottom">
          <h6 class="fw-semibold mb-0 text-body">
            Evaluasi Kriteria Kenaikan Tingkat
          </h6>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
              <thead class="table-light border-bottom">
                <tr class="text-secondary">
                  <th class="px-4 py-3" style="width: 35%;">Kriteria Evaluasi</th>
                  <th class="px-3 py-3" style="width: 45%;">Keterangan / Capaian</th>
                  <th class="px-4 py-3 text-end" style="width: 20%;">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($statusKenaikan['syarat'] as $s): ?>
                  <tr>
                    <td class="px-4 py-3 fw-medium text-body"><?= esc($s['kriteria']) ?></td>
                    <td class="px-3 py-3 text-secondary"><?= esc($s['keterangan']) ?></td>
                    <td class="px-4 py-3 text-end">
                      <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-3 py-1.5 fw-semibold">
                        <?= esc($s['status']) ?>
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer bg-body px-4 py-3 text-secondary small border-top">
          Seluruh kriteria kenaikan kelas telah diverifikasi dan memenuhi standar kurikulum satuan pendidikan.
        </div>
      </div>
    </div>
  </div>

<?php else: ?>
  <!-- KONDISI 3: HASIL KELULUSAN AKHIR -->
  <div class="row g-4 align-items-stretch">
    <!-- Kolom Kiri: Keputusan Kelulusan & Aksi -->
    <div class="col-lg-4">
      <div class="card border h-100">
        <div class="card-body p-4 d-flex flex-column justify-content-between">
          <div>
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1.5 fw-semibold">
                Jenjang SMA Tuntas
              </span>
              <span class="text-secondary small fw-medium">T.A. <?= esc($statusKelulusan['tahun_ajaran']) ?></span>
            </div>

            <h4 class="fw-bold text-primary mb-1">Dinyatakan <?= esc($statusKelulusan['status']) ?></h4>
            <p class="text-secondary small mb-4">Ditetapkan pada: <?= esc($statusKelulusan['tanggal_keputusan']) ?></p>

            <div class="bg-body-tertiary rounded p-3 mb-4 border">
              <span class="text-secondary small d-block mb-1">Nomor Seri Ijazah Resmi:</span>
              <span class="font-monospace fw-bold text-primary fs-6 d-block mb-2"><?= esc($statusKelulusan['nomor_ijazah']) ?></span>
              <p class="text-secondary small mb-0 lh-base border-top pt-2">
                <?= esc($statusKelulusan['keterangan']) ?>
              </p>
            </div>
          </div>

          <div class="d-grid gap-2 pt-3 border-top">
            <a href="<?= base_url('siswa/transkrip') ?>" class="btn btn-primary py-2 fw-medium">
              Buka Transkrip Nilai (6 Semester)
            </a>
            <button class="btn btn-outline-secondary py-2 fw-medium" data-bs-toggle="modal" data-bs-target="#modalUnduhSKL">
              Cetak Dokumen SKL
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Kolom Kanan: Rekapitulasi Nilai & Evaluasi Syarat -->
    <div class="col-lg-8 d-flex flex-column gap-4">
      <!-- Rincian Formula Nilai Akhir -->
      <div class="card border">
        <div class="card-header bg-body px-4 py-3 border-bottom">
          <h6 class="fw-semibold mb-0 text-body">
            Formula Rekapitulasi Nilai Sekolah
          </h6>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table align-middle mb-0 small">
              <thead class="table-light border-bottom">
                <tr class="text-secondary">
                  <th class="px-4 py-3" style="width: 50%;">Komponen Penilaian</th>
                  <th class="px-3 py-3 text-center" style="width: 25%;">Bobot</th>
                  <th class="px-4 py-3 text-end" style="width: 25%;">Rata-rata</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="px-4 py-3 text-body">Rata-rata Rapor (Semester 1 s.d. 6)</td>
                  <td class="px-3 py-3 text-center text-secondary font-monospace"><?= $statusKelulusan['bobot_rapor'] ?? 60 ?>%</td>
                  <td class="px-4 py-3 text-end font-monospace fw-semibold text-body"><?= number_format($statusKelulusan['rata_rapor'] ?? 90.5, 1) ?></td>
                </tr>
                <tr>
                  <td class="px-4 py-3 text-body">Ujian Sekolah (US - Teori &amp; Praktik)</td>
                  <td class="px-3 py-3 text-center text-secondary font-monospace"><?= $statusKelulusan['bobot_us'] ?? 40 ?>%</td>
                  <td class="px-4 py-3 text-end font-monospace fw-semibold text-body"><?= number_format($statusKelulusan['rata_us'] ?? 93.7, 1) ?></td>
                </tr>
                <tr class="table-light border-top">
                  <td colspan="2" class="px-4 py-3 fw-bold text-body">Nilai Akhir Kelulusan (Sekolah):</td>
                  <td class="px-4 py-3 text-end fw-bold text-success font-monospace fs-5"><?= number_format($statusKelulusan['rata_rata_akhir'] ?? 91.8, 1) ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Kriteria Kelulusan -->
      <div class="card border">
        <div class="card-header bg-body px-4 py-3 border-bottom">
          <h6 class="fw-semibold mb-0 text-body">
            Pemenuhan Kriteria Kelulusan
          </h6>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
              <thead class="table-light border-bottom">
                <tr class="text-secondary">
                  <th class="px-4 py-3" style="width: 40%;">Kriteria Penilaian</th>
                  <th class="px-3 py-3" style="width: 40%;">Keterangan</th>
                  <th class="px-4 py-3 text-end" style="width: 20%;">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($statusKelulusan['syarat'] as $s): ?>
                  <tr>
                    <td class="px-4 py-3 fw-medium text-body"><?= esc($s['kriteria']) ?></td>
                    <td class="px-3 py-3 text-secondary"><?= esc($s['keterangan']) ?></td>
                    <td class="px-4 py-3 text-end">
                      <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-3 py-1.5 fw-semibold">
                        <?= esc($s['status']) ?>
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- Modal Unduh / Cetak SKL -->
<div class="modal fade" id="modalUnduhSKL" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-sm">
      <div class="modal-header px-4 py-3">
        <h6 class="modal-title fw-bold">Surat Keterangan Lulus (SKL)</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="p-3 bg-body-tertiary rounded border mb-3 text-center">
          <span class="fw-semibold text-body d-block">Dokumen Resmi SKL</span>
          <span class="small font-monospace text-secondary">Nomor: <?= esc($statusKelulusan['nomor_ijazah'] ?? 'DN-02/M-SMA/26/001234') ?></span>
        </div>
        <p class="small text-secondary mb-0 lh-base">
          Surat Keterangan Lulus (SKL) resmi memuat rangkuman nilai kumulatif 6 semester dan nilai akhir kelulusan yang telah disahkan oleh Kepala Sekolah untuk keperluan pendaftaran perguruan tinggi atau kedinasan.
        </p>
      </div>
      <div class="modal-footer px-4 py-3 justify-content-end gap-2">
        <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary btn-sm px-3" onclick="window.print()">
          Cetak Dokumen
        </button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
