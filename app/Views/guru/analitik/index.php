<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
  <div>
    <h4 class="fw-bold mb-1">
      Analitik Nilai: <?= ($variant === 'wali') ? 'Kelas Perwalian (XI-MIPA-1)' : esc($pengajaran['mapel_nama']) ?>
    </h4>
    <p class="text-secondary small mb-0">Distribusi statistik capaian kompetensi dan evaluasi ketuntasan KKM</p>
  </div>
  <div class="btn-group btn-group-sm">
    <a href="<?= base_url('guru/analitik/' . $pengajaran['id'] . '/mapel') ?>" class="btn <?= ($variant === 'mapel') ? 'btn-primary' : 'btn-outline-secondary' ?>">
      Analitik Mapel
    </a>
    <a href="<?= base_url('guru/analitik/' . $pengajaran['id'] . '/wali') ?>" class="btn <?= ($variant === 'wali') ? 'btn-primary' : 'btn-outline-secondary' ?>">
      Analitik Lintas Mapel (Wali Kelas)
    </a>
  </div>
</div>

<!-- KPI Metric Strip -->
<div class="card mb-4 border">
  <div class="card-body p-3">
    <div class="row g-3 text-center text-md-start">
      <div class="col-md-4 border-end-md">
        <div class="text-secondary small">Nilai Rata-rata Kelas</div>
        <div class="fs-4 fw-bold text-body"><?= $stats['rata_rata'] ?></div>
        <div class="text-secondary small">Standar KKM: 75.0</div>
      </div>
      <div class="col-md-4 border-end-md">
        <div class="text-secondary small">Nilai Tertinggi Siswa</div>
        <div class="fs-4 fw-bold text-body"><?= $stats['tertinggi'] ?></div>
        <div class="text-secondary small">Predikat A (Sangat Baik)</div>
      </div>
      <div class="col-md-4">
        <div class="text-secondary small">Nilai Terendah</div>
        <div class="fs-4 fw-bold text-body"><?= $stats['terendah'] ?></div>
        <div class="text-danger small fw-medium"><?= $stats['remedial_count'] ?> siswa di bawah KKM</div>
      </div>
    </div>
  </div>
</div>

<!-- Grafik ApexCharts -->
<div class="card mb-4 border">
  <div class="card-header bg-body py-2 px-3">
    <span class="fw-semibold small text-secondary">
      <?= ($variant === 'wali') ? 'Grafik Radar Rata-Rata Seluruh Mapel XI-MIPA-1' : 'Distribusi Nilai Siswa (Histogram Rentang Nilai)' ?>
    </span>
  </div>
  <div class="card-body">
    <div id="chart-analitik" style="min-height: 320px;"></div>
  </div>
</div>

<!-- Tabel Siswa di Bawah KKM -->
<div class="card border">
  <div class="card-header bg-body py-2 px-3 d-flex justify-content-between align-items-center">
    <span class="fw-semibold small text-danger">
      Daftar Siswa Belum Tuntas (Di Bawah KKM 75.00)
    </span>
    <span class="text-secondary small">
      Total: <?= count($siswaBawahKkm) ?> siswa
    </span>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 120px;">NIS</th>
            <th>Nama Lengkap Siswa</th>
            <th style="width: 110px;" class="text-center">Nilai Akhir</th>
            <th style="width: 120px;" class="text-center">Selisih KKM</th>
            <th>Rekomendasi Tindak Lanjut</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($siswaBawahKkm as $sb): ?>
            <tr>
              <td class="text-secondary font-monospace small"><?= esc($sb['nis']) ?></td>
              <td class="text-body fw-medium"><?= esc($sb['nama']) ?></td>
              <td class="text-center text-danger fw-bold"><?= esc($sb['nilai_akhir']) ?></td>
              <td class="text-center text-danger font-monospace small">-<?= $sb['kkm'] - $sb['nilai_akhir'] ?> Poin</td>
              <td class="text-body small"><?= esc($sb['rekomendasi']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const isWali = "<?= $variant ?>" === "wali";
    let options;

    if (isWali) {
      options = {
        series: [{
          name: 'Rata-rata Rombel',
          data: [92, 85, 88, 91, 84, 89, 87, 90, 86, 94]
        }],
        chart: {
          height: 320,
          type: 'radar',
          toolbar: { show: false }
        },
        xaxis: {
          categories: ['PAI', 'PPKN', 'B.Indo', 'MTK Wajib', 'Sejarah', 'B.Inggris', 'Seni', 'PJOK', 'PKWU', 'MTK Minat']
        },
        colors: ['#0d6efd']
      };
    } else {
      options = {
        series: [{
          name: 'Jumlah Siswa',
          data: [2, 5, 14, 10]
        }],
        chart: {
          type: 'bar',
          height: 320,
          toolbar: { show: false }
        },
        plotOptions: {
          bar: { borderRadius: 4, horizontal: false, columnWidth: '45%' }
        },
        xaxis: {
          categories: ['< 75 (D)', '75 - 82 (C)', '83 - 90 (B)', '91 - 100 (A)']
        },
        colors: ['#dc3545', '#ffc107', '#0d6efd', '#198754']
      };
    }

    const chart = new ApexCharts(document.querySelector("#chart-analitik"), options);
    chart.render();
  });
</script>
<?= $this->endSection() ?>

