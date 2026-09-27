<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
  <div>
    <h4 class="fw-bold mb-1">
      Input Nilai: <?= esc($pengajaran['mapel_nama']) ?>
    </h4>
    <div class="text-secondary small">
      Kelas: <strong class="text-body me-2"><?= esc($pengajaran['kelas_nama']) ?></strong>
      &bull; KKM: <strong class="text-body"><?= number_format($pengajaran['kkm'], 0) ?></strong>
      &bull; Semester Ganjil 2025/2026
    </div>
  </div>
  <div class="d-flex flex-wrap gap-2">
    <a href="<?= base_url('guru/tugas/' . $pengajaran['id']) ?>" class="btn btn-outline-secondary btn-sm">
      Kelola Tugas &amp; UH
    </a>
    <a href="<?= base_url('guru/nilai/' . $pengajaran['id'] . '/sync-rata-rata') ?>" class="btn btn-outline-secondary btn-sm">
      Sinkronkan Ulang Rata-rata
    </a>
    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
      Import Excel
    </button>
  </div>
</div>

<!-- Tabs Pengetahuan vs Keterampilan -->
<ul class="nav nav-tabs mb-3">
  <li class="nav-item">
    <a class="nav-link px-4 <?= ($activeAspek === 'pengetahuan') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('guru/nilai/' . $pengajaran['id'] . '/pengetahuan') ?>">
      Pengetahuan (Teori)
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link px-4 <?= ($activeAspek === 'keterampilan') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('guru/nilai/' . $pengajaran['id'] . '/keterampilan') ?>">
      Keterampilan (Praktik/Proyek)
    </a>
  </li>
</ul>

<?php if ($activeAspek === 'pengetahuan'): ?>
  <!-- Ringkasan Alur Nilai Harian -->
  <div class="card bg-body-tertiary border mb-3">
    <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 small">
      <div>
        <span class="fw-semibold text-body">Nilai Harian Terintegrasi:</span>
        <span class="text-secondary ms-1">Nilai pada kolom UH dan Tugas dikalkulasi otomatis dari akumulasi rata-rata buku tugas.</span>
      </div>
      <div>
        <a href="<?= base_url('guru/tugas/' . $pengajaran['id']) ?>" class="btn btn-outline-secondary btn-sm">
          Buka Bank Tugas &amp; UH
        </a>
      </div>
    </div>
  </div>
<?php endif; ?>

<form action="<?= base_url('guru/save-action') ?>" method="post">
  <?= csrf_field() ?>
  <input type="hidden" name="action" value="Nilai <?= ucfirst($activeAspek) ?> <?= esc($pengajaran['mapel_nama']) ?>">
  <input type="hidden" name="redirect_url" value="/guru/nilai/<?= $pengajaran['id'] ?>/<?= $activeAspek ?>">
  <input type="hidden" name="pengajaran_id" value="<?= $pengajaran['id'] ?>">
  <input type="hidden" name="aspek" value="<?= $activeAspek ?>">

  <div class="card mb-4 border">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0 text-center">
          <thead class="table-light">
            <tr>
              <th class="text-start" style="width: 48px;">No</th>
              <th class="text-start" style="min-width: 220px; position: sticky; left: 0; background: var(--bs-table-bg, var(--bs-body-bg)); z-index: 2;">
                Nama Lengkap Siswa
              </th>
              <?php foreach ($komponenList as $komp): ?>
                <th style="min-width: 140px;">
                  <span class="fw-semibold"><?= esc($komp['nama']) ?></span>
                  <div class="text-secondary small fw-normal">Bobot: <?= $komp['bobot_persen'] ?>%</div>
                  <?php if ($activeAspek === 'pengetahuan' && (str_contains($komp['nama'], 'UH') || str_contains($komp['nama'], 'Ulangan'))): ?>
                    <div class="text-secondary small fw-normal">(Otomatis UH)</div>
                  <?php elseif ($activeAspek === 'pengetahuan' && (str_contains($komp['nama'], 'Tugas'))): ?>
                    <div class="text-secondary small fw-normal">(Otomatis Tugas)</div>
                  <?php endif; ?>
                </th>
              <?php endforeach; ?>
              <th style="width: 100px;">
                Nilai Akhir
              </th>
              <th style="width: 80px;">
                Predikat
              </th>
              <th style="min-width: 300px;" class="text-start">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span class="fw-semibold">Deskripsi Capaian (CP)</span>
                  <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2" id="btnGenerateAllCp" title="Generate Otomatis Seluruh Deskripsi CP Siswa">
                    Auto-Isi Semua
                  </button>
                </div>
                <small class="text-secondary fw-normal">Wajib diisi sebelum pengajuan rapor</small>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($siswaNilai)): ?>
              <tr>
                <td colspan="<?= 5 + count($komponenList) ?>" class="text-center text-secondary py-4">Belum ada data siswa pada rombel ini</td>
              </tr>
            <?php else: ?>
              <?php $no = 1; foreach ($siswaNilai as $row): ?>
              <?php $vals = $row[$activeAspek]; ?>
              <tr>
                <td class="text-secondary"><?= $no++ ?></td>
                <td class="text-start" style="position: sticky; left: 0; background: var(--bs-table-bg, var(--bs-body-bg)); z-index: 2;">
                  <div>
                    <span class="text-body fw-medium d-block"><?= esc($row['nama']) ?></span>
                    <small class="text-secondary">NIS: <?= esc($row['nis']) ?></small>
                  </div>
                </td>
                <?php if ($activeAspek === 'pengetahuan'): ?>
                  <!-- Kolom UH -->
                  <td>
                    <input type="number" 
                           name="nilai[<?= $row['siswa_id'] ?>][uh]" 
                           class="form-control form-control-sm text-center fw-semibold input-uh" 
                           value="<?= $vals['uh'] ?>" 
                           min="0" 
                           max="100" 
                           step="0.1"
                           data-siswa-id="<?= $row['siswa_id'] ?>">
                  </td>
                  <!-- Kolom Tugas -->
                  <td>
                    <input type="number" 
                           name="nilai[<?= $row['siswa_id'] ?>][tugas]" 
                           class="form-control form-control-sm text-center fw-semibold input-tugas" 
                           value="<?= $vals['tugas'] ?>" 
                           min="0" 
                           max="100" 
                           step="0.1"
                           data-siswa-id="<?= $row['siswa_id'] ?>">
                  </td>
                  <!-- Kolom UTS -->
                  <td>
                    <input type="number" 
                           name="nilai[<?= $row['siswa_id'] ?>][uts]" 
                           class="form-control form-control-sm text-center input-uts" 
                           value="<?= $vals['uts'] ?>" 
                           min="0" 
                           max="100" 
                           step="0.1"
                           data-siswa-id="<?= $row['siswa_id'] ?>">
                  </td>
                  <!-- Kolom UAS -->
                  <td>
                    <input type="number" 
                           name="nilai[<?= $row['siswa_id'] ?>][uas]" 
                           class="form-control form-control-sm text-center input-uas" 
                           value="<?= $vals['uas'] ?>" 
                           min="0" 
                           max="100" 
                           step="0.1"
                           data-siswa-id="<?= $row['siswa_id'] ?>">
                  </td>
                <?php else: ?>
                  <td><input type="number" name="nilai[<?= $row['siswa_id'] ?>][praktik]" class="form-control form-control-sm text-center" value="<?= $vals['praktik'] ?>" min="0" max="100" step="0.1"></td>
                  <td><input type="number" name="nilai[<?= $row['siswa_id'] ?>][proyek]" class="form-control form-control-sm text-center" value="<?= $vals['proyek'] ?>" min="0" max="100" step="0.1"></td>
                  <td><input type="number" name="nilai[<?= $row['siswa_id'] ?>][portofolio]" class="form-control form-control-sm text-center" value="<?= $vals['portofolio'] ?>" min="0" max="100" step="0.1"></td>
                <?php endif; ?>

                <td class="fw-bold" id="cellNa_<?= $row['siswa_id'] ?>">
                  <?= $vals['nilai_akhir'] ?>
                </td>
                <td>
                  <span id="cellPredikat_<?= $row['siswa_id'] ?>" class="fw-semibold <?= ($vals['predikat'] === 'D') ? 'text-danger' : 'text-body' ?>">
                    <?= esc($vals['predikat']) ?>
                  </span>
                </td>
                <td class="text-start">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="text-secondary small">Narasi Capaian</span>
                    <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none text-secondary btn-generate-single-cp" data-siswa-id="<?= $row['siswa_id'] ?>" title="Generate Narasi CP">
                      Auto-Isi
                    </button>
                  </div>
                  <textarea class="form-control form-control-sm textarea-deskripsi" id="deskripsi_<?= $row['siswa_id'] ?>" name="deskripsi[<?= $row['siswa_id'] ?>]" rows="2" placeholder="Deskripsi Capaian Pembelajaran (wajib)..." required><?= esc($vals['deskripsi'] ?? '') ?></textarea>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Sticky Bottom Save Bar -->
  <div class="sticky-bottom-bar d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 shadow-sm border">
    <div class="text-secondary small">
      Nilai akhir (NA) dan predikat terhitung otomatis berdasarkan bobot kurikulum.
    </div>
    <div class="d-flex gap-2">
      <button type="reset" class="btn btn-outline-secondary btn-sm px-3">Batal Perubahan</button>
      <button type="submit" class="btn btn-primary btn-sm px-3">
        Simpan Nilai <?= ucfirst($activeAspek) ?>
      </button>
    </div>
  </div>
</form>

<!-- Modal Import Excel Nilai (Open State) -->
<div class="modal show" id="modalImportExcel" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('guru/save-action') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Import Nilai Excel">
        <input type="hidden" name="redirect_url" value="/guru/nilai/<?= $pengajaran['id'] ?>/<?= $activeAspek ?>">
        <div class="modal-header">
          <h5 class="modal-title fw-semibold">Import Nilai dari Excel</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="small text-secondary mb-3">Unggah berkas spreadsheet format .xlsx atau .csv yang telah diisi sesuai template nilai mata pelajaran ini.</p>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Pilih Berkas Nilai (.xlsx / .csv)</label>
            <input type="file" name="file_excel" class="form-control form-control-sm" accept=".xlsx, .xls, .csv" required>
          </div>
          <div class="p-2 bg-body-tertiary rounded border small text-secondary">
            Belum punya formatnya? <a href="javascript:void(0)" onclick="unduhTemplateNilai()" class="text-primary fw-semibold">Unduh Template Format CSV/Excel</a>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-3">Unggah &amp; Proses Nilai</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function unduhTemplateNilai() {
  const mapel = '<?= esc($pengajaran['mapel_nama'] ?? 'Mata_Pelajaran') ?>';
  let csv = "No,NIS,Nama_Siswa,Nilai_UH,Nilai_Tugas,Nilai_UTS,Nilai_UAS\n";
  <?php if (!empty($siswaList)): ?>
    <?php foreach ($siswaList as $idx => $s): ?>
      csv += "<?= ($idx + 1) ?>,<?= esc($s['nis']) ?>,\"<?= esc($s['nama']) ?>\",0,0,0,0\n";
    <?php endforeach; ?>
  <?php else: ?>
    csv += "1,242510001,\"Muhammad Raihan Pratama\",0,0,0,0\n";
    csv += "2,242510002,\"Aisyah Azzahra Putri\",0,0,0,0\n";
  <?php endif; ?>
  const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
  const link = document.createElement('a');
  link.href = URL.createObjectURL(blob);
  link.download = "Template_Nilai_" + mapel.replace(/[^a-zA-Z0-9]/g, '_') + ".csv";
  link.click();
}

document.addEventListener('DOMContentLoaded', function() {
  const activeAspek = '<?= $activeAspek ?>';

  // Generator Narasi CP berdasarkan Nilai Akhir & TP
  function generateCpNarrative(score, aspek) {
    const val = parseFloat(score) || 0;
    if (aspek === 'pengetahuan') {
      if (val >= 85) {
        return 'Menunjukkan penguasaan yang sangat baik dalam materi pembuktian induksi matematika dan pemodelan program linear dua variabel.';
      } else if (val >= 75) {
        return 'Menunjukkan penguasaan yang baik dalam materi operasi aljabar matriks, dan cukup dalam analisis determinan serta invers.';
      } else {
        return 'Perlu bimbingan lebih lanjut dan pendampingan intensif dalam pemodelan sistem pertidaksamaan linear.';
      }
    } else {
      if (val >= 85) {
        return 'Sangat terampil menyajikan model matematika dan menyelesaikan proyek kontekstual aljabar matriks secara mandiri dan sistematis.';
      } else if (val >= 75) {
        return 'Terampil mempraktikkan perhitungan aljabar matriks, cukup terampil dalam menggambar daerah penyelesaian grafik.';
      } else {
        return 'Perlu pendampingan praktikum terbimbing dalam penyelesaian lembar kerja unjuk kerja geometri.';
      }
    }
  }

  function recalculateRow(siswaId) {
    const elUh = document.querySelector('input[name="nilai[' + siswaId + '][uh]"]');
    const elTugas = document.querySelector('input[name="nilai[' + siswaId + '][tugas]"]');
    const elUts = document.querySelector('input[name="nilai[' + siswaId + '][uts]"]');
    const elUas = document.querySelector('input[name="nilai[' + siswaId + '][uas]"]');

    if (!elUh || !elTugas || !elUts || !elUas) return;

    const uh = parseFloat(elUh.value) || 0;
    const tugas = parseFloat(elTugas.value) || 0;
    const uts = parseFloat(elUts.value) || 0;
    const uas = parseFloat(elUas.value) || 0;

    // Bobot: UH 20%, Tugas 20%, UTS 25%, UAS 35%
    const na = (uh * 0.20) + (tugas * 0.20) + (uts * 0.25) + (uas * 0.35);
    const naRounded = Math.round(na * 10) / 10;

    let predikat = 'D';
    let isDanger = true;

    if (naRounded >= 92) {
      predikat = 'A';
      isDanger = false;
    } else if (naRounded >= 83) {
      predikat = 'B';
      isDanger = false;
    } else if (naRounded >= 75) {
      predikat = 'C';
      isDanger = false;
    }

    const cellNa = document.getElementById('cellNa_' + siswaId);
    const cellPredikat = document.getElementById('cellPredikat_' + siswaId);

    if (cellNa) cellNa.textContent = naRounded.toFixed(1);
    if (cellPredikat) {
      cellPredikat.className = 'fw-semibold ' + (isDanger ? 'text-danger' : 'text-body');
      cellPredikat.textContent = predikat;
    }
  }

  document.querySelectorAll('.input-uh, .input-tugas, .input-uts, .input-uas').forEach(input => {
    input.addEventListener('input', function() {
      const sId = this.dataset.siswaId;
      recalculateRow(sId);
    });
  });

  // Tombol Auto-Isi per Siswa
  document.querySelectorAll('.btn-auto-cp, .btn-generate-single-cp').forEach(btn => {
    btn.addEventListener('click', function() {
      const sId = this.dataset.siswaId;
      const cellNa = document.getElementById('cellNa_' + sId);
      const textarea = document.getElementById('deskripsi_' + sId);
      if (cellNa && textarea) {
        const score = parseFloat(cellNa.textContent) || 80;
        textarea.value = generateCpNarrative(score, activeAspek);
        textarea.classList.add('border-success');
        setTimeout(() => textarea.classList.remove('border-success'), 1500);
      }
    });
  });

  // Tombol Auto-Isi Semua Siswa
  const btnAll = document.getElementById('btnGenerateAllCp');
  if (btnAll) {
    btnAll.addEventListener('click', function() {
      document.querySelectorAll('.textarea-deskripsi').forEach(ta => {
        const match = ta.id.match(/deskripsi_(\d+)/);
        if (match) {
          const sId = match[1];
          const cellNa = document.getElementById('cellNa_' + sId);
          const score = cellNa ? parseFloat(cellNa.textContent) || 80 : 80;
          ta.value = generateCpNarrative(score, activeAspek);
          ta.classList.add('border-success');
          setTimeout(() => ta.classList.remove('border-success'), 1500);
        }
      });
      const origText = btnAll.innerHTML;
      btnAll.innerHTML = 'CP Terisi Otomatis';
      btnAll.classList.replace('btn-outline-secondary', 'btn-success');
      setTimeout(() => {
        btnAll.innerHTML = origText;
        btnAll.classList.replace('btn-success', 'btn-outline-secondary');
      }, 2000);
    });
  }

  // Validasi Mandatory Sebelum Simpan: Deskripsi tidak boleh kosong
  const mainForm = document.querySelector('form[action*="guru/save-action"]');
  if (mainForm) {
    mainForm.addEventListener('submit', function(e) {
      let emptyCount = 0;
      let firstEmpty = null;
      document.querySelectorAll('.textarea-deskripsi').forEach(ta => {
        if (!ta.value.trim()) {
          emptyCount++;
          ta.classList.add('is-invalid');
          if (!firstEmpty) firstEmpty = ta;
        } else {
          ta.classList.remove('is-invalid');
        }
      });
      if (emptyCount > 0) {
        e.preventDefault();
        if (firstEmpty) {
          firstEmpty.focus();
          firstEmpty.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
      }
    });
  }
});
</script>

<!-- Static Modal Backdrop for Figma Export -->
<div class="modal-backdrop show"></div>
<style>body { overflow: hidden; }</style>

<?= $this->endSection() ?>
