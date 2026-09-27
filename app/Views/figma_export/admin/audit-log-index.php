<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">Pusat Log Audit &amp; Jejak Rekam Sistem</h4>
    <p class="text-secondary small mb-0">Dokumentasi audit trail otomatis perubahan data nilai pasca buka kunci dan riwayat transaksi sistem</p>
  </div>
  <div>
    <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
      Cetak Dokumen Audit
    </button>
  </div>
</div>

<!-- Nav Tabs -->
<ul class="nav nav-tabs mb-3" id="auditTabs" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active fw-semibold" id="tab-nilai-btn" data-bs-toggle="tab" data-bs-target="#tab-nilai" type="button" role="tab">
      1. Audit Trail Revisi Nilai
      <span class="badge bg-secondary-subtle text-secondary border ms-1"><?= count($auditNilai ?? []) ?></span>
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link fw-semibold" id="tab-sistem-btn" data-bs-toggle="tab" data-bs-target="#tab-sistem" type="button" role="tab">
      2. Aktivitas Tata Kelola Sistem
      <span class="badge bg-secondary-subtle text-secondary border ms-1"><?= count($sistemLogs ?? []) ?></span>
    </button>
  </li>
</ul>

<div class="tab-content" id="auditTabsContent">
  
  <!-- Tab 1: Audit Nilai -->
  <div class="tab-pane fade show active" id="tab-nilai" role="tabpanel">
    <div class="card border mb-4">
      <div class="card-header bg-body py-2 px-3 d-flex justify-content-between align-items-center">
        <div>
          <h6 class="mb-0 fw-semibold text-body">
            Histori Perubahan Nilai Pasca Buka Kunci Raport
          </h6>
          <span class="text-secondary small">Tercatat secara otomatis setiap kali guru mengubah nilai yang telah dibuka kuncinya</span>
        </div>
        <span class="text-secondary small">Audit Trail Aktif</span>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width: 40px;">No</th>
                <th>Siswa / NIS</th>
                <th>Kelas &amp; Mapel</th>
                <th>Komponen</th>
                <th class="text-center">Nilai Semula</th>
                <th class="text-center">Nilai Revisi</th>
                <th>Diubah Oleh</th>
                <th>Alasan Perubahan</th>
                <th>Otorisasi</th>
                <th>Waktu</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($auditNilai)): ?>
                <?php $no = 1; foreach ($auditNilai as $l): ?>
                  <tr>
                    <td class="text-center font-monospace text-secondary small"><?= $no++ ?></td>
                    <td>
                      <div class="fw-semibold text-body small"><?= esc($l['siswa_nama']) ?></div>
                      <span class="text-secondary font-monospace small">NIS: <?= esc($l['siswa_nis']) ?></span>
                    </td>
                    <td>
                      <span class="badge bg-secondary-subtle text-secondary border mb-1"><?= esc($l['kelas']) ?></span>
                      <div class="small fw-medium text-body"><?= esc($l['mapel']) ?></div>
                    </td>
                    <td><span class="small text-secondary"><?= esc($l['komponen']) ?></span></td>
                    <td class="text-center font-monospace small text-secondary">
                      <?= number_format($l['nilai_sebelum'], 1) ?>
                    </td>
                    <td class="text-center font-monospace small fw-bold text-success">
                      <?= number_format($l['nilai_sesudah'], 1) ?>
                    </td>
                    <td>
                      <div class="fw-medium small text-body"><?= esc($l['diubah_oleh']) ?></div>
                    </td>
                    <td style="max-width: 260px;">
                      <span class="text-secondary small">"<?= esc($l['alasan']) ?>"</span>
                    </td>
                    <td>
                      <span class="text-success small fw-medium">
                        <?= esc($l['disetujui_oleh'] ?? 'Kepala Sekolah') ?>
                      </span>
                    </td>
                    <td>
                      <span class="font-monospace text-secondary small"><?= esc($l['waktu_perubahan']) ?></span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="10" class="text-center text-secondary small py-4">Belum ada catatan revisi nilai.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Tab 2: Log Sistem -->
  <div class="tab-pane fade" id="tab-sistem" role="tabpanel">
    <div class="card border mb-4">
      <div class="card-header bg-body py-2 px-3">
        <h6 class="mb-0 fw-semibold text-body">
          Log Aktivitas Transisi Tahun Ajaran, Raport, &amp; Persuratan
        </h6>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width: 40px;">No</th>
                <th>Kategori</th>
                <th>Aktivitas</th>
                <th>Pelaku / Akun</th>
                <th>Detail &amp; Dampak</th>
                <th>Status</th>
                <th>Waktu</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($sistemLogs)): ?>
                <?php $no = 1; foreach ($sistemLogs as $sl): ?>
                  <tr>
                    <td class="text-center font-monospace text-secondary small"><?= $no++ ?></td>
                    <td><span class="badge bg-secondary-subtle text-secondary border"><?= esc($sl['kategori']) ?></span></td>
                    <td class="fw-semibold small text-body"><?= esc($sl['aktivitas']) ?></td>
                    <td class="small"><?= esc($sl['pelaku']) ?></td>
                    <td class="small text-secondary"><?= esc($sl['detail']) ?></td>
                    <td><span class="text-success small fw-medium"><?= esc($sl['status']) ?></span></td>
                    <td class="font-monospace text-secondary small"><?= esc($sl['waktu']) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>

<?= $this->endSection() ?>
