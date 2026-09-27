<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
  <div>
    <h4 class="fw-bold mb-1">Tingkatan Kelas</h4>
    <p class="text-secondary small mb-0">Master urutan level kelas (Fase pendidikan)</p>
  </div>
  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahTingkatan">
    + Tambah Tingkatan
  </button>
</div>

<div class="card border">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 70px;" class="text-center">Urutan</th>
            <th>Nama Tingkatan</th>
            <th>Jumlah Rombel Aktif</th>
            <th class="text-end" style="width: 140px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($tingkatanList as $t): ?>
            <tr>
              <td class="text-center text-secondary font-monospace"><?= esc($t['urutan']) ?></td>
              <td class="fw-medium text-body"><?= esc($t['nama']) ?></td>
              <td>
                <span class="text-secondary small"><?= esc($t['jumlah_kelas']) ?> Kelas</span>
              </td>
              <td class="text-end">
                <div class="d-inline-flex gap-1">
                  <button class="btn btn-outline-secondary btn-sm" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEditTingkatan" data-nama="<?= esc($t['nama']) ?>" data-urutan="<?= esc($t['urutan']) ?>">Edit</button>
                  <button class="btn btn-outline-danger btn-sm" title="Hapus" data-bs-toggle="modal" data-bs-target="#modalHapusTingkatan" data-nama="<?= esc($t['nama']) ?>">Hapus</button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Tingkatan -->
<div class="modal show" id="modalTambahTingkatan" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Tingkatan Kelas">
        <input type="hidden" name="redirect_url" value="/admin/tingkatan">
        
        <div class="modal-header">
          <h5 class="modal-title fw-semibold">Tambah Tingkatan Kelas Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold">Nama Tingkatan</label>
            <input type="text" class="form-control form-control-sm" name="nama" placeholder="Contoh: Kelas 10 / Fase E" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Urutan Level (Angka)</label>
            <input type="number" class="form-control form-control-sm" name="urutan" value="4" min="1" max="15" required>
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

<!-- Modal Edit Tingkatan -->
<div class="modal fade" id="modalEditTingkatan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Tingkatan Kelas">
        <input type="hidden" name="redirect_url" value="/admin/tingkatan">
        
        <div class="modal-header">
          <h5 class="modal-title fw-semibold">Edit Tingkatan Kelas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold">Nama Tingkatan</label>
            <input type="text" class="form-control form-control-sm" id="editNamaTingkatan" name="nama" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Urutan Level (Angka)</label>
            <input type="number" class="form-control form-control-sm" id="editUrutanTingkatan" name="urutan" min="1" max="15" required>
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

<!-- Modal Hapus Tingkatan -->
<div class="modal fade" id="modalHapusTingkatan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Tingkatan Kelas">
        <input type="hidden" name="redirect_url" value="/admin/tingkatan">
        <div class="modal-header">
          <h6 class="modal-title text-danger fw-semibold">Hapus Tingkatan</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center py-3">
          <p class="mb-0 small">Yakin ingin menghapus tingkatan <strong id="hapusNamaTingkatan">-</strong>?</p>
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
document.querySelectorAll('[data-bs-target="#modalEditTingkatan"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('editNamaTingkatan').value = this.dataset.nama || '';
    document.getElementById('editUrutanTingkatan').value = this.dataset.urutan || '';
  });
});
document.querySelectorAll('[data-bs-target="#modalHapusTingkatan"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('hapusNamaTingkatan').textContent = this.dataset.nama || '';
  });
});
</script>


<!-- Static Modal Backdrop for Figma Export -->
<div class="modal-backdrop show"></div>
<style>body { overflow: hidden; }</style>
<?= $this->endSection() ?>

