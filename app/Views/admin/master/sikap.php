<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">Master Penilaian Non-Akademik</h4>
    <p class="text-secondary small mb-0">Master jenis penilaian sikap spiritual & sosial, kegiatan ekstrakurikuler, dan prestasi siswa</p>
  </div>
  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSikap">
    + Tambah Aspek Sikap
  </button>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs mb-3">
  <li class="nav-item">
    <a class="nav-link active fw-semibold" href="<?= base_url('admin/sikap') ?>">
      1. Jenis Sikap & Karakter
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-secondary" href="<?= base_url('admin/ekskul') ?>">
      2. Jenis Ekstrakurikuler
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-secondary" href="<?= base_url('admin/prestasi') ?>">
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
            <th style="width: 80px;">Urutan</th>
            <th>Nama Aspek Sikap / Karakter</th>
            <th class="text-end" style="width: 140px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($sikapList as $s): ?>
            <tr>
              <td>
                <span class="font-monospace text-secondary small fw-medium">
                  <?= esc($s['urutan']) ?>
                </span>
              </td>
              <td class="fw-medium small"><?= esc($s['nama']) ?></td>
              <td class="text-end">
                <button class="btn btn-outline-secondary btn-sm py-0 px-2" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEditSikap" data-nama="<?= esc($s['nama']) ?>" data-urutan="<?= esc($s['urutan']) ?>">Edit</button>
                <button class="btn btn-outline-danger btn-sm py-0 px-2" title="Hapus" data-bs-toggle="modal" data-bs-target="#modalHapusSikap" data-nama="<?= esc($s['nama']) ?>">Hapus</button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Sikap -->
<div class="modal fade" id="modalTambahSikap" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Jenis Sikap">
        <input type="hidden" name="redirect_url" value="/admin/sikap">
        
        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Tambah Aspek Sikap Baru</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Nama Aspek Sikap</label>
            <input type="text" class="form-control form-control-sm" name="nama" placeholder="Contoh: Kejujuran & Integritas" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Urutan Tampil di Raport</label>
            <input type="number" class="form-control form-control-sm" name="urutan" value="5" min="1" max="20" required>
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

<!-- Modal Edit Sikap -->
<div class="modal fade" id="modalEditSikap" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Jenis Sikap">
        <input type="hidden" name="redirect_url" value="/admin/sikap">
        
        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Edit Aspek Sikap</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Nama Aspek Sikap</label>
            <input type="text" class="form-control form-control-sm" id="editNamaSikap" name="nama" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Urutan Tampil di Raport</label>
            <input type="number" class="form-control form-control-sm" id="editUrutanSikap" name="urutan" min="1" max="20" required>
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

<!-- Modal Hapus Sikap -->
<div class="modal fade" id="modalHapusSikap" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Jenis Sikap">
        <input type="hidden" name="redirect_url" value="/admin/sikap">
        <div class="modal-header">
          <h6 class="modal-title fw-semibold text-danger">Hapus Aspek Sikap</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center py-3">
          <p class="small mb-0">Yakin ingin menghapus aspek sikap <strong id="hapusNamaSikap">-</strong>?</p>
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
document.querySelectorAll('[data-bs-target="#modalEditSikap"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('editNamaSikap').value = this.dataset.nama || '';
    document.getElementById('editUrutanSikap').value = this.dataset.urutan || '';
  });
});
document.querySelectorAll('[data-bs-target="#modalHapusSikap"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('hapusNamaSikap').textContent = this.dataset.nama || '';
  });
});
</script>

<?= $this->endSection() ?>
