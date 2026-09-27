<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-3">
  <a href="<?= base_url('admin/siswa') ?>" class="text-decoration-none small text-secondary">
    &larr; Kembali ke Daftar Siswa
  </a>
</div>

<!-- Header Profil Siswa -->
<div class="card border mb-3">
  <div class="card-body p-3">
    <div class="d-flex flex-column flex-md-row align-items-center gap-3">
      <img src="<?= esc($siswa['foto_path']) ?>" alt="<?= esc($siswa['nama']) ?>" class="rounded-circle border" width="72" height="72" style="object-fit: cover;">
      <div class="flex-grow-1 text-center text-md-start">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
          <div>
            <h5 class="fw-bold mb-1"><?= esc($siswa['nama']) ?></h5>
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start gap-2 text-secondary small">
              <span>NIS: <strong class="text-body font-monospace"><?= esc($siswa['nis']) ?></strong></span>
              <span>&bull;</span>
              <span>NISN: <strong class="text-body font-monospace"><?= esc($siswa['nisn']) ?></strong></span>
              <span>&bull;</span>
              <span>Rombel: <span class="badge bg-secondary-subtle text-secondary border"><?= esc($siswa['kelas_nama'] ?? 'Unassigned') ?></span></span>
            </div>
          </div>
          <div>
            <a href="<?= base_url('admin/siswa/edit/' . $siswa['id']) ?>" class="btn btn-outline-secondary btn-sm">
              Edit Biodata
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 5 Tabs Detail Siswa -->
<ul class="nav nav-tabs mb-3">
  <li class="nav-item">
    <a class="nav-link <?= ($activeTab === 'biodata') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('admin/siswa/detail/' . $siswa['id'] . '/biodata') ?>">
      1. Biodata Lengkap
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= ($activeTab === 'ortu') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('admin/siswa/detail/' . $siswa['id'] . '/ortu') ?>">
      2. Orang Tua / Wali
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= ($activeTab === 'riwayat') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('admin/siswa/detail/' . $siswa['id'] . '/riwayat') ?>">
      3. Riwayat Kelas
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= ($activeTab === 'nilai') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('admin/siswa/detail/' . $siswa['id'] . '/nilai') ?>">
      4. Rekap Nilai Raport
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= ($activeTab === 'dokumen') ? 'active fw-semibold' : 'text-secondary' ?>" href="<?= base_url('admin/siswa/detail/' . $siswa['id'] . '/dokumen') ?>">
      5. Dokumen Digital
    </a>
  </li>
</ul>

<!-- Konten Tab -->
<div class="card border">
  <div class="card-body p-3">

    <?php if ($activeTab === 'biodata'): ?>
      <!-- TAB 1: BIODATA LENGKAP -->
      <div class="row g-3">
        <div class="col-md-6 border-bottom pb-2">
          <span class="small text-secondary d-block">Nama Lengkap</span>
          <span class="fw-medium small"><?= esc($siswa['nama']) ?></span>
        </div>
        <div class="col-md-3 border-bottom pb-2">
          <span class="small text-secondary d-block">NIS</span>
          <span class="font-monospace small"><?= esc($siswa['nis']) ?></span>
        </div>
        <div class="col-md-3 border-bottom pb-2">
          <span class="small text-secondary d-block">NISN</span>
          <span class="font-monospace small"><?= esc($siswa['nisn']) ?></span>
        </div>
        <div class="col-md-6 border-bottom pb-2">
          <span class="small text-secondary d-block">Tempat, Tanggal Lahir</span>
          <span class="small"><?= esc($siswa['tempat_lahir']) ?>, <?= date('d F Y', strtotime($siswa['tanggal_lahir'])) ?></span>
        </div>
        <div class="col-md-3 border-bottom pb-2">
          <span class="small text-secondary d-block">Jenis Kelamin</span>
          <span class="small"><?= ($siswa['jenis_kelamin'] === 'L') ? 'Laki-laki' : 'Perempuan' ?></span>
        </div>
        <div class="col-md-3 border-bottom pb-2">
          <span class="small text-secondary d-block">Agama</span>
          <span class="small"><?= esc($siswa['agama']) ?></span>
        </div>
        <div class="col-12 border-bottom pb-2">
          <span class="small text-secondary d-block">Alamat Lengkap</span>
          <span class="small"><?= esc($siswa['alamat']) ?></span>
        </div>
        <div class="col-md-4 border-bottom pb-2">
          <span class="small text-secondary d-block">Status dalam Keluarga</span>
          <span class="small"><?= esc($siswa['status_dalam_keluarga']) ?> (Anak ke-<?= esc($siswa['anak_ke']) ?>)</span>
        </div>
        <div class="col-md-4 border-bottom pb-2">
          <span class="small text-secondary d-block">Asal Sekolah</span>
          <span class="small"><?= esc($siswa['sekolah_asal']) ?></span>
        </div>
        <div class="col-md-4 border-bottom pb-2">
          <span class="small text-secondary d-block">Tanggal Diterima</span>
          <span class="small"><?= date('d F Y', strtotime($siswa['tanggal_diterima'])) ?></span>
        </div>
      </div>

    <?php elseif ($activeTab === 'ortu'): ?>
      <!-- TAB 2: ORANG TUA / WALI -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-semibold mb-0">Data Orang Tua / Wali Siswa</h6>
        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahOrtu">+ Tambah Data Ortu/Wali</button>
      </div>
      <div class="row g-3">
        <?php if (!empty($siswa['ortu'])): ?>
          <?php foreach ($siswa['ortu'] as $ortu): ?>
            <div class="col-md-4">
              <div class="card border h-100 p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="badge bg-secondary-subtle text-secondary border text-uppercase"><?= esc($ortu['jenis']) ?></span>
                  <button class="btn btn-sm btn-outline-secondary py-0 px-2" title="Edit Data Ortu/Wali" data-bs-toggle="modal" data-bs-target="#modalEditOrtu" data-jenis="<?= esc($ortu['jenis']) ?>" data-nama="<?= esc($ortu['nama']) ?>" data-pekerjaan="<?= esc($ortu['pekerjaan']) ?>" data-telepon="<?= esc($ortu['telepon']) ?>" data-alamat="<?= esc($ortu['alamat']) ?>">Edit</button>
                </div>
                <h6 class="fw-semibold mb-2"><?= esc($ortu['nama']) ?></h6>
                <div class="small text-secondary mb-1">Pekerjaan: <span class="text-body fw-medium"><?= esc($ortu['pekerjaan']) ?></span></div>
                <div class="small text-secondary mb-1">No. Telp: <span class="text-body font-monospace"><?= esc($ortu['telepon']) ?></span></div>
                <div class="small text-secondary"><?= esc($ortu['alamat']) ?></div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

    <?php elseif ($activeTab === 'riwayat'): ?>
      <!-- TAB 3: RIWAYAT KELAS & MULTI-SEMESTER -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <h6 class="mb-0 fw-semibold">Riwayat Penempatan Kelas &amp; Status Akademik</h6>
          <span class="text-secondary small">Data historis per tahun ajaran dan semester</span>
        </div>
        <span class="text-secondary small"><?= count($riwayatKelas ?? []) ?> semester tercatat</span>
      </div>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Tahun Ajaran</th>
              <th>Semester</th>
              <th>Kelas / Rombel</th>
              <th>No. Absen</th>
              <th>Rata-rata Rapor</th>
              <th>Ranking</th>
              <th>Status Siswa</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($riwayatKelas)): ?>
              <?php foreach ($riwayatKelas as $rk): ?>
                <tr>
                  <td class="fw-medium small"><?= esc($rk['tahun_ajaran_nama']) ?></td>
                  <td class="small">
                    <?= esc($rk['semester_nama']) ?>
                  </td>
                  <td><span class="badge bg-secondary-subtle text-secondary border"><?= esc($rk['kelas_nama']) ?></span></td>
                  <td class="font-monospace small text-secondary"><?= esc($rk['urutan_absen'] ?? '-') ?></td>
                  <td class="fw-semibold small font-monospace"><?= isset($rk['rata_rata']) ? number_format($rk['rata_rata'], 1) : '<span class="text-muted fw-normal">&mdash;</span>' ?></td>
                  <td class="small"><?= isset($rk['ranking']) ? '#' . $rk['ranking'] : '&mdash;' ?></td>
                  <td class="small">
                    <?= esc($rk['status_siswa']) ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center text-secondary small py-4">Belum ada data riwayat kelas untuk siswa ini.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    <?php elseif ($activeTab === 'nilai'): ?>
      <!-- TAB 4: REKAP NILAI RAPORT -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-semibold mb-0">Rekap Nilai Semester Ganjil TA 2025/2026</h6>
        <span class="text-secondary small">Status: Draft</span>
      </div>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-center">
          <thead class="table-light">
            <tr>
              <th class="text-start">Mata Pelajaran</th>
              <th style="width: 80px;">KKM</th>
              <th style="width: 130px;">Nilai Pengetahuan</th>
              <th style="width: 90px;">Predikat</th>
              <th style="width: 130px;">Nilai Keterampilan</th>
              <th style="width: 90px;">Predikat</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($raport['nilai_kelompok'] as $kelompokName => $mapelList): ?>
              <tr class="table-light">
                <td colspan="6" class="text-start py-1 fw-semibold small text-secondary"><?= esc($kelompokName) ?></td>
              </tr>
              <?php foreach ($mapelList as $m): ?>
                <tr>
                  <td class="text-start fw-medium small"><?= esc($m['mapel']) ?></td>
                  <td class="font-monospace small text-secondary"><?= $m['kkm'] ?></td>
                  <td class="font-monospace fw-semibold small"><?= $m['pengetahuan_nilai'] ?></td>
                  <td class="small fw-semibold"><?= $m['pengetahuan_predikat'] ?></td>
                  <td class="font-monospace fw-semibold small"><?= $m['keterampilan_nilai'] ?></td>
                  <td class="small fw-semibold"><?= $m['keterampilan_predikat'] ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    <?php elseif ($activeTab === 'dokumen'): ?>
      <!-- TAB 5: DOKUMEN DIGITAL -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-semibold mb-0">Arsip Berkas Digital Siswa</h6>
        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalUploadDokumen">+ Upload Dokumen</button>
      </div>
      <div class="list-group">
        <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
          <div>
            <span class="d-block fw-medium small text-body"><?= 'Scan Ijazah SMP Asli' ?></span>
            <span class="text-secondary small">Diupload pada: 20 Juli 2024 &bull; 1.4 MB (PDF)</span>
          </div>
          <div class="btn-group btn-group-sm">
            <button class="btn btn-outline-secondary py-0 px-2" data-bs-toggle="modal" data-bs-target="#modalPreviewDokumen" data-nama="Scan Ijazah SMP Asli" data-tipe="pdf">Lihat</button>
            <button class="btn btn-outline-secondary py-0 px-2" onclick="window.print()">Cetak</button>
          </div>
        </div>
        <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
          <div>
            <span class="d-block fw-medium small text-body"><?= 'Scan Kartu Keluarga & Akta Kelahiran' ?></span>
            <span class="text-secondary small">Diupload pada: 20 Juli 2024 &bull; 2.1 MB (JPG)</span>
          </div>
          <div class="btn-group btn-group-sm">
            <button class="btn btn-outline-secondary py-0 px-2" data-bs-toggle="modal" data-bs-target="#modalPreviewDokumen" data-nama="Scan Kartu Keluarga & Akta Kelahiran" data-tipe="image">Lihat</button>
            <button class="btn btn-outline-secondary py-0 px-2" onclick="window.print()">Cetak</button>
          </div>
        </div>
      </div>
    <?php endif; ?>

  </div>
</div>

<!-- Modal Tambah Ortu/Wali -->
<div class="modal fade" id="modalTambahOrtu" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Data Orang Tua / Wali">
        <input type="hidden" name="redirect_url" value="/admin/siswa/detail/<?= $siswa['id'] ?>/ortu">
        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Tambah Data Orang Tua / Wali</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Hubungan / Jenis</label>
            <select class="form-select form-select-sm" name="jenis" required>
              <option value="Ayah">Ayah</option>
              <option value="Ibu">Ibu</option>
              <option value="Wali">Wali</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Nama Lengkap</label>
            <input type="text" class="form-control form-control-sm" name="nama" placeholder="Contoh: Muhammad Yusuf, S.E." required>
          </div>
          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Pekerjaan</label>
              <input type="text" class="form-control form-control-sm" name="pekerjaan" placeholder="Contoh: Wiraswasta / PNS" required>
            </div>
            <div class="col-6">
              <label class="form-label small fw-semibold text-secondary mb-1">No. Telepon / WhatsApp</label>
              <input type="text" class="form-control form-control-sm" name="telepon" placeholder="Contoh: 08123456789" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Alamat Domisili</label>
            <textarea class="form-control form-control-sm" name="alamat" rows="2" placeholder="Alamat lengkap domisili ortu/wali" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-3">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Ortu/Wali -->
<div class="modal fade" id="modalEditOrtu" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Data Orang Tua / Wali">
        <input type="hidden" name="redirect_url" value="/admin/siswa/detail/<?= $siswa['id'] ?>/ortu">
        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Edit Data Orang Tua / Wali</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Hubungan / Jenis</label>
            <select class="form-select form-select-sm" id="editJenisOrtu" name="jenis" required>
              <option value="Ayah">Ayah</option>
              <option value="Ibu">Ibu</option>
              <option value="Wali">Wali</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Nama Lengkap</label>
            <input type="text" class="form-control form-control-sm" id="editNamaOrtu" name="nama" required>
          </div>
          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label small fw-semibold text-secondary mb-1">Pekerjaan</label>
              <input type="text" class="form-control form-control-sm" id="editPekerjaanOrtu" name="pekerjaan" required>
            </div>
            <div class="col-6">
              <label class="form-label small fw-semibold text-secondary mb-1">No. Telepon / WhatsApp</label>
              <input type="text" class="form-control form-control-sm" id="editTeleponOrtu" name="telepon" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Alamat Domisili</label>
            <textarea class="form-control form-control-sm" id="editAlamatOrtu" name="alamat" rows="2" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-3">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Upload Dokumen -->
<div class="modal fade" id="modalUploadDokumen" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <form action="<?= base_url('admin/save-action') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="Dokumen Siswa">
        <input type="hidden" name="redirect_url" value="/admin/siswa/detail/<?= $siswa['id'] ?>/dokumen">
        <div class="modal-header">
          <h6 class="modal-title fw-semibold">Upload Dokumen Digital Siswa</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Jenis Dokumen</label>
            <select class="form-select form-select-sm" name="jenis_dokumen" required>
              <option value="Scan Ijazah SMP Asli">Scan Ijazah SMP Asli</option>
              <option value="Scan Kartu Keluarga & Akta Kelahiran">Scan Kartu Keluarga & Akta Kelahiran</option>
              <option value="Scan Rapor SMP">Scan Rapor SMP</option>
              <option value="Sertifikat Piagam Kejuaraan">Sertifikat Piagam Kejuaraan</option>
              <option value="Dokumen Lainnya">Dokumen Lainnya</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Keterangan Tambahan</label>
            <input type="text" class="form-control form-control-sm" name="keterangan" placeholder="Contoh: Berkas asli telah diverifikasi">
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Pilih File (PDF, JPG, PNG)</label>
            <input type="file" class="form-control form-control-sm" name="file_dokumen" accept=".pdf,.jpg,.jpeg,.png">
            <span class="text-secondary small">Maksimal ukuran file 5 MB</span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-3">Upload Dokumen</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Pratinjau Dokumen -->
<div class="modal fade" id="modalPreviewDokumen" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <div class="modal-header">
        <h6 class="modal-title fw-semibold">Pratinjau Dokumen</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center py-4">
        <h6 id="previewDocTitle" class="fw-bold mb-2">-</h6>
        <p class="text-secondary small mb-0">Berkas digital resmi siswa terarsip pada sistem sekolah.</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('[data-bs-target="#modalEditOrtu"]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('editJenisOrtu').value = this.dataset.jenis || 'Ayah';
    document.getElementById('editNamaOrtu').value = this.dataset.nama || '';
    document.getElementById('editPekerjaanOrtu').value = this.dataset.pekerjaan || '';
    document.getElementById('editTeleponOrtu').value = this.dataset.telepon || '';
    document.getElementById('editAlamatOrtu').value = this.dataset.alamat || '';
  });
});
document.querySelectorAll('[data-bs-target="#modalPreviewDokumen"]').forEach(btn => {
  btn.addEventListener('click', function() {
    const docName = this.dataset.nama || 'Dokumen';
    document.getElementById('previewDocTitle').textContent = docName;
  });
});
</script>

<?= $this->endSection() ?>
