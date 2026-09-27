<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">Modul Ujian Sekolah &amp; Formula Kelulusan (Kelas 12)</h4>
    <p class="text-secondary small mb-0">Konfigurasi bobot kelulusan, manajemen nilai ujian sekolah, dan kalkulasi nilai akhir kelulusan</p>
  </div>
  <div>
    <span class="text-secondary small">
      Tahun Ajaran 2025/2026
    </span>
  </div>
</div>

<div class="row g-3 mb-3">
  <!-- Formula Kelulusan Card -->
  <div class="col-lg-5">
    <div class="card border h-100">
      <div class="card-header bg-body px-3 py-2 d-flex justify-content-between align-items-center">
        <span class="fw-semibold small text-body">
          Formula Perhitungan Nilai Kelulusan
        </span>
        <span class="text-success small fw-medium">Aktif</span>
      </div>
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Konfigurasi Formula Kelulusan Kelas 12">
        <input type="hidden" name="redirect_url" value="/admin/ujian-sekolah">

        <div class="card-body p-3">
          <div class="alert alert-light border py-2 px-3 mb-3 small">
            <span class="fw-semibold d-block">Formula Resmi Kelulusan:</span>
            <code class="small text-body">Nilai Akhir = (Bobot Rapor &times; Rata-rata Smt 1-5) + (Bobot US &times; Rata-rata Ujian Sekolah)</code>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Jumlah Semester Rapor yang Digunakan</label>
            <select class="form-select form-select-sm" name="jumlah_semester_raport">
              <option value="5" <?= ($formula['jumlah_semester_raport'] ?? 6) == 5 ? 'selected' : '' ?>>5 Semester (Smt 1 - Smt 5 / Prediksi Kelulusan Awal)</option>
              <option value="6" <?= ($formula['jumlah_semester_raport'] ?? 6) == 6 ? 'selected' : '' ?>>6 Semester (Smt 1 - Smt 6 / Kelulusan Akhir Definitif)</option>
            </select>
            <span class="text-secondary small d-block mt-1">Pilih 5 semester untuk simulasi, atau 6 semester penuh untuk penentuan kelulusan definitif &amp; SKL.</span>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Bobot Rata-rata Rapor (%)</label>
            <div class="input-group input-group-sm">
              <input type="number" class="form-control" name="bobot_rapor" value="<?= esc($formula['bobot_rapor']) ?>" min="0" max="100" required>
              <span class="input-group-text">%</span>
            </div>
            <span class="text-secondary small d-block mt-1">Akumulasi nilai rapor sesuai jumlah semester yang dipilih di atas.</span>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Bobot Nilai Ujian Sekolah / US (%)</label>
            <div class="input-group input-group-sm">
              <input type="number" class="form-control" name="bobot_us" value="<?= esc($formula['bobot_ujian_sekolah']) ?>" min="0" max="100" required>
              <span class="input-group-text">%</span>
            </div>
            <span class="text-secondary small d-block mt-1">Nilai ujian tulis dan praktik yang diselenggarakan satuan pendidikan.</span>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Ambang Batas Minimal KKM Kelulusan</label>
            <input type="number" step="0.1" class="form-control form-control-sm" name="kkm_kelulusan" value="<?= esc($formula['kkm_kelulusan']) ?>" required>
          </div>

          <div class="p-2 rounded bg-light border small">
            <span class="text-secondary d-block">Keterangan Regulasi:</span>
            <span class="text-body fw-medium"><?= esc($formula['keterangan']) ?></span>
          </div>
        </div>

        <div class="card-footer bg-body py-2 px-3 text-end">
          <button type="submit" class="btn btn-primary btn-sm px-3">
            Simpan Formula Kelulusan
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Master Mapel Ujian Sekolah Card -->
  <div class="col-lg-7">
    <div class="card border h-100">
      <div class="card-header bg-body px-3 py-2 d-flex justify-content-between align-items-center">
        <span class="fw-semibold small text-body">
          Mata Pelajaran Ujian Sekolah (US 2025/2026)
        </span>
        <span class="text-secondary small">
          <?= count($ujianData['mapel_ujian']) ?> Mapel
        </span>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width: 50px;">No</th>
                <th>Kode</th>
                <th>Mata Pelajaran Ujian</th>
                <th>KKM</th>
                <th>Bentuk Ujian</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($ujianData['mapel_ujian'] as $mu): ?>
                <tr>
                  <td class="font-monospace text-secondary small"><?= $no++ ?></td>
                  <td><span class="font-monospace small text-secondary"><?= esc($mu['kode']) ?></span></td>
                  <td class="fw-medium small text-body"><?= esc($mu['nama']) ?></td>
                  <td class="font-monospace small text-secondary"><?= esc($mu['kkm']) ?>.00</td>
                  <td>
                    <span class="badge bg-secondary-subtle text-secondary border">Tulis &amp; Praktik</span>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Tabel Rekap Nilai Ujian Sekolah & Nilai Akhir Siswa Kelas 12 -->
<div class="card border mb-4">
  <div class="card-header bg-body px-3 py-2 d-flex justify-content-between align-items-center">
    <div>
      <span class="fw-semibold small text-body d-block">
        Rekapitulasi Nilai Ujian Sekolah &amp; Status Kelulusan (Kelas XII-MIPA-1)
      </span>
      <span class="text-secondary small">Kalkulasi nilai akhir kelulusan untuk penerbitan Ijazah dan SKL</span>
    </div>
    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="SiakadHelper.exportTableToCSV('#tableRekapUS', 'rekap_nilai_ujian_sekolah')">
      Export Rekap US
    </button>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" id="tableRekapUS">
        <thead class="table-light">
          <tr>
            <th style="width: 50px;">No</th>
            <th>Nama Siswa &amp; NIS</th>
            <th>Kelas</th>
            <th class="text-center">Rapor Smt 1-5 (60%)</th>
            <th class="text-center">Rata US (40%)</th>
            <th class="text-center">Nilai Akhir</th>
            <th class="text-center">Status</th>
            <th>Nomor Ijazah</th>
            <th class="text-end" style="width: 150px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($ujianData['siswa_kelas12'] as $sk): ?>
            <tr>
              <td class="font-monospace text-secondary small"><?= $no++ ?></td>
              <td>
                <span class="fw-semibold text-body small d-block"><?= esc($sk['nama']) ?></span>
                <span class="font-monospace small text-secondary">NIS: <?= esc($sk['nis']) ?></span>
              </td>
              <td><span class="badge bg-secondary-subtle text-secondary border"><?= esc($sk['kelas']) ?></span></td>
              <td class="text-center font-monospace small fw-medium"><?= number_format($sk['rata_rapor_smt_1_5'], 1) ?></td>
              <td class="text-center font-monospace small fw-medium"><?= number_format($sk['rata_us'], 1) ?></td>
              <td class="text-center font-monospace small fw-bold">
                <?= number_format($sk['nilai_akhir'], 1) ?>
              </td>
              <td class="text-center">
                <span class="text-success small fw-medium">
                  <?= esc($sk['status_kelulusan']) ?>
                </span>
              </td>
              <td>
                <span class="font-monospace small text-secondary"><?= esc($sk['nomor_ijazah']) ?></span>
              </td>
              <td class="text-end">
                <div class="d-inline-flex gap-1">
                  <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2" data-bs-toggle="modal" data-bs-target="#modalDetailUS<?= $sk['siswa_id'] ?>" title="Rincian Nilai US">
                    Detail
                  </button>
                  <a href="<?= base_url('admin/siswa/transkrip/' . $sk['siswa_id']) ?>" class="btn btn-outline-secondary btn-sm py-0 px-2" title="Cetak Transkrip Lengkap">
                    Transkrip
                  </a>
                </div>
              </td>
            </tr>

            <!-- Modal Detail Nilai US Siswa -->
            <div class="modal fade" id="modalDetailUS<?= $sk['siswa_id'] ?>" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border shadow-sm">
                  <div class="modal-header py-2 px-3">
                    <h6 class="modal-title fw-semibold">
                      Rincian Nilai Ujian Sekolah: <?= esc($sk['nama']) ?>
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body p-3">
                    <div class="row g-3 mb-3">
                      <div class="col-md-4">
                        <div class="p-3 border rounded bg-light">
                          <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-secondary small">Rata-rata Rapor (Smt 1-5)</span>
                            <span class="small font-monospace text-secondary">60%</span>
                          </div>
                          <div class="fs-5 fw-bold font-monospace"><?= number_format($sk['rata_rapor_smt_1_5'], 1) ?></div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="p-3 border rounded bg-light">
                          <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-secondary small">Rata-rata Ujian Sekolah</span>
                            <span class="small font-monospace text-secondary">40%</span>
                          </div>
                          <div class="fs-5 fw-bold font-monospace"><?= number_format($sk['rata_us'], 1) ?></div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="p-3 border rounded bg-light">
                          <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-secondary small">Nilai Akhir Kelulusan</span>
                            <span class="text-success small fw-bold">LULUS</span>
                          </div>
                          <div class="fs-5 fw-bold font-monospace text-success"><?= number_format($sk['nilai_akhir'], 1) ?></div>
                        </div>
                      </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="fw-semibold text-body small">Daftar Nilai per Mata Pelajaran Ujian Sekolah</span>
                      <span class="text-secondary small"><?= count($ujianData['mapel_ujian']) ?> Mata Pelajaran</span>
                    </div>
                    <div class="table-responsive rounded border">
                      <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                          <tr>
                            <th style="width: 50px;">No</th>
                            <th>Mata Pelajaran</th>
                            <th class="text-center" style="width: 130px;">Standar KKM</th>
                            <th class="text-center" style="width: 160px;">Nilai Ujian Sekolah</th>
                            <th class="text-center" style="width: 140px;">Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $n = 1; foreach ($ujianData['mapel_ujian'] as $mu): 
                            $val = $sk['nilai_us'][$mu['kode']] ?? 85;
                          ?>
                            <tr>
                              <td class="font-monospace text-secondary small"><?= $n++ ?></td>
                              <td>
                                <span class="fw-medium small text-body"><?= esc($mu['nama']) ?></span>
                                <span class="font-monospace small text-secondary ms-1">(<?= esc($mu['kode']) ?>)</span>
                              </td>
                              <td class="text-center font-monospace small text-secondary"><?= esc($mu['kkm']) ?>.00</td>
                              <td class="text-center font-monospace small fw-bold"><?= esc($val) ?></td>
                              <td class="text-center">
                                <span class="text-success small fw-medium">Tuntas</span>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="modal-footer d-flex justify-content-end gap-2 px-3 py-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <a href="<?= base_url('admin/siswa/transkrip/' . $sk['siswa_id']) ?>" class="btn btn-primary btn-sm">
                      Cetak Lembar Transkrip
                    </a>
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
