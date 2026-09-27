<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
  <div class="col-lg-7">
    <div class="card border">
      <div class="card-header bg-body py-2 px-3">
        <h5 class="fw-semibold small mb-0">
          Buka Rombongan Belajar (Kelas) Baru
        </h5>
      </div>

      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Kelas Baru">
        <input type="hidden" name="redirect_url" value="/admin/kelas">

        <div class="card-body p-3 p-md-4">
          <div class="mb-3">
            <label class="form-label small fw-semibold">Nama Kelas</label>
            <input type="text" class="form-control form-control-sm" name="nama_kelas" placeholder="Contoh: X-MIPA-3 / XI-IPS-2" required>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Tingkatan Sekolah</label>
            <select class="form-select form-select-sm" name="tingkatan_id" required>
              <option value="">-- Pilih Tingkatan Kelas --</option>
              <?php foreach ($tingkatan as $t): ?>
                <option value="<?= $t['id'] ?>"><?= esc($t['nama']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Jurusan / Konsentrasi (Opsional)</label>
            <select class="form-select form-select-sm" name="jurusan_id">
              <option value="">-- Tanpa Jurusan (Umum) --</option>
              <?php foreach ($jurusan as $j): ?>
                <option value="<?= $j['id'] ?>"><?= esc($j['nama_jurusan']) ?> (<?= esc($j['kode']) ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Wali Kelas Pengampu</label>
            <select class="form-select form-select-sm" name="wali_kelas_id">
              <option value="">-- Pilih Guru Wali Kelas (Bisa Ditentukan Nanti) --</option>
              <?php foreach ($guru as $g): ?>
                <option value="<?= $g['id'] ?>"><?= esc($g['nama']) ?> (NIP: <?= esc($g['nip']) ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Kapasitas Maksimal Siswa</label>
            <div class="input-group input-group-sm">
              <input type="number" class="form-control" name="kapasitas_max" value="32" min="10" max="50" required>
              <span class="input-group-text">Siswa</span>
            </div>
          </div>
        </div>

        <div class="card-footer bg-body d-flex justify-content-end gap-2 py-2 px-3">
          <a href="<?= base_url('admin/kelas') ?>" class="btn btn-outline-secondary btn-sm px-3">Batal</a>
          <button type="submit" class="btn btn-primary btn-sm px-4">
            Simpan Kelas Baru
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

