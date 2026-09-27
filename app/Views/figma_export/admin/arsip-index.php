<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-1">Modul Arsip &amp; Penelusuran Histori</h4>
    <p class="text-secondary small mb-0">Pusat pencarian data historis alumni, kenaikan kelas, raport lampau, mutasi, dan persuratan</p>
  </div>
  <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.print()">
    Cetak Rekap Arsip
  </button>
</div>

<!-- 7 Horizontal Tabs Arsip -->
<ul class="nav nav-tabs mb-3">
  <li class="nav-item">
    <a class="nav-link <?= ($activeTab === 'alumni') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('admin/arsip/alumni') ?>">
      1. Siswa / Alumni
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= ($activeTab === 'kenaikan') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('admin/arsip/kenaikan') ?>">
      2. Kenaikan Kelas
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= ($activeTab === 'raport') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('admin/arsip/raport') ?>">
      3. Arsip Raport
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= ($activeTab === 'mutasi') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('admin/arsip/mutasi') ?>">
      4. Mutasi Siswa
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= ($activeTab === 'dokumen') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('admin/arsip/dokumen') ?>">
      5. Dokumen Digital
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= ($activeTab === 'penugasan') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('admin/arsip/penugasan') ?>">
      6. Penugasan Guru
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= ($activeTab === 'surat') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('admin/arsip/surat') ?>">
      7. Surat Masuk &amp; Keluar
    </a>
  </li>
</ul>

<div class="card border">
  <!-- Search & Filter bar -->
  <div class="card-header bg-body py-2 px-3">
    <div class="row g-2 align-items-center">
      <div class="col-md-4">
        <input type="text" class="form-control form-control-sm" placeholder="Cari data pada arsip ini...">
      </div>
      <div class="col-md-3">
        <select class="form-select form-select-sm">
          <option>Filter Semua Tahun Ajaran</option>
          <option>2024/2025</option>
          <option>2023/2024</option>
        </select>
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      
      <?php if ($activeTab === 'alumni'): ?>
        <!-- TAB 1: ALUMNI -->
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Nama Siswa / Alumni</th>
              <th>NIS</th>
              <th>Tahun Lulus</th>
              <th>Kelas Terakhir</th>
              <th>Status</th>
              <th class="text-end" style="width: 140px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($arsip['alumni'])): ?>
              <tr>
                <td colspan="6" class="text-center text-secondary small py-4">Belum ada arsip data alumni</td>
              </tr>
            <?php else: ?>
              <?php foreach ($arsip['alumni'] as $al): ?>
                <tr>
                  <td class="fw-medium small text-body"><?= esc($al['nama']) ?></td>
                  <td><span class="font-monospace small text-secondary"><?= esc($al['nis']) ?></span></td>
                  <td><span class="font-monospace small"><?= esc($al['tahun_lulus']) ?></span></td>
                  <td class="small"><?= esc($al['kelas_terakhir']) ?></td>
                  <td><span class="text-success small fw-medium"><?= esc($al['status']) ?></span></td>
                  <td class="text-end">
                    <a href="<?= base_url('admin/siswa') ?>" class="btn btn-outline-secondary btn-sm py-0 px-2">Buku Induk</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>

      <?php elseif ($activeTab === 'kenaikan'): ?>
        <!-- TAB 2: RIWAYAT KENAIKAN KELAS -->
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Tahun Ajaran</th>
              <th>Nama Siswa</th>
              <th>Kelas Asal</th>
              <th>Kelas Tujuan</th>
              <th>Keputusan</th>
              <th>Catatan</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($arsip['kenaikan_kelas'])): ?>
              <tr>
                <td colspan="6" class="text-center text-secondary small py-4">Belum ada riwayat kenaikan kelas</td>
              </tr>
            <?php else: ?>
              <?php foreach ($arsip['kenaikan_kelas'] as $kk): ?>
                <tr>
                  <td><span class="font-monospace small text-secondary"><?= esc($kk['tahun']) ?></span></td>
                  <td class="fw-medium small text-body"><?= esc($kk['nama']) ?></td>
                  <td><span class="badge bg-secondary-subtle text-secondary border"><?= esc($kk['kelas_asal']) ?></span></td>
                  <td><span class="badge bg-secondary-subtle text-secondary border"><?= esc($kk['kelas_tujuan']) ?></span></td>
                  <td><span class="text-success small fw-medium"><?= esc($kk['status']) ?></span></td>
                  <td class="text-secondary small"><?= esc($kk['catatan']) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>

      <?php elseif ($activeTab === 'raport'): ?>
        <!-- TAB 3: ARSIP RAPORT -->
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Tahun Ajaran &amp; Semester</th>
              <th>Nama Siswa</th>
              <th>Kelas</th>
              <th>Tanggal Finalisasi</th>
              <th class="text-end" style="width: 140px;">Dokumen</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($arsip['raport'])): ?>
              <tr>
                <td colspan="5" class="text-center text-secondary small py-4">Belum ada arsip raport digital</td>
              </tr>
            <?php else: ?>
              <?php foreach ($arsip['raport'] as $rp): ?>
                <tr>
                  <td class="small"><strong class="text-body"><?= esc($rp['tahun']) ?></strong> &bull; Semester <?= esc($rp['semester']) ?></td>
                  <td class="fw-medium small text-body"><?= esc($rp['nama']) ?></td>
                  <td><span class="badge bg-secondary-subtle text-secondary border"><?= esc($rp['kelas']) ?></span></td>
                  <td class="small text-secondary"><?= date('d M Y', strtotime($rp['finalized_at'])) ?></td>
                  <td class="text-end">
                    <a href="<?= base_url('siswa/raport/preview') ?>" class="btn btn-outline-secondary btn-sm py-0 px-2">
                      Unduh PDF
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>

      <?php elseif ($activeTab === 'mutasi'): ?>
        <!-- TAB 4: MUTASI SISWA -->
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Nama Siswa</th>
              <th>NIS</th>
              <th>Jenis Mutasi</th>
              <th>Tanggal</th>
              <th>Asal / Sekolah Tujuan</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($arsip['mutasi'])): ?>
              <tr>
                <td colspan="6" class="text-center text-secondary small py-4">Belum ada riwayat mutasi siswa</td>
              </tr>
            <?php else: ?>
              <?php foreach ($arsip['mutasi'] as $mt): ?>
                <tr>
                  <td class="fw-medium small text-body"><?= esc($mt['nama']) ?></td>
                  <td><span class="font-monospace small text-secondary"><?= esc($mt['nis']) ?></span></td>
                  <td>
                    <?php if ($mt['jenis'] === 'Pindah Keluar'): ?>
                      <span class="badge bg-secondary-subtle text-secondary border">Pindah Keluar</span>
                    <?php else: ?>
                      <span class="badge bg-secondary-subtle text-secondary border">Pindah Masuk</span>
                    <?php endif; ?>
                  </td>
                  <td class="small text-secondary"><?= date('d M Y', strtotime($mt['tanggal'])) ?></td>
                  <td class="small"><?= esc($mt['asal_tujuan']) ?></td>
                  <td class="text-secondary small"><?= esc($mt['keterangan']) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>

      <?php elseif ($activeTab === 'dokumen'): ?>
        <!-- TAB 5: DOKUMEN DIGITAL -->
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Nama Siswa</th>
              <th>Jenis Dokumen</th>
              <th>Nama File</th>
              <th>Tanggal Upload</th>
              <th class="text-end" style="width: 120px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($arsip['dokumen'])): ?>
              <tr>
                <td colspan="5" class="text-center text-secondary small py-4">Belum ada arsip dokumen digital</td>
              </tr>
            <?php else: ?>
              <?php foreach ($arsip['dokumen'] as $dk): ?>
                <tr>
                  <td class="fw-medium small text-body"><?= esc($dk['nama_siswa']) ?></td>
                  <td><span class="badge bg-secondary-subtle text-secondary border"><?= esc($dk['jenis_dokumen']) ?></span></td>
                  <td><span class="font-monospace small text-secondary"><?= esc($dk['file_path']) ?></span></td>
                  <td class="small text-secondary"><?= date('d M Y', strtotime($dk['tanggal_upload'])) ?></td>
                  <td class="text-end">
                    <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2" onclick="window.print()">Cetak</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>

      <?php elseif ($activeTab === 'penugasan'): ?>
        <!-- TAB 6: PENUGASAN GURU HISTORIS -->
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Tahun Ajaran</th>
              <th>Guru Pengajar</th>
              <th>Mata Pelajaran</th>
              <th>Kelas yang Diajar</th>
              <th>Semester</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($arsip['penugasan_guru'])): ?>
              <tr>
                <td colspan="5" class="text-center text-secondary small py-4">Belum ada riwayat penugasan guru</td>
              </tr>
            <?php else: ?>
              <?php foreach ($arsip['penugasan_guru'] as $pg): ?>
                <tr>
                  <td><span class="font-monospace small text-secondary"><?= esc($pg['tahun']) ?></span></td>
                  <td class="fw-medium small text-body"><?= esc($pg['guru']) ?></td>
                  <td class="small"><?= esc($pg['mapel']) ?></td>
                  <td class="small"><?= esc($pg['kelas']) ?></td>
                  <td class="small text-secondary"><?= esc($pg['semester']) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>

      <?php elseif ($activeTab === 'surat'): ?>
        <!-- TAB 7: SURAT MASUK & KELUAR -->
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Jenis</th>
              <th>Nomor Surat</th>
              <th>Tanggal</th>
              <th>Pengirim / Tujuan</th>
              <th>Perihal</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($suratMasuk) && empty($suratKeluar)): ?>
              <tr>
                <td colspan="6" class="text-center text-secondary small py-4">Belum ada arsip surat</td>
              </tr>
            <?php else: ?>
              <?php foreach ($suratMasuk as $sm): ?>
                <tr>
                  <td><span class="badge bg-secondary-subtle text-secondary border">Surat Masuk</span></td>
                  <td><span class="font-monospace small fw-medium"><?= esc($sm['nomor_agenda']) ?></span></td>
                  <td class="small text-secondary"><?= date('d M Y', strtotime($sm['tanggal_diterima'])) ?></td>
                  <td class="small"><?= esc($sm['pengirim']) ?></td>
                  <td class="small"><?= esc($sm['perihal']) ?></td>
                  <td><span class="text-success small fw-medium"><?= esc($sm['status']) ?></span></td>
                </tr>
              <?php endforeach; ?>
              <?php foreach ($suratKeluar as $sk): ?>
                <tr>
                  <td><span class="badge bg-secondary-subtle text-secondary border">Surat Keluar</span></td>
                  <td><span class="font-monospace small fw-medium"><?= esc($sk['nomor_surat']) ?></span></td>
                  <td class="small text-secondary"><?= date('d M Y', strtotime($sk['tanggal_surat'])) ?></td>
                  <td class="small"><?= esc($sk['tujuan']) ?></td>
                  <td class="small"><?= esc($sk['perihal']) ?></td>
                  <td><span class="text-secondary small"><?= esc($sk['status']) ?></span></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      <?php endif; ?>

    </div>
  </div>
</div>

<?= $this->endSection() ?>
