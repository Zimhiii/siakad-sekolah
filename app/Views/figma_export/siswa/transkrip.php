<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-print-none d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
  <div>
    <a href="<?= base_url('siswa/status') ?>" class="text-decoration-none small text-secondary">
      Kembali ke Status Akademik
    </a>
    <h4 class="fw-bold mb-0">Transkrip Nilai Kumulatif 6 Semester</h4>
    <p class="text-secondary small mb-0">Rekapitulasi resmi capaian pembelajaran seluruh semester untuk keperluan seleksi PTN (SNBP/SNBT) atau kedinasan.</p>
  </div>
  <div class="d-flex gap-2">
    <button onclick="window.print()" class="btn btn-primary btn-sm">
      Cetak / Simpan PDF Transkrip Resmi
    </button>
  </div>
</div>

<!-- Lembar Kertas Transkrip Resmi (Print Ready) -->
<div class="card shadow-sm border p-4 p-md-5 bg-white text-dark mb-4" id="transkrip-paper" style="color: #000 !important; font-family: 'Times New Roman', Times, serif;">
  
  <!-- Kop Surat Resmi Sekolah -->
  <div class="d-flex align-items-center justify-content-between pb-3 mb-4" style="border-bottom: 2px solid #000;">
    <div class="d-flex align-items-center gap-3">
      <img src="https://ui-avatars.com/api/?name=SIAKAD+FI&background=1E3A5F&color=fff&size=96" width="70" height="70" class="border p-1" alt="Logo Sekolah">
      <div>
        <div style="font-size: 11px; text-transform: uppercase; font-weight: bold; letter-spacing: 0.5px;">Yayasan Fithrah Insani Bandung Barat</div>
        <h4 style="font-size: 18px; font-weight: bold; margin: 2px 0; text-transform: uppercase;">SMA IT Fithrah Insani</h4>
        <div style="font-size: 11px; line-height: 1.3;">
          NPSN: 20224156 &bull; NSS: 301020801001 &bull; Terakreditasi "A" (Amat Baik)<br>
          Jl. Haji Gofur No. 10, Gadobangkong, Kec. Ngamprah, Kab. Bandung Barat, Jawa Barat 40552
        </div>
      </div>
    </div>
    <div class="text-end d-none d-sm-block" style="font-size: 11px; line-height: 1.3;">
      <span>Website: fithrahinsani.sch.id</span><br>
      <span>Email: info@fithrahinsani.sch.id</span><br>
      <span>Telp: (022) 6625890</span>
    </div>
  </div>

  <div class="text-center mb-4">
    <h5 style="font-size: 16px; font-weight: bold; text-transform: uppercase; margin-bottom: 2px; text-decoration: underline;">TRANSKRIP NILAI PRESTASI AKADEMIK</h5>
    <div style="font-size: 12px;">Nomor: <?= 'TR-SMAFI/' . date('Y') . '/' . esc($transkrip['siswa']['nis']) ?></div>
  </div>

  <!-- Identitas Peserta Didik -->
  <table class="table-borderless mb-4" style="width: 100%; font-size: 12px; border: none;">
    <tr>
      <td style="width: 18%; padding: 2px 0; border: none;">Nama Lengkap</td>
      <td style="width: 32%; padding: 2px 0; border: none;">: <strong><?= esc($transkrip['siswa']['nama']) ?></strong></td>
      <td style="width: 18%; padding: 2px 0; border: none;">Tempat, Tanggal Lahir</td>
      <td style="width: 32%; padding: 2px 0; border: none;">: <?= esc($transkrip['siswa']['tempat_lahir']) ?>, <?= date('d F Y', strtotime($transkrip['siswa']['tanggal_lahir'])) ?></td>
    </tr>
    <tr>
      <td style="padding: 2px 0; border: none;">NIS / NISN</td>
      <td style="padding: 2px 0; border: none;">: <?= esc($transkrip['siswa']['nis']) ?> / <?= esc($transkrip['siswa']['nisn']) ?></td>
      <td style="padding: 2px 0; border: none;">Program Peminatan</td>
      <td style="padding: 2px 0; border: none;">: MIPA (Matematika &amp; Ilmu Pengetahuan Alam)</td>
    </tr>
    <tr>
      <td style="padding: 2px 0; border: none;">Satuan Pendidikan</td>
      <td style="padding: 2px 0; border: none;">: SMA IT Fithrah Insani</td>
      <td style="padding: 2px 0; border: none;">Status Pendidikan</td>
      <td style="padding: 2px 0; border: none;">: Peserta Didik Aktif</td>
    </tr>
  </table>

  <!-- Tabel Riwayat Capaian Semesteran (1 s.d. 6) -->
  <div style="font-size: 12px; font-weight: bold; text-transform: uppercase; margin-bottom: 6px; border-bottom: 1px solid #000; padding-bottom: 3px;">
    I. REKAPITULASI CAPAIAN PER SEMESTER (SEMESTER 1 S.D. 6)
  </div>
  <table style="width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 16px;">
    <thead>
      <tr style="background: #f0f0f0; text-align: center;">
        <th style="border: 1px solid #000; padding: 6px 4px; width: 12%;">Tingkat</th>
        <th style="border: 1px solid #000; padding: 6px 4px; width: 28%;">Semester &amp; Tahun Ajaran</th>
        <th style="border: 1px solid #000; padding: 6px 4px; width: 12%;">Rombel</th>
        <th style="border: 1px solid #000; padding: 6px 4px; width: 12%;">Rata-rata</th>
        <th style="border: 1px solid #000; padding: 6px 4px; width: 12%;">Predikat</th>
        <th style="border: 1px solid #000; padding: 6px 4px; width: 12%;">Peringkat</th>
        <th style="border: 1px solid #000; padding: 6px 4px; width: 12%;">Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($transkrip['semesters'] as $idx => $smt): ?>
        <tr style="text-align: center;">
          <td style="border: 1px solid #000; padding: 5px 4px;"><?= esc($smt['tingkat']) ?></td>
          <td style="border: 1px solid #000; padding: 5px 4px; text-align: left; padding-left: 10px;">Semester <?= esc($smt['semester']) ?> (<?= esc($smt['tahun_ajaran']) ?>)</td>
          <td style="border: 1px solid #000; padding: 5px 4px;"><?= esc($smt['kelas']) ?></td>
          <td style="border: 1px solid #000; padding: 5px 4px; font-weight: bold;"><?= number_format($smt['rata_rata'], 1) ?></td>
          <td style="border: 1px solid #000; padding: 5px 4px;"><?= esc($smt['predikat']) ?></td>
          <td style="border: 1px solid #000; padding: 5px 4px;">Peringkat <?= esc($smt['peringkat']) ?></td>
          <td style="border: 1px solid #000; padding: 5px 4px;"><?= esc($smt['status_kenaikan']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Ringkasan Rata-rata Nilai Kumulatif -->
  <table style="width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 16px;">
    <tbody>
      <tr>
        <td style="border: 1px solid #000; padding: 6px 10px; width: 35%; background: #f0f0f0; font-weight: bold;">Rata-rata Nilai Kumulatif (Skala 0-100)</td>
        <td style="border: 1px solid #000; padding: 6px 10px; width: 15%; text-align: center; font-weight: bold; font-size: 13px;"><?= number_format($transkrip['rata_rata_kumulatif'], 1) ?></td>
        <td style="border: 1px solid #000; padding: 6px 10px; width: 30%; background: #f0f0f0; font-weight: bold;">Predikat Capaian Kumulatif</td>
        <td style="border: 1px solid #000; padding: 6px 10px; width: 20%; text-align: center; font-weight: bold;"><?= esc($transkrip['predikat_kumulatif'] ?? 'A (Sangat Baik)') ?></td>
      </tr>
      <tr>
        <td style="border: 1px solid #000; padding: 6px 10px; background: #f0f0f0; font-weight: bold;">Total Beban Belajar Diselesaikan</td>
        <td style="border: 1px solid #000; padding: 6px 10px; text-align: center;"><?= esc($transkrip['total_jam_pelajaran'] ?? 192) ?> JP</td>
        <td style="border: 1px solid #000; padding: 6px 10px; background: #f0f0f0; font-weight: bold;">Status Ketuntasan Belajar</td>
        <td style="border: 1px solid #000; padding: 6px 10px; text-align: center;">TUNTAS</td>
      </tr>
    </tbody>
  </table>

  <!-- Formula & Catatan Kelulusan Sekolah -->
  <div style="border: 1px solid #000; padding: 8px 12px; font-size: 11px; margin-bottom: 30px; line-height: 1.4;">
    <strong>Catatan Kelulusan &amp; Pengesahan:</strong> Berdasarkan SK Kepala Sekolah No. <?= esc($formula['sk_nomor'] ?? 'SK/014/FI/2025') ?>, Nilai Akhir Kelulusan dihitung dari pembobotan <strong><?= $formula['bobot_rapor'] ?? 60 ?>% Rata-rata Rapor (6 Semester) + <?= $formula['bobot_ujian_sekolah'] ?? 40 ?>% Ujian Sekolah</strong>. Dokumen transkrip ini sah digunakan untuk persyaratan pendaftaran Seleksi Nasional Masuk Perguruan Tinggi Negeri (SNBP/SNBT), perguruan tinggi kedinasan, maupun beasiswa luar negeri.
  </div>

  <!-- Tanda Tangan Dokumen Resmi -->
  <table class="table-borderless" style="width: 100%; border: none; font-size: 12px;">
    <tr>
      <td style="border: none; text-align: center; width: 33%; vertical-align: top;">
        <p style="margin: 0;">Mengetahui,</p>
        <p style="margin: 0;">Orang Tua / Wali Siswa,</p>
        <div style="height: 70px;"></div>
        <p style="margin: 0; border-top: 1px solid #000; padding-top: 4px; display: inline-block; min-width: 160px;">
          ( ............................................ )
        </p>
      </td>
      <td style="border: none; text-align: center; width: 33%; vertical-align: top;">
        <p style="margin: 0;">Pasfoto 3x4</p>
        <div style="width: 75px; height: 95px; border: 1px solid #000; margin: 4px auto; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #555;">
          Cap Sekolah
        </div>
      </td>
      <td style="border: none; text-align: center; width: 33%; vertical-align: top;">
        <p style="margin: 0;">Bandung Barat, <?= date('d F Y') ?></p>
        <p style="margin: 0;">Kepala SMA IT Fithrah Insani,</p>
        <div style="height: 70px;"></div>
        <p style="margin: 0; font-weight: bold; text-decoration: underline;">Drs. H. Ahmad Fauzi, M.Pd.</p>
        <div style="font-size: 11px;">NIP. 196805121994031004</div>
      </td>
    </tr>
  </table>

</div>

<style>
@media print {
  body { background: white !important; font-family: 'Times New Roman', Times, serif !important; }
  .d-print-none, .app-header, .app-sidebar, .app-footer { display: none !important; }
  .app-main, .app-content, .container-fluid { margin: 0 !important; padding: 0 !important; }
  #transkrip-paper { border: none !important; box-shadow: none !important; padding: 0 !important; margin: 0 !important; }
  @page { size: portrait; margin: 15mm; }
}
</style>

<?= $this->endSection() ?>
