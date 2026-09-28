<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title) ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Times New Roman', Times, serif;
      background-color: #f8f9fa;
      color: #000;
      overflow-x: hidden;
    }
    .paper-container {
      width: 297mm; /* Landscape A4 */
      max-width: calc(100% - 30px);
      box-sizing: border-box;
      min-height: 210mm;
      margin: 20px auto;
      background: #fff;
      padding: 15mm 20mm;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .kop-surat {
      border-bottom: 3px double #000;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }
    .kop-surat img {
      width: 80px;
      height: 80px;
      object-fit: contain;
    }
    .table-bordered th, .table-bordered td {
      border: 1px solid #000 !important;
      padding: 4px 6px;
      font-size: 11px;
    }
    .table-bordered th {
      background-color: #f2f2f2 !important;
      text-align: center;
      vertical-align: middle;
    }
    .ttd-box {
      width: 250px;
      text-align: center;
      font-size: 12px;
    }
    @media print {
      body {
        background: #fff;
        margin: 0;
      }
      .paper-container {
        width: 100%;
        margin: 0;
        padding: 10mm 15mm;
        box-shadow: none;
      }
      .no-print {
        display: none !important;
      }
      @page {
        size: A4 landscape;
        margin: 10mm;
      }
    }
  </style>
</head>
<body>

  <!-- Floating Bar Aksi Cetak (Disembunyikan saat print) -->
  <div class="no-print bg-dark text-white py-2 px-3 sticky-top shadow-sm">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
        <a href="<?= base_url('guru/presensi/' . $pengajaran['id']) ?>" class="btn btn-sm btn-outline-light">
          Kembali ke Sistem
        </a>
        <span class="fs-7 text-light opacity-75">Pratinjau Cetak: Buku Presensi &amp; Jurnal KBM Resmi</span>
      </div>
      <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-sm btn-primary px-3">
          Cetak Dokumen (PDF)
        </button>
      </div>
    </div>
  </div>

  <div class="paper-container">
    <!-- KOP RESMI SEKOLAH -->
    <div class="kop-surat d-flex align-items-center gap-4">
      <img src="<?= esc($sekolah['logo_url']) ?>" alt="Logo Sekolah" class="border rounded p-1">
      <div class="text-center flex-grow-1">
        <h5 class="fw-bold mb-0 text-uppercase" style="letter-spacing: 1px;">YAYASAN FITHRAH INSANI BANDUNG BARAT</h5>
        <h4 class="fw-bold mb-0 text-uppercase"><?= esc($sekolah['nama_sekolah']) ?></h4>
        <p class="mb-0 small" style="font-family: Arial, sans-serif; font-size: 11px;">
          NPSN: <?= esc($sekolah['npsn']) ?> &bull; NSS: <?= esc($sekolah['nss']) ?> &bull; Status Akreditasi: <strong>A (Unggul)</strong><br>
          <?= esc($sekolah['alamat']) ?>, Kec. <?= esc($sekolah['kecamatan']) ?>, <?= esc($sekolah['kabupaten_kota']) ?> - <?= esc($sekolah['provinsi']) ?><br>
          Website: <?= esc($sekolah['website']) ?> &bull; Email: <?= esc($sekolah['email']) ?> &bull; Telp: <?= esc($sekolah['telepon']) ?>
        </p>
      </div>
    </div>

    <!-- JUDUL LAPORAN -->
    <div class="text-center mb-3">
      <h5 class="fw-bold mb-1 text-uppercase" style="text-decoration: underline;">
        BUKU PRESENSI & JURNAL KEGIATAN BELAJAR MENGAJAR (KBM)
      </h5>
      <p class="small mb-0" style="font-family: Arial, sans-serif;">
        Tahun Ajaran <?= esc($taAktif) ?>
      </p>
    </div>

    <!-- IDENTITAS PENGAJARAN -->
    <table class="table table-borderless table-sm mb-3" style="font-size: 12px; font-family: Arial, sans-serif;">
      <tr>
        <td style="width: 160px;"><strong>Mata Pelajaran</strong></td>
        <td style="width: 10px;">:</td>
        <td style="width: 320px;"><?= esc($pengajaran['mapel_nama']) ?></td>
        <td style="width: 160px;"><strong>Guru Pengampu</strong></td>
        <td style="width: 10px;">:</td>
        <td><?= esc($namaGuru) ?></td>
      </tr>
      <tr>
        <td><strong>Kelas / Rombel</strong></td>
        <td>:</td>
        <td><?= esc($pengajaran['kelas_nama']) ?></td>
        <td><strong>Standar KKM</strong></td>
        <td>:</td>
        <td><?= number_format($pengajaran['kkm'], 0) ?></td>
      </tr>
      <tr>
        <td><strong>Semester</strong></td>
        <td>:</td>
        <td><?= esc($pengajaran['semester_nama']) ?></td>
        <td><strong>Total Pertemuan Terlaksana</strong></td>
        <td>:</td>
        <td><?= $rekapData['pertemuanSelesaiCount'] ?> dari <?= $rekapData['targetPertemuan'] ?> Sesi</td>
      </tr>
    </table>

    <!-- BAGIAN 1: REKAPITULASI PRESENSI SISWA -->
    <div class="mb-4">
      <h6 class="fw-bold mb-1" style="font-size: 13px;">I. REKAPITULASI PRESENSI KEHADIRAN SISWA</h6>
      <table class="table table-bordered align-middle text-center mb-1">
        <thead>
          <tr>
            <th rowspan="2" style="width: 30px;">NO</th>
            <th rowspan="2" style="width: 80px;">NIS</th>
            <th rowspan="2" class="text-start ps-2" style="width: 220px;">NAMA LENGKAP SISWA</th>
            <th colspan="<?= count($pertemuanList) ?>">PERTEMUAN TATAP MUKA</th>
            <th colspan="5">REKAP</th>
            <th rowspan="2" style="width: 60px;">%</th>
            <th rowspan="2" style="width: 75px;">STATUS</th>
          </tr>
          <tr>
            <?php foreach ($pertemuanList as $pt): ?>
              <th style="width: 26px;">P<?= esc($pt['pertemuan_ke']) ?></th>
            <?php endforeach; ?>
            <th style="width: 25px;">H</th>
            <th style="width: 25px;">S</th>
            <th style="width: 25px;">I</th>
            <th style="width: 25px;">A</th>
            <th style="width: 25px;">D</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rekapData['rekap'] as $idx => $r): ?>
            <tr>
              <td><?= $idx + 1 ?></td>
              <td><?= esc($r['nis']) ?></td>
              <td class="text-start ps-2"><?= esc($r['nama']) ?></td>
              
              <?php foreach ($pertemuanList as $pt): ?>
                <?php 
                  $st = $r['kehadiran'][$pt['id']]['status'] ?? '-';
                ?>
                <td class="fw-bold">
                  <?= $st ?>
                </td>
              <?php endforeach; ?>

              <td class="fw-bold"><?= $r['total_hadir'] ?></td>
              <td><?= $r['total_sakit'] ?></td>
              <td><?= $r['total_izin'] ?></td>
              <td><?= $r['total_alpa'] ?></td>
              <td><?= $r['total_dispensasi'] ?></td>
              <td class="fw-bold">
                <?= $r['persentase'] ?>%
              </td>
              <td>
                <?= $r['is_tuntas'] ? 'Tuntas' : 'Peringatan' ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <small style="font-size: 10px; font-family: Arial, sans-serif;">
        *Keterangan: H: Hadir &bull; S: Sakit &bull; I: Izin &bull; A: Alpa (Tanpa Keterangan) &bull; D: Dispensasi Tugas Sekolah/Lomba. Ambang batas syarat kelayakan UAS: minimal 85% kehadiran.
      </small>
    </div>

    <!-- BAGIAN 2: JURNAL PELAKSANAAN PEMBELAJARAN (KBM) -->
    <div class="mb-4">
      <h6 class="fw-bold mb-1" style="font-size: 13px;">II. JURNAL KEGIATAN BELAJAR MENGAJAR (AGENDA GURU)</h6>
      <table class="table table-bordered align-middle text-start mb-0">
        <thead>
          <tr>
            <th style="width: 35px;">PER</th>
            <th style="width: 100px;">TANGGAL</th>
            <th style="width: 140px;">JAM PELAJARAN</th>
            <th style="width: 260px;">MATERI POKOK / CAPAIAN PEMBELAJARAN</th>
            <th style="width: 160px;">METODE KBM</th>
            <th>REFLEKSI / CATATAN KEGIATAN GURU</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pertemuanList as $pt): ?>
            <?php if ($pt['status'] === 'selesai'): ?>
              <tr>
                <td class="text-center fw-bold">P-<?= esc($pt['pertemuan_ke']) ?></td>
                <td><?= date('d/m/Y', strtotime($pt['tanggal'])) ?></td>
                <td><?= esc($pt['jam_ke']) ?></td>
                <td><?= esc($pt['materi_pokok']) ?></td>
                <td><?= esc($pt['metode']) ?></td>
                <td class="fst-italic"><?= !empty($pt['catatan_jurnal']) ? esc($pt['catatan_jurnal']) : '-' ?></td>
              </tr>
            <?php endif; ?>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- BAGIAN 3: LEMBAR PENGESAHAN TANDA TANGAN -->
    <div class="d-flex justify-content-between align-items-start mt-4 pt-2">
      <div class="ttd-box">
        <p class="mb-1">Mengetahui,</p>
        <p class="fw-bold mb-5">Kepala SMA IT Fithrah Insani</p>
        <p class="fw-bold mb-0 text-decoration-underline"><?= esc($sekolah['kepala_sekolah']) ?></p>
        <p class="small text-secondary mb-0">NIP. 19740512 199903 1 002</p>
      </div>

      <div class="ttd-box">
        <p class="mb-1">Bandung Barat, <?= date('d F Y') ?></p>
        <p class="fw-bold mb-5">Guru Mata Pelajaran</p>
        <p class="fw-bold mb-0 text-decoration-underline"><?= esc($namaGuru) ?></p>
        <p class="small text-secondary mb-0">NIP. 19820815 200801 1 014</p>
      </div>
    </div>
  </div>

</body>
</html>
