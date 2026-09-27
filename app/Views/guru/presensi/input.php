<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Header & Navigasi Breadcrumb -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start gap-3 mb-3">
  <div>
    <div class="d-flex align-items-center gap-2 mb-1">
      <a href="<?= base_url('guru/presensi/' . $pengajaran['id']) ?>" class="text-decoration-none text-secondary small">
        Kembali ke Daftar Pertemuan
      </a>
      <span class="text-muted small">&bull;</span>
      <span class="badge bg-secondary-subtle text-secondary border"><?= esc($pengajaran['kelas_nama']) ?></span>
      <span class="badge bg-secondary-subtle text-secondary border"><?= esc($pengajaran['mapel_nama']) ?></span>
    </div>
    <h4 class="fw-bold text-body mb-0">
      Input Presensi &amp; Jurnal KBM: Pertemuan Ke-<?= esc($pertemuan['pertemuan_ke']) ?>
    </h4>
    <p class="text-secondary small mb-0">
      Catat kehadiran siswa secara akurat dan isikan rangkuman materi KBM untuk buku agenda mengajar resmi.
    </p>
  </div>

  <div class="d-flex gap-2">
    <a href="<?= base_url('guru/presensi/' . $pengajaran['id']) ?>" class="btn btn-outline-secondary btn-sm">
      Batal
    </a>
    <button type="button" class="btn btn-outline-primary btn-sm" onclick="setSemuaHadir()">
      Set Semua Hadir
    </button>
  </div>
</div>

<form action="<?= base_url('guru/presensi/' . $pengajaran['id'] . '/save/' . $pertemuan['id']) ?>" method="POST" id="formPresensi">
  <?= csrf_field() ?>

  <div class="row g-3">
    <!-- Presensi Siswa -->
    <div class="col-lg-8">
      <div class="card border mb-3">
        <div class="card-header bg-body border-bottom p-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
          <div>
            <h6 class="fw-semibold text-body mb-0">
              Daftar Kehadiran Peserta Didik
            </h6>
            <small class="text-secondary">Pilih status kehadiran untuk setiap siswa di bawah ini</small>
          </div>
          <!-- Real-time Live Counters -->
          <div class="d-flex flex-wrap gap-1">
            <span class="badge bg-success-subtle text-success border border-success-subtle fw-normal" id="counterH">Hadir: 0</span>
            <span class="badge bg-warning-subtle text-warning border border-warning-subtle fw-normal" id="counterS">Sakit: 0</span>
            <span class="badge bg-info-subtle text-info border border-info-subtle fw-normal" id="counterI">Izin: 0</span>
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-normal" id="counterA">Alpa: 0</span>
            <span class="badge bg-secondary-subtle text-secondary border fw-normal" id="counterD">Disp: 0</span>
          </div>
        </div>

        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th class="ps-3 text-center" style="width: 48px;">No</th>
                  <th style="min-width: 200px;">Siswa</th>
                  <th class="text-center" style="width: 240px;">Status Kehadiran</th>
                  <th class="pe-3">Catatan / Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($siswaPresensi as $idx => $sp): ?>
                  <?php 
                    $sId = $sp['siswa_id'];
                    $currentSt = $sp['status'] ?? 'H';
                  ?>
                  <tr>
                    <td class="ps-3 text-secondary text-center"><?= $idx + 1 ?></td>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <img src="<?= esc($sp['foto_path']) ?>" alt="Foto" class="rounded-circle border" width="32" height="32">
                        <div>
                          <div class="fw-medium text-body"><?= esc($sp['nama']) ?></div>
                          <div class="text-secondary small font-monospace">NIS: <?= esc($sp['nis']) ?></div>
                        </div>
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="btn-group btn-group-sm w-100" role="group" aria-label="Status Kehadiran">
                        <!-- H: Hadir -->
                        <input type="radio" class="btn-check status-radio" name="status[<?= $sId ?>]" id="status_h_<?= $sId ?>" value="H" <?= ($currentSt === 'H') ? 'checked' : '' ?> onchange="updateCounters()">
                        <label class="btn btn-outline-success fw-bold" for="status_h_<?= $sId ?>" title="Hadir">H</label>

                        <!-- S: Sakit -->
                        <input type="radio" class="btn-check status-radio" name="status[<?= $sId ?>]" id="status_s_<?= $sId ?>" value="S" <?= ($currentSt === 'S') ? 'checked' : '' ?> onchange="updateCounters()">
                        <label class="btn btn-outline-warning fw-bold" for="status_s_<?= $sId ?>" title="Sakit">S</label>

                        <!-- I: Izin -->
                        <input type="radio" class="btn-check status-radio" name="status[<?= $sId ?>]" id="status_i_<?= $sId ?>" value="I" <?= ($currentSt === 'I') ? 'checked' : '' ?> onchange="updateCounters()">
                        <label class="btn btn-outline-info fw-bold" for="status_i_<?= $sId ?>" title="Izin">I</label>

                        <!-- A: Alpa -->
                        <input type="radio" class="btn-check status-radio" name="status[<?= $sId ?>]" id="status_a_<?= $sId ?>" value="A" <?= ($currentSt === 'A') ? 'checked' : '' ?> onchange="updateCounters()">
                        <label class="btn btn-outline-danger fw-bold" for="status_a_<?= $sId ?>" title="Alpa / Tanpa Keterangan">A</label>

                        <!-- D: Dispensasi -->
                        <input type="radio" class="btn-check status-radio" name="status[<?= $sId ?>]" id="status_d_<?= $sId ?>" value="D" <?= ($currentSt === 'D') ? 'checked' : '' ?> onchange="updateCounters()">
                        <label class="btn btn-outline-secondary fw-bold" for="status_d_<?= $sId ?>" title="Dispensasi">D</label>
                      </div>
                    </td>
                    <td class="pe-3">
                      <input type="text" name="catatan[<?= $sId ?>]" class="form-control form-control-sm" placeholder="Catatan khusus (surat dokter, izin...)" value="<?= esc($sp['catatan']) ?>">
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Form Jurnal Mengajar (KBM) -->
    <div class="col-lg-4">
      <div class="card border sticky-top" style="top: 20px;">
        <div class="card-header bg-body border-bottom p-3">
          <h6 class="fw-semibold text-body mb-0">
            Jurnal &amp; Agenda Mengajar
          </h6>
          <small class="text-secondary">Dokumentasi resmi pelaksanaan KBM tatap muka</small>
        </div>
        <div class="card-body p-3">
          <div class="mb-3">
            <label class="form-label small fw-semibold">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
            <input type="date" name="tanggal" class="form-control form-control-sm" value="<?= esc($pertemuan['tanggal']) ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Jam Pelajaran Ke- <span class="text-danger">*</span></label>
            <input type="text" name="jam_ke" class="form-control form-control-sm" value="<?= esc($pertemuan['jam_ke']) ?>" placeholder="Misal: Jam ke 1-2 (07:15 - 08:45)" required>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Materi Pokok / Capaian Pembelajaran <span class="text-danger">*</span></label>
            <textarea name="materi_pokok" class="form-control form-control-sm" rows="2" placeholder="Tuliskan pokok materi / KD yang dibahas..." required><?= esc($pertemuan['materi_pokok']) ?></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Metode / Model Pembelajaran</label>
            <input type="text" name="metode" class="form-control form-control-sm" value="<?= esc($pertemuan['metode']) ?>" placeholder="Misal: Problem Based Learning, Diskusi Kelompok">
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Refleksi Guru &amp; Catatan KBM</label>
            <textarea name="catatan_jurnal" class="form-control form-control-sm" rows="3" placeholder="Catatan kendala, respon siswa, atau tindak lanjut pertemuan berikutnya..."><?= esc($pertemuan['catatan_jurnal']) ?></textarea>
          </div>

          <hr class="opacity-25 my-3">

          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-sm">
              Simpan Presensi &amp; Jurnal KBM
            </button>
            <a href="<?= base_url('guru/presensi/' . $pengajaran['id']) ?>" class="btn btn-outline-secondary btn-sm">
              Kembali tanpa Menyimpan
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
function setSemuaHadir() {
  const radioH = document.querySelectorAll('input[type="radio"][value="H"]');
  radioH.forEach(radio => {
    radio.checked = true;
  });
  updateCounters();
}

function updateCounters() {
  let countH = 0, countS = 0, countI = 0, countA = 0, countD = 0;
  
  const checkedRadios = document.querySelectorAll('.status-radio:checked');
  checkedRadios.forEach(r => {
    if (r.value === 'H') countH++;
    else if (r.value === 'S') countS++;
    else if (r.value === 'I') countI++;
    else if (r.value === 'A') countA++;
    else if (r.value === 'D') countD++;
  });

  const elH = document.getElementById('counterH');
  const elS = document.getElementById('counterS');
  const elI = document.getElementById('counterI');
  const elA = document.getElementById('counterA');
  const elD = document.getElementById('counterD');

  if (elH) elH.textContent = 'Hadir: ' + countH;
  if (elS) elS.textContent = 'Sakit: ' + countS;
  if (elI) elI.textContent = 'Izin: ' + countI;
  if (elA) elA.textContent = 'Alpa: ' + countA;
  if (elD) elD.textContent = 'Disp: ' + countD;
}

// Inisialisasi hitungan counter saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
  updateCounters();
});
</script>

<?= $this->endSection() ?>

