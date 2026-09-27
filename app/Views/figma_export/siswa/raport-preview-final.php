<?php $raport['status'] = 'final'; ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4 btn-no-print">
  <div>
    <a href="<?= base_url('siswa/raport') ?>" class="text-decoration-none small text-secondary">
      Kembali ke Riwayat Raport
    </a>
    <h4 class="fw-bold mb-1">Pratinjau Raport Digital Siswa</h4>
  </div>
  <div class="d-flex gap-2">
    <button type="button" class="btn btn-primary btn-sm" onclick="window.print()">
      Cetak / Simpan PDF
    </button>
  </div>
</div>

<?php if (($raport['status'] ?? 'draft') === 'final'): ?>
  <div class="alert alert-light border border-success-subtle mb-4 btn-no-print" role="alert">
    <div class="small text-secondary">
      <strong class="text-success">Dokumen Raport Resmi:</strong> Lembar raport ini siap dicetak dan ditandatangani secara fisik untuk keperluan arsip, dinas pendidikan, maupun beasiswa.
    </div>
  </div>
<?php elseif (($raport['status'] ?? 'draft') === 'menunggu_persetujuan_kepsek'): ?>
  <div class="alert alert-light border border-info-subtle mb-4 btn-no-print" role="alert">
    <div class="small text-secondary">
      <strong class="text-info-emphasis">Menunggu Pengesahan Pimpinan:</strong> Raport telah selesai disusun dan diverifikasi oleh Wali Kelas, saat ini dalam proses pengesahan Kepala Sekolah.
    </div>
  </div>
<?php else: ?>
  <div class="alert alert-light border border-warning-subtle mb-4 btn-no-print" role="alert">
    <div class="small text-secondary">
      <strong class="text-warning-emphasis">Perhatian Status Draf:</strong> Raport ini masih berstatus <em>Draft (Sedang Diproses)</em> oleh Dewan Guru. Nilai yang tampil merupakan capaian sementara.
    </div>
  </div>
<?php endif; ?>

<!-- Paper-Like Document Wrapper -->
<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="card card-paper mb-5">
      
      <div class="card-body p-4 p-md-5">
        
        <!-- Header Dokumen Raport ala Kertas -->
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
            <table class="table mb-0" style="font-size:13px;">
              <thead>
                <tr>
                  <th style="width: 25%;">Aspek Penilaian</th>
                  <th style="width: 15%; text-align:center;">Predikat</th>
                  <th style="width: 60%;">Deskripsi Kemajuan Siswa</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($raport['sikap'] as $s): ?>
                  <tr>
                    <td><?= esc($s['jenis_sikap']) ?></td>
                    <td class="text-center"><strong><?= esc($s['predikat']) ?></strong></td>
                    <td><?= esc($s['deskripsi']) ?></td>
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
                      <td style="border:1px solid #000; padding:6px 8px; text-align:center;"><?= $m['pengetahuan_nilai'] ?></td>
                      <td style="border:1px solid #000; padding:6px 8px; text-align:center; font-weight:bold;">
                        <?= esc($m['pengetahuan_predikat']) ?>
                      </td>
                      <td style="border:1px solid #000; padding:6px 8px; font-size:12px;">
                        <?= esc($m['pengetahuan_deskripsi']) ?>
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
                      <td style="border:1px solid #000; padding:6px 8px; text-align:center;"><?= $m['keterampilan_nilai'] ?></td>
                      <td style="border:1px solid #000; padding:6px 8px; text-align:center; font-weight:bold;">
                        <?= esc($m['keterampilan_predikat']) ?>
                      </td>
                      <td style="border:1px solid #000; padding:6px 8px; font-size:12px;">
                        <?= esc($m['keterampilan_deskripsi']) ?>
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
              <table class="table mb-0" style="font-size:13px;">
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
              <table class="table mb-0" style="font-size:13px;">
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
              <td style="border:1px solid #000; padding:6px 12px; width:10%; text-align:center; font-weight:bold;"><?= $raport['ketidakhadiran']['sakit'] ?></td>
              <td style="border:1px solid #000; padding:6px 12px; width:8%;">Hari</td>
              <td style="border:1px solid #000; padding:6px 12px; width:20%;">Izin (I)</td>
              <td style="border:1px solid #000; padding:6px 12px; width:10%; text-align:center; font-weight:bold;"><?= $raport['ketidakhadiran']['izin'] ?></td>
              <td style="border:1px solid #000; padding:6px 12px; width:8%;">Hari</td>
              <td style="border:1px solid #000; padding:6px 12px; width:24%;">Tanpa Keterangan (A)</td>
              <td style="border:1px solid #000; padding:6px 12px; width:10%; text-align:center; font-weight:bold;"><?= $raport['ketidakhadiran']['tanpa_keterangan'] ?></td>
              <td style="border:1px solid #000; padding:6px 12px; width:8%;">Hari</td>
            </tr>
          </table>
        </div>

        <!-- SECTION G: CATATAN WALI KELAS -->
        <div class="mb-4">
          <h6 style="font-weight:bold; font-size:13px; border-bottom:1px solid #000; padding-bottom:4px; margin-bottom:10px; color:#000; text-transform:uppercase;">
            G. CATATAN WALI KELAS
          </h6>
          <div style="width:100%; border:1px solid #999; padding:10px 12px; font-family:'Times New Roman',serif; font-size:13px; min-height:60px;">
            <?= esc($raport['catatan_wali_kelas']) ?>
          </div>
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

<?= $this->endSection() ?>
