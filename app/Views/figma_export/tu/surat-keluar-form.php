<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
  <div class="col-lg-9">
    <div class="card">
      <div class="card-header bg-body py-3">
        <h5 class="card-title mb-0">
          Buat Surat Keluar Baru
        </h5>
      </div>

      <form action="<?= base_url('tu/save-action') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Surat Keluar Baru">
        <input type="hidden" name="redirect_url" value="/tu/surat-keluar">

        <div class="card-body p-4">
          
          <!-- Toggle Nomor Otomatis vs Manual -->
          <div class="p-3 border rounded bg-body-tertiary mb-4">
            <div class="form-check form-switch mb-2">
              <input class="form-check-input" type="checkbox" id="toggleAutoNumber" checked onchange="toggleNomorMode(this.checked)">
              <label class="form-check-label small fw-semibold" for="toggleAutoNumber">Generate Nomor Surat Otomatis (Format Baku Sekolah)</label>
            </div>
            
            <div id="panelAutoNumber">
              <span class="text-secondary small d-block">Nomor surat yang akan digenerate:</span>
              <span class="badge bg-secondary-subtle text-secondary-emphasis border font-monospace mt-1"><?= esc($nextNomor) ?></span>
            </div>

            <div id="panelManualNumber" class="d-none mt-2">
              <label class="form-label small fw-semibold text-danger">Input Nomor Surat Manual:</label>
              <input type="text" class="form-control form-control-sm" name="nomor_surat_manual" placeholder="Contoh: 105/SMA-FI/TU/XII/2025">
            </div>
          </div>

          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label small fw-semibold text-secondary">Instansi / Orang Tujuan Surat</label>
              <input type="text" class="form-control" name="tujuan" placeholder="Contoh: Kepala Dinas Pendidikan Provinsi Jawa Barat" required>
            </div>

            <div class="col-md-4">
              <label class="form-label small fw-semibold text-secondary">Tanggal Surat</label>
              <input type="date" class="form-control" name="tanggal_surat" value="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold text-secondary">Kategori Surat</label>
              <select class="form-select" name="kategori_surat_id" required>
                <?php foreach ($kategoriList as $k): ?>
                  <option value="<?= $k['id'] ?>"><?= esc($k['nama']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold text-secondary">Sifat Surat</label>
              <select class="form-select" name="sifat">
                <option value="biasa" selected>Biasa</option>
                <option value="penting">Penting</option>
                <option value="segera">Segera / Mendesak</option>
                <option value="rahasia">Rahasia</option>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label small fw-semibold text-secondary">Perihal Surat</label>
              <input type="text" class="form-control" name="perihal" placeholder="Isi perihal surat keluar" required>
            </div>

            <div class="col-12">
              <label class="form-label small fw-semibold text-secondary">Keterangan Tambahan</label>
              <textarea class="form-control" name="keterangan" rows="2" placeholder="Catatan internal pengiriman surat"></textarea>
            </div>

            <!-- Upload File Draft Dokumen -->
            <div class="col-12">
              <label class="form-label small fw-semibold text-secondary">Lampirkan File Dokumen Surat (Word / PDF)</label>
              <div class="border rounded p-3 bg-body-tertiary">
                <input type="file" name="file_dokumen" class="form-control form-control-sm mb-1">
                <div class="text-secondary small">Format yang didukung: PDF, DOCX (Maks. 10 MB)</div>
              </div>
            </div>
          </div>

        </div>

        <div class="card-footer bg-body d-flex justify-content-end gap-2 py-3">
          <a href="<?= base_url('tu/surat-keluar') ?>" class="btn btn-outline-secondary">Batal</a>
          <button type="submit" class="btn btn-primary px-4">
            Ajukan untuk Tanda Tangan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  function toggleNomorMode(isAuto) {
    const autoPanel = document.getElementById('panelAutoNumber');
    const manualPanel = document.getElementById('panelManualNumber');
    if (isAuto) {
      autoPanel.classList.remove('d-none');
      manualPanel.classList.add('d-none');
    } else {
      autoPanel.classList.add('d-none');
      manualPanel.classList.remove('d-none');
    }
  }
</script>
<?= $this->endSection() ?>
