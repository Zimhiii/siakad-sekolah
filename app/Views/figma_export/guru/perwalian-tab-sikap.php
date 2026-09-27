<?php $activeTab = 'sikap'; ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
  <div>
    <h4 class="fw-bold mb-1">Kelas Perwalian: XI-MIPA-1</h4>
    <p class="text-secondary small mb-0">Pengisian penilaian Sikap Spiritual &amp; Sosial, Kegiatan Ekstrakurikuler, Catatan Prestasi, dan Rekapitulasi Kehadiran</p>
  </div>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs mb-3">
  <li class="nav-item">
    <a class="nav-link px-4 <?= ($activeTab === 'sikap') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('guru/perwalian/sikap') ?>">
      Penilaian Sikap
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link px-4 <?= ($activeTab === 'ekskul') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('guru/perwalian/ekskul') ?>">
      Ekstrakurikuler
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link px-4 <?= ($activeTab === 'prestasi') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('guru/perwalian/prestasi') ?>">
      Catatan Prestasi
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link px-4 <?= ($activeTab === 'absensi') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('guru/perwalian/absensi') ?>">
      Rekap Kehadiran
    </a>
  </li>
</ul>

<form action="<?= ($activeTab === 'absensi') ? base_url('guru/perwalian/absensi') : base_url('guru/save-action') ?>" method="post">
  <?= csrf_field() ?>
  <input type="hidden" name="action" value="Data <?= ucfirst($activeTab) ?> Kelas XI-MIPA-1">
  <input type="hidden" name="redirect_url" value="/guru/perwalian/<?= $activeTab ?>">

  <div class="card mb-4 border">
    <div class="card-body p-0">
      
      <?php if ($activeTab === 'sikap'): ?>
        <!-- TAB 1: SIKAP MATRIX -->
        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle mb-0 text-center">
            <thead class="table-light">
              <tr>
                <th class="text-start" style="width: 48px;">No</th>
                <th class="text-start" style="min-width: 220px;">Nama Siswa</th>
                <th style="min-width: 180px;">Sikap Spiritual (Predikat)</th>
                <th style="min-width: 180px;">Sikap Sosial (Predikat)</th>
                <th class="text-start" style="min-width: 300px;">Catatan Deskripsi Sikap</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($siswaList)): ?>
                <tr>
                  <td colspan="5" class="text-center py-4 text-secondary">Belum ada siswa dalam rombel ini.</td>
                </tr>
              <?php else: ?>
                <?php $no = 1; foreach ($siswaList as $s): ?>
                  <tr>
                    <td class="text-secondary"><?= $no++ ?></td>
                    <td class="text-start">
                      <span class="text-body d-block fw-medium"><?= esc($s['nama']) ?></span>
                      <small class="text-secondary">NIS: <?= esc($s['nis']) ?></small>
                    </td>
                    <td>
                      <select name="sikap[<?= $s['id'] ?>][spiritual]" class="form-select form-select-sm text-center fw-medium">
                        <option value="SB" selected>Sangat Baik (A)</option>
                        <option value="B">Baik (B)</option>
                        <option value="C">Cukup (C)</option>
                        <option value="K">Kurang (D)</option>
                      </select>
                    </td>
                    <td>
                      <select name="sikap[<?= $s['id'] ?>][sosial]" class="form-select form-select-sm text-center fw-medium">
                        <option value="SB">Sangat Baik (A)</option>
                        <option value="B" selected>Baik (B)</option>
                        <option value="C">Cukup (C)</option>
                        <option value="K">Kurang (D)</option>
                      </select>
                    </td>
                    <td>
                      <input type="text" name="sikap[<?= $s['id'] ?>][deskripsi]" class="form-control form-control-sm" value="Menunjukkan ketaatan beribadah dan sikap sopan santun yang konsisten dalam pergaulan sekolah.">
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

      <?php elseif ($activeTab === 'ekskul'): ?>
        <!-- TAB 2: EKSTRAKURIKULER -->
        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width: 48px;" class="text-center">No</th>
                <th style="min-width: 220px;">Nama Siswa</th>
                <th style="min-width: 200px;">Ekstrakurikuler Wajib</th>
                <th style="min-width: 220px;">Ekstrakurikuler Pilihan</th>
                <th>Keterangan / Capaian</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($siswaList)): ?>
                <tr>
                  <td colspan="5" class="text-center py-4 text-secondary">Belum ada siswa dalam rombel ini.</td>
                </tr>
              <?php else: ?>
                <?php $no = 1; foreach ($siswaList as $s): ?>
                  <tr>
                    <td class="text-center text-secondary"><?= $no++ ?></td>
                    <td>
                      <span class="text-body d-block fw-medium"><?= esc($s['nama']) ?></span>
                      <small class="text-secondary">NIS: <?= esc($s['nis']) ?></small>
                    </td>
                    <td>
                      <div class="d-flex gap-2 align-items-center">
                        <span class="fw-medium small">Pramuka:</span>
                        <select name="ekskul[<?= $s['id'] ?>][nilai_wajib]" class="form-select form-select-sm w-auto">
                          <option value="A" selected>A (Sangat Baik)</option>
                          <option value="B">B (Baik)</option>
                        </select>
                      </div>
                    </td>
                    <td>
                      <div class="d-flex gap-2 align-items-center">
                        <select name="ekskul[<?= $s['id'] ?>][pilihan]" class="form-select form-select-sm">
                          <option value="Robotika &amp; IoT" selected>Robotika &amp; IoT</option>
                          <option value="PMR / KSR">PMR / KSR</option>
                          <option value="Paskibra">Paskibra</option>
                          <option value="KIR (Karya Ilmiah)">KIR (Karya Ilmiah)</option>
                        </select>
                        <select name="ekskul[<?= $s['id'] ?>][nilai_pilihan]" class="form-select form-select-sm w-auto">
                          <option value="A" selected>A</option>
                          <option value="B">B</option>
                        </select>
                      </div>
                    </td>
                    <td>
                      <input type="text" name="ekskul[<?= $s['id'] ?>][keterangan]" class="form-control form-control-sm" value="Aktif dalam kejuaraan line tracer tingkat kota.">
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

      <?php elseif ($activeTab === 'prestasi'): ?>
        <!-- TAB 3: CATATAN PRESTASI -->
        <div class="p-3">
          <div class="card bg-body-tertiary border mb-3">
            <div class="card-body py-2 px-3 small text-secondary">
              Catat prestasi kompetisi akademik maupun non-akademik siswa yang diraih selama semester aktif ini untuk ditampilkan pada Raport Bagian D.
            </div>
          </div>

          <?php if (empty($siswaList)): ?>
            <div class="text-center py-4 text-secondary">Belum ada siswa dalam rombel ini.</div>
          <?php else: ?>
            <?php $idx = 1; foreach ($siswaList as $s): ?>
              <div class="card mb-3 border prestasi-card">
                <div class="card-header bg-body d-flex justify-content-between align-items-center py-2">
                  <span class="fw-semibold small"><?= $idx++ ?>. <?= esc($s['nama']) ?> (NIS: <?= esc($s['nis']) ?>)</span>
                  <span class="text-secondary small">1 Prestasi Tercatat</span>
                </div>
                <div class="card-body p-3">
                  <div class="row g-2 align-items-center">
                    <div class="col-md-3">
                      <select name="prestasi[<?= $s['id'] ?>][kategori]" class="form-select form-select-sm">
                        <option value="Prestasi Akademik" selected>Prestasi Akademik</option>
                        <option value="Prestasi Non-Akademik / Seni">Prestasi Non-Akademik / Seni</option>
                        <option value="Prestasi Olahraga">Prestasi Olahraga</option>
                        <option value="Prestasi Keagamaan / Tahfidz">Prestasi Keagamaan / Tahfidz</option>
                      </select>
                    </div>
                    <div class="col-md-2">
                      <select name="prestasi[<?= $s['id'] ?>][tingkat]" class="form-select form-select-sm">
                        <option value="Tingkat Kabupaten/Kota" selected>Tingkat Kabupaten/Kota</option>
                        <option value="Tingkat Provinsi">Tingkat Provinsi</option>
                        <option value="Tingkat Nasional">Tingkat Nasional</option>
                        <option value="Tingkat Internasional">Tingkat Internasional</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <input type="text" name="prestasi[<?= $s['id'] ?>][keterangan]" class="form-control form-control-sm" value="Juara 2 Olimpiade Sains Nasional (OSN) Tingkat Kabupaten Bidang Matematika 2025" placeholder="Keterangan prestasi">
                    </div>
                    <div class="col-md-1 text-end">
                      <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus Prestasi" onclick="this.closest('.prestasi-card').remove()">Hapus</button>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

      <?php elseif ($activeTab === 'absensi'): ?>
        <!-- TAB 4: REKAP KEHADIRAN / ABSENSI KELAS -->
        <div class="card bg-body-tertiary border m-3 mb-0">
          <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 small">
            <div>
              <span class="fw-semibold text-body">Sinkronisasi Raport:</span>
              <span class="text-secondary ms-1">Jumlah Sakit (S), Izin (I), dan Alpa (A) akan otomatis dimasukkan ke Bagian E (Ketidakhadiran) lembar raport.</span>
            </div>
            <div>
              <a href="<?= base_url('guru/raport/tinjau/1') ?>" class="btn btn-outline-secondary btn-sm">
                Tinjau di Lembar Raport
              </a>
            </div>
          </div>
        </div>

        <div class="table-responsive p-3">
          <table class="table table-bordered table-hover align-middle mb-0 text-center">
            <thead class="table-light">
              <tr>
                <th class="text-start" style="width: 48px;">No</th>
                <th class="text-start" style="min-width: 200px;">Nama Siswa</th>
                <th style="width: 100px;">
                  Sakit (S)<br><small class="text-secondary fw-normal">(Hari)</small>
                </th>
                <th style="width: 100px;">
                  Izin (I)<br><small class="text-secondary fw-normal">(Hari)</small>
                </th>
                <th style="width: 100px;">
                  Alpa (A)<br><small class="text-secondary fw-normal">(Hari)</small>
                </th>
                <th style="width: 110px;">Total Absen<br><small class="text-secondary fw-normal">(S + I + A)</small></th>
                <th style="width: 130px;">Persentase Hadir<br><small class="text-secondary fw-normal">(Est. 100 Hari KBM)</small></th>
                <th class="text-start" style="min-width: 240px;">Catatan Kedisiplinan / Kehadiran</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($siswaList as $s): ?>
                <?php 
                  $abs = $s['absensi'] ?? ['sakit' => 0, 'izin' => 0, 'tanpa_keterangan' => 0, 'catatan' => ''];
                  $sakit = (int)($abs['sakit'] ?? 0);
                  $izin = (int)($abs['izin'] ?? 0);
                  $alpa = (int)($abs['tanpa_keterangan'] ?? ($abs['alpa'] ?? 0));
                  $totalAbsen = $sakit + $izin + $alpa;
                  $pctHadir = max(0, round(((100 - $totalAbsen) / 100) * 100, 1));
                ?>
                <tr>
                  <td class="text-start text-secondary"><?= $no++ ?></td>
                  <td class="text-start">
                    <span class="text-body fw-medium d-block"><?= esc($s['nama']) ?></span>
                    <small class="text-secondary">NIS: <?= esc($s['nis']) ?></small>
                  </td>
                  <td>
                    <input type="number" name="sakit[<?= $s['id'] ?>]" value="<?= $sakit ?>" min="0" max="100" class="form-control form-control-sm text-center fw-bold input-sakit" data-siswa-id="<?= $s['id'] ?>">
                  </td>
                  <td>
                    <input type="number" name="izin[<?= $s['id'] ?>]" value="<?= $izin ?>" min="0" max="100" class="form-control form-control-sm text-center fw-bold input-izin" data-siswa-id="<?= $s['id'] ?>">
                  </td>
                  <td>
                    <input type="number" name="tanpa_keterangan[<?= $s['id'] ?>]" value="<?= $alpa ?>" min="0" max="100" class="form-control form-control-sm text-center fw-bold input-alpa" data-siswa-id="<?= $s['id'] ?>">
                  </td>
                  <td>
                    <span id="totalAbsen_<?= $s['id'] ?>" class="<?= ($totalAbsen > 3) ? 'text-danger fw-semibold' : 'text-body' ?>">
                      <?= $totalAbsen ?> Hari
                    </span>
                  </td>
                  <td>
                    <span id="pctHadir_<?= $s['id'] ?>" class="fw-medium <?= ($pctHadir >= 95) ? 'text-success' : (($pctHadir >= 90) ? 'text-body' : 'text-danger') ?>">
                      <?= $pctHadir ?>%
                    </span>
                  </td>
                  <td>
                    <input type="text" name="catatan[<?= $s['id'] ?>]" value="<?= esc($abs['catatan'] ?? '') ?>" class="form-control form-control-sm" placeholder="Catatan kehadiran siswa...">
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>

    </div>
  </div>

  <!-- Sticky Save Bar -->
  <div class="sticky-bottom-bar d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 shadow-sm border">
    <div class="text-secondary small">
      <?php if ($activeTab === 'absensi'): ?>
        Menyimpan rekap kehadiran akan otomatis memperbarui data ketidakhadiran di lembar raport digital kelas XI-MIPA-1.
      <?php else: ?>
        Perubahan data <?= ucfirst($activeTab) ?> tersimpan ke buku perwalian kelas XI-MIPA-1.
      <?php endif; ?>
    </div>
    <div class="d-flex gap-2">
      <button type="reset" class="btn btn-outline-secondary btn-sm px-3">Batal</button>
      <button type="submit" class="btn btn-primary btn-sm px-4">
        Simpan Data <?= ucfirst($activeTab) ?>
      </button>
    </div>
  </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
  function updateAbsensiRow(siswaId) {
    const elSakit = document.querySelector('input[name="sakit[' + siswaId + ']"]');
    const elIzin = document.querySelector('input[name="izin[' + siswaId + ']"]');
    const elAlpa = document.querySelector('input[name="tanpa_keterangan[' + siswaId + ']"]');

    if (!elSakit || !elIzin || !elAlpa) return;

    const s = parseInt(elSakit.value) || 0;
    const i = parseInt(elIzin.value) || 0;
    const a = parseInt(elAlpa.value) || 0;
    const total = s + i + a;
    const pct = Math.max(0, Math.round(((100 - total) / 100) * 1000) / 10);

    const badgeTotal = document.getElementById('totalAbsen_' + siswaId);
    const textPct = document.getElementById('pctHadir_' + siswaId);

    if (badgeTotal) {
      badgeTotal.textContent = total + ' Hari';
      badgeTotal.className = (total > 3) ? 'text-danger fw-semibold' : 'text-body';
    }

    if (textPct) {
      textPct.textContent = pct + '%';
      if (pct >= 95) {
        textPct.className = 'fw-medium text-success';
      } else if (pct >= 90) {
        textPct.className = 'fw-medium text-body';
      } else {
        textPct.className = 'fw-medium text-danger';
      }
    }
  }

  document.querySelectorAll('.input-sakit, .input-izin, .input-alpa').forEach(input => {
    input.addEventListener('input', function() {
      const sId = this.dataset.siswaId;
      updateAbsensiRow(sId);
    });
  });
});
</script>

<?= $this->endSection() ?>

