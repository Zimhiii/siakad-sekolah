<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
  <div>
    <h4 class="fw-bold mb-1">Jurusan / Konsentrasi Keahlian</h4>
    <p class="text-secondary small mb-0">Master peminatan program keahlian peserta didik</p>
  </div>
  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahJurusan">
    + Tambah Jurusan
  </button>
</div>

<div class="card border">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 140px;">Kode Jurusan</th>
            <th>Nama Jurusan</th>
            <th>Jumlah Rombel Aktif</th>
            <th class="text-end" style="width: 140px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($jurusanList as $j): ?>
            <tr>
              <td class="font-monospace text-secondary fw-semibold"><?= esc($j['kode']) ?></td>
              <td class="fw-medium text-body"><?= esc($j['nama_jurusan']) ?></td>
              <td>
                <span class="text-secondary small"><?= esc($j['jumlah_kelas']) ?> Kelas</span>
              </td>
              <td class="text-end">
                <div class="d-inline-flex gap-1">
                  <button class="btn btn-outline-secondary btn-sm" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEditJurusan" data-nama="<?= esc($j['nama_jurusan']) ?>" data-kode="<?= esc($j['kode']) ?>">Edit</button>
                  <button class="btn btn-outline-danger btn-sm" title="Hapus" data-bs-toggle="modal" data-bs-target="#modalHapusJurusan" data-nama="<?= esc($j['nama_jurusan']) ?>">Hapus</button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Jurusan -->
<div class="modal show" id="modalTambahJurusan" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Jurusan">
        <input type="hidden" name="redirect_url" value="/admin/jurusan">
        
        <div class="modal-header">
          <h5 class="modal-title fw-semibold">Tambah Jurusan Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold">Nama Jurusan</label>
            <input type="text" class="form-control form-control-sm" name="nama_jurusan" placeholder="Contoh: Matematika dan Ilmu Pengetahuan Alam" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Kode Singkatan</label>
            <input type="text" class="form-control form-control-sm" name="kode" placeholder="Contoh: MIPA / IPS" required>
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

<!-- Modal Edit Jurusan -->
<div class="modal fade" id="modalEditJurusan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Jurusan">
        <input type="hidden" name="redirect_url" value="/admin/jurusan">
        
        <div class="modal-header">
          <h5 class="modal-title fw-semibold">Edit Jurusan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold">Nama Jurusan</label>
            <input type="text" class="form-control form-control-sm" id="editNamaJurusan" name="nama_jurusan" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Kode Singkatan</label>
            <input type="text" class="form-control form-control-sm" id="editKodeJurusan" name="kode" required>
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

<!-- Modal Hapus Jurusan -->
<div class="modal fade" id="modalHapusJurusan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Jurusan">
        <input type="hidden" name="redirect_url" value="/admin/jurusan">
        <div class="modal-header">
          <h6 class="modal-title text-danger fw-semibold">Hapus Jurusan</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center py-3">
          <p class="mb-0 small">Yakin ingin menghapus jurusan <strong id="hapusNamaJurusan">-</strong>?</p>
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
document.querySelectorAll('[data-bs-target="#modalEditJurusan"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('editNamaJurusan').value = this.dataset.nama || '';
    document.getElementById('editKodeJurusan').value = this.dataset.kode || '';
  });
});
document.querySelectorAll('[data-bs-target="#modalHapusJurusan"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('hapusNamaJurusan').textContent = this.dataset.nama || '';
  });
});
</script>


<!-- Static Modal Backdrop for Figma Export -->
<div class="modal-backdrop show"></div>
<style>body { overflow: hidden; }</style>
<?= $this->endSection() ?>

