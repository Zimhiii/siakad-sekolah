<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
@media print {
  body {
    background: #fff !important;
    font-size: 10px !important;
    color: #000 !important;
  }
  .app-sidebar, .app-header, .btn-toolbar-leger, .breadcrumb, .stat-summary-leger, footer {
    display: none !important;
  }
  .app-main, .app-content, .container-fluid {
    padding: 0 !important;
    margin: 0 !important;
  }
  .card {
    border: none !important;
    box-shadow: none !important;
  }
  .table-responsive {
    overflow: visible !important;
  }
  .table-leger {
    width: 100% !important;
    border: 1px solid #000 !important;
    font-size: 9px !important;
  }
  .table-leger th, .table-leger td {
    border: 1px solid #000 !important;
    padding: 3px 4px !important;
    color: #000 !important;
    background: transparent !important;
  }
  .print-header {
    display: block !important;
  }
  @page {
    size: landscape;
    margin: 1cm;
  }
}
.print-header {
  display: none;
}
.sticky-col-1 {
  position: sticky;
  left: 0;
  background: var(--bs-body-bg);
  z-index: 2;
}
.sticky-col-2 {
  position: sticky;
  left: 42px;
  background: var(--bs-body-bg);
  z-index: 2;
  box-shadow: 2px 0 4px rgba(0,0,0,0.03);
}
.table-leger th {
  font-weight: 600;
}
.table-leger .cell-nilai {
  font-variant-numeric: tabular-nums;
}
</style>

<!-- Print Header Format Dinas Pendidikan -->
<div class="print-header mb-3 text-center">
  <h4 class="fw-bold mb-0 text-uppercase">MATRIKS NILAI KELAS (BUKU KUMPULAN NILAI / LEGER)</h4>
  <h5 class="fw-semibold mb-1"><?= esc($sekolah['nama_sekolah'] ?? 'SMA IT FITHRAH INSANI') ?></h5>
  <p class="small mb-0">
    Kelas: <strong><?= esc($legerData['kelas']) ?></strong> &bull; Semester: <strong>Ganjil</strong> &bull; Tahun Ajaran: <strong>2025/2026</strong> &bull; Wali Kelas: <strong><?= esc($legerData['wali_kelas']) ?></strong>
  </p>
  <hr style="border-top: 2px solid #000; margin: 8px 0;">
</div>

<!-- Header Toolbar -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 btn-toolbar-leger">
  <div>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-1 fs-7">
        <li class="breadcrumb-item"><a href="<?= base_url('guru/dashboard') ?>" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('guru/perwalian') ?>" class="text-decoration-none">Perwalian</a></li>
        <li class="breadcrumb-item active" aria-current="page">Matriks Nilai Kelas</li>
      </ol>
    </nav>
    <h4 class="fw-bold mb-1">
      Matriks Nilai Kelas: <?= esc($legerData['kelas']) ?>
    </h4>
    <p class="text-secondary small mb-0">
      Buku Kumpulan Nilai Lintas Mata Pelajaran (Leger) &bull; Wali Kelas: <strong><?= esc($legerData['wali_kelas']) ?></strong>
    </p>
  </div>

  <div class="d-flex flex-wrap align-items-center gap-2">
    <a href="<?= base_url('guru/perwalian/absensi') ?>" class="btn btn-outline-secondary btn-sm px-3">
      Edit Rekap Absensi
    </a>
    <button type="button" class="btn btn-outline-secondary btn-sm px-3" id="btnTogglePredikat">
      Tampilkan: <span id="labelModeNilai" class="fw-bold">Angka</span>
    </button>
    <button type="button" class="btn btn-outline-secondary btn-sm px-3" id="btnToggleSort">
      Urutkan: <span id="labelSort" class="fw-bold">Ranking</span>
    </button>
    <button type="button" class="btn btn-primary btn-sm px-3" onclick="window.print()">
      Cetak Matriks Nilai
    </button>
  </div>
</div>

<!-- Ringkasan Metrik Kelas -->
<div class="card border shadow-sm mb-4 stat-summary-leger">
  <div class="card-body p-3">
    <div class="row g-3 text-center text-md-start">
      <div class="col-6 col-md-3 border-end">
        <span class="text-secondary small d-block mb-1">Rata-rata Kelas</span>
        <div class="fs-4 fw-bold text-dark mb-0"><?= number_format($stats['overall_avg'], 1) ?></div>
        <span class="text-secondary fs-8">Standar KKM: 75.0</span>
      </div>

      <div class="col-6 col-md-3 border-end">
        <span class="text-secondary small d-block mb-1">Peringkat 1 Umum</span>
        <div class="fw-bold text-dark text-truncate mb-0"><?= esc($legerData['rows'][0]['nama'] ?? '-') ?></div>
        <span class="text-secondary fs-8">Rata-rata: <?= number_format($legerData['rows'][0]['rata_rata'] ?? 0, 1) ?></span>
      </div>

      <div class="col-6 col-md-3 border-end">
        <span class="text-secondary small d-block mb-1">Ketuntasan KKM Kelas</span>
        <div class="fs-4 fw-bold text-dark mb-0">
          <?= $stats['tuntas_count'] ?> <span class="text-secondary fs-6 fw-normal">/ <?= $stats['total_siswa'] ?> Siswa</span>
        </div>
        <span class="text-success fs-8 fw-semibold"><?= $stats['tuntas_percent'] ?>% Tuntas Seluruh Mapel</span>
      </div>

      <div class="col-6 col-md-3">
        <span class="text-secondary small d-block mb-1">Rentang Nilai Rata-rata</span>
        <div class="fs-4 fw-bold text-dark mb-0">
          <?= number_format($stats['min_avg'], 1) ?> &ndash; <?= number_format($stats['max_avg'], 1) ?>
        </div>
        <span class="text-secondary fs-8">Min: <?= $stats['min_avg'] ?> | Max: <?= $stats['max_avg'] ?></span>
      </div>
    </div>
  </div>
</div>

<!-- Tabel Leger Nilai Master -->
<div class="card border shadow-sm mb-4">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle mb-0 text-center table-leger" id="tableLeger">
        <thead class="table-light">
          <tr>
            <th rowspan="2" class="align-middle sticky-col-1" style="width: 42px;">No</th>
            <th rowspan="2" class="align-middle text-start sticky-col-2" style="min-width: 220px;">
              Nama Lengkap Siswa<br>
              <small class="text-secondary fw-normal">NIS</small>
            </th>
            <th colspan="<?= count($legerData['mapelList']) ?>" class="bg-body-secondary text-secondary">
              Daftar Mata Pelajaran (Skala 0 - 100)
            </th>
            <th rowspan="2" class="align-middle fw-bold bg-body-tertiary" style="min-width: 80px;">
              Jumlah<br><small class="fw-normal text-secondary">Total</small>
            </th>
            <th rowspan="2" class="align-middle fw-bold bg-body-tertiary" style="min-width: 80px;">
              Rata2<br><small class="fw-normal text-secondary">Nilai</small>
            </th>
            <th rowspan="2" class="align-middle fw-bold bg-body-tertiary" style="min-width: 75px;">
              Peringkat
            </th>
            <th colspan="3" class="bg-body-secondary text-secondary" style="min-width: 105px;">
              Presensi
            </th>
            <th rowspan="2" class="align-middle bg-body-tertiary" style="min-width: 90px;">
              Status
            </th>
          </tr>
          <tr class="table-light text-secondary fs-8">
            <?php foreach ($legerData['mapelList'] as $m): ?>
              <th style="min-width: 54px;" class="py-2" title="<?= esc($m['nama']) ?>">
                <?= esc($m['kode']) ?>
              </th>
            <?php endforeach; ?>
            <th style="width: 35px;" class="py-2" title="Sakit">S</th>
            <th style="width: 35px;" class="py-2" title="Izin">I</th>
            <th style="width: 35px;" class="py-2" title="Alpa">A</th>
          </tr>
        </thead>
        <tbody id="tbodyLeger">
          <?php $no = 1; foreach ($legerData['rows'] as $r): ?>
            <tr data-ranking="<?= $r['ranking'] ?>" data-nama="<?= esc($r['nama']) ?>" data-nis="<?= esc($r['nis']) ?>" data-no="<?= $no ?>">
              <td class="sticky-col-1 text-secondary cell-no py-2"><?= $no++ ?></td>
              <td class="text-start sticky-col-2 py-2">
                <span class="text-dark fw-semibold d-block text-truncate" style="max-width: 210px;"><?= esc($r['nama']) ?></span>
                <small class="text-secondary fs-8">NIS: <?= esc($r['nis']) ?></small>
              </td>

              <!-- Kolom Nilai per Mapel -->
              <?php foreach ($legerData['mapelList'] as $m): ?>
                <?php 
                  $score = $r['mapel_scores'][$m['kode']] ?? 0;
                  $pred = ($score >= 92) ? 'A' : (($score >= 83) ? 'B' : (($score >= 75) ? 'C' : 'D'));
                  $isUnderKkm = ($score < $m['kkm']);
                ?>
                <td class="py-2 <?= $isUnderKkm ? 'bg-danger-subtle text-danger fw-bold' : 'text-dark' ?>">
                  <span class="cell-nilai" data-score="<?= $score ?>" data-predikat="<?= $pred ?>">
                    <?= number_format($score, 0) ?>
                  </span>
                </td>
              <?php endforeach; ?>

              <!-- Total & Rata-rata -->
              <td class="fw-semibold text-dark py-2">
                <?= number_format($r['total_nilai'], 1) ?>
              </td>
              <td class="fw-bold text-dark py-2">
                <?= number_format($r['rata_rata'], 1) ?>
              </td>

              <!-- Peringkat / Ranking -->
              <td class="py-2">
                <?php if ($r['ranking'] === 1): ?>
                  <span class="badge bg-dark text-white fw-semibold px-2 py-1">
                    1
                  </span>
                <?php elseif ($r['ranking'] <= 3): ?>
                  <span class="badge bg-secondary-subtle text-dark border px-2 py-1">
                    <?= $r['ranking'] ?>
                  </span>
                <?php else: ?>
                  <span class="text-secondary fw-medium">
                    <?= $r['ranking'] ?>
                  </span>
                <?php endif; ?>
              </td>

              <!-- Absensi S / I / A -->
              <td class="py-2 text-secondary"><?= $r['sakit'] ?></td>
              <td class="py-2 text-secondary"><?= $r['izin'] ?></td>
              <td class="py-2 text-secondary"><?= $r['alpa'] ?></td>

              <!-- Status Ketuntasan -->
              <td class="py-2">
                <?php if ($r['is_tuntas']): ?>
                  <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                    Tuntas
                  </span>
                <?php else: ?>
                  <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                    Belum
                  </span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Lembar Tanda Tangan Cetak Fisik -->
<div class="mt-4 pt-3 print-signature-leger">
  <table class="table table-borderless text-center w-100" style="border:none;">
    <tr>
      <td style="width: 50%; border:none;">
        <p class="mb-0">Mengetahui,</p>
        <p class="fw-bold mb-5">Kepala SMA IT Fithrah Insani,</p>
        <p class="fw-bold text-decoration-underline mb-0"><?= esc($sekolah['nama_kepsek'] ?? 'Drs. H. Ahmad Fauzi, M.Pd.') ?></p>
        <small class="text-secondary">NIP. 197508122000031002</small>
      </td>
      <td style="width: 50%; border:none;">
        <p class="mb-0">Bandung Barat, <?= date('d F Y') ?></p>
        <p class="fw-bold mb-5">Wali Kelas <?= esc($legerData['kelas']) ?>,</p>
        <p class="fw-bold text-decoration-underline mb-0"><?= esc($legerData['wali_kelas']) ?></p>
        <small class="text-secondary">NIP. 198503152010011008</small>
      </td>
    </tr>
  </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  let isPredikatMode = false;
  let isSortedByRank = true;

  const btnTogglePredikat = document.getElementById('btnTogglePredikat');
  const labelModeNilai = document.getElementById('labelModeNilai');
  const btnToggleSort = document.getElementById('btnToggleSort');
  const labelSort = document.getElementById('labelSort');
  const tbody = document.getElementById('tbodyLeger');

  // Toggle Mode Angka vs Predikat
  btnTogglePredikat.addEventListener('click', function() {
    isPredikatMode = !isPredikatMode;
    labelModeNilai.textContent = isPredikatMode ? 'Predikat' : 'Angka';

    document.querySelectorAll('.cell-nilai').forEach(el => {
      if (isPredikatMode) {
        el.textContent = el.dataset.predikat;
      } else {
        el.textContent = Math.round(parseFloat(el.dataset.score));
      }
    });
  });

  // Toggle Sortir Ranking vs Nama/NIS
  btnToggleSort.addEventListener('click', function() {
    isSortedByRank = !isSortedByRank;
    labelSort.textContent = isSortedByRank ? 'Ranking' : 'Nama/NIS';

    const rows = Array.from(tbody.querySelectorAll('tr'));
    rows.sort((a, b) => {
      if (isSortedByRank) {
        return parseInt(a.dataset.ranking) - parseInt(b.dataset.ranking);
      } else {
        return a.dataset.nama.localeCompare(b.dataset.nama);
      }
    });

    tbody.innerHTML = '';
    rows.forEach((r, idx) => {
      r.querySelector('.cell-no').textContent = idx + 1;
      tbody.appendChild(r);
    });
  });
});
</script>

<?= $this->endSection() ?>
