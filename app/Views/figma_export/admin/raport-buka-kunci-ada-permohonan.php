<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">Otorisasi Buka Kunci Raport Final</h4>
    <p class="text-secondary small mb-0">Kelola permohonan revisi nilai dari guru/wali kelas dan otorisasi langsung raport yang berstatus Final</p>
  </div>
</div>

<!-- Nav Tabs Antara Permohonan Masuk vs Raport Terkunci -->
<ul class="nav nav-tabs mb-3" id="raportUnlockTabs" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active fw-semibold" id="tab-requests-btn" data-bs-toggle="tab" data-bs-target="#tab-requests" type="button" role="tab" aria-selected="true">
      Permohonan dari Guru
      <?php if (!empty($unlockRequestsPending)): ?>
        <span class="badge bg-danger ms-1"><?= count($unlockRequestsPending) ?></span>
      <?php endif; ?>
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link fw-semibold" id="tab-locked-btn" data-bs-toggle="tab" data-bs-target="#tab-locked" type="button" role="tab" aria-selected="false">
      Raport Final (Buka Kunci Langsung)
      <span class="badge bg-secondary-subtle text-secondary ms-1"><?= count($lockedRaportList) ?></span>
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link fw-semibold" id="tab-audit-btn" data-bs-toggle="tab" data-bs-target="#tab-audit" type="button" role="tab" aria-selected="false">
      Audit Trail Perubahan Nilai
      <span class="badge bg-secondary-subtle text-secondary ms-1"><?= count($logPerubahanNilai ?? []) ?></span>
    </button>
  </li>
</ul>

<div class="tab-content" id="raportUnlockTabsContent">

  <!-- Tab 1: Permohonan dari Guru -->
  <div class="tab-pane fade show active" id="tab-requests" role="tabpanel">
    <div class="card mb-4 border">
      <div class="card-header bg-body py-2 px-3 d-flex justify-content-between align-items-center">
        <div>
          <h6 class="mb-0 fw-semibold text-body">
            Pengajuan Revisi Raport Menunggu Konfirmasi
          </h6>
          <span class="text-secondary small">Wali kelas atau guru mapel yang memerlukan perbaikan data nilai</span>
        </div>
        <span class="text-secondary small">
          <?= count($unlockRequestsPending) ?> permohonan
        </span>
      </div>

      <div class="card-body p-0">
        <?php if (!empty($unlockRequestsPending)): ?>
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th style="width: 50px;">No</th>
                  <th>Nama Siswa & NIS</th>
                  <th>Rombel & Semester</th>
                  <th>Alasan Pengajuan Revisi</th>
                  <th>Diminta Oleh & Waktu</th>
                  <th>Status</th>
                  <th class="text-end" style="width: 170px;">Keputusan Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach ($unlockRequestsPending as $req): ?>
                  <tr>
                    <td class="font-monospace text-secondary small"><?= $no++ ?></td>
                    <td>
                      <span class="fw-semibold text-body small d-block"><?= esc($req['siswa_nama']) ?></span>
                      <span class="font-monospace small text-secondary">NIS: <?= esc($req['siswa_nis']) ?></span>
                    </td>
                    <td>
                      <span class="badge bg-secondary-subtle text-secondary border d-block mb-1"><?= esc($req['kelas']) ?></span>
                      <span class="text-secondary small"><?= esc($req['semester']) ?></span>
                    </td>
                    <td style="max-width: 280px;">
                      <div class="p-2 rounded bg-light border small text-secondary">
                        "<?= esc($req['alasan']) ?>"
                      </div>
                    </td>
                    <td>
                      <span class="fw-medium text-body d-block small"><?= esc($req['diminta_oleh']) ?></span>
                      <span class="text-secondary small"><?= esc($req['diminta_pada']) ?></span>
                    </td>
                    <td>
                      <span class="text-warning small fw-semibold">
                        Pending
                      </span>
                    </td>
                    <td class="text-end">
                      <div class="d-inline-flex gap-1">
                        <button type="button" class="btn btn-outline-success btn-sm py-0 px-2" data-bs-toggle="modal" data-bs-target="#modalApproveUnlock<?= $req['id'] ?>">
                          Setujui
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2" data-bs-toggle="modal" data-bs-target="#modalRejectUnlock<?= $req['id'] ?>">
                          Tolak
                        </button>
                      </div>
                    </td>
                  </tr>

                  <!-- Modal Setujui Buka Kunci -->
                  <div class="modal fade" id="modalApproveUnlock<?= $req['id'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content border shadow-sm">
                        <form action="<?= base_url('admin/save-action') ?>" method="post">
                          <?= csrf_field() ?>
                          <input type="hidden" name="action" value="Permohonan buka kunci raport <?= esc($req['siswa_nama']) ?> telah disetujui. Status raport kembali ke Draft.">
                          <input type="hidden" name="unlock_decision" value="approve">
                          <input type="hidden" name="siswa_id" value="<?= esc($req['siswa_id'] ?? $req['id']) ?>">
                          <input type="hidden" name="request_id" value="<?= esc($req['id']) ?>">
                          <input type="hidden" name="redirect_url" value="/admin/raport/buka-kunci">

                          <div class="modal-header">
                            <h6 class="modal-title fw-semibold">
                              Setujui Pembukaan Kunci Raport
                            </h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p class="small text-body mb-2">
                              Apakah Anda yakin menyetujui pembukaan kunci raport untuk siswa <strong><?= esc($req['siswa_nama']) ?></strong>?
                            </p>
                            <div class="p-2 bg-light rounded border small mb-3">
                              <span class="fw-semibold">Alasan Pengajuan Guru:</span>
                              <p class="mb-0 text-secondary mt-1">"<?= esc($req['alasan']) ?>"</p>
                            </div>
                            <span class="text-secondary small d-block">
                              Status raport siswa ini akan dikembalikan dari <strong>Final</strong> menjadi <strong>Draft</strong> sehingga guru dapat merevisi nilai.
                            </span>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success btn-sm px-3">
                              Ya, Setujui
                            </button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <!-- Modal Tolak Permohonan -->
                  <div class="modal fade" id="modalRejectUnlock<?= $req['id'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content border shadow-sm">
                        <form action="<?= base_url('admin/save-action') ?>" method="post">
                          <?= csrf_field() ?>
                          <input type="hidden" name="action" value="Permohonan buka kunci raport <?= esc($req['siswa_nama']) ?> ditolak oleh Admin.">
                          <input type="hidden" name="unlock_decision" value="reject">
                          <input type="hidden" name="siswa_id" value="<?= esc($req['siswa_id'] ?? $req['id']) ?>">
                          <input type="hidden" name="request_id" value="<?= esc($req['id']) ?>">
                          <input type="hidden" name="redirect_url" value="/admin/raport/buka-kunci">

                          <div class="modal-header">
                            <h6 class="modal-title fw-semibold text-danger">
                              Tolak Permohonan Buka Kunci
                            </h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p class="small text-body mb-3">
                              Tolak permohonan buka kunci raport untuk siswa <strong><?= esc($req['siswa_nama']) ?></strong>:
                            </p>
                            <div class="mb-3">
                              <label class="form-label small fw-semibold text-secondary mb-1">Alasan Penolakan (Opsional)</label>
                              <textarea class="form-control form-control-sm" name="alasan_penolakan" rows="2" placeholder="Contoh: Batas waktu revisi semester ganjil telah lewat..."></textarea>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger btn-sm px-3">
                              Konfirmasi Penolakan
                            </button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="p-4 text-center text-secondary small">
            <p class="mb-0 fw-medium">Tidak ada permohonan buka kunci raport yang pending.</p>
            <span class="text-secondary">Semua raport terkunci dalam kondisi aman.</span>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Tab 2: Raport Final (Buka Kunci Langsung) -->
  <div class="tab-pane fade" id="tab-locked" role="tabpanel">
    <div class="card mb-4 border">
      <div class="card-header bg-body py-2 px-3">
        <div class="row g-2 align-items-center">
          <div class="col-md-4">
            <input type="text" class="form-control form-control-sm" placeholder="Cari nama siswa / kelas...">
          </div>
          <div class="col-md-8 text-md-end">
            <span class="text-secondary small">Administrator memiliki hak langsung untuk membuka kunci raport kapan saja</span>
          </div>
        </div>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width: 50px;">No</th>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>Rombel</th>
                <th>Semester</th>
                <th>Waktu Finalisasi</th>
                <th>Status</th>
                <th class="text-end" style="width: 140px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($lockedRaportList as $lr): ?>
                <tr>
                  <td class="font-monospace text-secondary small"><?= $no++ ?></td>
                  <td class="text-body fw-medium small"><?= esc($lr['nama_siswa']) ?></td>
                  <td><span class="font-monospace small text-secondary"><?= esc($lr['nis']) ?></span></td>
                  <td><span class="badge bg-secondary-subtle text-secondary border"><?= esc($lr['kelas']) ?></span></td>
                  <td class="small"><?= esc($lr['semester']) ?></td>
                  <td>
                    <span class="text-secondary small d-block"><?= esc($lr['finalized_at']) ?></span>
                    <span class="text-secondary small">Oleh: <?= esc($lr['finalized_by']) ?></span>
                  </td>
                  <td>
                    <span class="text-danger small fw-semibold">Terkunci</span>
                  </td>
                  <td class="text-end">
                    <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2" data-bs-toggle="modal" data-bs-target="#modalBukaKunciDirect<?= $lr['id'] ?>">
                      Buka Kunci
                    </button>
                  </td>
                </tr>

                <!-- Modal Buka Kunci Langsung Admin -->
                <div class="modal fade" id="modalBukaKunciDirect<?= $lr['id'] ?>" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border shadow-sm">
                      <form action="<?= base_url('admin/save-action') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="Pembukaan kunci raport siswa <?= esc($lr['nama_siswa']) ?> oleh Administrator">
                        <input type="hidden" name="unlock_decision" value="approve">
                        <input type="hidden" name="siswa_id" value="<?= esc($lr['id']) ?>">
                        <input type="hidden" name="redirect_url" value="/admin/raport/buka-kunci">

                        <div class="modal-header">
                          <h6 class="modal-title fw-semibold">
                            Buka Kunci Langsung oleh Admin
                          </h6>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <p class="small mb-2">Anda akan mengembalikan status raport ananda <strong><?= esc($lr['nama_siswa']) ?></strong> dari <em>Final</em> menjadi <em>Draft</em>.</p>
                          
                          <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary mb-1">Catatan Otorisasi Admin (Wajib Diisi)</label>
                            <textarea class="form-control form-control-sm" name="alasan_revisi" rows="3" placeholder="Contoh: Koreksi nilai ulangan susulan Matematika dan perbaikan deskripsi sikap..." required></textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-primary btn-sm px-3">
                            Ya, Buka Kunci
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Tab 3: Audit Trail Riwayat Perubahan Nilai Pasca Buka Kunci -->
  <div class="tab-pane fade" id="tab-audit" role="tabpanel">
    <div class="card mb-4 border">
      <div class="card-header bg-body py-2 px-3 d-flex justify-content-between align-items-center">
        <div>
          <h6 class="mb-0 fw-semibold text-body">
            Audit Trail Log Perubahan & Revisi Nilai Siswa
          </h6>
          <span class="text-secondary small">Perekaman jejak riwayat koreksi nilai pasca pembukaan kunci raport</span>
        </div>
        <span class="text-secondary small">
          Sistem Audit Aktif
        </span>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width: 50px;">No</th>
                <th>Siswa / NIS</th>
                <th>Mata Pelajaran & Komponen</th>
                <th>Nilai Sebelum &rarr; Sesudah</th>
                <th>Alasan Revisi & Pengubah</th>
                <th>Otorisasi</th>
                <th>Waktu Perubahan</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($logPerubahanNilai)): ?>
                <?php $no = 1; foreach ($logPerubahanNilai as $log): ?>
                  <tr>
                    <td class="font-monospace text-secondary small"><?= $no++ ?></td>
                    <td>
                      <span class="fw-semibold text-body small d-block"><?= esc($log['siswa_nama'] ?? '-') ?></span>
                      <span class="font-monospace small text-secondary">NIS: <?= esc($log['siswa_nis'] ?? '-') ?> &bull; <?= esc($log['kelas'] ?? '-') ?></span>
                    </td>
                    <td>
                      <span class="badge bg-secondary-subtle text-secondary border d-block mb-1"><?= esc($log['mapel'] ?? ($log['mata_pelajaran'] ?? 'Semua Mapel')) ?></span>
                      <span class="text-secondary small"><?= esc($log['komponen'] ?? 'Status Raport') ?></span>
                    </td>
                    <td>
                      <span class="font-monospace small"><?= esc($log['nilai_sebelum'] ?? '-') ?> &rarr; <strong class="text-success"><?= esc($log['nilai_sesudah'] ?? '-') ?></strong></span>
                    </td>
                    <td style="max-width: 250px;">
                      <div class="small text-secondary mb-1">"<?= esc($log['alasan'] ?? '-') ?>"</div>
                      <span class="text-secondary small d-block"><?= esc($log['diubah_oleh'] ?? '-') ?></span>
                    </td>
                    <td>
                      <span class="text-success small fw-medium">Disetujui</span>
                      <span class="text-secondary small d-block"><?= esc($log['disetujui_oleh'] ?? 'Kepala Sekolah') ?></span>
                    </td>
                    <td>
                      <span class="text-secondary small d-block"><?= !empty($log['waktu_perubahan']) ? date('d M Y', strtotime($log['waktu_perubahan'])) : date('d M Y') ?></span>
                      <span class="font-monospace small text-secondary"><?= !empty($log['waktu_perubahan']) ? date('H:i:s', strtotime($log['waktu_perubahan'])) : date('H:i:s') ?> WIB</span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="text-center py-4 text-secondary small">Belum ada catatan log revisi nilai.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>

<?= $this->endSection() ?>
