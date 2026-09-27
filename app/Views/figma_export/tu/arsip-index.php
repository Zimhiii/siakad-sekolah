<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">Arsip Persuratan Sekolah</h4>
    <p class="text-secondary small mb-0">Pencarian dan penelusuran arsip surat masuk dan surat keluar</p>
  </div>
  <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.print()">
    Cetak Hasil Pencarian
  </button>
</div>

<!-- Tabs Masuk vs Keluar -->
<ul class="nav nav-tabs mb-3">
  <li class="nav-item">
    <a class="nav-link <?= ($activeTab === 'masuk') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('tu/arsip/masuk') ?>">
      1. Arsip Surat Masuk
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= ($activeTab === 'keluar') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('tu/arsip/keluar') ?>">
      2. Arsip Surat Keluar
    </a>
  </li>
</ul>

<div class="card border">
  <div class="card-header bg-body py-2 px-3">
    <div class="row g-2 align-items-center">
      <div class="col-md-4">
        <input type="text" class="form-control form-control-sm" placeholder="Cari nomor surat / perihal...">
      </div>
      <div class="col-md-3">
        <select class="form-select form-select-sm">
          <option>Filter Semua Kategori</option>
          <?php foreach ($kategoriList as $k): ?>
            <option value="<?= $k['id'] ?>"><?= esc($k['nama']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-3">
        <input type="date" class="form-control form-control-sm" value="2025-11-01">
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <?php if ($activeTab === 'masuk'): ?>
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 140px;">Nomor Agenda</th>
              <th style="width: 170px;">Nomor Surat</th>
              <th style="width: 130px;">Tanggal Terima</th>
              <th>Pengirim</th>
              <th>Perihal</th>
              <th style="width: 100px;">Status</th>
              <th class="text-end" style="width: 120px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($suratMasuk)): ?>
              <tr>
                <td colspan="7" class="text-center text-secondary small py-4">Belum ada arsip surat masuk</td>
              </tr>
            <?php else: ?>
              <?php foreach ($suratMasuk as $sm): ?>
                <tr>
                  <td><span class="font-monospace small fw-medium"><?= esc($sm['nomor_agenda']) ?></span></td>
                  <td><span class="font-monospace small text-secondary"><?= esc($sm['nomor_surat']) ?></span></td>
                  <td class="small text-secondary"><?= date('d M Y', strtotime($sm['tanggal_diterima'])) ?></td>
                  <td class="small"><?= esc($sm['pengirim']) ?></td>
                  <td class="small"><?= esc($sm['perihal']) ?></td>
                  <td><span class="text-success small fw-medium"><?= esc($sm['status']) ?></span></td>
                  <td class="text-end">
                    <a href="<?= base_url('tu/surat-masuk/detail/' . $sm['id']) ?>" class="btn btn-outline-secondary btn-sm py-0 px-2">Buka Berkas</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      <?php else: ?>
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 170px;">Nomor Surat</th>
              <th style="width: 130px;">Tanggal Surat</th>
              <th>Tujuan Surat</th>
              <th>Perihal</th>
              <th style="width: 100px;">Status</th>
              <th class="text-end" style="width: 120px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($suratKeluar)): ?>
              <tr>
                <td colspan="6" class="text-center text-secondary small py-4">Belum ada arsip surat keluar</td>
              </tr>
            <?php else: ?>
              <?php foreach ($suratKeluar as $sk): ?>
                <tr>
                  <td><span class="font-monospace small fw-medium"><?= esc($sk['nomor_surat']) ?></span></td>
                  <td class="small text-secondary"><?= date('d M Y', strtotime($sk['tanggal_surat'])) ?></td>
                  <td class="small"><?= esc($sk['tujuan']) ?></td>
                  <td class="small"><?= esc($sk['perihal']) ?></td>
                  <td><span class="badge bg-secondary-subtle text-secondary border"><?= esc($sk['status']) ?></span></td>
                  <td class="text-end">
                    <a href="<?= base_url('tu/surat-keluar/detail/' . $sk['id']) ?>" class="btn btn-outline-secondary btn-sm py-0 px-2">Buka Berkas</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
