<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
  <div class="col-lg-9">
    <div class="card">
      <div class="card-header bg-body py-3">
        <h5 class="card-title mb-0">
          Catat Surat Masuk Baru
        </h5>
      </div>

      <form action="<?= base_url('tu/save-action') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Surat Masuk Baru">
        <input type="hidden" name="redirect_url" value="/tu/surat-masuk">

        <div class="card-body p-4">
          
          <div class="alert alert-light border d-flex align-items-center mb-4" role="alert">
            <div class="small text-secondary">
              Nomor Agenda Internal akan digenerate otomatis: <span class="badge bg-secondary-subtle text-secondary-emphasis border font-monospace"><?= esc($nextAgenda) ?></span>
            </div>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small fw-semibold text-secondary">Nomor Surat Asli (Dari Pengirim)</label>
              <input type="text" class="form-control" name="nomor_surat" placeholder="Contoh: 421.3/890/Disdik/2025" required>
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-semibold text-secondary">Tanggal Tertulis di Surat</label>
              <input type="date" class="form-control" name="tanggal_surat" value="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-semibold text-secondary">Tanggal Diterima Sekolah</label>
              <input type="date" class="form-control" name="tanggal_diterima" value="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold text-secondary">Instansi / Nama Pengirim</label>
              <input type="text" class="form-control" name="pengirim" placeholder="Contoh: Dinas Pendidikan Provinsi Jawa Barat" required>
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-semibold text-secondary">Kategori Surat</label>
              <select class="form-select" name="kategori_surat_id" required>
                <?php foreach ($kategoriList as $k): ?>
                  <option value="<?= $k['id'] ?>"><?= esc($k['nama']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-semibold text-secondary">Sifat Surat</label>
              <select class="form-select" name="sifat">
                <option value="biasa">Biasa</option>
                <option value="penting" selected>Penting</option>
                <option value="segera">Segera / Mendesak</option>
                <option value="rahasia">Rahasia</option>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label small fw-semibold text-secondary">Perihal / Pokok Surat</label>
              <input type="text" class="form-control" name="perihal" placeholder="Isi perihal singkat surat masuk" required>
            </div>

            <div class="col-12">
              <label class="form-label small fw-semibold text-secondary">Keterangan / Catatan Tambahan</label>
              <textarea class="form-control" name="keterangan" rows="2" placeholder="Catatan fisik surat"></textarea>
            </div>

            <!-- Upload File Lampiran / Scan -->
            <div class="col-12">
              <label class="form-label small fw-semibold text-secondary">Upload Scan Dokumen Surat (PDF / JPG)</label>
              <div class="border rounded p-3 bg-body-tertiary">
                <input type="file" name="file_lampiran" class="form-control form-control-sm mb-1">
                <div class="text-secondary small">Format yang didukung: PDF, JPG, PNG (Maks. 10 MB)</div>
              </div>
            </div>
          </div>

        </div>

        <div class="card-footer bg-body d-flex justify-content-end gap-2 py-3">
          <a href="<?= base_url('tu/surat-masuk') ?>" class="btn btn-outline-secondary">Batal</a>
          <button type="submit" class="btn btn-primary px-4">
            Simpan Surat Masuk
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
