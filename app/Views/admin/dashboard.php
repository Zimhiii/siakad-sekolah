<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
  <div>
    <h4 class="fw-bold mb-1">Dashboard Administrator</h4>
    <p class="text-secondary small mb-0">Ringkasan statistik dan operasional akademik sekolah</p>
  </div>
</div>

<?php if (!empty($unlockRequestsPending)): ?>
  <!-- Permohonan Buka Kunci Pending -->
  <div class="card bg-body-tertiary border mb-4">
    <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 small">
      <div>
        <span class="fw-semibold text-danger">Permohonan Persetujuan Raport:</span>
        <span class="text-secondary ms-1">Terdapat <?= count($unlockRequestsPending) ?> permohonan buka kunci raport menunggu peninjauan Anda.</span>
      </div>
      <div>
        <a href="<?= base_url('admin/raport/buka-kunci') ?>" class="btn btn-outline-secondary btn-sm">
          Tinjau Permohonan
        </a>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- Baris 1: 4 Kartu Metrik Ringkas -->
<div class="card mb-4 border">
  <div class="card-body p-3">
    <div class="row g-3 text-center text-md-start">
      <div class="col-6 col-xl-3 border-end-md">
        <div class="text-secondary small">Total Siswa Aktif</div>
        <div class="fs-4 fw-bold text-body"><?= esc($stats['total_siswa']) ?></div>
        <div class="mt-1">
          <a href="<?= base_url('admin/siswa') ?>" class="small text-decoration-none">
            Lihat Data Siswa &rarr;
          </a>
        </div>
      </div>
      <div class="col-6 col-xl-3 border-end-md">
        <div class="text-secondary small">Total Guru &amp; Pengajar</div>
        <div class="fs-4 fw-bold text-body"><?= esc($stats['total_guru']) ?></div>
        <div class="mt-1">
          <a href="<?= base_url('admin/guru') ?>" class="small text-decoration-none">
            Lihat Data Guru &rarr;
          </a>
        </div>
      </div>
      <div class="col-6 col-xl-3 border-end-md">
        <div class="text-secondary small">Jumlah Rombel / Kelas</div>
        <div class="fs-4 fw-bold text-body"><?= esc($stats['total_kelas']) ?></div>
        <div class="mt-1">
          <a href="<?= base_url('admin/kelas') ?>" class="small text-decoration-none">
            Kelola Rombel &rarr;
          </a>
        </div>
      </div>
      <div class="col-6 col-xl-3">
        <div class="text-secondary small">Tahun Ajaran &amp; Semester</div>
        <div class="fs-5 fw-bold text-body text-truncate"><?= esc($stats['ta_status'] ?? '2025/2026 Ganjil') ?></div>
        <div class="mt-1">
          <a href="<?= base_url('admin/tahun-ajaran') ?>" class="small text-decoration-none">
            Kelola Tahun Ajaran &rarr;
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Baris 2: Grafik Distribusi Siswa & Tabel Ringkas TA -->
<div class="row g-3 mb-4">
  <div class="col-lg-7">
    <div class="card h-100 border">
      <div class="card-header bg-body d-flex justify-content-between align-items-center py-2 px-3">
        <span class="fw-semibold small text-secondary">Jumlah Siswa per Tingkatan &amp; Jurusan</span>
        <span class="text-secondary small">T.A. 2025/2026</span>
      </div>
      <div class="card-body">
        <div id="chart-siswa-tingkatan" style="min-height: 280px;"></div>
      </div>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="card h-100 border">
      <div class="card-header bg-body d-flex justify-content-between align-items-center py-2 px-3">
        <span class="fw-semibold small text-secondary">Tahun Ajaran &amp; Status</span>
        <a href="<?= base_url('admin/wizard/1') ?>" class="btn btn-primary btn-sm">
          + Tahun Ajaran Baru
        </a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>Tahun Ajaran</th>
                <th>Periode</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($ta_list as $ta): ?>
                <tr>
                  <td class="fw-medium"><?= esc($ta['nama']) ?></td>
                  <td class="text-secondary small">
                    <?= date('d M Y', strtotime($ta['tanggal_mulai'])) ?> - <?= date('d M Y', strtotime($ta['tanggal_selesai'])) ?>
                  </td>
                  <td>
                    <?php if ($ta['status'] === 'aktif'): ?>
                      <span class="badge bg-success-subtle text-success border border-success-subtle fw-normal">Aktif</span>
                    <?php elseif ($ta['status'] === 'draft'): ?>
                      <span class="badge bg-secondary-subtle text-secondary border fw-normal">Draft</span>
                    <?php else: ?>
                      <span class="badge bg-secondary-subtle text-secondary border fw-normal">Selesai</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer bg-body text-end py-2 px-3">
        <a href="<?= base_url('admin/tahun-ajaran') ?>" class="text-decoration-none small">
          Lihat Detail Semester &rarr;
        </a>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const options = {
      series: [
        { name: 'MIPA', data: [42, 38, 32] },
        { name: 'IPS', data: [24, 22, 19] }
      ],
      chart: {
        type: 'bar',
        height: 280,
        toolbar: { show: false }
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          borderRadius: 4
        },
      },
      dataLabels: { enabled: false },
      stroke: { show: true, width: 2, colors: ['transparent'] },
      xaxis: {
        categories: ['Kelas 10', 'Kelas 11', 'Kelas 12'],
      },
      yaxis: {
        title: { text: 'Jumlah Siswa' }
      },
      fill: { opacity: 1 },
      colors: ['#0d6efd', '#2CA58D'],
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " Siswa";
          }
        }
      }
    };

    const chart = new ApexCharts(document.querySelector("#chart-siswa-tingkatan"), options);
    chart.render();
  });
</script>
<?= $this->endSection() ?>

