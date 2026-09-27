<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">Master Jenis Prestasi</h4>
    <p class="text-secondary small mb-0">Kategori capaian kejuaraan atau penghargaan siswa</p>
  </div>
  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPrestasi">
    + Tambah Kategori Prestasi
  </button>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs mb-3">
  <li class="nav-item">
    <a class="nav-link text-secondary" href="<?= base_url('admin/sikap') ?>">
      1. Jenis Sikap & Karakter
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-secondary" href="<?= base_url('admin/ekskul') ?>">
      2. Jenis Ekstrakurikuler
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link active fw-semibold" href="<?= base_url('admin/prestasi') ?>">
      3. Jenis Prestasi
    </a>
  </li>
</ul>

<div class="card border">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 80px;">No</th>
            <th>Nama Kategori Prestasi</th>
            <th class="text-end" style="width: 140px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($prestasiList as $p): ?>
            <tr>
              <td class="font-monospace text-secondary small"><?= $no++ ?></td>
              <td class="fw-medium small"><?= esc($p['nama']) ?></td>
              <td class="text-end">
                <button class="btn btn-outline-secondary btn-sm py-0 px-2" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEditPrestasi" data-nama="<?= esc($p['nama']) ?>">Edit</button>
                <button class="btn btn-outline-danger btn-sm py-0 px-2" title="Hapus" data-bs-toggle="modal" data-bs-target="#modalHapusPrestasi" data-nama="<?= esc($p['nama']) ?>">Hapus</button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Prestasi -->
<div class="modal fade" id="modalTambahPrestasi" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Jenis Prestasi">
        <input type="hidden" name="redirect_url" value="/admin/prestasi">
        
        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Tambah Kategori Prestasi</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Nama Kategori Prestasi</label>
            <input type="text" class="form-control form-control-sm" name="nama" placeholder="Contoh: Keagamaan & Tahfidz" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-3">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Prestasi -->
<div class="modal fade" id="modalEditPrestasi" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Jenis Prestasi">
        <input type="hidden" name="redirect_url" value="/admin/prestasi">
        
        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Edit Kategori Prestasi</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Nama Kategori Prestasi</label>
            <input type="text" class="form-control form-control-sm" id="editNamaPrestasi" name="nama" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-3">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Hapus Prestasi -->
<div class="modal fade" id="modalHapusPrestasi" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Jenis Prestasi">
        <input type="hidden" name="redirect_url" value="/admin/prestasi">
        <div class="modal-header">
          <h6 class="modal-title fw-semibold text-danger">Hapus Kategori Prestasi</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center py-3">
          <p class="small mb-0">Yakin ingin menghapus kategori prestasi <strong id="hapusNamaPrestasi">-</strong>?</p>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger btn-sm px-3">Ya, Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('[data-bs-target="#modalEditPrestasi"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('editNamaPrestasi').value = this.dataset.nama || '';
  });
});
document.querySelectorAll('[data-bs-target="#modalHapusPrestasi"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('hapusNamaPrestasi').textContent = this.dataset.nama || '';
  });
});
</script>

<?= $this->endSection() ?>
