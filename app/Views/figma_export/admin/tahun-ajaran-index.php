<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">Tahun Ajaran & Semester</h4>
    <p class="text-secondary small mb-0">Kelola siklus akademik tahunan dan status keaktifan semester</p>
  </div>
  <a href="<?= base_url('admin/wizard/1') ?>" class="btn btn-primary btn-sm">
    + Buka Tahun Ajaran Baru
  </a>
</div>

<div class="card mb-4 border">
  <div class="card-header bg-body py-2 px-3">
    <div class="row align-items-center g-2">
      <div class="col-md-4">
        <input type="text" class="form-control form-control-sm" placeholder="Cari tahun ajaran...">
      </div>
      <div class="col-md-8 text-md-end">
        <span class="text-secondary small">Hanya ada 1 Tahun Ajaran berstatus 'Aktif' dalam satu waktu</span>
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 60px;">No</th>
            <th>Nama Tahun Ajaran</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Semester Terdaftar</th>
            <th>Status</th>
            <th class="text-end" style="width: 200px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($tahunAjaran as $ta): ?>
            <tr>
              <td class="font-monospace text-secondary small"><?= $no++ ?></td>
              <td>
                <span class="fw-semibold small"><?= esc($ta['nama']) ?></span>
                <?php if ($ta['status'] === 'aktif'): ?>
                  <span class="badge bg-secondary-subtle text-secondary border ms-2">Berjalan</span>
                <?php endif; ?>
              </td>
              <td class="small"><?= date('d M Y', strtotime($ta['tanggal_mulai'])) ?></td>
              <td class="small"><?= date('d M Y', strtotime($ta['tanggal_selesai'])) ?></td>
              <td>
                <div class="d-flex flex-column gap-1">
                  <?php 
                    $ganjilActive = false;
                    $genapActive = false;
                    foreach ($ta['semesters'] as $sem): 
                      if ($sem['nama'] === 'Ganjil' && !empty($sem['is_active'])) $ganjilActive = true;
                      if ($sem['nama'] === 'Genap' && !empty($sem['is_active'])) $genapActive = true;
                  ?>
                    <div class="small d-inline-flex align-items-center <?= !empty($sem['is_active']) ? 'fw-semibold text-body' : 'text-secondary' ?>">
                      <span>Semester <?= esc($sem['nama']) ?></span>
                      <?php if (!empty($sem['is_active'])): ?>
                        <span class="badge bg-secondary-subtle text-secondary border ms-1">Aktif</span>
                      <?php endif; ?>
                    </div>
                  <?php endforeach; ?>

                  <?php if ($ta['status'] === 'aktif' && $ganjilActive && !$genapActive): ?>
                    <div class="mt-1">
                      <a href="<?= base_url('admin/aktivasi-semester-genap') ?>" class="btn btn-outline-primary btn-sm py-0 px-2 small text-nowrap">
                        Mulai Semester Genap &rarr;
                      </a>
                    </div>
                  <?php endif; ?>
                </div>
              </td>
              <td>
                <?php if ($ta['status'] === 'aktif'): ?>
                  <span class="text-success small fw-medium">Aktif</span>
                <?php elseif ($ta['status'] === 'draft'): ?>
                  <span class="text-secondary small fw-medium">Draft Persiapan</span>
                <?php else: ?>
                  <span class="text-secondary small">Selesai (Arsip)</span>
                <?php endif; ?>
              </td>
              <td class="text-end">
                <div class="d-inline-flex gap-1">
                  <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#modalDetailTA<?= $ta['id'] ?>">
                    Detail
                  </button>
                  <a href="<?= base_url('admin/wizard/1') ?>" class="btn btn-outline-secondary btn-sm py-0 px-2" title="Edit / Lanjutkan Setup">
                    Setup
                  </a>
                  <?php if ($ta['status'] !== 'aktif'): ?>
                    <form action="<?= base_url('admin/save-action') ?>" method="post" class="d-inline">
                      <?= csrf_field() ?>
                      <input type="hidden" name="action" value="Aktivasi Tahun Ajaran <?= esc($ta['nama']) ?>">
                      <input type="hidden" name="redirect_url" value="/admin/tahun-ajaran">
                      <button type="submit" class="btn btn-outline-success btn-sm py-0 px-2" title="Set Sebagai Aktif" onclick="return confirm('Aktifkan Tahun Ajaran <?= esc($ta['nama']) ?> sebagai periode akademik berjalan?')">
                        Aktifkan
                      </button>
                    </form>
                  <?php endif; ?>
                </div>
              </td>
            </tr>

            <!-- Modal Detail TA -->
            <div class="modal fade" id="modalDetailTA<?= $ta['id'] ?>" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border shadow-sm">
                  <div class="modal-header">
                    <h6 class="modal-title fw-semibold">Detail Tahun Ajaran: <?= esc($ta['nama']) ?></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul class="list-group list-group-flush mb-3">
                      <li class="list-group-item d-flex justify-content-between px-0 py-2 small">
                        <span class="text-secondary">Status</span>
                        <span class="text-uppercase fw-semibold"><?= esc($ta['status']) ?></span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between px-0 py-2 small">
                        <span class="text-secondary">Tanggal Mulai</span>
                        <span><?= date('d F Y', strtotime($ta['tanggal_mulai'])) ?></span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between px-0 py-2 small">
                        <span class="text-secondary">Tanggal Selesai</span>
                        <span><?= date('d F Y', strtotime($ta['tanggal_selesai'])) ?></span>
                      </li>
                    </ul>
                    <h6 class="small fw-semibold mb-2">Daftar Semester:</h6>
                    <div class="bg-light p-3 rounded border">
                      <?php foreach ($ta['semesters'] as $s): ?>
                        <div class="d-flex justify-content-between align-items-center py-1 border-bottom">
                          <div class="d-flex align-items-center small">
                            <span class="<?= !empty($s['is_active']) ? 'fw-semibold text-body' : '' ?>">Semester <?= esc($s['nama']) ?></span>
                            <?php if (!empty($s['is_active'])): ?>
                              <span class="badge bg-secondary-subtle text-secondary border ms-1">Aktif</span>
                            <?php endif; ?>
                          </div>
                          <span class="text-secondary small"><?= date('d/m/Y', strtotime($s['tanggal_mulai'])) ?> - <?= date('d/m/Y', strtotime($s['tanggal_selesai'])) ?></span>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
