<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">Penugasan Guru Mengajar</h4>
    <p class="text-secondary small mb-0">Matriks jadwal guru pengajar per mata pelajaran, rombel, semester, dan standar KKM</p>
  </div>
  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPenugasan">
    + Tambah Penugasan
  </button>
</div>

<div class="card border">
  <div class="card-header bg-body py-2 px-3">
    <div class="row g-2 align-items-center">
      <div class="col-md-3">
        <select class="form-select form-select-sm">
          <option>Semua Tahun Ajaran (2025/2026)</option>
        </select>
      </div>
      <div class="col-md-3">
        <select class="form-select form-select-sm">
          <option>Semua Semester (Ganjil)</option>
        </select>
      </div>
      <div class="col-md-3">
        <select class="form-select form-select-sm">
          <option>Semua Kelas / Rombel</option>
        </select>
      </div>
      <div class="col-md-3">
        <input type="text" class="form-control form-control-sm" placeholder="Cari guru / mapel...">
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 60px;">No</th>
            <th>Guru Pengajar</th>
            <th>Mata Pelajaran</th>
            <th>Rombel (Kelas)</th>
            <th>Semester</th>
            <th style="width: 90px;">KKM</th>
            <th class="text-end" style="width: 110px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($penugasanList)): ?>
            <tr>
              <td colspan="7" class="text-center text-secondary small py-4">Belum ada penugasan guru pengampu</td>
            </tr>
          <?php else: ?>
            <?php $no = 1; foreach ($penugasanList as $p): ?>
              <tr>
                <td class="font-monospace text-secondary small"><?= $no++ ?></td>
                <td class="fw-medium small"><?= esc($p['guru_nama']) ?></td>
                <td class="small"><?= esc($p['mapel_nama']) ?></td>
                <td>
                  <span class="badge bg-secondary-subtle text-secondary border">
                    <?= esc($p['kelas_nama']) ?>
                  </span>
                </td>
                <td class="small text-secondary">Semester <?= esc($p['semester_nama']) ?></td>
                <td>
                  <span class="font-monospace small fw-semibold">
                    <?= number_format($p['kkm'], 0) ?>
                  </span>
                </td>
                <td class="text-end">
                  <button class="btn btn-outline-danger btn-sm py-0 px-2" title="Hapus Penugasan" data-bs-toggle="modal" data-bs-target="#modalHapusPenugasan" data-guru="<?= esc($p['guru_nama']) ?>" data-mapel="<?= esc($p['mapel_nama']) ?>" data-kelas="<?= esc($p['kelas_nama']) ?>">Hapus</button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah Penugasan -->
<div class="modal fade" id="modalTambahPenugasan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Penugasan Guru Mengajar">
        <input type="hidden" name="redirect_url" value="/admin/penugasan">
        
        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Tambah Penugasan Guru Mengajar</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Guru Pengajar</label>
            <select class="form-select form-select-sm" name="guru_id" required>
              <option value="">-- Pilih Guru --</option>
              <?php foreach ($guruList as $g): ?>
                <option value="<?= $g['id'] ?>"><?= esc($g['nama']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Mata Pelajaran</label>
            <select class="form-select form-select-sm" name="mapel_id" required>
              <option value="">-- Pilih Mata Pelajaran --</option>
              <?php foreach ($mapelList as $m): ?>
                <option value="<?= $m['id'] ?>"><?= esc($m['nama_mapel']) ?> (<?= esc($m['kode_mapel']) ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Kelas / Rombel</label>
              <select class="form-select form-select-sm" name="kelas_id" required>
                <?php foreach ($kelasList as $k): ?>
                  <option value="<?= $k['id'] ?>"><?= esc($k['nama_kelas']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Semester</label>
              <select class="form-select form-select-sm" name="semester_id" required>
                <option value="1">Ganjil</option>
                <option value="2">Genap</option>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Standar KKM (Kriteria Ketuntasan Minimal)</label>
            <select class="form-select form-select-sm" name="kkm" required>
              <?php if (!empty($kriteriaList)): ?>
                <?php foreach ($kriteriaList as $kr): ?>
                  <option value="<?= esc($kr['kkm']) ?>" <?= ($kr['kkm'] == 75) ? 'selected' : '' ?>>
                    KKM <?= number_format($kr['kkm'], 0) ?> (<?= esc($kr['keterangan']) ?>)
                  </option>
                <?php endforeach; ?>
              <?php else: ?>
                <option value="75" selected>KKM 75 (Standar Reguler)</option>
                <option value="80">KKM 80 (Program Unggulan)</option>
              <?php endif; ?>
            </select>
            <span class="text-secondary small d-block mt-1">Pilihan KKM mengacu pada Master KKM &amp; Interval Predikat.</span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-3">Simpan Penugasan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Hapus Penugasan -->
<div class="modal fade" id="modalHapusPenugasan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Penugasan Guru Mengajar">
        <input type="hidden" name="redirect_url" value="/admin/penugasan">
        <div class="modal-header">
          <h6 class="modal-title fw-semibold text-danger">Hapus Penugasan</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center py-3">
          <p class="small mb-0">Yakin ingin menghapus penugasan mengajar untuk <strong id="hapusGuruPenugasan">-</strong> pada mata pelajaran <strong id="hapusMapelPenugasan">-</strong> di rombel <strong id="hapusKelasPenugasan">-</strong>?</p>
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
document.querySelectorAll('[data-bs-target="#modalHapusPenugasan"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('hapusGuruPenugasan').textContent = this.dataset.guru || '';
    document.getElementById('hapusMapelPenugasan').textContent = this.dataset.mapel || '';
    document.getElementById('hapusKelasPenugasan').textContent = this.dataset.kelas || '';
  });
});
</script>

<?= $this->endSection() ?>
