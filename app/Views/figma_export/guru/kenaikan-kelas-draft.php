<?php $isDisahkanSemua = false; ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start gap-2 mb-3">
  <div>
    <h4 class="fw-bold mb-1">Keputusan Kenaikan Kelas &amp; Sidang Pleno</h4>
    <p class="text-secondary small mb-0">Usulan rekomendasi status kenaikan atau kelulusan oleh Wali Kelas dan pengesahan Sidang Pleno.</p>
  </div>
  <div>
    <?php if ($isDisahkanSemua): ?>
      <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
        Pleno: Telah Disahkan Resmi
      </span>
    <?php else: ?>
      <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2">
        Pleno: Tahap Usulan / Draft
      </span>
    <?php endif; ?>
  </div>
</div>

<!-- Ringkasan Alur Kenaikan -->
<div class="card bg-body-tertiary border mb-3">
  <div class="card-body py-2 px-3">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 small">
      <div>
        <span class="fw-semibold text-body">Alur Kenaikan:</span>
        <span class="text-secondary ms-1">1. Usulan Wali Kelas &rarr; 2. Sidang Pleno Dewan Guru &amp; Kepsek &rarr; 3. Buka Kunci Transisi Admin</span>
      </div>
      <div class="text-secondary">
        Tahun Ajaran 2025/2026 &bull; Semester Genap
      </div>
    </div>
  </div>
</div>

<form action="<?= base_url('guru/kenaikan-kelas') ?>" method="post">
  <?= csrf_field() ?>

  <!-- Nav Tabs -->
  <ul class="nav nav-tabs mb-3" id="kenaikanTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active fw-medium" id="tab-kenaikan-btn" data-bs-toggle="tab" data-bs-target="#tab-kenaikan" type="button" role="tab" aria-selected="true">
        Kelas X &amp; XI (Kenaikan Kelas)
        <span class="badge bg-secondary-subtle text-secondary border ms-1"><?= count($siswaKenaikan) ?></span>
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link fw-medium" id="tab-kelulusan-btn" data-bs-toggle="tab" data-bs-target="#tab-kelulusan" type="button" role="tab" aria-selected="false">
        Kelas XII (Kelulusan Akhir)
        <span class="badge bg-secondary-subtle text-secondary border ms-1"><?= count($siswaKelulusan) ?></span>
      </button>
    </li>
  </ul>

  <div class="tab-content" id="kenaikanTabsContent">
    
    <!-- Tab 1: Kelas X & XI -->
    <div class="tab-pane fade show active" id="tab-kenaikan" role="tabpanel">
      <div class="card mb-4 border">
        <div class="card-header bg-body py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
          <div>
            <h6 class="mb-0 fw-semibold text-body">Daftar Siswa Kelas XI-MIPA-1</h6>
            <div class="text-secondary small">Tinjau rekap indikator akademik, kehadiran, dan sikap sebelum menentukan rekomendasi usulan.</div>
          </div>
          <span class="badge bg-secondary-subtle text-secondary border">Kenaikan Tingkat ke Kelas XII</span>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th style="width: 48px;" class="text-center">No</th>
                  <th style="min-width: 190px;">Nama Siswa &amp; NIS</th>
                  <th style="min-width: 200px;">Indikator Kelayakan</th>
                  <th style="width: 90px;" class="text-center">Rata-Rata</th>
                  <th style="width: 170px;">Rekomendasi Usulan</th>
                  <th style="width: 150px;">Kelas Tujuan</th>
                  <th style="width: 120px;">Status Pleno</th>
                  <th>Catatan Wali Kelas / Dewan Guru</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach ($siswaKenaikan as $s): ?>
                  <tr>
                    <td class="text-center text-secondary"><?= $no++ ?></td>
                    <td>
                      <div class="fw-semibold text-body"><?= esc($s['nama']) ?></div>
                      <div class="text-secondary small font-monospace">NIS: <?= esc($s['nis']) ?> &bull; <?= esc($s['kelas_asal']) ?></div>
                      <?php if ($s['tinggal_berulang'] ?? false): ?>
                        <div class="mt-1">
                          <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-normal">Perhatian Khusus BK</span>
                        </div>
                      <?php endif; ?>
                    </td>
                    <td>
                      <div class="d-flex flex-column gap-1 small">
                        <div class="d-flex justify-content-between text-secondary">
                          <span>Akademik:</span>
                          <?php if (($s['mapel_bawah_kkm_count'] ?? 0) > 0): ?>
                            <span class="text-danger fw-semibold"><?= $s['mapel_bawah_kkm_count'] ?> Mapel &lt; KKM</span>
                          <?php else: ?>
                            <span class="text-success fw-medium">Tuntas KKM</span>
                          <?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-between text-secondary">
                          <span>Kehadiran:</span>
                          <?php if (($s['kehadiran_persen'] ?? 100) < 85): ?>
                            <span class="text-danger fw-semibold"><?= number_format($s['kehadiran_persen'] ?? 0, 1) ?>% (Kritis)</span>
                          <?php else: ?>
                            <span class="text-body"><?= number_format($s['kehadiran_persen'] ?? 0, 1) ?>%</span>
                          <?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-between text-secondary">
                          <span>Sikap:</span>
                          <span class="text-body"><?= esc($s['sikap_predikat'] ?? 'Baik') ?></span>
                        </div>
                      </div>
                    </td>
                    <td class="text-center">
                      <span class="fw-semibold <?= ($s['rata_rata'] < 75) ? 'text-danger' : 'text-body' ?>">
                        <?= number_format($s['rata_rata'], 1) ?>
                      </span>
                    </td>
                    <td>
                      <select class="form-select form-select-sm select-status-kenaikan" 
                              name="status_usulan[<?= $s['id'] ?>]" 
                              data-row-id="<?= $s['id'] ?>"
                              data-kelas-asal="<?= esc($s['kelas_asal']) ?>"
                              onchange="handleKenaikanChange(this)">
                        <option value="naik" <?= ($s['status'] === 'naik') ? 'selected' : '' ?>>Naik Kelas</option>
                        <option value="tidak_naik" <?= ($s['status'] === 'tidak_naik') ? 'selected' : '' ?>>Tidak Naik (Tinggal)</option>
                      </select>
                    </td>
                    <td>
                      <select class="form-select form-select-sm select-kelas-tujuan" 
                              id="selectKelasTujuan_<?= $s['id'] ?>" 
                              name="kelas_tujuan[<?= $s['id'] ?>]">
                        <option value="XII-MIPA-1" <?= ($s['kelas_tujuan'] === 'XII-MIPA-1' || empty($s['kelas_tujuan'])) ? 'selected' : '' ?>>XII-MIPA-1</option>
                        <option value="XII-MIPA-2" <?= ($s['kelas_tujuan'] === 'XII-MIPA-2') ? 'selected' : '' ?>>XII-MIPA-2</option>
                        <option value="XII-IPS-1" <?= ($s['kelas_tujuan'] === 'XII-IPS-1') ? 'selected' : '' ?>>XII-IPS-1</option>
                        <option value="<?= esc($s['kelas_asal']) ?>" class="opt-kelas-asal d-none"><?= esc($s['kelas_asal']) ?> (Tetap)</option>
                      </select>
                    </td>
                    <td>
                      <?php if (($s['status_pleno'] ?? '') === 'disahkan_pleno'): ?>
                        <span class="badge bg-success-subtle text-success border border-success-subtle fw-normal">Disahkan</span>
                      <?php else: ?>
                        <span class="badge bg-secondary-subtle text-secondary border fw-normal">Draft Usulan</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm" 
                             name="catatan[<?= $s['id'] ?>]" 
                             value="<?= esc($s['catatan']) ?>" 
                             placeholder="Catatan / pertimbangan...">
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Tab 2: Kelas XII (Kelulusan) -->
    <div class="tab-pane fade" id="tab-kelulusan" role="tabpanel">
      <div class="card mb-4 border">
        <div class="card-header bg-body py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
          <div>
            <h6 class="mb-0 fw-semibold text-body">Daftar Siswa Kelas XII</h6>
            <div class="text-secondary small">Penetapan status kelulusan akhir satuan pendidikan dan input nomor seri ijazah.</div>
          </div>
          <span class="badge bg-secondary-subtle text-secondary border">Penetapan SK Kelulusan</span>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th style="width: 48px;" class="text-center">No</th>
                  <th style="min-width: 180px;">Nama Siswa &amp; NIS</th>
                  <th style="width: 130px;">Kelas Asal</th>
                  <th style="width: 110px;" class="text-center">Rata-Rata</th>
                  <th style="width: 220px;">Keputusan Kelulusan</th>
                  <th style="width: 200px;">Nomor Ijazah</th>
                  <th style="width: 120px;">Status Pleno</th>
                  <th>Catatan / Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach ($siswaKelulusan as $s): ?>
                  <tr>
                    <td class="text-center text-secondary"><?= $no++ ?></td>
                    <td>
                      <div class="fw-semibold text-body"><?= esc($s['nama']) ?></div>
                      <div class="text-secondary small font-monospace">NIS: <?= esc($s['nis']) ?></div>
                    </td>
                    <td><span class="badge bg-secondary-subtle text-secondary border"><?= esc($s['kelas_asal']) ?></span></td>
                    <td class="text-center fw-semibold text-body"><?= number_format($s['rata_rata'], 1) ?></td>
                    <td>
                      <select class="form-select form-select-sm" name="status_usulan[<?= $s['id'] ?>]">
                        <option value="lulus" <?= ($s['status'] === 'lulus') ? 'selected' : '' ?>>Lulus</option>
                        <option value="mengulang" <?= ($s['status'] === 'mengulang') ? 'selected' : '' ?>>Belum Memenuhi Syarat (Mengulang)</option>
                      </select>
                      <input type="hidden" name="kelas_tujuan[<?= $s['id'] ?>]" value="<?= ($s['status'] === 'lulus') ? 'Alumni' : esc($s['kelas_asal']) ?>">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm font-monospace" 
                             name="nomor_ijazah[<?= $s['id'] ?>]" 
                             value="<?= esc($s['nomor_ijazah'] ?? '') ?>" 
                             placeholder="DN-02/...">
                    </td>
                    <td>
                      <?php if (($s['status_pleno'] ?? '') === 'disahkan_pleno'): ?>
                        <span class="badge bg-success-subtle text-success border border-success-subtle fw-normal">Disahkan</span>
                      <?php else: ?>
                        <span class="badge bg-secondary-subtle text-secondary border fw-normal">Draft Usulan</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm" 
                             name="catatan[<?= $s['id'] ?>]" 
                             value="<?= esc($s['catatan']) ?>" 
                             placeholder="Catatan kelulusan...">
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

  <!-- Action Bar 2 Tahap -->
  <div class="card bg-body-tertiary border p-3 mb-4 rounded-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div class="small text-secondary">
      Simpan draft usulan untuk keperluan telaah Wali Kelas, atau sahkan secara resmi dalam Sidang Pleno bersama Pimpinan Sekolah.
    </div>
    <div class="d-flex flex-wrap gap-2">
      <button type="submit" name="tindakan" value="simpan_usulan" class="btn btn-outline-secondary btn-sm px-3">
        Simpan Usulan Wali Kelas
      </button>
      <button type="submit" name="tindakan" value="sahkan_pleno" class="btn btn-primary btn-sm px-3" onclick="return confirm('Apakah Anda yakin ingin mengesahkan hasil Sidang Pleno Kenaikan Kelas ini secara resmi? Keputusan ini akan membuka kunci transisi kelas di Administrator.');">
        Sahkan Sidang Pleno
      </button>
    </div>
  </div>
</form>

<script>
function handleKenaikanChange(selectEl) {
  const rowId = selectEl.getAttribute('data-row-id');
  const kelasAsal = selectEl.getAttribute('data-kelas-asal');
  const selectTujuan = document.getElementById('selectKelasTujuan_' + rowId);
  if (!selectTujuan) return;
  const status = selectEl.value;

  if (status === 'tidak_naik') {
    let optAsal = selectTujuan.querySelector('.opt-kelas-asal');
    if (optAsal) {
      optAsal.classList.remove('d-none');
      optAsal.selected = true;
    } else {
      let newOpt = document.createElement('option');
      newOpt.value = kelasAsal;
      newOpt.textContent = kelasAsal + ' (Tetap)';
      newOpt.selected = true;
      newOpt.className = 'opt-kelas-asal';
      selectTujuan.appendChild(newOpt);
    }
    selectTujuan.value = kelasAsal;
    selectTujuan.setAttribute('disabled', 'disabled');

    let hiddenInput = document.getElementById('hiddenKelasTujuan_' + rowId);
    if (!hiddenInput) {
      hiddenInput = document.createElement('input');
      hiddenInput.type = 'hidden';
      hiddenInput.id = 'hiddenKelasTujuan_' + rowId;
      hiddenInput.name = 'kelas_tujuan[' + rowId + ']';
      hiddenInput.value = kelasAsal;
      selectTujuan.parentNode.appendChild(hiddenInput);
    } else {
      hiddenInput.value = kelasAsal;
    }
  } else {
    selectTujuan.removeAttribute('disabled');
    let optAsal = selectTujuan.querySelector('.opt-kelas-asal');
    if (optAsal) {
      optAsal.classList.add('d-none');
    }
    if (selectTujuan.value === kelasAsal) {
      selectTujuan.value = 'XII-MIPA-1';
    }
    let hiddenInput = document.getElementById('hiddenKelasTujuan_' + rowId);
    if (hiddenInput) {
      hiddenInput.remove();
    }
  }
}

// Inisialisasi awal jika ada yang tidak naik
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.select-status-kenaikan').forEach(function(sel) {
    if (sel.value === 'tidak_naik') {
      handleKenaikanChange(sel);
    }
  });
});
</script>

<?= $this->endSection() ?>

