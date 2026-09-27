<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
  <div>
    <h4 class="fw-bold mb-1">Daftar Surat Masuk</h4>
    <p class="text-secondary small mb-0">Pencatatan surat masuk kedinasan, permohonan, dan disposisi tindak lanjut.</p>
  </div>
  <a href="<?= base_url('tu/surat-masuk/tambah') ?>" class="btn btn-primary">
    + Catat Surat Masuk
  </a>
</div>

<div class="card">
  <div class="card-header bg-body py-3">
    <div class="row g-2 align-items-center">
      <div class="col-md-3">
        <select class="form-select form-select-sm">
          <option>Semua Periode (Bulan Ini)</option>
        </select>
      </div>
      <div class="col-md-3">
        <select class="form-select form-select-sm">
          <option>Semua Kategori Surat</option>
          <?php foreach ($kategoriList as $k): ?>
            <option value="<?= $k['id'] ?>"><?= esc($k['nama']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-3">
        <select class="form-select form-select-sm">
          <option>Semua Status</option>
          <option>Diterima</option>
          <option>Didisposisikan</option>
          <option>Selesai</option>
        </select>
      </div>
      <div class="col-md-3">
        <input type="text" class="form-control form-control-sm" placeholder="Cari nomor/pengirim/perihal...">
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Nomor Agenda</th>
            <th>Nomor Surat Asal</th>
            <th>Tanggal Diterima</th>
            <th>Instansi / Pengirim</th>
            <th>Perihal</th>
            <th>Kategori</th>
            <th>Status</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($suratMasukList)): ?>
            <tr>
              <td colspan="8" class="text-center text-secondary py-4">Belum ada surat masuk yang tercatat</td>
            </tr>
          <?php else: ?>
            <?php foreach ($suratMasukList as $sm): ?>
              <tr>
                <td>
                  <a href="<?= base_url('tu/surat-masuk/detail/' . $sm['id']) ?>" class="text-primary text-decoration-none font-monospace fw-semibold">
                    <?= esc($sm['nomor_agenda']) ?>
                  </a>
                </td>
                <td><span class="font-monospace text-secondary"><?= esc($sm['nomor_surat']) ?></span></td>
                <td><span class="text-secondary"><?= date('d M Y', strtotime($sm['tanggal_diterima'])) ?></span></td>
                <td class="fw-medium text-body"><?= esc($sm['pengirim']) ?></td>
                <td><?= esc($sm['perihal']) ?></td>
                <td><span class="badge bg-secondary-subtle text-secondary-emphasis border"><?= esc($sm['kategori']) ?></span></td>
                <td>
                  <?php if ($sm['status'] === 'didisposisikan'): ?>
                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">Didisposisikan</span>
                  <?php elseif ($sm['status'] === 'selesai'): ?>
                    <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">Selesai</span>
                  <?php else: ?>
                    <span class="badge bg-secondary-subtle text-secondary-emphasis border">Diarsipkan</span>
                  <?php endif; ?>
                </td>
                <td class="text-end">
                  <a href="<?= base_url('tu/surat-masuk/detail/' . $sm['id']) ?>" class="btn btn-outline-primary btn-sm">
                    Disposisi
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
