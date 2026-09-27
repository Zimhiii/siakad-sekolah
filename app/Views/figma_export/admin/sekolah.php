<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="card border">
      <div class="card-header bg-body py-2 px-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-semibold small mb-0">Identitas Satuan Pendidikan</h5>
        <span class="text-secondary small">Data Pokok Pendidikan</span>
      </div>

      <form action="<?= base_url('admin/save-action') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Data Sekolah">
        <input type="hidden" name="redirect_url" value="/admin/sekolah">

        <div class="card-body p-3 p-md-4">
          
          <!-- Logo & Header info -->
          <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between p-3 bg-body-tertiary rounded border mb-4 gap-3">
            <div class="d-flex align-items-center gap-3">
              <img src="<?= esc($sekolahData['logo_url']) ?>" alt="Logo Sekolah" class="rounded-circle border" width="60" height="60">
              <div>
                <h5 class="fw-bold mb-1"><?= esc($sekolahData['nama_sekolah']) ?></h5>
                <p class="text-secondary small mb-0">NPSN: <?= esc($sekolahData['npsn']) ?> &bull; NSS: <?= esc($sekolahData['nss']) ?></p>
              </div>
            </div>
            <div>
              <label for="logo_sekolah" class="btn btn-outline-secondary btn-sm">
                Ganti Logo
              </label>
              <input type="file" id="logo_sekolah" name="logo_sekolah" class="d-none">
            </div>
          </div>

          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label small fw-semibold">Nama Sekolah</label>
              <input type="text" class="form-control form-control-sm" name="nama_sekolah" value="<?= esc($sekolahData['nama_sekolah']) ?>" required>
            </div>

            <div class="col-md-4">
              <label class="form-label small fw-semibold">Jenjang Pendidikan</label>
              <input type="text" class="form-control form-control-sm bg-body-tertiary" value="SMA / MA (Sekolah Menengah Atas)" readonly>
              <input type="hidden" name="jenjang" value="SMA">
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold">NPSN (Nomor Pokok Sekolah Nasional)</label>
              <input type="text" class="form-control form-control-sm" name="npsn" value="<?= esc($sekolahData['npsn']) ?>" required>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold">NSS (Nomor Statistik Sekolah)</label>
              <input type="text" class="form-control form-control-sm" name="nss" value="<?= esc($sekolahData['nss']) ?>">
            </div>

            <div class="col-md-12">
              <label class="form-label small fw-semibold">Nama Kepala Sekolah</label>
              <input type="text" class="form-control form-control-sm" name="kepala_sekolah" value="<?= esc($sekolahData['kepala_sekolah']) ?>" required>
            </div>

            <div class="col-12">
              <label class="form-label small fw-semibold">Alamat Lengkap</label>
              <textarea class="form-control form-control-sm" name="alamat" rows="2" required><?= esc($sekolahData['alamat']) ?></textarea>
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-semibold">Kelurahan / Desa</label>
              <input type="text" class="form-control form-control-sm" name="kelurahan" value="<?= esc($sekolahData['kelurahan']) ?>">
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-semibold">Kecamatan</label>
              <input type="text" class="form-control form-control-sm" name="kecamatan" value="<?= esc($sekolahData['kecamatan']) ?>">
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-semibold">Kabupaten / Kota</label>
              <input type="text" class="form-control form-control-sm" name="kabupaten_kota" value="<?= esc($sekolahData['kabupaten_kota']) ?>">
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-semibold">Provinsi</label>
              <input type="text" class="form-control form-control-sm" name="provinsi" value="<?= esc($sekolahData['provinsi']) ?>">
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold">Website Resmi</label>
              <input type="url" class="form-control form-control-sm" name="website" value="<?= esc($sekolahData['website']) ?>">
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold">Email Resmi</label>
              <input type="email" class="form-control form-control-sm" name="email" value="<?= esc($sekolahData['email']) ?>">
            </div>
          </div>

        </div>

        <div class="card-footer bg-body d-flex justify-content-end gap-2 py-2 px-3">
          <button type="reset" class="btn btn-outline-secondary btn-sm px-3">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-4">
            Simpan Perubahan
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<?= $this->endSection() ?>

