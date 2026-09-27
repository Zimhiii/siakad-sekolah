<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">Format Penomoran Surat Otomatis</h4>
    <p class="text-secondary small mb-0">Template pola nomor agenda surat masuk dan nomor surat keluar</p>
  </div>
  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahFormatSurat">
    + Tambah Pola Format
  </button>
</div>

<div class="card border">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 140px;">Jenis Surat</th>
            <th>Pola Format Pattern</th>
            <th>Contoh Tergenerate</th>
            <th>No. Terakhir</th>
            <th>Reset Tahunan</th>
            <th class="text-end" style="width: 140px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($formatList as $f): ?>
            <tr>
              <td>
                <?php if ($f['jenis'] === 'masuk'): ?>
                  <span class="badge bg-secondary-subtle text-secondary border">Surat Masuk</span>
                <?php else: ?>
                  <span class="badge bg-secondary-subtle text-secondary border">Surat Keluar</span>
                <?php endif; ?>
              </td>
              <td><span class="font-monospace small text-body"><?= esc($f['format_pattern']) ?></span></td>
              <td><span class="font-monospace small fw-medium"><?= esc($f['contoh']) ?></span></td>
              <td><span class="font-monospace small text-secondary"><?= esc($f['nomor_urut_terakhir']) ?></span></td>
              <td class="small text-secondary">
                <?= $f['reset_tahunan'] ? 'Ya (Tiap 1 Jan)' : 'Tidak' ?>
              </td>
              <td class="text-end">
                <button class="btn btn-outline-secondary btn-sm py-0 px-2" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEditFormatSurat" data-jenis="<?= esc($f['jenis']) ?>" data-pattern="<?= esc($f['format_pattern']) ?>" data-reset="<?= $f['reset_tahunan'] ? '1' : '0' ?>">Edit</button>
                <button class="btn btn-outline-danger btn-sm py-0 px-2" title="Hapus" data-bs-toggle="modal" data-bs-target="#modalHapusFormatSurat" data-pattern="<?= esc($f['format_pattern']) ?>">Hapus</button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Builder Format Penomoran Surat -->
<div class="modal fade" id="modalTambahFormatSurat" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Format Penomoran Surat">
        <input type="hidden" name="redirect_url" value="/admin/format-surat">

        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Builder Pola Nomor Surat</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Jenis Surat</label>
            <select class="form-select form-select-sm" name="jenis">
              <option value="keluar">Surat Keluar</option>
              <option value="masuk">Surat Masuk</option>
            </select>
          </div>

          <div class="mb-2">
            <label class="form-label small fw-semibold text-secondary mb-1">Pola Format Nomor</label>
            <input type="text" class="form-control form-control-sm" id="formatPatternInput" name="format_pattern" value="{nomor_urut}/SMA-FI/TU/{bulan_romawi}/{tahun}" required>
          </div>

          <!-- Token click inserters -->
          <div class="mb-3">
            <span class="text-secondary small d-block mb-1">Klik variabel di bawah untuk menambahkan ke pola:</span>
            <div class="d-flex flex-wrap gap-1">
              <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-1 font-monospace" onclick="insertToken('{nomor_urut}')">{nomor_urut}</button>
              <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-1 font-monospace" onclick="insertToken('{nomor_urut_3}')">{nomor_urut_3}</button>
              <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-1 font-monospace" onclick="insertToken('{kode_sekolah}')">{kode_sekolah}</button>
              <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-1 font-monospace" onclick="insertToken('{bulan_romawi}')">{bulan_romawi}</button>
              <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-1 font-monospace" onclick="insertToken('{tahun}')">{tahun}</button>
            </div>
          </div>

          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="resetTahunanSwitch" name="reset_tahunan" checked>
            <label class="form-check-label small text-secondary" for="resetTahunanSwitch">Reset nomor urut kembali ke 1 setiap pergantian tahun baru</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-3">Simpan Pola</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Format Penomoran Surat -->
<div class="modal fade" id="modalEditFormatSurat" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Format Penomoran Surat">
        <input type="hidden" name="redirect_url" value="/admin/format-surat">

        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Edit Pola Nomor Surat</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Jenis Surat</label>
            <select class="form-select form-select-sm" id="editJenisFormat" name="jenis" required>
              <option value="keluar">Surat Keluar</option>
              <option value="masuk">Surat Masuk</option>
            </select>
          </div>

          <div class="mb-2">
            <label class="form-label small fw-semibold text-secondary mb-1">Pola Format Nomor</label>
            <input type="text" class="form-control form-control-sm" id="editFormatPatternInput" name="format_pattern" required>
          </div>

          <!-- Token click inserters -->
          <div class="mb-3">
            <span class="text-secondary small d-block mb-1">Klik variabel di bawah untuk menambahkan ke pola:</span>
            <div class="d-flex flex-wrap gap-1">
              <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-1 font-monospace" onclick="insertEditToken('{nomor_urut}')">{nomor_urut}</button>
              <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-1 font-monospace" onclick="insertEditToken('{nomor_urut_3}')">{nomor_urut_3}</button>
              <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-1 font-monospace" onclick="insertEditToken('{kode_sekolah}')">{kode_sekolah}</button>
              <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-1 font-monospace" onclick="insertEditToken('{bulan_romawi}')">{bulan_romawi}</button>
              <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-1 font-monospace" onclick="insertEditToken('{tahun}')">{tahun}</button>
            </div>
          </div>

          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="editResetTahunanSwitch" name="reset_tahunan">
            <label class="form-check-label small text-secondary" for="editResetTahunanSwitch">Reset nomor urut kembali ke 1 setiap pergantian tahun baru</label>
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

<!-- Modal Hapus Format Penomoran Surat -->
<div class="modal fade" id="modalHapusFormatSurat" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Format Penomoran Surat">
        <input type="hidden" name="redirect_url" value="/admin/format-surat">
        <div class="modal-header">
          <h6 class="modal-title fw-semibold text-danger">Hapus Format</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center py-3">
          <p class="small mb-2">Yakin ingin menghapus pola penomoran surat:</p>
          <code id="hapusPatternFormat" class="small">-</code>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger btn-sm px-3">Ya, Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  function insertToken(token) {
    const input = document.getElementById('formatPatternInput');
    input.value += token;
    input.focus();
  }

  function insertEditToken(token) {
    const input = document.getElementById('editFormatPatternInput');
    input.value += token;
    input.focus();
  }

  document.querySelectorAll('[data-bs-target="#modalEditFormatSurat"]').forEach(btn => {
    btn.addEventListener('click', function() {
      document.getElementById('editJenisFormat').value = this.dataset.jenis || 'keluar';
      document.getElementById('editFormatPatternInput').value = this.dataset.pattern || '';
      document.getElementById('editResetTahunanSwitch').checked = (this.dataset.reset === '1');
    });
  });

  document.querySelectorAll('[data-bs-target="#modalHapusFormatSurat"]').forEach(btn => {
    btn.addEventListener('click', function() {
      document.getElementById('hapusPatternFormat').textContent = this.dataset.pattern || '';
    });
  });
</script>
<?= $this->endSection() ?>
