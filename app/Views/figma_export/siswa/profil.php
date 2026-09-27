<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
  <div class="col-lg-9">
    
    <!-- Profil Header -->
    <div class="card mb-4 text-center p-4">
      <img src="<?= esc($siswa['foto_path']) ?>" alt="<?= esc($siswa['nama']) ?>" class="rounded-circle border mx-auto mb-3" width="96" height="96">
      <h4 class="fw-bold mb-1"><?= esc($siswa['nama']) ?></h4>
      <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 text-secondary small">
        <span>NIS: <span class="font-monospace text-body fw-medium"><?= esc($siswa['nis']) ?></span></span>
        <span>&bull;</span>
        <span>NISN: <span class="font-monospace text-body fw-medium"><?= esc($siswa['nisn']) ?></span></span>
        <span>&bull;</span>
        <span>Rombel: <span class="badge bg-secondary-subtle text-secondary-emphasis border"><?= esc($siswa['kelas_nama']) ?></span></span>
      </div>
    </div>

    <!-- Data Diri Siswa -->
    <div class="card mb-4">
      <div class="card-header bg-body py-3">
        <h6 class="mb-0 fw-semibold">Data Diri Lengkap Siswa</h6>
      </div>
      <div class="card-body p-4">
        <div class="row g-3 small">
          <div class="col-md-6 border-bottom pb-2">
            <span class="text-secondary d-block">Tempat, Tanggal Lahir</span>
            <strong class="text-body"><?= esc($siswa['tempat_lahir']) ?>, <?= date('d F Y', strtotime($siswa['tanggal_lahir'])) ?></strong>
          </div>
          <div class="col-md-3 border-bottom pb-2">
            <span class="text-secondary d-block">Jenis Kelamin</span>
            <strong class="text-body"><?= ($siswa['jenis_kelamin'] === 'L') ? 'Laki-laki' : 'Perempuan' ?></strong>
          </div>
          <div class="col-md-3 border-bottom pb-2">
            <span class="text-secondary d-block">Agama</span>
            <strong class="text-body"><?= esc($siswa['agama']) ?></strong>
          </div>
          <div class="col-md-6 border-bottom pb-2">
            <span class="text-secondary d-block">Asal Sekolah</span>
            <strong class="text-body"><?= esc($siswa['sekolah_asal']) ?></strong>
          </div>
          <div class="col-md-6 border-bottom pb-2">
            <span class="text-secondary d-block">Status dalam Keluarga</span>
            <strong class="text-body"><?= esc($siswa['status_dalam_keluarga']) ?> (Anak ke-<?= esc($siswa['anak_ke']) ?>)</strong>
          </div>
          <div class="col-12">
            <span class="text-secondary d-block">Alamat Domisili</span>
            <strong class="text-body"><?= esc($siswa['alamat']) ?></strong>
          </div>
        </div>
      </div>
    </div>

    <!-- Data Orang Tua/Wali -->
    <div class="card mb-4">
      <div class="card-header bg-body py-3">
        <h6 class="mb-0 fw-semibold">Data Orang Tua / Wali</h6>
      </div>
      <div class="card-body p-4">
        <div class="row g-3">
          <?php if (!empty($siswa['ortu'])): ?>
            <?php foreach ($siswa['ortu'] as $ortu): ?>
              <div class="col-md-6">
                <div class="p-3 border rounded bg-body-tertiary">
                  <span class="badge bg-secondary-subtle text-secondary-emphasis border text-uppercase mb-2"><?= esc($ortu['jenis']) ?></span>
                  <h6 class="fw-semibold text-body mb-2"><?= esc($ortu['nama']) ?></h6>
                  <div class="small text-secondary mb-1">Pekerjaan: <strong class="text-body"><?= esc($ortu['pekerjaan']) ?></strong></div>
                  <div class="small text-secondary">Telepon: <span class="font-monospace text-body"><?= esc($ortu['telepon']) ?></span></div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Riwayat Kelas & Multi-Semester Siswa (siswa_riwayat_kelas) -->
    <div class="card">
      <div class="card-header bg-body py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold">Riwayat Penempatan Kelas &amp; Prestasi Akademik</h6>
        <span class="badge bg-secondary-subtle text-secondary-emphasis border"><?= count($riwayatKelas ?? []) ?> Semester</span>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light">
              <tr>
                <th>Tahun Ajaran</th>
                <th>Semester</th>
                <th>Kelas</th>
                <th>No. Absen</th>
                <th>Rata-rata</th>
                <th>Peringkat</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($riwayatKelas)): ?>
                <?php foreach ($riwayatKelas as $rk): ?>
                  <tr>
                    <td class="fw-semibold text-primary"><?= esc($rk['tahun_ajaran_nama']) ?></td>
                    <td>
                      <span class="badge bg-secondary-subtle text-secondary-emphasis border">
                        <?= esc($rk['semester_nama']) ?>
                      </span>
                    </td>
                    <td><span class="badge bg-secondary-subtle text-secondary-emphasis border"><?= esc($rk['kelas_nama']) ?></span></td>
                    <td><span class="font-monospace"><?= esc($rk['urutan_absen'] ?? '-') ?></span></td>
                    <td><span class="font-monospace fw-bold"><?= isset($rk['rata_rata']) ? number_format($rk['rata_rata'], 1) : '<span class="text-muted fst-italic">Sedang Berjalan</span>' ?></span></td>
                    <td><span class="font-monospace"><?= isset($rk['ranking']) ? '#' . $rk['ranking'] : '-' ?></span></td>
                    <td>
                      <?php
                        $badgeClass = match($rk['status_siswa']) {
                          'Aktif' => 'bg-success-subtle text-success-emphasis border border-success-subtle',
                          'Naik' => 'bg-info-subtle text-info-emphasis border border-info-subtle',
                          'Lulus' => 'bg-primary-subtle text-primary border border-primary-subtle',
                          'Pindah Keluar' => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
                          'Tinggal Kelas' => 'bg-danger-subtle text-danger border border-danger-subtle',
                          default => 'bg-secondary-subtle text-secondary-emphasis border'
                        };
                      ?>
                      <span class="badge <?= $badgeClass ?>"><?= esc($rk['status_siswa']) ?></span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="text-center text-muted py-4">Belum ada riwayat kelas tercatat.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>

<?= $this->endSection() ?>
