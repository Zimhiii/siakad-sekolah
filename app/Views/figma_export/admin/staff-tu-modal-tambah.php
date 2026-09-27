<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">Akun Staff Tata Usaha (TU)</h4>
    <p class="text-secondary small mb-0">Manajemen akun pengelola persuratan, kearsipan, dan administrasi sekolah</p>
  </div>
  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahStaff">
    + Tambah Staff TU
  </button>
</div>

<div class="card border">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 60px;">No</th>
            <th>Nama Staff TU & Email</th>
            <th>NIP</th>
            <th>Jabatan Administrasi</th>
            <th>Username</th>
            <th>Status</th>
            <th class="text-end" style="width: 160px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($staffList as $st): ?>
            <tr>
              <td class="font-monospace text-secondary small"><?= $no++ ?></td>
              <td>
                <div class="fw-medium small"><?= esc($st['nama']) ?></div>
                <div class="text-secondary small"><?= esc($st['email']) ?></div>
              </td>
              <td><span class="font-monospace small text-secondary"><?= esc($st['nip']) ?></span></td>
              <td><span class="badge bg-secondary-subtle text-secondary border"><?= esc($st['jabatan']) ?></span></td>
              <td><span class="font-monospace small text-secondary">@<?= esc($st['username']) ?></span></td>
              <td><span class="text-success small fw-medium">Aktif</span></td>
              <td class="text-end">
                <button class="btn btn-outline-secondary btn-sm py-0 px-2" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEditStaff" data-nama="<?= esc($st['nama']) ?>" data-jabatan="<?= esc($st['jabatan']) ?>" data-nip="<?= esc($st['nip']) ?>" data-hp="<?= esc($st['no_hp']) ?>" data-username="<?= esc($st['username']) ?>">Edit</button>
                <button class="btn btn-outline-danger btn-sm py-0 px-2" title="Nonaktifkan" data-bs-toggle="modal" data-bs-target="#modalNonaktifkanStaff" data-nama="<?= esc($st['nama']) ?>">Nonaktifkan</button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Staff TU (OPEN STATE) -->
<div class="modal show" id="modalTambahStaff" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Akun Staff TU">
        <input type="hidden" name="redirect_url" value="/admin/staff-tu">
        
        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Tambah Akun Staff TU</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Nama Lengkap & Gelar</label>
            <input type="text" class="form-control form-control-sm" name="nama" placeholder="Contoh: Siti Aisyah, S.AP." required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Jabatan</label>
            <input type="text" class="form-control form-control-sm" name="jabatan" placeholder="Contoh: Staf Kearsipan / Keuangan" required>
          </div>
          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label small fw-semibold text-secondary mb-1">NIP</label>
              <input type="text" class="form-control form-control-sm" name="nip" placeholder="NIP Pegawai">
            </div>
            <div class="col-6">
              <label class="form-label small fw-semibold text-secondary mb-1">No. HP</label>
              <input type="tel" class="form-control form-control-sm" name="no_hp" placeholder="08123456789">
            </div>
          </div>
          <div class="row g-2">
            <div class="col-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Username</label>
              <input type="text" class="form-control form-control-sm" name="username" placeholder="tu.nama" required>
            </div>
            <div class="col-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Password</label>
              <input type="password" class="form-control form-control-sm" name="password" placeholder="Password" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-3">Simpan Akun TU</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Staff TU -->
<div class="modal fade" id="modalEditStaff" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <div class="modal-header">
        <h6 class="modal-title fw-semibold">Edit Akun Staff TU</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi Nonaktifkan Staff TU -->
<div class="modal fade" id="modalNonaktifkanStaff" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border shadow-sm">
      <div class="modal-header">
        <h6 class="modal-title fw-semibold text-danger">Nonaktifkan Staff</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    </div>
  </div>
</div>

<!-- Static Modal Backdrop for Figma Export -->
<div class="modal-backdrop show"></div>
<style>body { overflow: hidden; }</style>

<?= $this->endSection() ?>
