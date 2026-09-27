<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">Data Induk Siswa</h4>
    <p class="text-secondary small mb-0">Database biodata siswa, NISN nasional, status rombel, dan mutasi</p>
  </div>
  <a href="<?= base_url('admin/siswa/tambah') ?>" class="btn btn-primary btn-sm">
    + Tambah Siswa
  </a>
</div>

<div class="card border">
  <div class="card-header bg-body py-2 px-3">
    <div class="row g-2 align-items-center">
      <div class="col-md-4">
        <input type="text" class="form-control form-control-sm" placeholder="Cari NIS / NISN / Nama siswa...">
      </div>
      <div class="col-md-3">
        <select class="form-select form-select-sm">
          <option value="">Semua Rombel (Kelas)</option>
          <?php foreach ($kelasList as $k): ?>
            <option value="<?= $k['id'] ?>"><?= esc($k['nama_kelas']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-5 text-md-end">
        <span class="text-secondary small"><?= count($siswaList) ?> siswa terdaftar</span>
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 60px;">No</th>
            <th>Nama Lengkap Siswa</th>
            <th>NIS</th>
            <th>NISN</th>
            <th>Kelas / Rombel</th>
            <th>Status</th>
            <th class="text-end" style="width: 240px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($siswaList)): ?>
            <tr>
              <td colspan="7" class="text-center text-secondary small py-4">Belum ada data akun siswa</td>
            </tr>
          <?php else: ?>
            <?php $no = 1; foreach ($siswaList as $s): ?>
              <tr>
                <td class="font-monospace text-secondary small"><?= $no++ ?></td>
                <td>
                  <a href="<?= base_url('admin/siswa/detail/' . $s['id']) ?>" class="fw-semibold text-body text-decoration-none small d-block">
                    <?= esc($s['nama']) ?>
                  </a>
                  <div class="text-secondary small"><?= ($s['jenis_kelamin'] === 'L') ? 'Laki-laki' : 'Perempuan' ?> &bull; <?= esc($s['sekolah_asal']) ?></div>
                </td>
                <td><span class="font-monospace small text-secondary"><?= esc($s['nis']) ?></span></td>
                <td><span class="font-monospace small text-secondary"><?= esc($s['nisn']) ?></span></td>
                <td>
                  <?php if ($s['kelas_nama']): ?>
                    <span class="badge bg-secondary-subtle text-secondary border"><?= esc($s['kelas_nama']) ?></span>
                  <?php else: ?>
                    <span class="text-secondary small">-</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($s['status'] === 'aktif'): ?>
                    <span class="text-success small fw-medium">Aktif</span>
                  <?php elseif ($s['status'] === 'lulus'): ?>
                    <span class="text-secondary small fw-medium">Lulus</span>
                  <?php else: ?>
                    <span class="text-warning small fw-medium">Mutasi</span>
                  <?php endif; ?>
                </td>
                <td class="text-end">
                  <a href="<?= base_url('admin/siswa/detail/' . $s['id']) ?>" class="btn btn-outline-primary btn-sm py-0 px-2" title="Lihat Profil Lengkap">Detail</a>
                  <a href="<?= base_url('admin/siswa/edit/' . $s['id']) ?>" class="btn btn-outline-secondary btn-sm py-0 px-2" title="Edit">Edit</a>
                  <button class="btn btn-outline-secondary btn-sm py-0 px-2" title="Mutasi Siswa" data-bs-toggle="modal" data-bs-target="#modalMutasiSiswa" data-id="<?= esc($s['id']) ?>" data-nama="<?= esc($s['nama']) ?>">Mutasi</button>
                  <button class="btn btn-outline-danger btn-sm py-0 px-2" title="Nonaktifkan Siswa" data-bs-toggle="modal" data-bs-target="#modalNonaktifkanSiswa" data-id="<?= esc($s['id']) ?>" data-nama="<?= esc($s['nama']) ?>">Nonaktifkan</button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi Nonaktifkan Siswa (OPEN STATE) -->
<div class="modal show" id="modalNonaktifkanSiswa" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Akun Siswa">
        <input type="hidden" name="redirect_url" value="/admin/siswa">
        <input type="hidden" name="siswa_id" id="nonaktifkanSiswaId" value="1">
        <div class="modal-header">
          <h6 class="modal-title fw-semibold text-danger">Nonaktifkan Siswa</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center py-3">
          <p class="small mb-0">Yakin ingin menonaktifkan akun siswa <strong id="nonaktifkanNamaSiswa"><?= esc($siswaList[0]['nama'] ?? 'Muhammad Raihan Pratama') ?></strong>?</p>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger btn-sm px-3">Ya, Nonaktifkan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Mutasi Siswa -->
<div class="modal fade" id="modalMutasiSiswa" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <div class="modal-header">
        <h6 class="modal-title fw-semibold">Mutasi Siswa</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    </div>
  </div>
</div>

<!-- Static Modal Backdrop for Figma Export -->
<div class="modal-backdrop show"></div>
<style>body { overflow: hidden; }</style>

<?= $this->endSection() ?>
