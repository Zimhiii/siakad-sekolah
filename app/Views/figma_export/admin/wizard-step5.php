<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Stepper Navigation -->
<div class="wizard-stepper mb-3">
  <div class="step-item completed">
    <div class="step-bubble">1</div>
    <span class="step-label">Info Tahun Ajaran</span>
  </div>
  <div class="step-item completed">
    <div class="step-bubble">2</div>
    <span class="step-label">Kelas &amp; Kapasitas</span>
  </div>
  <div class="step-item completed">
    <div class="step-bubble">3</div>
    <span class="step-label">Wali Kelas</span>
  </div>
  <div class="step-item completed">
    <div class="step-bubble">4</div>
    <span class="step-label">Kenaikan Kelas</span>
  </div>
  <div class="step-item active">
    <div class="step-bubble">5</div>
    <span class="step-label">Penugasan Guru</span>
  </div>
  <div class="step-item">
    <div class="step-bubble">6</div>
    <span class="step-label">Ringkasan</span>
  </div>
</div>

<div class="card mb-4 border">
  <div class="card-header bg-body py-2 px-3 d-flex justify-content-between align-items-center">
    <div>
      <h6 class="card-title fw-semibold mb-0">
        Langkah 5/6: Penugasan Guru Mengajar &amp; KKM
      </h6>
    </div>
    <button type="button" class="btn btn-outline-secondary btn-sm" id="btnSalinTemplate" onclick="salinTemplatePenugasan()">
      Muat Template Standar
    </button>
  </div>

  <form action="<?= base_url('admin/wizard/6') ?>" method="get">
    <div class="card-body p-3">
      <p class="text-secondary small mb-3">
        Tentukan penugasan guru pengampu mata pelajaran untuk rombel Tahun Ajaran 2026/2027:
      </p>

      <div class="table-responsive">
        <table class="table table-bordered align-middle mb-0" id="tablePenugasan">
          <thead class="table-light">
            <tr>
              <th style="width: 250px;">Guru Pengajar</th>
              <th style="width: 230px;">Mata Pelajaran</th>
              <th style="width: 170px;">Kelas</th>
              <th style="width: 140px;">Semester</th>
              <th style="width: 100px;">KKM</th>
              <th style="width: 80px;" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <select class="form-select form-select-sm" name="guru_id[]" required>
                  <option value="">-- Pilih Guru --</option>
                  <?php foreach ($guru as $g): ?>
                    <option value="<?= $g['id'] ?>" <?= ($g['id'] == 1) ? 'selected' : '' ?>>
                      <?= esc($g['nama']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </td>
              <td>
                <select class="form-select form-select-sm" name="mapel_id[]" required>
                  <option value="">-- Pilih Mata Pelajaran --</option>
                  <?php foreach ($mapel as $m): ?>
                    <option value="<?= $m['id'] ?>" <?= ($m['kode'] === 'MAT-W') ? 'selected' : '' ?>>
                      <?= esc($m['nama']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </td>
              <td>
                <select class="form-select form-select-sm" name="kelas_id[]" required>
                  <option value="">-- Pilih Kelas --</option>
                  <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k['id'] ?>" <?= ($k['id'] == 4) ? 'selected' : '' ?>>
                      <?= esc($k['nama_kelas']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </td>
              <td>
                <select class="form-select form-select-sm" name="semester[]">
                  <option value="Ganjil" selected>Ganjil</option>
                  <option value="Genap">Genap</option>
                </select>
              </td>
              <td>
                <input type="number" class="form-control form-control-sm text-center font-monospace" name="kkm[]" value="75" min="50" max="100" required>
              </td>
              <td class="text-center">
                <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2" onclick="hapusBarisPenugasan(this)" title="Hapus Baris">
                  Hapus
                </button>
              </td>
            </tr>
            <tr>
              <td>
                <select class="form-select form-select-sm" name="guru_id[]" required>
                  <option value="">-- Pilih Guru --</option>
                  <?php foreach ($guru as $g): ?>
                    <option value="<?= $g['id'] ?>" <?= ($g['id'] == 2) ? 'selected' : '' ?>>
                      <?= esc($g['nama']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </td>
              <td>
                <select class="form-select form-select-sm" name="mapel_id[]" required>
                  <option value="">-- Pilih Mata Pelajaran --</option>
                  <?php foreach ($mapel as $m): ?>
                    <option value="<?= $m['id'] ?>" <?= ($m['kode'] === 'BIO') ? 'selected' : '' ?>>
                      <?= esc($m['nama']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </td>
              <td>
                <select class="form-select form-select-sm" name="kelas_id[]" required>
                  <option value="">-- Pilih Kelas --</option>
                  <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k['id'] ?>" <?= ($k['id'] == 1) ? 'selected' : '' ?>>
                      <?= esc($k['nama_kelas']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </td>
              <td>
                <select class="form-select form-select-sm" name="semester[]">
                  <option value="Ganjil" selected>Ganjil</option>
                  <option value="Genap">Genap</option>
                </select>
              </td>
              <td>
                <input type="number" class="form-control form-control-sm text-center font-monospace" name="kkm[]" value="75" min="50" max="100" required>
              </td>
              <td class="text-center">
                <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2" onclick="hapusBarisPenugasan(this)" title="Hapus Baris">
                  Hapus
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="tambahBarisPenugasan()">
        + Tambah Baris Penugasan
      </button>
    </div>

    <div class="card-footer bg-body d-flex justify-content-between align-items-center py-2 px-3">
      <a href="<?= base_url('admin/wizard/4') ?>" class="btn btn-outline-secondary btn-sm">
        Kembali ke Langkah 4
      </a>
      <button type="submit" class="btn btn-primary btn-sm px-3">
        Lanjut ke Langkah 6 &rarr;
      </button>
    </div>
  </form>
</div>

<!-- Template HTML untuk Baris Baru -->
<template id="rowPenugasanTemplate">
  <tr>
    <td>
      <select class="form-select form-select-sm" name="guru_id[]" required>
        <option value="">-- Pilih Guru --</option>
        <?php foreach ($guru as $g): ?>
          <option value="<?= $g['id'] ?>"><?= esc($g['nama']) ?></option>
        <?php endforeach; ?>
      </select>
    </td>
    <td>
      <select class="form-select form-select-sm" name="mapel_id[]" required>
        <option value="">-- Pilih Mata Pelajaran --</option>
        <?php foreach ($mapel as $m): ?>
          <option value="<?= $m['id'] ?>"><?= esc($m['nama']) ?></option>
        <?php endforeach; ?>
      </select>
    </td>
    <td>
      <select class="form-select form-select-sm" name="kelas_id[]" required>
        <option value="">-- Pilih Kelas --</option>
        <?php foreach ($kelas as $k): ?>
          <option value="<?= $k['id'] ?>"><?= esc($k['nama_kelas']) ?></option>
        <?php endforeach; ?>
      </select>
    </td>
    <td>
      <select class="form-select form-select-sm" name="semester[]">
        <option value="Ganjil" selected>Ganjil</option>
        <option value="Genap">Genap</option>
      </select>
    </td>
    <td>
      <input type="number" class="form-control form-control-sm text-center font-monospace" name="kkm[]" value="75" min="50" max="100" required>
    </td>
    <td class="text-center">
      <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2" onclick="hapusBarisPenugasan(this)" title="Hapus Baris">
        Hapus
      </button>
    </td>
  </tr>
</template>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  function tambahBarisPenugasan() {
    const template = document.getElementById('rowPenugasanTemplate');
    const tbody = document.querySelector('#tablePenugasan tbody');
    if (!template || !tbody) return;

    const clone = template.content.cloneNode(true);
    tbody.appendChild(clone);
  }

  function hapusBarisPenugasan(btn) {
    const row = btn.closest('tr');
    const tbody = row.closest('tbody');
    if (tbody && tbody.querySelectorAll('tr').length > 1) {
      row.remove();
    } else {
      row.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
      row.querySelector('input[type="number"]').value = 75;
    }
  }

  function salinTemplatePenugasan() {
    tambahBarisPenugasan();
    tambahBarisPenugasan();
  }
</script>
<?= $this->endSection() ?>
