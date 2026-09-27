<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card border">
      <div class="card-header bg-body py-2 px-3">
        <h6 class="card-title fw-semibold mb-0">
          <?= !empty($guru) ? 'Edit Data Guru' : 'Tambah Data Guru Baru' ?>
        </h6>
      </div>

      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Data Guru">
        <input type="hidden" name="redirect_url" value="/admin/guru">

        <div class="card-body p-3">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Nama Lengkap & Gelar</label>
              <input type="text" class="form-control form-control-sm" name="nama" value="<?= esc($guru['nama'] ?? '') ?>" placeholder="Contoh: Ustadz Ahmad Fauzi, M.Pd." required>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold text-secondary mb-1">NIP (Nomor Induk Pegawai)</label>
              <input type="text" class="form-control form-control-sm" name="nip" value="<?= esc($guru['nip'] ?? '') ?>" placeholder="Contoh: 198503152010011008">
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Nomor WhatsApp / HP</label>
              <input type="tel" class="form-control form-control-sm" name="no_hp" value="<?= esc($guru['no_hp'] ?? '') ?>" placeholder="Contoh: 081223344551">
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Email Akun</label>
              <input type="email" class="form-control form-control-sm" name="email" value="<?= esc($guru['email'] ?? '') ?>" placeholder="Contoh: guru@fithrahinsani.sch.id">
            </div>

            <div class="col-12">
              <label class="form-label small fw-semibold text-secondary mb-1">Alamat Tempat Tinggal</label>
              <textarea class="form-control form-control-sm" name="alamat" rows="2" placeholder="Alamat domisili lengkap"><?= esc($guru['alamat'] ?? '') ?></textarea>
            </div>

            <div class="col-12"><hr class="my-1 border-secondary-subtle"></div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Username Login</label>
              <input type="text" class="form-control form-control-sm" name="username" value="<?= esc($guru['username'] ?? '') ?>" placeholder="Contoh: guru.hendra" required>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Password <?= !empty($guru) ? '<span class="fw-normal text-muted">(Kosongkan jika tidak diubah)</span>' : '' ?></label>
              <input type="password" class="form-control form-control-sm" name="password" placeholder="Password akun" <?= empty($guru) ? 'required' : '' ?>>
            </div>
          </div>
        </div>

        <div class="card-footer bg-body d-flex justify-content-end gap-2 py-2 px-3">
          <a href="<?= base_url('admin/guru') ?>" class="btn btn-outline-secondary btn-sm">Batal</a>
          <button type="submit" class="btn btn-primary btn-sm px-3">Simpan Data Guru</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
