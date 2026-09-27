<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
  <div>
    <h4 class="fw-bold mb-1">Tugas Harian &amp; Ulangan Harian</h4>
    <div class="text-secondary small">
      Mata Pelajaran: <strong class="text-body"><?= esc($pengajaran['mapel_nama']) ?></strong>
      &bull; Kelas: <strong class="text-body"><?= esc($pengajaran['kelas_nama']) ?></strong>
    </div>
  </div>
  <div>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalBuatTugas">
      Buat Tugas / Ulangan Baru
    </button>
  </div>
</div>

<!-- Helper Integrasi Nilai -->
<div class="card bg-body-tertiary border mb-3">
  <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 small">
    <div>
      <span class="fw-semibold text-body">Kalkulasi Otomatis:</span>
      <span class="text-secondary ms-1">Nilai dari setiap tugas dan ulangan harian otomatis dihitung rata-ratanya dan dimasukkan ke buku nilai utama.</span>
    </div>
    <div>
      <a href="<?= base_url('guru/nilai/' . $pengajaran['id'] . '/pengetahuan') ?>" class="btn btn-outline-secondary btn-sm">
        Buka Input Nilai Mapel
      </a>
    </div>
  </div>
</div>

<!-- Nav Tabs: Daftar Tugas vs Rekap Rata-rata -->
<ul class="nav nav-tabs mb-3" id="tugasTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active fw-semibold" id="list-tab" data-bs-toggle="tab" data-bs-target="#tabDaftarTugas" type="button" role="tab">
      Daftar Tugas &amp; UH (<?= count($tugasList) ?>)
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link fw-semibold" id="rekap-tab" data-bs-toggle="tab" data-bs-target="#tabRekapNilai" type="button" role="tab">
      Rekap Nilai Siswa &amp; Rata-rata
    </button>
  </li>
</ul>

<div class="tab-content" id="tugasTabContent">
  <!-- Tab 1: Daftar Tugas & UH -->
  <div class="tab-pane fade show active" id="tabDaftarTugas" role="tabpanel">
    <div class="card border">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width: 48px;" class="text-center">No</th>
                <th>Judul Tugas / Ulangan</th>
                <th>Tanggal Pelaksanaan</th>
                <th>Komponen</th>
                <th>Kelengkapan Nilai</th>
                <th class="text-end" style="width: 160px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($tugasList)): ?>
                <tr>
                  <td colspan="6" class="text-center text-secondary py-4">Belum ada tugas atau ulangan harian yang dibuat.</td>
                </tr>
              <?php else: ?>
                <?php $no = 1; foreach ($tugasList as $t): ?>
                  <tr>
                    <td class="text-center text-secondary"><?= $no++ ?></td>
                    <td class="text-body fw-medium">
                      <?= esc($t['judul']) ?>
                    </td>
                    <td class="text-secondary"><?= date('d F Y', strtotime($t['tanggal'])) ?></td>
                    <td>
                      <span class="text-body small">
                        <?= esc($t['komponen']) ?>
                      </span>
                    </td>
                    <td>
                      <span class="badge <?= ($t['jumlah_dinilai'] >= $t['total_siswa']) ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning-emphasis border border-warning-subtle' ?> fw-normal">
                        <?= $t['jumlah_dinilai'] ?> / <?= $t['total_siswa'] ?> Dinilai
                      </span>
                    </td>
                    <td class="text-end">
                      <div class="d-inline-flex gap-1">
                        <a href="<?= base_url('guru/tugas/' . $pengajaran['id'] . '/nilai/' . $t['id']) ?>" class="btn btn-outline-primary btn-sm">
                          Input Nilai
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus" data-bs-toggle="modal" data-bs-target="#modalHapusTugas" data-id="<?= esc($t['id']) ?>" data-judul="<?= esc($t['judul']) ?>">Hapus</button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Tab 2: Rekap Nilai Siswa & Rata-rata -->
  <div class="tab-pane fade" id="tabRekapNilai" role="tabpanel">
    <div class="card border">
      <div class="card-header bg-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 py-2 px-3">
        <span class="small fw-semibold text-secondary">
          Akumulasi Nilai Seluruh Tugas &amp; UH Siswa Kelas <?= esc($pengajaran['kelas_nama']) ?>
        </span>
        <div class="d-flex gap-2">
          <a href="<?= base_url('guru/nilai/' . $pengajaran['id'] . '/sync-rata-rata') ?>" class="btn btn-outline-secondary btn-sm">
            Sinkronkan ke Buku Nilai
          </a>
          <a href="<?= base_url('guru/nilai/' . $pengajaran['id'] . '/pengetahuan') ?>" class="btn btn-primary btn-sm">
            Buka Buku Nilai Mapel
          </a>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle mb-0 text-center">
            <thead class="table-light">
              <tr>
                <th rowspan="2" class="align-middle text-start" style="width: 48px;">No</th>
                <th rowspan="2" class="align-middle text-start" style="min-width: 200px;">Nama Siswa</th>
                <th colspan="3" class="border-bottom-0">Tugas Harian &amp; Kuis</th>
                <th colspan="2" class="border-bottom-0">Ulangan Harian (UH)</th>
                <th rowspan="2" class="align-middle fw-semibold" style="min-width: 110px;">
                  Rata-rata Tugas<br><small class="fw-normal text-secondary">(Masuk Nilai)</small>
                </th>
                <th rowspan="2" class="align-middle fw-semibold" style="min-width: 110px;">
                  Rata-rata UH<br><small class="fw-normal text-secondary">(Masuk Nilai)</small>
                </th>
                <th rowspan="2" class="align-middle text-end" style="width: 80px;">Aksi</th>
              </tr>
              <tr>
                <th class="small text-secondary fw-normal">Tugas 1</th>
                <th class="small text-secondary fw-normal">Tugas 2</th>
                <th class="small text-secondary fw-normal">Tugas 3</th>
                <th class="small text-secondary fw-normal">UH 1</th>
                <th class="small text-secondary fw-normal">UH 2</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($rekapData['rekap'])): ?>
                <tr>
                  <td colspan="9" class="text-center text-secondary py-4">Belum ada data nilai tugas untuk siswa rombel ini.</td>
                </tr>
              <?php else: ?>
                <?php $rNo = 1; foreach ($rekapData['rekap'] as $r): ?>
                  <tr>
                    <td class="text-start text-secondary"><?= $rNo++ ?></td>
                    <td class="text-start">
                      <span class="text-body fw-medium d-block"><?= esc($r['nama']) ?></span>
                      <small class="text-secondary">NIS: <?= esc($r['nis']) ?></small>
                    </td>
                    <td><?= $r['scores'][1] ?? '-' ?></td>
                    <td><?= $r['scores'][2] ?? '-' ?></td>
                    <td><?= $r['scores'][4] ?? '-' ?></td>
                    <td><?= $r['scores'][3] ?? '-' ?></td>
                    <td><?= $r['scores'][5] ?? '-' ?></td>
                    <td class="fw-bold text-body">
                      <?= number_format($r['avg_tugas'], 1) ?>
                    </td>
                    <td class="fw-bold text-body">
                      <?= number_format($r['avg_uh'], 1) ?>
                    </td>
                    <td class="text-end">
                      <a href="<?= base_url('guru/tugas/' . $pengajaran['id'] . '/nilai/1') ?>" class="btn btn-outline-secondary btn-sm" title="Edit Nilai Tugas">
                        Edit
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Buat Tugas Harian -->
<div class="modal fade" id="modalBuatTugas" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('guru/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Tugas Harian Baru">
        <input type="hidden" name="redirect_url" value="/guru/tugas/<?= $pengajaran['id'] ?>">

        <div class="modal-header">
          <h5 class="modal-title fw-semibold">Buat Tugas / Ulangan Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold">Judul Tugas / Ulangan</label>
            <input type="text" class="form-control form-control-sm" name="judul" placeholder="Contoh: Tugas 4: Matriks Invers" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Tanggal Pelaksanaan</label>
            <input type="date" class="form-control form-control-sm" name="tanggal" value="<?= date('Y-m-d') ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Kategori Komponen Nilai</label>
            <select class="form-select form-select-sm" name="komponen_id">
              <?php foreach ($komponenList as $komp): ?>
                <option value="<?= $komp['id'] ?>"><?= esc($komp['nama']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Deskripsi / Petunjuk Soal</label>
            <textarea class="form-control form-control-sm" name="deskripsi" rows="2" placeholder="Petunjuk pengerjaan soal"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-3">Simpan Tugas</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Hapus Tugas -->
<div class="modal fade" id="modalHapusTugas" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('guru/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Hapus Tugas Harian">
        <input type="hidden" name="redirect_url" value="/guru/tugas/<?= $pengajaran['id'] ?>">
        <input type="hidden" name="tugas_id" id="hapusTugasId">
        <div class="modal-header">
          <h6 class="modal-title text-danger fw-semibold">Hapus Tugas</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center py-3">
          <p class="mb-0 small">Yakin ingin menghapus tugas <strong id="hapusJudulTugas">-</strong>?</p>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger btn-sm">Ya, Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const modalHapus = document.getElementById('modalHapusTugas');
  if (modalHapus) {
    modalHapus.addEventListener('show.bs.modal', function(event) {
      const button = event.relatedTarget;
      if (button) {
        document.getElementById('hapusTugasId').value = button.getAttribute('data-id') || '';
        document.getElementById('hapusJudulTugas').textContent = button.getAttribute('data-judul') || '-';
      }
    });
  }
});
</script>

<?= $this->endSection() ?>

