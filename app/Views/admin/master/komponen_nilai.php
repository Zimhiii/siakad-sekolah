<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">Komponen Nilai & Bobot</h4>
    <p class="text-secondary small mb-0">Skema persentase pembobotan nilai akhir raport per aspek penilaian</p>
  </div>
  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKomponen">
    + Tambah Komponen
  </button>
</div>

<!-- Tabs Pengetahuan vs Keterampilan -->
<ul class="nav nav-tabs mb-3">
  <li class="nav-item">
    <a class="nav-link <?= ($activeAspek === 'pengetahuan') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('admin/komponen-nilai/pengetahuan') ?>">
      Aspek Pengetahuan (Teori & Kognitif)
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= ($activeAspek === 'keterampilan') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('admin/komponen-nilai/keterampilan') ?>">
      Aspek Keterampilan (Praktik & Portofolio)
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
            <th>Nama Komponen Nilai</th>
            <th style="width: 200px;">Bobot Persentase (%)</th>
            <th class="text-end" style="width: 140px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $totalBobot = 0; foreach ($komponenList as $k): $totalBobot += $k['bobot_persen']; ?>
            <tr>
              <td>
                <span class="font-monospace text-secondary small fw-medium"><?= esc($k['urutan']) ?></span>
              </td>
              <td class="fw-medium small"><?= esc($k['nama']) ?></td>
              <td>
                <span class="font-monospace fw-semibold small"><?= esc($k['bobot_persen']) ?>%</span>
              </td>
              <td class="text-end">
                <button class="btn btn-outline-secondary btn-sm py-0 px-2" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEditKomponen" data-nama="<?= esc($k['nama']) ?>" data-bobot="<?= esc($k['bobot_persen']) ?>" data-urutan="<?= esc($k['urutan']) ?>">Edit</button>
                <button class="btn btn-outline-danger btn-sm py-0 px-2" title="Hapus" data-bs-toggle="modal" data-bs-target="#modalHapusKomponen" data-nama="<?= esc($k['nama']) ?>">Hapus</button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot class="table-light">
          <tr>
            <th colspan="2" class="small fw-semibold">
              Total Bobot Komponen <?= ucfirst($activeAspek) ?>
            </th>
            <th colspan="2">
              <?php if ($totalBobot == 100): ?>
                <span class="text-success small fw-semibold">100% (Valid)</span>
              <?php else: ?>
                <span class="text-danger small fw-semibold"><?= $totalBobot ?>% (Harus tepat 100%)</span>
              <?php endif; ?>
            </th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Komponen -->
<div class="modal fade" id="modalTambahKomponen" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Komponen Nilai">
        <input type="hidden" name="redirect_url" value="/admin/komponen-nilai/<?= $activeAspek ?>">
        
        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Tambah Komponen Nilai</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Aspek Penilaian</label>
            <select class="form-select form-select-sm" name="aspek" required>
              <option value="pengetahuan" <?= ($activeAspek === 'pengetahuan') ? 'selected' : '' ?>>Pengetahuan</option>
              <option value="keterampilan" <?= ($activeAspek === 'keterampilan') ? 'selected' : '' ?>>Keterampilan</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Nama Komponen</label>
            <input type="text" class="form-control form-control-sm" name="nama" placeholder="Contoh: Tugas Mandiri / Penilaian Harian" required>
          </div>
          <div class="row g-2">
            <div class="col-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Bobot (%)</label>
              <input type="number" class="form-control form-control-sm" name="bobot_persen" value="20" min="1" max="100" required>
            </div>
            <div class="col-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Urutan</label>
              <input type="number" class="form-control form-control-sm" name="urutan" value="5" min="1" max="15" required>
            </div>
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

<!-- Modal Edit Komponen -->
<div class="modal fade" id="modalEditKomponen" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Komponen Nilai">
        <input type="hidden" name="redirect_url" value="/admin/komponen-nilai/<?= $activeAspek ?>">
        
        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Edit Komponen Nilai</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Nama Komponen</label>
            <input type="text" class="form-control form-control-sm" id="editNamaKomponen" name="nama" required>
          </div>
          <div class="row g-2">
            <div class="col-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Bobot (%)</label>
              <input type="number" class="form-control form-control-sm" id="editBobotKomponen" name="bobot_persen" min="1" max="100" required>
            </div>
            <div class="col-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Urutan</label>
              <input type="number" class="form-control form-control-sm" id="editUrutanKomponen" name="urutan" min="1" max="15" required>
            </div>
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

<!-- Modal Hapus Komponen -->
<div class="modal fade" id="modalHapusKomponen" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Komponen Nilai">
        <input type="hidden" name="redirect_url" value="/admin/komponen-nilai/<?= $activeAspek ?>">
        <div class="modal-header">
          <h6 class="modal-title fw-semibold text-danger">Hapus Komponen</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center py-3">
          <p class="small mb-0">Yakin ingin menghapus komponen nilai <strong id="hapusNamaKomponen">-</strong>?</p>
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
document.querySelectorAll('[data-bs-target="#modalEditKomponen"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('editNamaKomponen').value = this.dataset.nama || '';
    document.getElementById('editBobotKomponen').value = this.dataset.bobot || '';
    document.getElementById('editUrutanKomponen').value = this.dataset.urutan || '';
  });
});
document.querySelectorAll('[data-bs-target="#modalHapusKomponen"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('hapusNamaKomponen').textContent = this.dataset.nama || '';
  });
});
</script>

<?= $this->endSection() ?>
