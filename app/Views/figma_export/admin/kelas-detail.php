<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
  <div>
    <a href="<?= base_url('admin/kelas') ?>" class="text-decoration-none small text-secondary">
      &larr; Kembali ke Daftar Kelas
    </a>
    <h4 class="fw-bold mb-1">Rombel: <?= esc($kelas['nama_kelas']) ?></h4>
  </div>
  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSiswaKelas">
    + Tambah Siswa ke Kelas
  </button>
</div>

<!-- Header Info Kelas -->
<div class="card mb-4 border">
  <div class="card-body p-3">
    <div class="row align-items-center g-3 text-center text-md-start">
      <div class="col-md-3 border-end-md">
        <span class="text-secondary small d-block">Wali Kelas Pengampu:</span>
        <span class="fw-bold text-body"><?= esc($kelas['wali_kelas_nama']) ?></span>
      </div>
      <div class="col-md-3 border-end-md">
        <span class="text-secondary small d-block">Tingkatan &amp; Jurusan:</span>
        <span class="text-body fw-medium"><?= esc($kelas['tingkatan_nama']) ?> &bull; <?= esc($kelas['jurusan_kode'] ?? 'Umum') ?></span>
      </div>
      <div class="col-md-3 border-end-md">
        <span class="text-secondary small d-block">Jumlah Siswa Terdaftar:</span>
        <span class="fw-bold text-body"><?= count($siswaInKelas) ?> / <?= $kelas['kapasitas_max'] ?> Siswa</span>
      </div>
      <div class="col-md-3 text-md-end">
        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.print()">Cetak Presensi Kelas</button>
      </div>
    </div>
  </div>
</div>

<!-- Tabel Siswa dalam Kelas -->
<div class="card border">
  <div class="card-header bg-body py-2 px-3 d-flex justify-content-between align-items-center">
    <span class="fw-semibold small text-secondary">Daftar Siswa dalam Rombel</span>
    <span class="text-secondary small">Total <?= count($siswaInKelas) ?> Siswa</span>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 48px;" class="text-center">No</th>
            <th style="width: 120px;">NIS</th>
            <th style="width: 120px;">NISN</th>
            <th>Nama Lengkap Siswa</th>
            <th>Jenis Kelamin</th>
            <th>Status</th>
            <th class="text-end" style="width: 160px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($siswaInKelas)): ?>
            <tr>
              <td colspan="7" class="text-center py-4 text-secondary">Belum ada siswa yang dimasukkan ke kelas ini.</td>
            </tr>
          <?php else: ?>
            <?php $no = 1; foreach ($siswaInKelas as $s): ?>
              <tr>
                <td class="text-center text-secondary"><?= $no++ ?></td>
                <td><span class="text-secondary font-monospace small"><?= esc($s['nis']) ?></span></td>
                <td class="text-secondary font-monospace small"><?= esc($s['nisn']) ?></td>
                <td>
                  <a href="<?= base_url('admin/siswa/detail/' . $s['id']) ?>" class="text-decoration-none text-body fw-medium">
                    <?= esc($s['nama']) ?>
                  </a>
                </td>
                <td class="text-secondary small"><?= ($s['jenis_kelamin'] === 'L') ? 'Laki-laki' : 'Perempuan' ?></td>
                <td><span class="badge bg-success-subtle text-success border border-success-subtle fw-normal">Aktif</span></td>
                <td class="text-end">
                  <div class="d-inline-flex gap-1">
                    <a href="<?= base_url('admin/siswa/detail/' . $s['id']) ?>" class="btn btn-outline-secondary btn-sm">
                      Profil
                    </a>
                    <button type="button" class="btn btn-outline-danger btn-sm" title="Keluarkan dari Kelas" data-bs-toggle="modal" data-bs-target="#modalKeluarkanSiswa" data-nama="<?= esc($s['nama']) ?>" data-kelas="<?= esc($kelas['nama_kelas']) ?>">
                      Keluarkan
                    </button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Siswa ke Kelas -->
<div class="modal fade" id="modalTambahSiswaKelas" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Penambahan Siswa ke Rombel">
        <input type="hidden" name="redirect_url" value="/admin/kelas/detail/<?= $kelas['id'] ?>">

        <div class="modal-header">
          <h5 class="modal-title fw-semibold">Tambah Siswa ke Rombel <?= esc($kelas['nama_kelas']) ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="text-secondary small mb-3">Pilih siswa yang belum memiliki rombel (Unassigned) untuk dimasukkan ke kelas ini:</p>
          
          <div class="table-responsive border rounded" style="max-height: 280px;">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light sticky-top">
                <tr>
                  <th style="width: 40px;"><input type="checkbox" class="form-check-input"></th>
                  <th>NIS</th>
                  <th>Nama Siswa</th>
                  <th>Jenis Kelamin</th>
                  <th>Asal Sekolah</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($siswaUnassigned)): ?>
                  <?php foreach ($siswaUnassigned as $su): ?>
                    <tr>
                      <td><input type="checkbox" name="siswa_ids[]" value="<?= $su['id'] ?>" class="form-check-input"></td>
                      <td class="text-secondary font-monospace small"><?= esc($su['nis']) ?></td>
                      <td class="fw-medium text-body"><?= esc($su['nama']) ?></td>
                      <td class="text-secondary small"><?= ($su['jenis_kelamin'] === 'L') ? 'Laki-laki' : 'Perempuan' ?></td>
                      <td class="text-secondary small"><?= esc($su['sekolah_asal'] ?? '-') ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center text-secondary py-3">Tidak ada siswa yang berstatus Unassigned (Semua siswa telah teralokasikan ke kelas).</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-4">Tambahkan Siswa Terpilih</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi Keluarkan Siswa -->
<div class="modal fade" id="modalKeluarkanSiswa" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Keluarkan Siswa dari Rombel">
        <input type="hidden" name="redirect_url" value="/admin/kelas/detail/<?= $kelas['id'] ?>">
        <div class="modal-header">
          <h6 class="modal-title text-danger fw-semibold">Keluarkan dari Kelas</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center py-3">
          <p class="mb-0 small">Yakin ingin mengeluarkan <strong id="keluarkanNamaSiswa">-</strong> dari kelas <strong id="keluarkanKelasSiswa"><?= esc($kelas['nama_kelas']) ?></strong>?</p>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger btn-sm px-3">Ya, Keluarkan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('[data-bs-target="#modalKeluarkanSiswa"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('keluarkanNamaSiswa').textContent = this.dataset.nama || '';
    document.getElementById('keluarkanKelasSiswa').textContent = this.dataset.kelas || '';
  });
});
</script>

<?= $this->endSection() ?>

