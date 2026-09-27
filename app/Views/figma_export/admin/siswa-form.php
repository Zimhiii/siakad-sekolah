<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
  <div class="col-lg-9">
    <div class="card border">
      <div class="card-header bg-body py-2 px-3 d-flex justify-content-between align-items-center">
        <h6 class="card-title fw-semibold mb-0">
          <?= !empty($siswa) ? 'Edit Biodata Siswa' : 'Tambah Siswa Baru' ?>
        </h6>
        <div class="d-flex align-items-center gap-2">
          <label for="foto_siswa" class="btn btn-outline-secondary btn-sm">
            Upload Foto
          </label>
          <input type="file" id="foto_siswa" name="foto_siswa" class="d-none">
        </div>
      </div>

      <form action="<?= base_url('admin/save-action') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Data Siswa">
        <input type="hidden" name="redirect_url" value="/admin/siswa">

        <div class="card-body p-3">
          <h6 class="fw-semibold text-primary mb-3">1. Identitas Pokok Siswa</h6>
          
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Nama Lengkap Siswa</label>
              <input type="text" class="form-control form-control-sm" name="nama" value="<?= esc($siswa['nama'] ?? '') ?>" placeholder="Nama sesuai akta kelahiran" required>
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-semibold text-secondary mb-1">NIS (Nomor Induk Siswa)</label>
              <input type="text" class="form-control form-control-sm" name="nis" value="<?= esc($siswa['nis'] ?? '') ?>" placeholder="Nomor lokal" required>
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-semibold text-secondary mb-1">NISN (Nasional)</label>
              <input type="text" class="form-control form-control-sm" name="nisn" value="<?= esc($siswa['nisn'] ?? '') ?>" placeholder="10 digit NISN">
            </div>

            <div class="col-md-4">
              <label class="form-label small fw-semibold text-secondary mb-1">Tempat Lahir</label>
              <input type="text" class="form-control form-control-sm" name="tempat_lahir" value="<?= esc($siswa['tempat_lahir'] ?? '') ?>" placeholder="Kota/Kab">
            </div>

            <div class="col-md-4">
              <label class="form-label small fw-semibold text-secondary mb-1">Tanggal Lahir</label>
              <input type="date" class="form-control form-control-sm" name="tanggal_lahir" value="<?= esc($siswa['tanggal_lahir'] ?? '') ?>">
            </div>

            <div class="col-md-4">
              <label class="form-label small fw-semibold text-secondary mb-1">Jenis Kelamin</label>
              <select name="jenis_kelamin" class="form-select form-select-sm" required>
                <option value="L" <?= (($siswa['jenis_kelamin'] ?? '') === 'L') ? 'selected' : '' ?>>Laki-laki</option>
                <option value="P" <?= (($siswa['jenis_kelamin'] ?? '') === 'P') ? 'selected' : '' ?>>Perempuan</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label small fw-semibold text-secondary mb-1">Agama</label>
              <input type="text" class="form-control form-control-sm" name="agama" value="<?= esc($siswa['agama'] ?? 'Islam') ?>">
            </div>

            <div class="col-md-4">
              <label class="form-label small fw-semibold text-secondary mb-1">Status dalam Keluarga</label>
              <input type="text" class="form-control form-control-sm" name="status_dalam_keluarga" value="<?= esc($siswa['status_dalam_keluarga'] ?? 'Anak Kandung') ?>" placeholder="Anak Kandung/Anak Angkat">
            </div>

            <div class="col-md-4">
              <label class="form-label small fw-semibold text-secondary mb-1">Anak ke-</label>
              <input type="number" class="form-control form-control-sm" name="anak_ke" value="<?= esc($siswa['anak_ke'] ?? '1') ?>" min="1" max="15">
            </div>

            <div class="col-12">
              <label class="form-label small fw-semibold text-secondary mb-1">Alamat Tempat Tinggal Lengkap</label>
              <textarea class="form-control form-control-sm" name="alamat" rows="2" placeholder="Alamat domisili lengkap siswa"><?= esc($siswa['alamat'] ?? '') ?></textarea>
            </div>
          </div>

          <h6 class="fw-semibold text-primary mb-3">2. Riwayat Penerimaan & Kelas</h6>

          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Sekolah Asal</label>
              <input type="text" class="form-control form-control-sm" name="sekolah_asal" value="<?= esc($siswa['sekolah_asal'] ?? '') ?>" placeholder="SMP/MTs Asal">
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Tanggal Diterima</label>
              <input type="date" class="form-control form-control-sm" name="tanggal_diterima" value="<?= esc($siswa['tanggal_diterima'] ?? '2024-07-15') ?>">
            </div>

            <?php if (empty($siswa)): ?>
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary mb-1">Kelas Diterima Pertama Kali</label>
                <select name="kelas_diterima_id" class="form-select form-select-sm">
                  <?php foreach ($kelasList as $k): ?>
                    <option value="<?= $k['id'] ?>"><?= esc($k['nama_kelas']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            <?php endif; ?>

            <div class="col-md-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Kelas / Rombel Saat Ini</label>
              <select name="kelas_id" class="form-select form-select-sm">
                <option value="">-- Belum Ditempatkan (Unassigned) --</option>
                <?php foreach ($kelasList as $k): ?>
                  <option value="<?= $k['id'] ?>" <?= (($siswa['kelas_id'] ?? '') == $k['id']) ? 'selected' : '' ?>>
                    <?= esc($k['nama_kelas']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <h6 class="fw-semibold text-primary mb-3">3. Akun Pengguna Portal Siswa</h6>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Username Siswa</label>
              <input type="text" class="form-control form-control-sm" name="username" value="<?= esc($siswa['username'] ?? '') ?>" placeholder="Contoh: siswa.raihan" required>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Password <?= !empty($siswa) ? '<span class="fw-normal text-muted">(Kosongkan jika tidak diubah)</span>' : '' ?></label>
              <input type="password" class="form-control form-control-sm" name="password" placeholder="Password akun siswa" <?= empty($siswa) ? 'required' : '' ?>>
            </div>
          </div>

        </div>

        <div class="card-footer bg-body d-flex justify-content-end gap-2 py-2 px-3">
          <a href="<?= base_url('admin/siswa') ?>" class="btn btn-outline-secondary btn-sm">Batal</a>
          <button type="submit" class="btn btn-primary btn-sm px-3">Simpan Biodata Siswa</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
