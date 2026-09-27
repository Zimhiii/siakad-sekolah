<?php $raport['status'] = 'draft'; ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Navigasi Siswa Sebelumnya & Berikutnya -->
<div class="card mb-4">
  <div class="card-body py-2 px-3">
    <div class="d-flex justify-content-between align-items-center">
      <a href="<?= base_url('guru/raport/tinjau/' . max(1, $currentSiswaId - 1)) ?>" class="btn btn-outline-secondary btn-sm">
        Siswa Sebelumnya
      </a>

      <div class="d-flex align-items-center gap-2">
        <span class="text-secondary small d-none d-md-inline">Pilih Siswa:</span>
        <select class="form-select form-select-sm" style="min-width: 260px;" onchange="location.href='<?= base_url('guru/raport/tinjau/') ?>/' + this.value">
          <?php foreach ($siswaList as $s): ?>
            <option value="<?= $s['id'] ?>" <?= ($s['id'] == $currentSiswaId) ? 'selected' : '' ?>>
              <?= esc($s['nama']) ?> (<?= esc($s['nis']) ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <a href="<?= base_url('guru/raport/tinjau/' . min(count($siswaList), $currentSiswaId + 1)) ?>" class="btn btn-outline-secondary btn-sm">
        Siswa Berikutnya
      </a>
    </div>
  </div>
</div>

<?php if (!empty($catatanPenolakan) && ($raport['status'] ?? 'draft') === 'draft'): ?>
  <div class="alert alert-danger border-danger d-flex align-items-start gap-2 mb-4" role="alert">
    <div>
      <h6 class="alert-heading fw-bold mb-1 text-danger">Raport Dikembalikan oleh Kepala Sekolah untuk Revisi:</h6>
      <p class="mb-1 text-body small">"<?= esc($catatanPenolakan) ?>"</p>
      <small class="text-secondary d-block">Silakan perbaiki data nilai atau narasi capaian, kemudian kunci dan ajukan kembali.</small>
    </div>
  </div>
<?php endif; ?>

<form action="<?= base_url('guru/save-action') ?>" method="post">
  <?= csrf_field() ?>
  <input type="hidden" name="action" value="Raport Siswa <?= esc($raport['siswa']['nama']) ?>">
  <input type="hidden" name="redirect_url" value="/guru/raport/tinjau/<?= $currentSiswaId ?>">

  <!-- Paper Card Wrapper -->
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card card-paper mb-5">
        
        <!-- Header Dokumen Raport ala Kertas -->
        <div class="card-body p-4 p-md-5">
          
          <div style="text-align:center; border-bottom: 2px solid #000; padding-bottom: 12px; margin-bottom: 16px;">
            <p style="margin:0; font-size:13px;">PENCAPAIAN KOMPETENSI PESERTA DIDIK</p>
            <h4 style="margin:4px 0; font-size:18px; font-weight:bold;"><?= esc($sekolah['nama_sekolah']) ?></h4>
            <p style="margin:0; font-size:12px;">Alamat: <?= esc($sekolah['alamat']) ?> &bull; Telp: <?= esc($sekolah['telepon']) ?></p>
          </div>

          <!-- Metadata Siswa Grid (Tabel 2 Kolom Format Resmi) -->
          <table class="table-borderless" style="width:100%; font-size:13px; margin-bottom:16px; border:none;">
            <tr>
              <td style="width:50%; border:none; padding:2px 0;">
                Nama Peserta Didik : <strong><?= esc($raport['siswa']['nama']) ?></strong>
              </td>
              <td style="width:50%; border:none; padding:2px 0;">
                Kelas / Semester : <strong><?= esc($raport['siswa']['kelas']) ?> / <?= esc($raport['siswa']['semester']) ?></strong>
              </td>
            </tr>
            <tr>
              <td style="border:none; padding:2px 0;">
                NIS / NISN : <strong><?= esc($raport['siswa']['nis']) ?> / <?= esc($raport['siswa']['nisn']) ?></strong>
              </td>
              <td style="border:none; padding:2px 0;">
                Tahun Ajaran : <strong><?= esc($raport['siswa']['tahun_ajaran']) ?></strong>
              </td>
            </tr>
          </table>

          <!-- SECTION A: SIKAP -->
          <div class="mb-4">
            <h6 style="font-weight:bold; font-size:13px; border-bottom:1px solid #000; padding-bottom:4px; margin-bottom:10px; color:#000; text-transform:uppercase;">
              A. SIKAP (SPIRITUAL &amp; SOSIAL)
            </h6>
            <div class="table-responsive">
              <table class="table mb-0">
                <thead>
                  <tr>
                    <th style="width: 25%;">Aspek Penilaian</th>
                    <th style="width: 15%;">Predikat</th>
                    <th style="width: 60%;">Deskripsi Kemajuan Siswa</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($raport['sikap'] as $sIdx => $sikap): ?>
                    <tr>
                      <td><?= esc($sikap['jenis_sikap']) ?></td>
                      <td class="text-center">
                        <input type="text" name="sikap[<?= $sIdx ?>][predikat]" class="form-control form-control-sm text-center" value="<?= esc($sikap['predikat']) ?>">
                        <?php if (!empty($sikap['is_edited_manual'])): ?>
                          <small class="text-secondary fst-italic d-block mt-1 btn-no-print" style="font-size: 11px;">*(diedit manual)</small>
                        <?php endif; ?>
                      </td>
                      <td>
                        <textarea name="sikap[<?= $sIdx ?>][deskripsi]" class="form-control form-control-sm" rows="2"><?= esc($sikap['deskripsi']) ?></textarea>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- SECTION B: PENGETAHUAN -->
          <div class="mb-4">
            <h6 style="font-weight:bold; font-size:13px; border-bottom:1px solid #000;
                       padding-bottom:4px; margin-bottom:10px; color:#000; text-transform:uppercase;">
              B. PENGETAHUAN
            </h6>
            <div class="table-responsive">
              <table style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                  <tr>
                    <th style="border:1px solid #000; padding:6px 8px; text-align:center; background:#f0f0f0; width:5%;">NO</th>
                    <th style="border:1px solid #000; padding:6px 8px; text-align:center; background:#f0f0f0; width:30%;">Mata Pelajaran</th>
                    <th style="border:1px solid #000; padding:6px 8px; text-align:center; background:#f0f0f0; width:8%;">KKM</th>
                    <th style="border:1px solid #000; padding:6px 8px; text-align:center; background:#f0f0f0; width:10%;">Nilai</th>
                    <th style="border:1px solid #000; padding:6px 8px; text-align:center; background:#f0f0f0; width:8%;">Predikat</th>
                    <th style="border:1px solid #000; padding:6px 8px; text-align:center; background:#f0f0f0;">Deskripsi Capaian</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach ($raport['nilai_kelompok'] as $kelompokName => $mapelList): ?>
                    <tr class="baris-kelompok">
                      <td colspan="6" style="border:1px solid #000; padding:5px 8px; background:#e8e8e8; font-weight:bold; font-style:italic;">
                        <?= esc($kelompokName) ?>
                      </td>
                    </tr>
                    <?php foreach ($mapelList as $m): ?>
                      <tr>
                        <td style="border:1px solid #000; padding:6px 8px; text-align:center;"><?= $no++ ?></td>
                        <td style="border:1px solid #000; padding:6px 8px;"><?= esc($m['mapel']) ?></td>
                        <td style="border:1px solid #000; padding:6px 8px; text-align:center;"><?= $m['kkm'] ?></td>
                        <td style="border:1px solid #000; padding:6px 8px; text-align:center;">
                          <input type="number" name="pengetahuan_nilai[]"
                            value="<?= $m['pengetahuan_nilai'] ?>"
                            style="border:none; border-bottom:1px dashed #999; width:50px; text-align:center;
                                   font-family:'Times New Roman',serif; font-size:13px; background:transparent;">
                        </td>
                        <td style="border:1px solid #000; padding:6px 8px; text-align:center; font-weight:bold;">
                          <?= esc($m['pengetahuan_predikat']) ?>
                        </td>
                        <td style="border:1px solid #000; padding:6px 8px;">
                          <textarea name="pengetahuan_deskripsi[]" rows="2"
                            style="width:100%; border:none; border-bottom:1px dashed #999;
                                   font-family:'Times New Roman',serif; font-size:12px;
                                   background:transparent; resize:none;"
                          ><?= esc($m['pengetahuan_deskripsi']) ?></textarea>
                          <?php if (!empty($m['is_edited_manual'])): ?>
                            <small class="text-secondary fst-italic d-block mt-1 btn-no-print" style="font-size: 11px;">*(diedit manual)</small>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- SECTION C: KETERAMPILAN -->
          <div class="mb-4">
            <h6 style="font-weight:bold; font-size:13px; border-bottom:1px solid #000;
                       padding-bottom:4px; margin-bottom:10px; color:#000; text-transform:uppercase;">
              C. KETERAMPILAN
            </h6>
            <div class="table-responsive">
              <table style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                  <tr>
                    <th style="border:1px solid #000; padding:6px 8px; text-align:center; background:#f0f0f0; width:5%;">NO</th>
                    <th style="border:1px solid #000; padding:6px 8px; text-align:center; background:#f0f0f0; width:30%;">Mata Pelajaran</th>
                    <th style="border:1px solid #000; padding:6px 8px; text-align:center; background:#f0f0f0; width:8%;">KKM</th>
                    <th style="border:1px solid #000; padding:6px 8px; text-align:center; background:#f0f0f0; width:10%;">Nilai</th>
                    <th style="border:1px solid #000; padding:6px 8px; text-align:center; background:#f0f0f0; width:8%;">Predikat</th>
                    <th style="border:1px solid #000; padding:6px 8px; text-align:center; background:#f0f0f0;">Deskripsi Capaian</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach ($raport['nilai_kelompok'] as $kelompokName => $mapelList): ?>
                    <tr class="baris-kelompok">
                      <td colspan="6" style="border:1px solid #000; padding:5px 8px; background:#e8e8e8; font-weight:bold; font-style:italic;">
                        <?= esc($kelompokName) ?>
                      </td>
                    </tr>
                    <?php foreach ($mapelList as $m): ?>
                      <tr>
                        <td style="border:1px solid #000; padding:6px 8px; text-align:center;"><?= $no++ ?></td>
                        <td style="border:1px solid #000; padding:6px 8px;"><?= esc($m['mapel']) ?></td>
                        <td style="border:1px solid #000; padding:6px 8px; text-align:center;"><?= $m['kkm'] ?></td>
                        <td style="border:1px solid #000; padding:6px 8px; text-align:center;">
                          <input type="number" name="keterampilan_nilai[]"
                            value="<?= $m['keterampilan_nilai'] ?>"
                            style="border:none; border-bottom:1px dashed #999; width:50px; text-align:center;
                                   font-family:'Times New Roman',serif; font-size:13px; background:transparent;">
                        </td>
                        <td style="border:1px solid #000; padding:6px 8px; text-align:center; font-weight:bold;">
                          <?= esc($m['keterampilan_predikat']) ?>
                        </td>
                        <td style="border:1px solid #000; padding:6px 8px;">
                          <textarea name="keterampilan_deskripsi[]" rows="2"
                            style="width:100%; border:none; border-bottom:1px dashed #999;
                                   font-family:'Times New Roman',serif; font-size:12px;
                                   background:transparent; resize:none;"
                          ><?= esc($m['keterampilan_deskripsi']) ?></textarea>
                          <?php if (!empty($m['is_edited_manual'])): ?>
                            <small class="text-secondary fst-italic d-block mt-1 btn-no-print" style="font-size: 11px;">*(diedit manual)</small>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- SECTION D & E: EKSTRAKURIKULER & PRESTASI -->
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <h6 style="font-weight:bold; font-size:13px; border-bottom:1px solid #000; padding-bottom:4px; margin-bottom:10px; color:#000; text-transform:uppercase;">
                D. EKSTRAKURIKULER
              </h6>
              <div class="table-responsive">
                <table class="table mb-0">
                  <thead>
                    <tr>
                      <th>Kegiatan</th>
                      <th style="width: 70px; text-align: center;">Nilai</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($raport['ekstrakurikuler'] as $eks): ?>
                      <tr>
                        <td><?= esc($eks['kegiatan']) ?></td>
                        <td class="text-center"><?= esc($eks['predikat']) ?></td>
                        <td><?= esc($eks['keterangan']) ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="col-md-6">
              <h6 style="font-weight:bold; font-size:13px; border-bottom:1px solid #000; padding-bottom:4px; margin-bottom:10px; color:#000; text-transform:uppercase;">
                E. PRESTASI
              </h6>
              <div class="table-responsive">
                <table class="table mb-0">
                  <thead>
                    <tr>
                      <th>Jenis Prestasi</th>
                      <th>Keterangan Capaian</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($raport['prestasi'] as $pres): ?>
                      <tr>
                        <td><?= esc($pres['jenis']) ?></td>
                        <td><?= esc($pres['keterangan']) ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- SECTION F: KETIDAKHADIRAN -->
          <div class="mb-4">
            <h6 style="font-weight:bold; font-size:13px; border-bottom:1px solid #000; padding-bottom:4px; margin-bottom:10px; color:#000; text-transform:uppercase;">
              F. KETIDAKHADIRAN
            </h6>
            <table style="width:100%; font-size:13px; border-collapse:collapse;">
              <tr>
                <td style="border:1px solid #000; padding:6px 12px; width:20%;">Sakit (S)</td>
                <td style="border:1px solid #000; padding:6px 12px; width:10%; text-align:center;">
                  <input type="number" name="sakit" value="<?= $raport['ketidakhadiran']['sakit'] ?>"
                         style="border:none; width:40px; text-align:center; font-family:'Times New Roman',serif; background:transparent;">
                </td>
                <td style="border:1px solid #000; padding:6px 12px; width:8%;">Hari</td>
                <td style="border:1px solid #000; padding:6px 12px; width:20%;">Izin (I)</td>
                <td style="border:1px solid #000; padding:6px 12px; width:10%; text-align:center;">
                  <input type="number" name="izin" value="<?= $raport['ketidakhadiran']['izin'] ?>"
                         style="border:none; width:40px; text-align:center; font-family:'Times New Roman',serif; background:transparent;">
                </td>
                <td style="border:1px solid #000; padding:6px 12px; width:8%;">Hari</td>
                <td style="border:1px solid #000; padding:6px 12px; width:24%;">Tanpa Keterangan (A)</td>
                <td style="border:1px solid #000; padding:6px 12px; width:10%; text-align:center;">
                  <input type="number" name="tanpa_keterangan" value="<?= $raport['ketidakhadiran']['tanpa_keterangan'] ?>"
                         style="border:none; width:40px; text-align:center; font-family:'Times New Roman',serif; background:transparent;">
                </td>
                <td style="border:1px solid #000; padding:6px 12px; width:8%;">Hari</td>
              </tr>
            </table>
          </div>

          <!-- SECTION G: CATATAN WALI KELAS -->
          <div class="mb-4">
            <h6 style="font-weight:bold; font-size:13px; border-bottom:1px solid #000; padding-bottom:4px; margin-bottom:10px; color:#000; text-transform:uppercase;">
              G. CATATAN WALI KELAS
            </h6>
            <textarea name="catatan_wali_kelas" rows="4"
              style="width:100%; border:1px solid #999; padding:8px;
                     font-family:'Times New Roman',serif; font-size:13px;
                     resize:vertical; background:transparent;"
            ><?= esc($raport['catatan_wali_kelas']) ?></textarea>
          </div>

          <!-- Tanda Tangan Footer Dokumen (Format Cetak Fisik & Manual) -->
          <table class="table-borderless" style="width:100%; margin-top:40px; border:none; font-size:13px; color:#000;">
            <tr>
              <td style="border:none; text-align:center; width:33%; vertical-align:top;">
                <p style="margin:0;">Mengetahui,</p>
                <p style="margin:0;">Orang Tua / Wali Siswa,</p>
                <div style="height: 70px;"></div>
                <p style="margin:0; border-top:1px solid #000; padding-top:4px; display:inline-block; min-width:170px;">
                  ( ................................................ )
                </p>
              </td>
              <td style="border:none; text-align:center; width:33%; vertical-align:top;">
                <p style="margin:0;">Mengetahui,</p>
                <p style="margin:0;">Kepala Sekolah,</p>
                <div style="height: 70px;"></div>
                <p style="margin:0; font-weight:bold; text-decoration:underline;"><?= esc($raport['siswa']['kepala_sekolah']) ?></p>
                <div style="font-size:12px;">NIP. <?= esc($raport['approval_kepsek']['nip'] ?? '196805121994031004') ?></div>
              </td>
              <td style="border:none; text-align:center; width:33%; vertical-align:top;">
                <p style="margin:0;">Bandung Barat, <?= esc($raport['siswa']['tanggal_raport']) ?></p>
                <p style="margin:0;">Wali Kelas,</p>
                <div style="height: 70px;"></div>
                <p style="margin:0; font-weight:bold; text-decoration:underline;"><?= esc($raport['siswa']['wali_kelas']) ?></p>
                <div style="font-size:12px;">NIP. <?= esc($raport['approval_wali']['nip'] ?? '198203152009022003') ?></div>
              </td>
            </tr>
          </table>

        </div>
      </div>
    </div>
  </div>

  <!-- Sticky Bottom Save & Finalize Bar -->
  <div class="sticky-bottom-bar d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 shadow-sm border">
    <div>
      <?php if (($raport['status'] ?? '') === 'final'): ?>
        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
          Status: FINAL (Resmi Terbit &amp; Terkunci)
        </span>
      <?php elseif (($raport['status'] ?? '') === 'menunggu_persetujuan_kepsek'): ?>
        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2">
          Status: Menunggu Pengesahan Kepala Sekolah
        </span>
      <?php else: ?>
        <span class="badge bg-secondary-subtle text-secondary border px-3 py-2">
          Status: DRAFT (Dapat Diedit Wali Kelas)
        </span>
      <?php endif; ?>
    </div>
    <div class="d-flex flex-wrap gap-2">
      <?php if (($raport['status'] ?? '') === 'draft'): ?>
        <button type="submit" class="btn btn-outline-secondary btn-sm px-3">
          Simpan Draft
        </button>
        <button type="button" class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalFinalisasiRaport">
          Kunci &amp; Ajukan ke Kepala Sekolah
        </button>
      <?php elseif (($raport['status'] ?? '') === 'menunggu_persetujuan_kepsek'): ?>
        <button type="button" class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalPengesahanKepsek">
          Pengesahan Kepala Sekolah
        </button>
        <button type="button" class="btn btn-outline-danger btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalTolakKepsek">
          Kembalikan ke Wali Kelas
        </button>
        <a href="<?= base_url('guru/raport/buka-kunci/' . $currentSiswaId) ?>" class="btn btn-outline-secondary btn-sm px-3">
          Buka Kunci / Revisi
        </a>
      <?php else: ?>
        <button type="button" class="btn btn-outline-secondary btn-sm px-3" onclick="window.print()">
          Cetak Dokumen Raport
        </button>
        <a href="<?= base_url('guru/raport/buka-kunci/' . $currentSiswaId) ?>" class="btn btn-outline-danger btn-sm px-3">
          Permohonan Buka Kunci Revisi
        </a>
      <?php endif; ?>
    </div>
  </div>
</form>

<!-- Modal 1: Konfirmasi Kunci & Ajukan ke Kepala Sekolah (Wali Kelas) -->
<div class="modal fade" id="modalFinalisasiRaport" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('guru/raport/finalisasi/' . $currentSiswaId) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="tahap" value="ajukan_kepsek">

        <div class="modal-header">
          <h5 class="modal-title fw-semibold">Kunci &amp; Ajukan Raport</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-warning small mb-3">
            Setelah diajukan, seluruh nilai akan <strong>dikunci sementara</strong> oleh Wali Kelas dan diteruskan ke Kepala Sekolah untuk pengesahan tanda tangan digital resmi.
          </div>

          <h6 class="fs-7 mb-2 fw-semibold">Pemeriksaan Kelengkapan:</h6>
          <ul class="list-group list-group-flush mb-0 fs-7">
            <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-0">
              <span>Section A: Sikap Spiritual &amp; Sosial</span>
              <span class="text-success small fw-medium">Lengkap</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-0">
              <span>Section B &amp; C: Seluruh Mata Pelajaran &amp; CP</span>
              <span class="text-success small fw-medium">Lengkap</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-0">
              <span>Section D &amp; E: Ekstrakurikuler &amp; Prestasi</span>
              <span class="text-success small fw-medium">Lengkap</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-0">
              <span>Section F &amp; G: Presensi &amp; Catatan Wali Kelas</span>
              <span class="text-success small fw-medium">Lengkap</span>
            </li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-3">Kunci &amp; Ajukan ke Kepsek</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal 2: Pengesahan TTD Digital Kepala Sekolah -->
<div class="modal fade" id="modalPengesahanKepsek" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('guru/raport/finalisasi/' . $currentSiswaId) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="tahap" value="sahkan_kepsek">

        <div class="modal-header">
          <h5 class="modal-title fw-semibold">Pengesahan Tanda Tangan Digital</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="p-3 bg-light rounded-3 border mb-3 text-center">
            <h6 class="fw-bold mb-1">Drs. H. Ahmad Fauzi, M.Pd.</h6>
            <div class="small text-secondary">Kepala Sekolah SMA IT Fithrah Insani</div>
            <div class="font-monospace small text-muted">NIP. 196805121994031004</div>
          </div>
          <p class="small text-body mb-0">
            Dengan menekan tombol di bawah, Anda secara resmi mengesahkan capaian raport atas nama <strong><?= esc($raport['siswa']['nama']) ?></strong> (<?= esc($raport['siswa']['nis']) ?>). Nilai akan berstatus <strong>FINAL</strong> dan siswa/orang tua dapat langsung mengunduh/mencetak raport resmi.
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-3">Sahkan Resmi Sekarang</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal 3: Penolakan / Pengembalian Raport oleh Kepala Sekolah -->
<div class="modal fade" id="modalTolakKepsek" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('guru/raport/finalisasi/' . $currentSiswaId) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="tahap" value="tolak_kepsek">
        <div class="modal-header">
          <h5 class="modal-title fw-semibold text-danger">Kembalikan Raport ke Wali Kelas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div class="alert alert-warning small mb-3">
            Raport siswa <strong><?= esc($raport['siswa']['nama']) ?></strong> akan dikembalikan statusnya menjadi <strong>Draft</strong>. Wali Kelas dan guru mapel dapat memperbaiki data sebelum diajukan kembali.
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-danger">Catatan Revisi dari Kepala Sekolah <span class="text-danger">*</span></label>
            <textarea name="catatan_revisi" class="form-control form-control-sm" rows="3" placeholder="Tuliskan butir penilaian atau narasi capaian yang harus diperbaiki oleh dewan guru/wali kelas..." required></textarea>
            <small class="text-secondary fs-8">Catatan ini akan langsung ditampilkan sebagai pemberitahuan di halaman Wali Kelas.</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger btn-sm px-3">Kembalikan ke Draft</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

