<?php $activeAspek = 'keterampilan'; ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
  <div>
    <h4 class="fw-bold mb-1">Rincian Capaian Nilai Akademik</h4>
    <p class="text-secondary small mb-0">Rincian perolehan nilai mata pelajaran dan predikat ketuntasan KKM.</p>
  </div>
  <div>
    <select class="form-select form-select-sm" aria-label="Pilih Semester">
      <option selected>Semester Ganjil 2025/2026 (Aktif)</option>
      <option>Semester Genap 2024/2025</option>
      <option>Semester Ganjil 2024/2025</option>
    </select>
  </div>
</div>

<!-- Tabs Pengetahuan vs Keterampilan -->
<ul class="nav nav-tabs mb-4">
  <li class="nav-item">
    <a class="nav-link px-4 <?= ($activeAspek === 'pengetahuan') ? 'active fw-semibold text-primary' : 'text-secondary' ?>" href="<?= base_url('siswa/nilai/pengetahuan') ?>">
      Nilai Pengetahuan (Teori)
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link px-4 <?= ($activeAspek === 'keterampilan') ? 'active fw-semibold text-primary' : 'text-secondary' ?>" href="<?= base_url('siswa/nilai/keterampilan') ?>">
      Nilai Keterampilan (Praktik)
    </a>
  </li>
</ul>

<!-- Accordion Nilai Mapel -->
<?php if (empty($raport['nilai_kelompok'])): ?>
  <div class="card border p-5 text-center">
    <h6 class="fw-bold">Belum Ada Data Nilai</h6>
    <p class="text-secondary small mb-0">Data capaian kompetensi untuk semester ini belum dipublikasikan oleh pihak kurikulum.</p>
  </div>
<?php else: ?>
  <div class="accordion" id="accordionNilai">
    <?php $mapelIndex = 1; ?>
    <?php foreach ($raport['nilai_kelompok'] as $kelompokName => $mapelList): ?>
      <div class="mb-3">
        <div class="text-secondary text-uppercase small fw-semibold mb-2 px-1"><?= esc($kelompokName) ?></div>
        
        <?php foreach ($mapelList as $m): ?>
          <?php 
            $val = ($activeAspek === 'pengetahuan') ? $m['pengetahuan_nilai'] : $m['keterampilan_nilai'];
            $pred = ($activeAspek === 'pengetahuan') ? $m['pengetahuan_predikat'] : $m['keterampilan_predikat'];
            $desk = ($activeAspek === 'pengetahuan') ? $m['pengetahuan_deskripsi'] : $m['keterampilan_deskripsi'];
            $isTuntas = ($val >= $m['kkm']);
          ?>
          <div class="accordion-item mb-2 border rounded">
            <h2 class="accordion-header" id="headingMapel<?= $mapelIndex ?>">
              <button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMapel<?= $mapelIndex ?>" aria-expanded="false" aria-controls="collapseMapel<?= $mapelIndex ?>">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center w-100 me-3 gap-2">
                  <span class="text-body fw-medium"><?= esc($m['mapel']) ?></span>
                  <div class="d-flex align-items-center gap-3">
                    <span class="text-secondary small">KKM: <span class="font-monospace fw-semibold text-body"><?= $m['kkm'] ?></span></span>
                    <span class="font-monospace fw-bold <?= $isTuntas ? 'text-primary' : 'text-danger' ?>">Nilai: <?= $val ?></span>
                    <span class="badge <?= $isTuntas ? 'bg-success-subtle text-success-emphasis border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' ?> px-2 py-1">Predikat: <?= $pred ?></span>
                  </div>
                </div>
              </button>
            </h2>
            <div id="collapseMapel<?= $mapelIndex ?>" class="accordion-collapse collapse" aria-labelledby="headingMapel<?= $mapelIndex ?>">
              <div class="accordion-body bg-body-tertiary small">
                <div class="row g-3">
                  <div class="col-md-7">
                    <span class="d-block mb-1 text-primary fw-semibold">Deskripsi Kemajuan Belajar:</span>
                    <p class="text-secondary mb-0"><?= esc($desk) ?></p>
                  </div>
                  <div class="col-md-5 border-start">
                    <span class="d-block mb-1 text-body fw-semibold">Struktur Pembobotan Nilai:</span>
                    <ul class="list-unstyled mb-2 small">
                      <li class="d-flex justify-content-between py-1 border-bottom"><span class="text-secondary">Ulangan Harian / Formatif:</span> <span class="font-monospace fw-medium">20%</span></li>
                      <li class="d-flex justify-content-between py-1 border-bottom"><span class="text-secondary">Tugas Terstruktur & Portofolio:</span> <span class="font-monospace fw-medium">20%</span></li>
                      <li class="d-flex justify-content-between py-1 border-bottom"><span class="text-secondary">Penilaian Tengah Semester (PTS):</span> <span class="font-monospace fw-medium">25%</span></li>
                      <li class="d-flex justify-content-between py-1 border-bottom"><span class="text-secondary">Penilaian Akhir Semester (PAS):</span> <span class="font-monospace fw-medium">35%</span></li>
                      <li class="d-flex justify-content-between py-1 text-primary fw-bold"><span>Total Akumulasi Nilai:</span> <span class="font-monospace"><?= $val ?> (<?= $pred ?>)</span></li>
                    </ul>
                    <div class="p-2 bg-body rounded border small text-secondary">
                      Rincian tugas dan latihan harian per materi dapat dikonfirmasi langsung ke guru pengampu mapel.
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php $mapelIndex++; ?>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?= $this->endSection() ?>
