<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">Kategori Persuratan</h4>
    <p class="text-secondary small mb-0">Klasifikasi surat masuk dan surat keluar sekolah</p>
  </div>
  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKategoriSurat">
    + Tambah Kategori
  </button>
</div>

<div class="card border">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 80px;">No</th>
            <th>Nama Kategori Surat</th>
            <th>Berlaku Untuk</th>
            <th>Jumlah Arsip</th>
            <th class="text-end" style="width: 140px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($kategoriList as $k): ?>
            <tr>
              <td class="font-monospace text-secondary small"><?= $no++ ?></td>
              <td class="fw-medium small"><?= esc($k['nama']) ?></td>
              <td>
                <span class="badge bg-secondary-subtle text-secondary border">
                  <?php if ($k['berlaku_untuk'] === 'keduanya'): ?>
                    Surat Masuk &amp; Keluar
                  <?php elseif ($k['berlaku_untuk'] === 'masuk'): ?>
                    Surat Masuk
                  <?php else: ?>
                    Surat Keluar
                  <?php endif; ?>
                </span>
              </td>
              <td class="small text-secondary"><?= esc($k['jumlah_surat']) ?> dokumen</td>
              <td class="text-end">
                <button class="btn btn-outline-secondary btn-sm py-0 px-2" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEditKategoriSurat" data-nama="<?= esc($k['nama']) ?>" data-berlaku="<?= esc($k['berlaku_untuk']) ?>">Edit</button>
                <button class="btn btn-outline-danger btn-sm py-0 px-2" title="Hapus" data-bs-toggle="modal" data-bs-target="#modalHapusKategoriSurat" data-nama="<?= esc($k['nama']) ?>">Hapus</button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Kategori Surat -->
<div class="modal fade" id="modalTambahKategoriSurat" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Kategori Surat">
        <input type="hidden" name="redirect_url" value="/admin/kategori-surat">

        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Tambah Kategori Surat</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Nama Kategori</label>
            <input type="text" class="form-control form-control-sm" name="nama" placeholder="Contoh: Surat Tugas / SK Pembagian Jam" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Berlaku Untuk</label>
            <select class="form-select form-select-sm" name="berlaku_untuk">
              <option value="keduanya">Surat Masuk &amp; Surat Keluar</option>
              <option value="masuk">Hanya Surat Masuk</option>
              <option value="keluar">Hanya Surat Keluar</option>
            </select>
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

<!-- Modal Edit Kategori Surat -->
<div class="modal fade" id="modalEditKategoriSurat" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Kategori Surat">
        <input type="hidden" name="redirect_url" value="/admin/kategori-surat">

        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Edit Kategori Surat</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Nama Kategori</label>
            <input type="text" class="form-control form-control-sm" id="editNamaKategoriSurat" name="nama" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Berlaku Untuk</label>
            <select class="form-select form-select-sm" id="editBerlakuUntuk" name="berlaku_untuk">
              <option value="keduanya">Surat Masuk &amp; Surat Keluar</option>
              <option value="masuk">Hanya Surat Masuk</option>
              <option value="keluar">Hanya Surat Keluar</option>
            </select>
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

<!-- Modal Hapus Kategori Surat -->
<div class="modal fade" id="modalHapusKategoriSurat" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Kategori Surat">
        <input type="hidden" name="redirect_url" value="/admin/kategori-surat">
        <div class="modal-header">
          <h6 class="modal-title fw-semibold text-danger">Hapus Kategori Surat</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center py-3">
          <p class="small mb-0">Yakin ingin menghapus kategori surat <strong id="hapusNamaKategoriSurat">-</strong>?</p>
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
document.querySelectorAll('[data-bs-target="#modalEditKategoriSurat"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('editNamaKategoriSurat').value = this.dataset.nama || '';
    document.getElementById('editBerlakuUntuk').value = this.dataset.berlaku || 'keduanya';
  });
});
document.querySelectorAll('[data-bs-target="#modalHapusKategoriSurat"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('hapusNamaKategoriSurat').textContent = this.dataset.nama || '';
  });
});
</script>

<?= $this->endSection() ?>
