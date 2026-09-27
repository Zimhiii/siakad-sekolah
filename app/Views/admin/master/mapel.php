<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">Mata Pelajaran & Kelompok Mapel</h4>
    <p class="text-secondary small mb-0">Struktur pengelompokan kurikulum dan daftar mata pelajaran aktif</p>
  </div>
  <div class="d-flex gap-2">
    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKelompok">
      + Kelompok Mapel
    </button>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahMapel">
      + Tambah Mata Pelajaran
    </button>
  </div>
</div>

<div class="row g-3">
  <!-- Panel Kiri: Kelompok Mapel -->
  <div class="col-lg-4">
    <div class="card border h-100">
      <div class="card-header bg-body py-2 px-3 d-flex justify-content-between align-items-center">
        <span class="fw-semibold small">Kelompok Mapel</span>
        <span class="text-secondary small"><?= count($kelompokList) ?> kelompok</span>
      </div>
      <div class="list-group list-group-flush">
        <?php foreach ($kelompokList as $k): ?>
          <a href="<?= base_url('admin/mapel/' . $k['id']) ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-3 <?= ($selectedKelompok['id'] == $k['id']) ? 'active' : '' ?>">
            <span class="small fw-medium"><?= esc($k['nama']) ?></span>
            <span class="badge <?= ($selectedKelompok['id'] == $k['id']) ? 'bg-light text-dark' : 'bg-secondary-subtle text-secondary' ?>"><?= esc($k['jumlah_mapel']) ?></span>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Panel Kanan: Mapel Milik Kelompok Terpilih -->
  <div class="col-lg-8">
    <div class="card border h-100">
      <div class="card-header bg-body py-2 px-3 d-flex justify-content-between align-items-center">
        <div>
          <span class="text-secondary small d-block">Kelompok Terpilih</span>
          <span class="fw-semibold text-primary"><?= esc($selectedKelompok['nama']) ?></span>
        </div>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahMapel">
          Tambah ke Kelompok Ini
        </button>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width: 130px;">Kode Mapel</th>
                <th>Nama Mata Pelajaran</th>
                <th>Berlaku Untuk</th>
                <th class="text-end" style="width: 140px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($mapelList)): ?>
                <tr>
                  <td colspan="4" class="text-center py-4 text-secondary small">
                    Belum ada mata pelajaran dalam kelompok ini.
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($mapelList as $m): ?>
                  <tr>
                    <td>
                      <span class="font-monospace small fw-semibold text-secondary"><?= esc($m['kode_mapel']) ?></span>
                    </td>
                    <td class="fw-medium small"><?= esc($m['nama_mapel']) ?></td>
                    <td>
                      <span class="badge bg-secondary-subtle text-secondary border"><?= esc($m['jurusan_kode'] ?: 'Semua Jurusan') ?></span>
                    </td>
                    <td class="text-end">
                      <button class="btn btn-outline-secondary btn-sm py-0 px-2" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEditMapel" data-id="<?= esc($m['id']) ?>" data-nama="<?= esc($m['nama_mapel']) ?>" data-kode="<?= esc($m['kode_mapel']) ?>" data-kelompok="<?= esc($m['kelompok_mapel_id']) ?>" data-jurusan="<?= esc($m['jurusan_id'] ?? '') ?>">Edit</button>
                      <button class="btn btn-outline-danger btn-sm py-0 px-2" title="Hapus" data-bs-toggle="modal" data-bs-target="#modalHapusMapel" data-nama="<?= esc($m['nama_mapel']) ?>">Hapus</button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer bg-body py-2 px-3">
        <span class="text-secondary small">
          Nilai KKM ditentukan per penugasan guru pengajar di menu Penugasan Guru.
        </span>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Kelompok Mapel -->
<div class="modal fade" id="modalTambahKelompok" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Kelompok Mata Pelajaran">
        <input type="hidden" name="redirect_url" value="/admin/mapel">
        
        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Tambah Kelompok Mapel</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Nama Kelompok Mapel</label>
            <input type="text" class="form-control form-control-sm" name="nama" placeholder="Contoh: Kelompok A (Wajib) / Muatan Lokal" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Urutan Tampil</label>
            <input type="number" class="form-control form-control-sm" name="urutan" value="6" min="1" max="20" required>
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

<!-- Modal Tambah Mata Pelajaran -->
<div class="modal fade" id="modalTambahMapel" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Mata Pelajaran">
        <input type="hidden" name="redirect_url" value="/admin/mapel/<?= $selectedKelompok['id'] ?>">
        
        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Tambah Mata Pelajaran</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Nama Mata Pelajaran</label>
            <input type="text" class="form-control form-control-sm" name="nama_mapel" placeholder="Contoh: Fisika Terapan" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Kode Mapel</label>
            <input type="text" class="form-control form-control-sm" name="kode_mapel" placeholder="Contoh: FIS-T" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Kelompok Mapel</label>
            <select class="form-select form-select-sm" name="kelompok_mapel_id">
              <?php foreach ($kelompokList as $k): ?>
                <option value="<?= $k['id'] ?>" <?= ($selectedKelompok['id'] == $k['id']) ? 'selected' : '' ?>>
                  <?= esc($k['nama']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Peminatan / Jurusan</label>
            <select class="form-select form-select-sm" name="jurusan_id">
              <option value="">-- Berlaku untuk Semua Jurusan (Umum) --</option>
              <?php foreach ($jurusanList as $j): ?>
                <option value="<?= $j['id'] ?>"><?= esc($j['nama_jurusan']) ?> (<?= esc($j['kode']) ?>)</option>
              <?php endforeach; ?>
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

<!-- Modal Edit Mata Pelajaran -->
<div class="modal fade" id="modalEditMapel" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Mata Pelajaran">
        <input type="hidden" name="redirect_url" value="/admin/mapel/<?= $selectedKelompok['id'] ?>">
        
        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Edit Mata Pelajaran</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Nama Mata Pelajaran</label>
            <input type="text" class="form-control form-control-sm" id="editNamaMapel" name="nama_mapel" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Kode Mapel</label>
            <input type="text" class="form-control form-control-sm" id="editKodeMapel" name="kode_mapel" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Kelompok Mapel</label>
            <select class="form-select form-select-sm" id="editKelompokMapelId" name="kelompok_mapel_id" required>
              <?php foreach ($kelompokList as $k): ?>
                <option value="<?= $k['id'] ?>"><?= esc($k['nama']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Peminatan / Jurusan</label>
            <select class="form-select form-select-sm" id="editJurusanId" name="jurusan_id">
              <option value="">-- Berlaku untuk Semua Jurusan (Umum) --</option>
              <?php foreach ($jurusanList as $j): ?>
                <option value="<?= $j['id'] ?>"><?= esc($j['nama_jurusan']) ?> (<?= esc($j['kode']) ?>)</option>
              <?php endforeach; ?>
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

<!-- Modal Hapus Mata Pelajaran -->
<div class="modal fade" id="modalHapusMapel" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Mata Pelajaran">
        <input type="hidden" name="redirect_url" value="/admin/mapel/<?= $selectedKelompok['id'] ?>">
        <div class="modal-header">
          <h6 class="modal-title fw-semibold text-danger">Hapus Mata Pelajaran</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center py-3">
          <p class="small mb-0">Yakin ingin menghapus mata pelajaran <strong id="hapusNamaMapel">-</strong>?</p>
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
document.querySelectorAll('[data-bs-target="#modalEditMapel"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('editNamaMapel').value = this.dataset.nama || '';
    document.getElementById('editKodeMapel').value = this.dataset.kode || '';
    document.getElementById('editKelompokMapelId').value = this.dataset.kelompok || '';
    document.getElementById('editJurusanId').value = this.dataset.jurusan || '';
  });
});
document.querySelectorAll('[data-bs-target="#modalHapusMapel"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('hapusNamaMapel').textContent = this.dataset.nama || '';
  });
});
</script>

<?= $this->endSection() ?>
