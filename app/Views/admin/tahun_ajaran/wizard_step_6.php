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
  <div class="step-item completed">
    <div class="step-bubble">5</div>
    <span class="step-label">Penugasan Guru</span>
  </div>
  <div class="step-item active">
    <div class="step-bubble">6</div>
    <span class="step-label">Ringkasan</span>
  </div>
</div>

<div class="card mb-4 border">
  <div class="card-header bg-body py-2 px-3">
    <h6 class="card-title fw-semibold mb-0">
      Langkah 6/6: Ringkasan &amp; Konfirmasi Aktivasi Tahun Ajaran
    </h6>
  </div>

  <form action="<?= base_url('admin/save-action') ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="Aktivasi Tahun Ajaran 2026/2027">
    <input type="hidden" name="redirect_url" value="/admin/tahun-ajaran">

    <div class="card-body p-3">

      <!-- Checklist Verifikasi Konfigurasi -->
      <div class="card border mb-3">
        <div class="card-header bg-body py-2 px-3 d-flex justify-content-between align-items-center">
          <span class="small fw-semibold text-body">Checklist Konfigurasi Tahun Ajaran Baru</span>
          <span class="badge bg-secondary-subtle text-secondary border">Semua Langkah Siap</span>
        </div>
        <div class="list-group list-group-flush">
          
          <!-- Item 1: Info TA -->
          <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
            <div>
              <span class="text-body small fw-medium">Informasi &amp; Rentang Semester</span>
              <span class="text-secondary small ms-1">(2026/2027 &bull; Ganjil: 13 Jul - 18 Des 2026, Genap: 04 Jan - 18 Jun 2027)</span>
            </div>
            <span class="text-success small fw-medium">Terverifikasi</span>
          </div>

          <!-- Item 2: Kelas & Kapasitas -->
          <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
            <div>
              <span class="text-body small fw-medium">Rombel &amp; Kapasitas Siswa</span>
              <span class="text-secondary small ms-1">(12 Rombel baru &bull; 384 kursi siswa)</span>
            </div>
            <span class="text-success small fw-medium">Terverifikasi</span>
          </div>

          <!-- Item 3: Wali Kelas -->
          <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
            <div>
              <span class="text-body small fw-medium">Penunjukan Wali Kelas</span>
              <span class="text-secondary small ms-1">(12/12 rombel telah dialokasikan wali kelas)</span>
            </div>
            <span class="text-success small fw-medium">100% Ditugaskan</span>
          </div>

          <!-- Item 4: Kenaikan Kelas -->
          <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
            <div>
              <span class="text-body small fw-medium">Rekapitulasi Sidang Pleno Kenaikan &amp; Kelulusan</span>
              <span class="text-secondary small ms-1">(Hasil resmi pleno dewan guru tuntas)</span>
            </div>
            <span class="text-success small fw-medium">Tervalidasi</span>
          </div>

          <!-- Item 5: Penugasan Guru -->
          <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
            <div>
              <span class="text-body small fw-medium">Penugasan Guru Mengajar &amp; KKM</span>
              <span class="text-secondary small ms-1">(Matriks pengajaran dan batas KKM siap diterapkan)</span>
            </div>
            <span class="text-success small fw-medium">Terkonfigurasi</span>
          </div>

        </div>
      </div>
      
      <!-- Ringkasan Metrik Konfigurasi -->
      <div class="row g-3 mb-3">
        <div class="col-md-4">
          <div class="p-3 border rounded bg-light">
            <span class="text-secondary small d-block">Tahun Ajaran Baru</span>
            <div class="fs-5 fw-bold text-primary mb-1">2026/2027</div>
            <span class="text-success small fw-medium">Semester Ganjil Siap Aktif</span>
          </div>
        </div>

        <div class="col-md-4">
          <div class="p-3 border rounded bg-light">
            <span class="text-secondary small d-block">Rombel &amp; Daya Tampung</span>
            <div class="fs-5 fw-bold text-body mb-1">12 Rombel Baru</div>
            <span class="text-secondary small">Total Kapasitas: 384 Kursi</span>
          </div>
        </div>

        <div class="col-md-4">
          <div class="p-3 border rounded bg-light">
            <span class="text-secondary small d-block">Alokasi Tenaga Pendidik</span>
            <div class="fs-5 fw-bold text-body mb-1">24 Guru Terjadwal</div>
            <span class="text-secondary small">Wali Kelas 100% Terisi</span>
          </div>
        </div>
      </div>

      <!-- Catatan Aktivasi Transisi -->
      <div class="alert alert-light border mb-3 py-2 px-3 small" role="alert">
        <strong>Catatan Transisi Periode Akademik:</strong>
        Saat Tahun Ajaran 2026/2027 diaktifkan, periode sebelumnya (2025/2026) akan otomatis ditandai sebagai <em>Selesai</em> dan diarsipkan. Seluruh siswa yang naik kelas akan ditempatkan di rombel baru mereka pada semester ganjil.
      </div>

      <!-- Tombol Aksi Utama -->
      <div class="text-center py-2">
        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
          Aktifkan Tahun Ajaran 2026/2027
        </button>
        <div class="mt-2">
          <button type="submit" name="as_draft" value="1" class="btn btn-outline-secondary btn-sm">
            Simpan Sebagai Draft Persiapan
          </button>
        </div>
      </div>

    </div>

    <div class="card-footer bg-body d-flex justify-content-between align-items-center py-2 px-3">
      <a href="<?= base_url('admin/wizard/5') ?>" class="btn btn-outline-secondary btn-sm">
        Kembali ke Langkah 5
      </a>
      <span class="text-secondary small">Konfigurasi tervalidasi &amp; siap diaktifkan</span>
    </div>
  </form>
</div>

<?= $this->endSection() ?>
