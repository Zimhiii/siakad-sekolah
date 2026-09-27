<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Stepper Navigation -->
<div class="wizard-stepper mb-3">
  <div class="step-item completed">
    <div class="step-bubble">1</div>
    <span class="step-label">Info Tahun Ajaran</span>
  </div>
  <div class="step-item active">
    <div class="step-bubble">2</div>
    <span class="step-label">Kelas &amp; Kapasitas</span>
  </div>
  <div class="step-item">
    <div class="step-bubble">3</div>
    <span class="step-label">Wali Kelas</span>
  </div>
  <div class="step-item">
    <div class="step-bubble">4</div>
    <span class="step-label">Kenaikan Kelas</span>
  </div>
  <div class="step-item">
    <div class="step-bubble">5</div>
    <span class="step-label">Penugasan Guru</span>
  </div>
  <div class="step-item">
    <div class="step-bubble">6</div>
    <span class="step-label">Ringkasan</span>
  </div>
</div>

<div class="card mb-4 border">
  <div class="card-header bg-body py-2 px-3">
    <h6 class="card-title fw-semibold mb-0">
      Langkah 2/6: Tentukan Jumlah Kelas Paralel &amp; Kapasitas per Tingkatan
    </h6>
  </div>

  <form action="<?= base_url('admin/wizard/3') ?>" method="get">
    <div class="card-body p-3">
      <p class="text-secondary small mb-3">
        Konfigurasikan jumlah rombongan belajar (rombel) dan kapasitas kursi siswa untuk Tahun Ajaran <strong>2026/2027</strong>:
      </p>

      <div class="table-responsive">
        <table class="table table-bordered align-middle mb-0" id="tableKapasitasKelas">
          <thead class="table-light">
            <tr>
              <th style="width: 220px;">Tingkatan Sekolah</th>
              <th>Contoh Penamaan Rombel</th>
              <th style="width: 180px;">Jumlah Kelas Paralel</th>
              <th style="width: 180px;">Kapasitas / Kelas</th>
              <th style="width: 160px;" class="text-end">Subtotal Kursi</th>
            </tr>
          </thead>
          <tbody>
            <tr data-tingkat="10">
              <td class="fw-medium small">Kelas 10 (Fase E)</td>
              <td><span class="text-secondary small">X-MIPA-1, X-MIPA-2, X-IPS-1, X-IPS-2</span></td>
              <td>
                <div class="input-group input-group-sm">
                  <input type="number" class="form-control text-center input-rombel" name="rombel_10" value="4" min="1" max="10">
                  <span class="input-group-text small">Kelas</span>
                </div>
              </td>
              <td>
                <div class="input-group input-group-sm">
                  <input type="number" class="form-control text-center input-kapasitas" name="kapasitas_10" value="32" min="10" max="45">
                  <span class="input-group-text small">Siswa</span>
                </div>
              </td>
              <td class="text-end subtotal-cell fw-medium small font-monospace">128 Siswa</td>
            </tr>
            <tr data-tingkat="11">
              <td class="fw-medium small">Kelas 11 (Fase F)</td>
              <td><span class="text-secondary small">XI-MIPA-1, XI-MIPA-2, XI-IPS-1, XI-IPS-2</span></td>
              <td>
                <div class="input-group input-group-sm">
                  <input type="number" class="form-control text-center input-rombel" name="rombel_11" value="4" min="1" max="10">
                  <span class="input-group-text small">Kelas</span>
                </div>
              </td>
              <td>
                <div class="input-group input-group-sm">
                  <input type="number" class="form-control text-center input-kapasitas" name="kapasitas_11" value="32" min="10" max="45">
                  <span class="input-group-text small">Siswa</span>
                </div>
              </td>
              <td class="text-end subtotal-cell fw-medium small font-monospace">128 Siswa</td>
            </tr>
            <tr data-tingkat="12">
              <td class="fw-medium small">Kelas 12 (Fase F)</td>
              <td><span class="text-secondary small">XII-MIPA-1, XII-MIPA-2, XII-IPS-1, XII-IPS-2</span></td>
              <td>
                <div class="input-group input-group-sm">
                  <input type="number" class="form-control text-center input-rombel" name="rombel_12" value="4" min="1" max="10">
                  <span class="input-group-text small">Kelas</span>
                </div>
              </td>
              <td>
                <div class="input-group input-group-sm">
                  <input type="number" class="form-control text-center input-kapasitas" name="kapasitas_12" value="32" min="10" max="45">
                  <span class="input-group-text small">Siswa</span>
                </div>
              </td>
              <td class="text-end subtotal-cell fw-medium small font-monospace">128 Siswa</td>
            </tr>
          </tbody>
          <tfoot class="table-light">
            <tr>
              <th colspan="2" class="small fw-semibold">Total Keseluruhan</th>
              <th class="small fw-semibold" id="totalRombelCell">12 Rombel Baru</th>
              <th>&mdash;</th>
              <th class="text-end small fw-semibold font-monospace" id="totalKapasitasCell">384 Kursi Siswa</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    <div class="card-footer bg-body d-flex justify-content-between align-items-center py-2 px-3">
      <a href="<?= base_url('admin/wizard/1') ?>" class="btn btn-outline-secondary btn-sm">
        Kembali ke Langkah 1
      </a>
      <button type="submit" class="btn btn-primary btn-sm px-3">
        Lanjut ke Langkah 3 &rarr;
      </button>
    </div>
  </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  function hitungKapasitasOtomatis() {
    const table = document.getElementById('tableKapasitasKelas');
    if (!table) return;

    let totalRombel = 0;
    let totalKapasitas = 0;

    table.querySelectorAll('tbody tr').forEach(row => {
      const rombelInput = row.querySelector('.input-rombel');
      const kapasitasInput = row.querySelector('.input-kapasitas');
      const subtotalCell = row.querySelector('.subtotal-cell');

      const rombel = parseInt(rombelInput ? rombelInput.value : 0) || 0;
      const kapasitas = parseInt(kapasitasInput ? kapasitasInput.value : 0) || 0;
      const subtotal = rombel * kapasitas;

      totalRombel += rombel;
      totalKapasitas += subtotal;

      if (subtotalCell) {
        subtotalCell.textContent = subtotal.toLocaleString('id-ID') + ' Siswa';
      }
    });

    const totalRombelCell = document.getElementById('totalRombelCell');
    const totalKapasitasCell = document.getElementById('totalKapasitasCell');

    if (totalRombelCell) {
      totalRombelCell.textContent = totalRombel + ' Rombel Baru';
    }
    if (totalKapasitasCell) {
      totalKapasitasCell.textContent = totalKapasitas.toLocaleString('id-ID') + ' Kursi Siswa';
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('#tableKapasitasKelas input');
    inputs.forEach(input => {
      input.addEventListener('input', hitungKapasitasOtomatis);
    });
  });
</script>
<?= $this->endSection() ?>
