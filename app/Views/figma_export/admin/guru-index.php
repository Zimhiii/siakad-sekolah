<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">Data Guru & Tenaga Pendidik</h4>
    <p class="text-secondary small mb-0">Manajemen biodata guru, akun login, dan status keaktifan mengajar</p>
  </div>
  <a href="<?= base_url('admin/guru/tambah') ?>" class="btn btn-primary btn-sm">
    + Tambah Guru
  </a>
</div>

<div class="card border">
  <div class="card-header bg-body py-2 px-3">
    <div class="row g-2 align-items-center">
      <div class="col-md-4">
        <div class="input-group input-group-sm">
          <input type="text" class="form-control" placeholder="Cari nama guru / NIP...">
        </div>
      </div>
      <div class="col-md-8 text-md-end">
        <span class="text-secondary small"><?= count($guruList) ?> guru terdaftar</span>
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 60px;">No</th>
            <th>Nama Lengkap & Akun</th>
            <th>NIP</th>
            <th>No. Handphone</th>
            <th>Wali Kelas</th>
            <th>Status</th>
            <th class="text-end" style="width: 160px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($guruList)): ?>
            <tr>
              <td colspan="7" class="text-center text-secondary small py-4">Belum ada data akun guru</td>
            </tr>
          <?php else: ?>
            <?php $no = 1; foreach ($guruList as $g): ?>
              <tr>
                <td class="font-monospace text-secondary small"><?= $no++ ?></td>
                <td>
                  <div class="fw-medium small"><?= esc($g['nama']) ?></div>
                  <div class="text-secondary small font-monospace">@<?= esc($g['username']) ?></div>
                </td>
                <td><span class="font-monospace small text-secondary"><?= esc($g['nip']) ?></span></td>
                <td class="small"><?= esc($g['no_hp']) ?></td>
                <td>
                  <?php if ($g['is_wali']): ?>
                    <span class="badge bg-secondary-subtle text-secondary border"><?= esc($g['kelas_wali']) ?></span>
                  <?php else: ?>
                    <span class="text-secondary small">&mdash;</span>
                  <?php endif; ?>
                </td>
                <td>
                  <span class="text-success small fw-medium">Aktif</span>
                </td>
                <td class="text-end">
                  <a href="<?= base_url('admin/guru/edit/' . $g['id']) ?>" class="btn btn-outline-secondary btn-sm py-0 px-2" title="Edit Data">Edit</a>
                  <button class="btn btn-outline-danger btn-sm py-0 px-2" title="Nonaktifkan Akun" data-bs-toggle="modal" data-bs-target="#modalNonaktifkanGuru" data-id="<?= esc($g['id']) ?>" data-nama="<?= esc($g['nama']) ?>">Nonaktifkan</button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi Nonaktifkan Guru -->
<div class="modal fade" id="modalNonaktifkanGuru" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Akun Guru">
        <input type="hidden" name="redirect_url" value="/admin/guru">
        <input type="hidden" name="guru_id" id="nonaktifkanGuruId">
        <div class="modal-header">
          <h6 class="modal-title fw-semibold text-danger">Nonaktifkan Guru</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center py-3">
          <p class="small mb-0">Yakin ingin menonaktifkan akun <strong id="nonaktifkanNamaGuru">-</strong>?</p>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger btn-sm px-3">Ya, Nonaktifkan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('[data-bs-target="#modalNonaktifkanGuru"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('nonaktifkanGuruId').value = this.dataset.id || '';
    document.getElementById('nonaktifkanNamaGuru').textContent = this.dataset.nama || '';
  });
});
</script>

<?= $this->endSection() ?>
