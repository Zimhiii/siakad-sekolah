<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">KKM & Interval Predikat</h4>
    <p class="text-secondary small mb-0">Konversi nilai angka ke predikat huruf (A, B, C, D) berdasarkan Kriteria Ketuntasan Minimal</p>
  </div>
  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKriteria">
    + Tambah Set KKM
  </button>
</div>

<div class="row g-3">
  <?php foreach ($kriteriaList as $kriteria): ?>
    <div class="col-lg-6">
      <div class="card border h-100">
        <div class="card-header bg-body py-2 px-3 d-flex justify-content-between align-items-center">
          <div>
            <span class="fw-semibold">KKM: <?= number_format($kriteria['kkm'], 0) ?></span>
            <span class="text-secondary small ms-2">&mdash; <?= esc($kriteria['keterangan']) ?></span>
          </div>
          <div class="d-flex gap-1">
            <button class="btn btn-outline-secondary btn-sm py-0 px-2" title="Edit KKM" data-bs-toggle="modal" data-bs-target="#modalEditKriteria" data-kkm="<?= esc($kriteria['kkm']) ?>" data-keterangan="<?= esc($kriteria['keterangan']) ?>">Edit</button>
            <button class="btn btn-outline-danger btn-sm py-0 px-2" title="Hapus KKM" data-bs-toggle="modal" data-bs-target="#modalHapusKriteria" data-kkm="<?= esc($kriteria['kkm']) ?>" data-keterangan="<?= esc($kriteria['keterangan']) ?>">Hapus</button>
          </div>
        </div>

        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
              <thead class="table-light">
                <tr>
                  <th style="width: 140px;">Rentang Nilai</th>
                  <th style="width: 90px;">Predikat</th>
                  <th class="text-start">Deskripsi Kategori</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($kriteria['intervals'] as $inv): ?>
                  <tr>
                    <td class="font-monospace small">
                      <?= $inv['nilai_min'] ?> &ndash; <?= $inv['nilai_max'] ?>
                    </td>
                    <td>
                      <span class="fw-bold small"><?= esc($inv['predikat']) ?></span>
                    </td>
                    <td class="text-start small text-secondary"><?= esc($inv['deskripsi']) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="card-footer bg-body d-flex justify-content-between align-items-center py-2 px-3">
          <span class="text-secondary small"><?= count($kriteria['intervals']) ?> interval terdaftar</span>
          <button class="btn btn-outline-primary btn-sm py-0 px-2" data-bs-toggle="modal" data-bs-target="#modalTambahInterval" data-kkm="<?= esc($kriteria['kkm']) ?>" data-keterangan="<?= esc($kriteria['keterangan']) ?>">
            + Tambah Interval
          </button>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<!-- Modal Tambah Set KKM -->
<div class="modal fade" id="modalTambahKriteria" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Set KKM & Kriteria Penilaian">
        <input type="hidden" name="redirect_url" value="/admin/kriteria-penilaian">
        
        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Tambah Set Nilai KKM</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Nilai KKM (Standar Ketuntasan)</label>
            <input type="number" class="form-control form-control-sm" name="kkm" value="80" min="50" max="100" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Keterangan Penggunaan</label>
            <input type="text" class="form-control form-control-sm" name="keterangan" placeholder="Contoh: Program Reguler / Kelas Khusus" required>
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

<!-- Modal Edit Set KKM -->
<div class="modal fade" id="modalEditKriteria" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Set KKM & Kriteria Penilaian">
        <input type="hidden" name="redirect_url" value="/admin/kriteria-penilaian">
        
        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Edit Set Nilai KKM</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Nilai KKM (Standar Ketuntasan)</label>
            <input type="number" class="form-control form-control-sm" id="editKkm" name="kkm" min="50" max="100" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Keterangan Penggunaan</label>
            <input type="text" class="form-control form-control-sm" id="editKeterangan" name="keterangan" required>
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

<!-- Modal Hapus Set KKM -->
<div class="modal fade" id="modalHapusKriteria" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Set KKM & Kriteria Penilaian">
        <input type="hidden" name="redirect_url" value="/admin/kriteria-penilaian">
        <div class="modal-header">
          <h6 class="modal-title fw-semibold text-danger">Hapus Set KKM</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center py-3">
          <p class="small mb-0">Yakin ingin menghapus set KKM <strong id="hapusKkm">-</strong> (<span id="hapusKeterangan">-</span>)?</p>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger btn-sm px-3">Ya, Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Tambah Interval -->
<div class="modal fade" id="modalTambahInterval" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Interval Predikat KKM">
        <input type="hidden" name="redirect_url" value="/admin/kriteria-penilaian">
        <input type="hidden" name="kkm_id" id="intervalKkmId">
        
        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Tambah Interval Predikat</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="border rounded p-2 mb-3 bg-light small">
            Set KKM: <span id="intervalKkmInfo" class="fw-semibold text-primary">-</span>
          </div>
          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Nilai Minimal</label>
              <input type="number" class="form-control form-control-sm" name="nilai_min" min="0" max="100" placeholder="Contoh: 85" required>
            </div>
            <div class="col-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Nilai Maksimal</label>
              <input type="number" class="form-control form-control-sm" name="nilai_max" min="0" max="100" placeholder="Contoh: 100" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Predikat Huruf</label>
            <select class="form-select form-select-sm" name="predikat" required>
              <option value="A">A (Sangat Baik)</option>
              <option value="B">B (Baik)</option>
              <option value="C">C (Cukup)</option>
              <option value="D">D (Perlu Bimbingan)</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Keterangan / Deskripsi</label>
            <input type="text" class="form-control form-control-sm" name="deskripsi" placeholder="Contoh: Sangat Baik / Mencapai Ketuntasan Optimal" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-3">Simpan Interval</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('[data-bs-target="#modalEditKriteria"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('editKkm').value = this.dataset.kkm || '';
    document.getElementById('editKeterangan').value = this.dataset.keterangan || '';
  });
});
document.querySelectorAll('[data-bs-target="#modalHapusKriteria"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('hapusKkm').textContent = this.dataset.kkm || '';
    document.getElementById('hapusKeterangan').textContent = this.dataset.keterangan || '';
  });
});
document.querySelectorAll('[data-bs-target="#modalTambahInterval"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('intervalKkmId').value = this.dataset.kkm || '';
    document.getElementById('intervalKkmInfo').textContent = (this.dataset.kkm || '') + ' (' + (this.dataset.keterangan || '') + ')';
  });
});
</script>

<?= $this->endSection() ?>
