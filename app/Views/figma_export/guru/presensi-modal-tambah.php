<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Flash Message Success / Error -->
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
    <div><?= session()->getFlashdata('success') ?></div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<!-- Header & Filter Mapel Switcher -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start gap-3 mb-3">
  <div>
    <div class="d-flex align-items-center gap-2 mb-1">
      <span class="badge bg-secondary-subtle text-secondary border"><?= esc($pengajaran['kelas_nama']) ?></span>
      <span class="badge bg-secondary-subtle text-secondary border">Semester Ganjil 2025/2026</span>
    </div>
    <h4 class="fw-bold text-body mb-1">Presensi Harian &amp; Jurnal KBM</h4>
    <p class="text-secondary small mb-0">
      Mata Pelajaran: <strong><?= esc($pengajaran['mapel_nama']) ?></strong> &bull; Pengampu: <strong><?= esc($namaGuru) ?></strong>
    </p>
  </div>

  <div class="d-flex flex-wrap gap-2 align-items-center">
    <!-- Dropdown Switch Kelas/Mapel Pengajaran -->
    <div class="dropdown">
      <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Ganti Kelas Mapel
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow-sm">
        <li class="dropdown-header text-uppercase fs-8">Mata Pelajaran Saya</li>
        <?php foreach ($pengajaranList as $p): ?>
          <li>
            <a class="dropdown-item d-flex justify-content-between align-items-center <?= $p['id'] == $pengajaran['id'] ? 'active' : '' ?>" href="<?= base_url('guru/presensi/' . $p['id']) ?>">
              <span><?= esc($p['mapel_nama']) ?> (<?= esc($p['kelas_nama']) ?>)</span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <a href="<?= base_url('guru/presensi/' . $pengajaran['id'] . '/cetak') ?>" target="_blank" class="btn btn-outline-secondary btn-sm">
      Cetak Jurnal &amp; Rekap
    </a>

    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPertemuan">
      Tambah Pertemuan
    </button>
  </div>
</div>

<!-- Unified KPI Summary Bar -->
<div class="card border mb-3">
  <div class="card-body p-3">
    <div class="row g-3 text-center text-md-start">
      
      <div class="col-6 col-md-3 border-end-md">
        <div class="text-secondary small">Pertemuan Terlaksana</div>
        <div class="d-flex align-items-baseline gap-1 mt-1 justify-content-center justify-content-md-start">
          <span class="fs-5 fw-bold text-body"><?= $rekapData['pertemuanSelesaiCount'] ?></span>
          <span class="text-secondary small">/ <?= $rekapData['targetPertemuan'] ?> target</span>
        </div>
      </div>

      <div class="col-6 col-md-3 border-end-md">
        <div class="text-secondary small">Rata-Rata Kehadiran</div>
        <div class="d-flex align-items-baseline gap-2 mt-1 justify-content-center justify-content-md-start">
          <span class="fs-5 fw-bold text-body"><?= $rekapData['rataRataKelas'] ?>%</span>
          <span class="badge bg-success-subtle text-success border border-success-subtle fw-normal">Normal</span>
        </div>
      </div>

      <div class="col-6 col-md-3 border-end-md">
        <div class="text-secondary small">Kehadiran Kritis (&lt; 85%)</div>
        <div class="d-flex align-items-baseline gap-2 mt-1 justify-content-center justify-content-md-start">
          <span class="fs-5 fw-bold <?= empty($siswaKritis) ? 'text-body' : 'text-danger' ?>">
            <?= count($siswaKritis) ?> Siswa
          </span>
          <?php if (!empty($siswaKritis)): ?>
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-normal">Perhatian</span>
          <?php endif; ?>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="text-secondary small">Dokumentasi Jurnal</div>
        <div class="d-flex align-items-baseline gap-2 mt-1 justify-content-center justify-content-md-start">
          <span class="fs-5 fw-bold text-body">100%</span>
          <span class="badge bg-secondary-subtle text-secondary border fw-normal">Lengkap</span>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Alert Peringatan Siswa Kehadiran Kritis jika ada -->
<?php if (!empty($siswaKritis)): ?>
  <div class="card border-warning-subtle bg-warning-subtle bg-opacity-25 mb-3">
    <div class="card-body p-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
      <div>
        <div class="fw-semibold text-body mb-1">Peringatan Kehadiran Siswa di Bawah Ambang Batas 85%</div>
        <div class="small text-secondary">
          Siswa berikut berisiko tidak memenuhi syarat kelayakan mengikuti UAS jika ketidakhadiran berlanjut:
          <?php foreach ($siswaKritis as $idx => $sk): ?>
            <strong class="text-body"><?= esc($sk['nama']) ?></strong> (Kehadiran <?= $sk['persentase'] ?>% &bull; Alpa: <?= $sk['total_alpa'] ?>, Izin: <?= $sk['total_izin'] ?>)<?= ($idx < count($siswaKritis)-1) ? ', ' : '.' ?>
          <?php endforeach; ?>
        </div>
      </div>
      <div>
        <a href="<?= base_url('guru/presensi/' . $pengajaran['id'] . '/tab/rekap') ?>" class="btn btn-outline-secondary btn-sm text-nowrap">
          Buka Matriks Rekap
        </a>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- Nav Tabs Pertemuan vs Rekap -->
<div class="card border">
  <div class="card-header bg-body border-bottom p-3">
    <ul class="nav nav-tabs card-header-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link fw-medium <?= $activeTab === 'pertemuan' ? 'active' : '' ?>" href="<?= base_url('guru/presensi/' . $pengajaran['id'] . '/tab/pertemuan') ?>">
          Daftar Pertemuan &amp; Jurnal KBM
          <span class="badge bg-secondary-subtle text-secondary border ms-1"><?= count($pertemuanList) ?></span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link fw-medium <?= $activeTab === 'rekap' ? 'active' : '' ?>" href="<?= base_url('guru/presensi/' . $pengajaran['id'] . '/tab/rekap') ?>">
          Matriks Rekapitulasi Presensi
        </a>
      </li>
    </ul>
  </div>

  <div class="card-body p-0">
    <?php if ($activeTab === 'pertemuan'): ?>
      <!-- Tab 1: Daftar Pertemuan -->
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 80px;" class="text-center">Pertemuan</th>
              <th style="width: 170px;">Tanggal &amp; Waktu</th>
              <th style="min-width: 220px;">Materi Pokok &amp; Metode</th>
              <th style="width: 200px;">Kehadiran</th>
              <th>Refleksi / Jurnal KBM</th>
              <th class="text-end pe-3" style="width: 120px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pertemuanList as $pt): ?>
              <tr>
                <td class="text-center">
                  <span class="badge bg-secondary-subtle text-secondary border">
                    P-<?= esc($pt['pertemuan_ke']) ?>
                  </span>
                </td>
                <td>
                  <div class="fw-semibold text-body">
                    <?= date('d M Y', strtotime($pt['tanggal'])) ?>
                  </div>
                  <div class="text-secondary small">
                    <?= esc($pt['jam_ke']) ?>
                  </div>
                </td>
                <td>
                  <div class="fw-semibold text-body mb-1">
                    <?= esc($pt['materi_pokok']) ?>
                  </div>
                  <span class="badge bg-secondary-subtle text-secondary border fw-normal">
                    <?= esc($pt['metode']) ?>
                  </span>
                </td>
                <td>
                  <?php if ($pt['status'] === 'selesai'): ?>
                    <div class="small d-flex flex-wrap gap-2 text-secondary">
                      <span>H: <strong class="text-success"><?= $pt['rekap']['hadir'] ?></strong></span>
                      <?php if ($pt['rekap']['sakit'] > 0): ?>
                        <span>S: <strong class="text-warning"><?= $pt['rekap']['sakit'] ?></strong></span>
                      <?php endif; ?>
                      <?php if ($pt['rekap']['izin'] > 0): ?>
                        <span>I: <strong class="text-info"><?= $pt['rekap']['izin'] ?></strong></span>
                      <?php endif; ?>
                      <?php if ($pt['rekap']['alpa'] > 0): ?>
                        <span>A: <strong class="text-danger"><?= $pt['rekap']['alpa'] ?></strong></span>
                      <?php endif; ?>
                      <?php if ($pt['rekap']['dispensasi'] > 0): ?>
                        <span>D: <strong class="text-secondary"><?= $pt['rekap']['dispensasi'] ?></strong></span>
                      <?php endif; ?>
                    </div>
                    <small class="text-secondary d-block mt-1">
                      Total: <?= $pt['rekap']['total'] ?> siswa
                    </small>
                  <?php else: ?>
                    <span class="badge bg-secondary-subtle text-secondary border fw-normal">
                      Belum Diisi
                    </span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (!empty($pt['catatan_jurnal'])): ?>
                    <p class="text-secondary small mb-0 fst-italic" style="max-width: 320px;">
                      "<?= esc($pt['catatan_jurnal']) ?>"
                    </p>
                  <?php else: ?>
                    <span class="text-secondary small fst-italic">Belum ada catatan refleksi</span>
                  <?php endif; ?>
                </td>
                <td class="text-end pe-3">
                  <?php if ($pt['status'] === 'selesai'): ?>
                    <a href="<?= base_url('guru/presensi/' . $pengajaran['id'] . '/input/' . $pt['id']) ?>" class="btn btn-outline-secondary btn-sm">
                      Edit
                    </a>
                  <?php else: ?>
                    <a href="<?= base_url('guru/presensi/' . $pengajaran['id'] . '/input/' . $pt['id']) ?>" class="btn btn-primary btn-sm">
                      Isi Presensi
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    <?php else: ?>
      <!-- Tab 2: Matriks Rekapitulasi -->
      <div class="p-3 bg-body-tertiary border-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
        <div>
          <h6 class="fw-bold mb-1">Matriks Kehadiran Siswa Semester Ganjil TA 2025/2026</h6>
          <p class="text-secondary small mb-0">
            Keterangan: <span class="fw-bold text-success me-2">H = Hadir</span>
            <span class="fw-bold text-warning me-2">S = Sakit</span>
            <span class="fw-bold text-info me-2">I = Izin</span>
            <span class="fw-bold text-danger me-2">A = Alpa</span>
            <span class="fw-bold text-secondary me-2">D = Dispensasi</span>
            <span class="text-secondary ms-2">&bull; Syarat kelayakan UAS minimal 85% kehadiran</span>
          </p>
        </div>
        <div>
          <a href="<?= base_url('guru/presensi/' . $pengajaran['id'] . '/cetak') ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
            Cetak Rekapitulasi
          </a>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0 text-center">
          <thead class="table-light align-middle">
            <tr>
              <th rowspan="2" class="text-start ps-3" style="min-width: 200px;">Nama Siswa</th>
              <th rowspan="2" style="width: 100px;">NIS</th>
              <th colspan="<?= count($pertemuanList) ?>" class="bg-body-secondary">Pertemuan Tatap Muka</th>
              <th colspan="5" class="bg-light">Rekapitulasi</th>
              <th rowspan="2" style="width: 100px;">Persen</th>
              <th rowspan="2" style="width: 110px;">Status</th>
            </tr>
            <tr>
              <?php foreach ($pertemuanList as $pt): ?>
                <th style="width: 40px;" class="fw-semibold" title="<?= esc($pt['materi_pokok']) ?>">
                  P<?= esc($pt['pertemuan_ke']) ?>
                </th>
              <?php endforeach; ?>
              <th style="width: 36px;" class="text-success fw-bold">H</th>
              <th style="width: 36px;" class="text-warning fw-bold">S</th>
              <th style="width: 36px;" class="text-info fw-bold">I</th>
              <th style="width: 36px;" class="text-danger fw-bold">A</th>
              <th style="width: 36px;" class="text-secondary fw-bold">D</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rekapData['rekap'] as $r): ?>
              <tr>
                <td class="text-start ps-3">
                  <div class="d-flex align-items-center gap-2">
                    <img src="<?= esc($r['foto_path']) ?>" alt="Foto" class="rounded-circle border" width="26" height="26">
                    <span class="fw-medium text-body"><?= esc($r['nama']) ?></span>
                  </div>
                </td>
                <td class="text-secondary small font-monospace"><?= esc($r['nis']) ?></td>

                <!-- Kolom Pertemuan -->
                <?php foreach ($pertemuanList as $pt): ?>
                  <?php 
                    $stData = $r['kehadiran'][$pt['id']] ?? ['status' => '-', 'catatan' => ''];
                    $st = $stData['status'];
                  ?>
                  <td>
                    <?php if ($st === 'H'): ?>
                      <span class="text-success fw-bold">H</span>
                    <?php elseif ($st === 'S'): ?>
                      <span class="text-warning fw-bold" title="Sakit: <?= esc($stData['catatan']) ?>">S</span>
                    <?php elseif ($st === 'I'): ?>
                      <span class="text-info fw-bold" title="Izin: <?= esc($stData['catatan']) ?>">I</span>
                    <?php elseif ($st === 'A'): ?>
                      <span class="text-danger fw-bold" title="Alpa: <?= esc($stData['catatan']) ?>">A</span>
                    <?php elseif ($st === 'D'): ?>
                      <span class="text-secondary fw-bold" title="Dispensasi: <?= esc($stData['catatan']) ?>">D</span>
                    <?php else: ?>
                      <span class="text-secondary">-</span>
                    <?php endif; ?>
                  </td>
                <?php endforeach; ?>

                <!-- Rekap Count -->
                <td class="fw-semibold text-success"><?= $r['total_hadir'] ?></td>
                <td class="fw-semibold text-warning"><?= $r['total_sakit'] ?></td>
                <td class="fw-semibold text-info"><?= $r['total_izin'] ?></td>
                <td class="fw-semibold text-danger"><?= $r['total_alpa'] ?></td>
                <td class="fw-semibold text-secondary"><?= $r['total_dispensasi'] ?></td>

                <!-- Persentase Kehadiran -->
                <td>
                  <span class="fw-semibold <?= $r['is_tuntas'] ? 'text-body' : 'text-danger' ?>">
                    <?= $r['persentase'] ?>%
                  </span>
                </td>

                <!-- Status Tuntas / Peringatan -->
                <td>
                  <?php if ($r['is_tuntas']): ?>
                    <span class="badge bg-success-subtle text-success border border-success-subtle fw-normal">
                      Tuntas
                    </span>
                  <?php else: ?>
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-normal" title="Kehadiran di bawah 85%">
                      Peringatan
                    </span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Modal Tambah Pertemuan Baru (Open State) -->
<div class="modal show" id="modalTambahPertemuan" tabindex="-1" style="display: block;" aria-labelledby="modalTambahPertemuanLabel" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('guru/presensi/' . $pengajaran['id'] . '/tambah-pertemuan') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="modal-header">
          <h5 class="modal-title fw-semibold" id="modalTambahPertemuanLabel">
            Tambah Pertemuan KBM Baru
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-info py-2 px-3 small mb-3">
            Sistem akan otomatis menentukan nomor pertemuan berikutnya untuk kelas ini.
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Tanggal Pertemuan <span class="text-danger">*</span></label>
              <input type="date" name="tanggal" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Jam Pelajaran <span class="text-danger">*</span></label>
              <input type="text" name="jam_ke" class="form-control form-control-sm" value="Jam ke 1-2 (07:15 - 08:45)" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Materi Pokok / Capaian Pembelajaran <span class="text-danger">*</span></label>
            <input type="text" name="materi_pokok" class="form-control form-control-sm" placeholder="Contoh: Operasi Perkalian Skalar pada Matriks" required>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Metode / Model Pembelajaran</label>
            <input type="text" name="metode" class="form-control form-control-sm" value="Diskusi & Praktik Latihan Mandiri" placeholder="Metode yang digunakan">
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Catatan / Rencana Pembelajaran Awal</label>
            <textarea name="catatan_jurnal" class="form-control form-control-sm" rows="2" placeholder="Catatan awal guru (opsional)"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-3">
            Buat Pertemuan &amp; Isi Presensi
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
