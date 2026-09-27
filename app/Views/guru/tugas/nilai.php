<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb & Header Navigasi -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
  <div>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-1 small">
        <li class="breadcrumb-item"><a href="<?= base_url('guru/dashboard') ?>" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('guru/tugas/' . $pengajaran['id']) ?>" class="text-decoration-none">Tugas &amp; UH</a></li>
        <li class="breadcrumb-item active" aria-current="page">Penilaian</li>
      </ol>
    </nav>
    <h4 class="fw-bold mb-1">
      Input Nilai: <?= esc($tugas['judul']) ?>
    </h4>
    <div class="text-secondary small">
      Mata Pelajaran: <strong class="text-body"><?= esc($pengajaran['mapel_nama']) ?></strong>
      &bull; Kelas: <strong class="text-body"><?= esc($pengajaran['kelas_nama']) ?></strong>
      &bull; Komponen: <strong class="text-body"><?= esc($tugas['komponen']) ?></strong>
      &bull; KKM: <strong class="text-body"><?= number_format($pengajaran['kkm'], 0) ?></strong>
      &bull; Tanggal: <?= date('d F Y', strtotime($tugas['tanggal'])) ?>
    </div>
  </div>

  <div class="d-flex flex-wrap gap-2">
    <!-- Switcher Cepat Tugas / UH -->
    <div class="dropdown">
      <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        Pilih Tugas / UH Lain
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow-sm">
        <li><h6 class="dropdown-header">Daftar Evaluasi Kelas <?= esc($pengajaran['kelas_nama']) ?></h6></li>
        <?php foreach ($tugasList as $item): ?>
          <li>
            <a class="dropdown-item d-flex justify-content-between align-items-center <?= ($item['id'] == $tugas['id']) ? 'active' : '' ?>" 
               href="<?= base_url('guru/tugas/' . $pengajaran['id'] . '/nilai/' . $item['id']) ?>">
              <span><?= esc($item['judul']) ?></span>
              <small class="text-secondary ms-2">
                <?= str_contains($item['komponen'], 'UH') ? 'UH' : 'Tugas' ?>
              </small>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <a href="<?= base_url('guru/tugas/' . $pengajaran['id']) ?>" class="btn btn-outline-secondary btn-sm">
      Kembali ke Daftar
    </a>
  </div>
</div>

<!-- Helper Integrasi Nilai -->
<div class="card bg-body-tertiary border mb-3">
  <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 small">
    <div>
      <span class="fw-semibold text-body">Kalkulasi Otomatis:</span>
      <span class="text-secondary ms-1">Nilai yang disimpan akan otomatis diakumulasikan ke rata-rata komponen <strong><?= esc($tugas['komponen']) ?></strong> di buku nilai utama.</span>
    </div>
    <div>
      <a href="<?= base_url('guru/nilai/' . $pengajaran['id'] . '/pengetahuan') ?>" class="btn btn-outline-secondary btn-sm">
        Buka Buku Nilai Mapel
      </a>
    </div>
  </div>
</div>

<!-- Statistik Ringkas Tugas Ini (Unified KPI Strip) -->
<div class="card mb-4 border">
  <div class="card-body p-3">
    <div class="row g-3 text-center text-md-start">
      <div class="col-6 col-md-3 border-end-md">
        <div class="text-secondary small">Rata-rata Kelas</div>
        <div class="fs-4 fw-bold text-body" id="statAvgKelas"><?= number_format($stats['rata_rata'], 1) ?></div>
        <div class="text-secondary small">Standar KKM: <?= number_format($pengajaran['kkm'], 0) ?></div>
      </div>
      <div class="col-6 col-md-3 border-end-md">
        <div class="text-secondary small">Nilai Tertinggi</div>
        <div class="fs-4 fw-bold text-body" id="statMaxNilai"><?= $stats['tertinggi'] ?></div>
        <div class="text-secondary small">Skor tertinggi siswa</div>
      </div>
      <div class="col-6 col-md-3 border-end-md">
        <div class="text-secondary small">Nilai Terendah</div>
        <div class="fs-4 fw-bold text-body" id="statMinNilai"><?= $stats['terendah'] ?></div>
        <div class="text-secondary small">Perlu evaluasi</div>
      </div>
      <div class="col-6 col-md-3">
        <div class="text-secondary small">Ketuntasan KKM</div>
        <div class="fs-4 fw-bold text-body">
          <span id="statTuntasCount" class="text-success"><?= $stats['tuntas_count'] ?></span>
          <span class="text-secondary fs-6 fw-normal">/ <?= $stats['total_siswa'] ?></span>
        </div>
        <div class="text-secondary small" id="statRemedialCount">Remedial: <?= $stats['remedial_count'] ?> siswa</div>
      </div>
    </div>
  </div>
</div>

<!-- Form Penilaian Siswa -->
<form action="<?= base_url('guru/tugas/' . $pengajaran['id'] . '/nilai/' . $tugas['id']) ?>" method="post" id="formNilaiTugas">
  <?= csrf_field() ?>
  <input type="hidden" name="judul_tugas" value="<?= esc($tugas['judul']) ?>">

  <div class="card border mb-4">
    <div class="card-header bg-body d-flex justify-content-between align-items-center py-2 px-3">
      <span class="fw-semibold small">Daftar Nilai Siswa (<?= count($siswaNilaiList) ?> Siswa)</span>
      <span class="text-secondary small">Skala Penilaian: 0 &ndash; 100</span>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 48px;" class="text-center">No</th>
              <th style="min-width: 220px;">Nama Siswa</th>
              <th style="width: 140px;" class="text-center">Nilai (0-100)</th>
              <th style="width: 130px;" class="text-center">Status KKM</th>
              <th style="min-width: 260px;">Catatan Koreksi / Feedback Guru</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($siswaNilaiList as $row): ?>
              <tr>
                <td class="text-center text-secondary"><?= $no++ ?></td>
                <td>
                  <div class="fw-medium text-body"><?= esc($row['nama']) ?></div>
                  <small class="text-secondary">NIS: <?= esc($row['nis']) ?></small>
                </td>
                <td class="text-center">
                  <input type="number" 
                         name="nilai[<?= $row['siswa_id'] ?>]" 
                         value="<?= $row['nilai'] ?>" 
                         min="0" 
                         max="100" 
                         step="0.5" 
                         class="form-control form-control-sm text-center fw-bold input-nilai-item" 
                         data-siswa-id="<?= $row['siswa_id'] ?>"
                         placeholder="0"
                         required>
                </td>
                <td class="text-center">
                  <span id="badgeStatus_<?= $row['siswa_id'] ?>" 
                        class="<?= ($row['nilai'] >= $pengajaran['kkm']) ? 'text-success fw-medium' : 'text-danger fw-semibold' ?>">
                    <?= ($row['nilai'] >= $pengajaran['kkm']) ? 'Tuntas' : 'Remedial' ?>
                  </span>
                </td>
                <td>
                  <input type="text" 
                         name="catatan[<?= $row['siswa_id'] ?>]" 
                         value="<?= esc($row['catatan']) ?>" 
                         class="form-control form-control-sm" 
                         placeholder="Tuliskan catatan hasil koreksi / instruksi remedial...">
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Sticky Save Bar -->
  <div class="sticky-bottom-bar d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 shadow-sm border">
    <div class="text-secondary small">
      Menyimpan nilai akan otomatis mengalkulasi rata-rata <strong><?= esc($tugas['komponen']) ?></strong> kelas <?= esc($pengajaran['kelas_nama']) ?>.
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="<?= base_url('guru/nilai/' . $pengajaran['id'] . '/pengetahuan') ?>" class="btn btn-outline-secondary btn-sm px-3">
        Lihat di Buku Nilai Siswa
      </a>
      <button type="submit" class="btn btn-primary btn-sm px-4">
        Simpan Nilai &amp; Hitung Rata-rata
      </button>
    </div>
  </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const kkm = <?= (float)$pengajaran['kkm'] ?>;
  const inputs = document.querySelectorAll('.input-nilai-item');

  function updateLiveStats() {
    let values = [];
    let tuntas = 0;
    let remedial = 0;

    inputs.forEach(input => {
      const val = parseFloat(input.value);
      const siswaId = input.dataset.siswaId;
      const badge = document.getElementById('badgeStatus_' + siswaId);

      if (!isNaN(val)) {
        values.push(val);
        if (val >= kkm) {
          tuntas++;
          if (badge) {
            badge.className = 'text-success fw-medium';
            badge.textContent = 'Tuntas';
          }
        } else {
          remedial++;
          if (badge) {
            badge.className = 'text-danger fw-semibold';
            badge.textContent = 'Remedial';
          }
        }
      }
    });

    if (values.length > 0) {
      const avg = values.reduce((a, b) => a + b, 0) / values.length;
      const max = Math.max(...values);
      const min = Math.min(...values);

      const elAvg = document.getElementById('statAvgKelas');
      const elMax = document.getElementById('statMaxNilai');
      const elMin = document.getElementById('statMinNilai');
      const elTuntas = document.getElementById('statTuntasCount');
      const elRemedial = document.getElementById('statRemedialCount');

      if (elAvg) elAvg.textContent = avg.toFixed(1);
      if (elMax) elMax.textContent = max;
      if (elMin) elMin.textContent = min;
      if (elTuntas) elTuntas.textContent = tuntas;
      if (elRemedial) elRemedial.textContent = 'Remedial: ' + remedial + ' siswa';
    }
  }

  inputs.forEach(input => {
    input.addEventListener('input', updateLiveStats);
  });
});
</script>

<?= $this->endSection() ?>

