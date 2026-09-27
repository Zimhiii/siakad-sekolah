<?php

namespace App\Libraries;

class MockData
{
    public static function getSekolah()
    {
        return [
            'id' => 1,
            'nama_sekolah' => 'SMA IT Fithrah Insani',
            'npsn' => '20224156',
            'nss' => '301020801001',
            'jenjang' => 'SMA',
            'kepala_sekolah' => 'Drs. H. Ahmad Fauzi, M.Pd.',
            'alamat' => 'Jl. Haji Gofur No. 10, Gadobangkong',
            'kelurahan' => 'Gadobangkong',
            'kecamatan' => 'Ngamprah',
            'kabupaten_kota' => 'Kabupaten Bandung Barat',
            'provinsi' => 'Jawa Barat',
            'website' => 'https://fithrahinsani.sch.id',
            'email' => 'info@fithrahinsani.sch.id',
            'telepon' => '(022) 6625890',
            'logo_url' => 'https://ui-avatars.com/api/?name=SIAKAD+FI&background=1E3A5F&color=fff&size=128'
        ];
    }

    public static function getTahunAjaran()
    {
        $base = [
            [
                'id' => 1,
                'nama' => '2024/2025',
                'tanggal_mulai' => '2024-07-15',
                'tanggal_selesai' => '2025-06-20',
                'status' => 'selesai',
                'semesters' => [
                    ['id' => 1, 'nama' => 'Ganjil', 'tanggal_mulai' => '2024-07-15', 'tanggal_selesai' => '2024-12-20', 'is_active' => false],
                    ['id' => 2, 'nama' => 'Genap', 'tanggal_mulai' => '2025-01-06', 'tanggal_selesai' => '2025-06-20', 'is_active' => false]
                ]
            ],
            [
                'id' => 2,
                'nama' => '2025/2026',
                'tanggal_mulai' => '2025-07-14',
                'tanggal_selesai' => '2026-06-19',
                'status' => 'aktif',
                'semesters' => [
                    ['id' => 3, 'nama' => 'Ganjil', 'tanggal_mulai' => '2025-07-14', 'tanggal_selesai' => '2025-12-19', 'is_active' => true],
                    ['id' => 4, 'nama' => 'Genap', 'tanggal_mulai' => '2026-01-05', 'tanggal_selesai' => '2026-06-19', 'is_active' => false]
                ]
            ],
            [
                'id' => 3,
                'nama' => '2026/2027',
                'tanggal_mulai' => '2026-07-13',
                'tanggal_selesai' => '2027-06-18',
                'status' => 'draft',
                'semesters' => [
                    ['id' => 5, 'nama' => 'Ganjil', 'tanggal_mulai' => '2026-07-13', 'tanggal_selesai' => '2026-12-18', 'is_active' => false],
                    ['id' => 6, 'nama' => 'Genap', 'tanggal_mulai' => '2027-01-04', 'tanggal_selesai' => '2027-06-18', 'is_active' => false]
                ]
            ]
        ];

        if (function_exists('session')) {
            $taOverride = session()->get('tahun_ajaran_aktif_override');
            $semOverride = session()->get('semester_aktif_override');

            if ($taOverride) {
                foreach ($base as &$ta) {
                    if ($ta['nama'] === $taOverride) {
                        $ta['status'] = 'aktif';
                        $ta['semesters'][0]['is_active'] = true;
                        $ta['semesters'][1]['is_active'] = false;
                    } else {
                        $ta['status'] = 'selesai';
                        $ta['semesters'][0]['is_active'] = false;
                        $ta['semesters'][1]['is_active'] = false;
                    }
                }
            }

            if ($semOverride) {
                foreach ($base as &$ta) {
                    if ($ta['status'] === 'aktif') {
                        foreach ($ta['semesters'] as &$sem) {
                            $sem['is_active'] = ($sem['nama'] === $semOverride);
                        }
                    }
                }
            }
        }

        return $base;
    }

    public static function getTingkatan()
    {
        return [
            ['id' => 1, 'nama' => 'Kelas 10', 'urutan' => 1, 'jumlah_kelas' => 4],
            ['id' => 2, 'nama' => 'Kelas 11', 'urutan' => 2, 'jumlah_kelas' => 4],
            ['id' => 3, 'nama' => 'Kelas 12', 'urutan' => 3, 'jumlah_kelas' => 4],
        ];
    }

    public static function getJurusan()
    {
        return [
            ['id' => 1, 'nama_jurusan' => 'Matematika dan Ilmu Pengetahuan Alam', 'kode' => 'MIPA', 'jumlah_kelas' => 6],
            ['id' => 2, 'nama_jurusan' => 'Ilmu Pengetahuan Sosial', 'kode' => 'IPS', 'jumlah_kelas' => 6],
            ['id' => 3, 'nama_jurusan' => 'Bahasa dan Budaya', 'kode' => 'BAHASA', 'jumlah_kelas' => 0],
        ];
    }

    public static function getKelompokMapel()
    {
        return [
            ['id' => 1, 'nama' => 'Kelompok A (Umum / Wajib)', 'urutan' => 1, 'jumlah_mapel' => 6],
            ['id' => 2, 'nama' => 'Kelompok B (Umum / Wajib)', 'urutan' => 2, 'jumlah_mapel' => 3],
            ['id' => 3, 'nama' => 'Kelompok C (Peminatan MIPA)', 'urutan' => 3, 'jumlah_mapel' => 4],
            ['id' => 4, 'nama' => 'Kelompok C (Peminatan IPS)', 'urutan' => 4, 'jumlah_mapel' => 4],
            ['id' => 5, 'nama' => 'Muatan Lokal', 'urutan' => 5, 'jumlah_mapel' => 2],
        ];
    }

    public static function getMapel()
    {
        return [
            ['id' => 1, 'nama_mapel' => 'Pendidikan Agama Islam dan Budi Pekerti', 'kode_mapel' => 'PAI', 'kelompok_mapel_id' => 1, 'kelompok_nama' => 'Kelompok A (Umum / Wajib)', 'jurusan_id' => null, 'jurusan_kode' => 'Umum'],
            ['id' => 2, 'nama_mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'kode_mapel' => 'PPKN', 'kelompok_mapel_id' => 1, 'kelompok_nama' => 'Kelompok A (Umum / Wajib)', 'jurusan_id' => null, 'jurusan_kode' => 'Umum'],
            ['id' => 3, 'nama_mapel' => 'Bahasa Indonesia', 'kode_mapel' => 'BIND', 'kelompok_mapel_id' => 1, 'kelompok_nama' => 'Kelompok A (Umum / Wajib)', 'jurusan_id' => null, 'jurusan_kode' => 'Umum'],
            ['id' => 4, 'nama_mapel' => 'Matematika (Wajib)', 'kode_mapel' => 'MAT-W', 'kelompok_mapel_id' => 1, 'kelompok_nama' => 'Kelompok A (Umum / Wajib)', 'jurusan_id' => null, 'jurusan_kode' => 'Umum'],
            ['id' => 5, 'nama_mapel' => 'Sejarah Indonesia', 'kode_mapel' => 'SEJ-IND', 'kelompok_mapel_id' => 1, 'kelompok_nama' => 'Kelompok A (Umum / Wajib)', 'jurusan_id' => null, 'jurusan_kode' => 'Umum'],
            ['id' => 6, 'nama_mapel' => 'Bahasa Inggris', 'kode_mapel' => 'BING', 'kelompok_mapel_id' => 1, 'kelompok_nama' => 'Kelompok A (Umum / Wajib)', 'jurusan_id' => null, 'jurusan_kode' => 'Umum'],
            ['id' => 7, 'nama_mapel' => 'Seni Budaya', 'kode_mapel' => 'SBD', 'kelompok_mapel_id' => 2, 'kelompok_nama' => 'Kelompok B (Umum / Wajib)', 'jurusan_id' => null, 'jurusan_kode' => 'Umum'],
            ['id' => 8, 'nama_mapel' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan', 'kode_mapel' => 'PJOK', 'kelompok_mapel_id' => 2, 'kelompok_nama' => 'Kelompok B (Umum / Wajib)', 'jurusan_id' => null, 'jurusan_kode' => 'Umum'],
            ['id' => 9, 'nama_mapel' => 'Prakarya dan Kewirausahaan', 'kode_mapel' => 'PKWU', 'kelompok_mapel_id' => 2, 'kelompok_nama' => 'Kelompok B (Umum / Wajib)', 'jurusan_id' => null, 'jurusan_kode' => 'Umum'],
            ['id' => 10, 'nama_mapel' => 'Matematika Peminatan', 'kode_mapel' => 'MAT-P', 'kelompok_mapel_id' => 3, 'kelompok_nama' => 'Kelompok C (Peminatan MIPA)', 'jurusan_id' => 1, 'jurusan_kode' => 'MIPA'],
            ['id' => 11, 'nama_mapel' => 'Biologi', 'kode_mapel' => 'BIO', 'kelompok_mapel_id' => 3, 'kelompok_nama' => 'Kelompok C (Peminatan MIPA)', 'jurusan_id' => 1, 'jurusan_kode' => 'MIPA'],
            ['id' => 12, 'nama_mapel' => 'Fisika', 'kode_mapel' => 'FIS', 'kelompok_mapel_id' => 3, 'kelompok_nama' => 'Kelompok C (Peminatan MIPA)', 'jurusan_id' => 1, 'jurusan_kode' => 'MIPA'],
            ['id' => 13, 'nama_mapel' => 'Kimia', 'kode_mapel' => 'KIM', 'kelompok_mapel_id' => 3, 'kelompok_nama' => 'Kelompok C (Peminatan MIPA)', 'jurusan_id' => 1, 'jurusan_kode' => 'MIPA'],
            ['id' => 14, 'nama_mapel' => 'Geografi', 'kode_mapel' => 'GEO', 'kelompok_mapel_id' => 4, 'kelompok_nama' => 'Kelompok C (Peminatan IPS)', 'jurusan_id' => 2, 'jurusan_kode' => 'IPS'],
            ['id' => 15, 'nama_mapel' => 'Sosiologi', 'kode_mapel' => 'SOS', 'kelompok_mapel_id' => 4, 'kelompok_nama' => 'Kelompok C (Peminatan IPS)', 'jurusan_id' => 2, 'jurusan_kode' => 'IPS'],
            ['id' => 16, 'nama_mapel' => 'Ekonomi', 'kode_mapel' => 'EKO', 'kelompok_mapel_id' => 4, 'kelompok_nama' => 'Kelompok C (Peminatan IPS)', 'jurusan_id' => 2, 'jurusan_kode' => 'IPS'],
            ['id' => 17, 'nama_mapel' => 'Bahasa Sunda', 'kode_mapel' => 'BSUN', 'kelompok_mapel_id' => 5, 'kelompok_nama' => 'Muatan Lokal', 'jurusan_id' => null, 'jurusan_kode' => 'Umum'],
            ['id' => 18, 'nama_mapel' => 'Bahasa Arab / Tahfidz', 'kode_mapel' => 'BARB', 'kelompok_mapel_id' => 5, 'kelompok_nama' => 'Muatan Lokal', 'jurusan_id' => null, 'jurusan_kode' => 'Umum'],
        ];
    }

    public static function getKomponenNilai()
    {
        return [
            'pengetahuan' => [
                ['id' => 1, 'aspek' => 'pengetahuan', 'nama' => 'Ulangan Harian (UH)', 'bobot_persen' => 20, 'urutan' => 1],
                ['id' => 2, 'aspek' => 'pengetahuan', 'nama' => 'Tugas & Kuis', 'bobot_persen' => 20, 'urutan' => 2],
                ['id' => 3, 'aspek' => 'pengetahuan', 'nama' => 'Ujian Tengah Semester (UTS)', 'bobot_persen' => 25, 'urutan' => 3],
                ['id' => 4, 'aspek' => 'pengetahuan', 'nama' => 'Ujian Akhir Semester (UAS)', 'bobot_persen' => 35, 'urutan' => 4],
            ],
            'keterampilan' => [
                ['id' => 5, 'aspek' => 'keterampilan', 'nama' => 'Praktik / Unjuk Kerja', 'bobot_persen' => 40, 'urutan' => 1],
                ['id' => 6, 'aspek' => 'keterampilan', 'nama' => 'Proyek', 'bobot_persen' => 30, 'urutan' => 2],
                ['id' => 7, 'aspek' => 'keterampilan', 'nama' => 'Portofolio', 'bobot_persen' => 30, 'urutan' => 3],
            ]
        ];
    }

    public static function getKriteriaPenilaian()
    {
        return [
            [
                'kkm' => 75.00,
                'keterangan' => 'Standar Umum & Mapel Peminatan MIPA/IPS',
                'intervals' => [
                    ['nilai_min' => 91, 'nilai_max' => 100, 'predikat' => 'A', 'badge_class' => 'bg-success', 'deskripsi' => 'Sangat Baik'],
                    ['nilai_min' => 83, 'nilai_max' => 90, 'predikat' => 'B', 'badge_class' => 'bg-primary', 'deskripsi' => 'Baik'],
                    ['nilai_min' => 75, 'nilai_max' => 82, 'predikat' => 'C', 'badge_class' => 'bg-warning text-dark', 'deskripsi' => 'Cukup'],
                    ['nilai_min' => 0, 'nilai_max' => 74, 'predikat' => 'D', 'badge_class' => 'bg-danger', 'deskripsi' => 'Perlu Bimbingan']
                ]
            ],
            [
                'kkm' => 70.00,
                'keterangan' => 'Muatan Lokal & Keterampilan Khusus',
                'intervals' => [
                    ['nilai_min' => 90, 'nilai_max' => 100, 'predikat' => 'A', 'badge_class' => 'bg-success', 'deskripsi' => 'Sangat Baik'],
                    ['nilai_min' => 80, 'nilai_max' => 89, 'predikat' => 'B', 'badge_class' => 'bg-primary', 'deskripsi' => 'Baik'],
                    ['nilai_min' => 70, 'nilai_max' => 79, 'predikat' => 'C', 'badge_class' => 'bg-warning text-dark', 'deskripsi' => 'Cukup'],
                    ['nilai_min' => 0, 'nilai_max' => 69, 'predikat' => 'D', 'badge_class' => 'bg-danger', 'deskripsi' => 'Perlu Bimbingan']
                ]
            ]
        ];
    }

    public static function getJenisSikap()
    {
        return [
            ['id' => 1, 'nama' => 'Sikap Spiritual (Ketaatan Beribadah & Berdoa)', 'urutan' => 1],
            ['id' => 2, 'nama' => 'Sikap Sosial (Kejujuran & Disiplin)', 'urutan' => 2],
            ['id' => 3, 'nama' => 'Tanggung Jawab & Gotong Royong', 'urutan' => 3],
            ['id' => 4, 'nama' => 'Santun & Percaya Diri', 'urutan' => 4],
        ];
    }

    public static function getJenisEkstrakurikuler()
    {
        return [
            ['id' => 1, 'nama' => 'Pramuka (Wajib Gugus Depan)'],
            ['id' => 2, 'nama' => 'Palang Merah Remaja (PMR)'],
            ['id' => 3, 'nama' => 'Pasukan Pengibar Bendera (Paskibra)'],
            ['id' => 4, 'nama' => 'Klub Sains & Robotika'],
            ['id' => 5, 'nama' => 'Futsal & Basket'],
            ['id' => 6, 'nama' => 'Tahfidz Al-Qur\'an'],
        ];
    }

    public static function getJenisPrestasi()
    {
        return [
            ['id' => 1, 'nama' => 'Prestasi Akademik (OSN, Lomba Cerdas Cermat, Karya Ilmiah)'],
            ['id' => 2, 'nama' => 'Prestasi Non-Akademik (Olahraga, Seni, Tahfidz, Debat)'],
        ];
    }

    public static function getGuru()
    {
        return [
            ['id' => 1, 'user_id' => 2, 'nip' => '198503152010011008', 'nama' => 'Ustadz Hendra Gunawan, M.Pd.', 'no_hp' => '081223344551', 'alamat' => 'Jl. Cisitu Lama No. 12, Bandung', 'email' => 'hendra.g@fithrahinsani.sch.id', 'username' => 'guru.hendra', 'is_active' => true, 'is_wali' => true, 'kelas_wali' => 'XI-MIPA-1', 'mapel_utama' => 'Matematika (Wajib)'],
            ['id' => 2, 'user_id' => 3, 'nip' => '198807202012022004', 'nama' => 'Ustadzah Siti Nurhaliza, S.Pd.', 'no_hp' => '081398765432', 'alamat' => 'Komp. Permata Padalarang Blok C-4', 'email' => 'siti.nur@fithrahinsani.sch.id', 'username' => 'guru.siti', 'is_active' => true, 'is_wali' => true, 'kelas_wali' => 'X-MIPA-1', 'mapel_utama' => 'Biologi'],
            ['id' => 3, 'user_id' => 4, 'nip' => '197911042005011003', 'nama' => 'Ustadz Budi Rahardjo, S.Si.', 'no_hp' => '081567891234', 'alamat' => 'Jl. Cihanjuang No. 88, Cimahi', 'email' => 'budi.r@fithrahinsani.sch.id', 'username' => 'guru.budi', 'is_active' => true, 'is_wali' => false, 'kelas_wali' => null, 'mapel_utama' => 'Fisika'],
            ['id' => 4, 'user_id' => 5, 'nip' => '199204122019032011', 'nama' => 'Ustadzah Rina Maryani, S.Pd.', 'no_hp' => '085721123456', 'alamat' => 'Jl. Kolonel Masturi No. 45, Cimahi', 'email' => 'rina.m@fithrahinsani.sch.id', 'username' => 'guru.rina', 'is_active' => true, 'is_wali' => true, 'kelas_wali' => 'XII-MIPA-1', 'mapel_utama' => 'Kimia'],
            ['id' => 5, 'user_id' => 6, 'nip' => '198302182009011007', 'nama' => 'Ustadz Abdul Karim, Lc., M.Ag.', 'no_hp' => '081290887766', 'alamat' => 'Jl. Terusan Pasirkoja No. 101, Bandung', 'email' => 'abdul.karim@fithrahinsani.sch.id', 'username' => 'guru.karim', 'is_active' => true, 'is_wali' => false, 'kelas_wali' => null, 'mapel_utama' => 'Pendidikan Agama Islam'],
            ['id' => 6, 'user_id' => 7, 'nip' => '199009092015022003', 'nama' => 'Ustadzah Dewi Kartika, M.Pd.', 'no_hp' => '081344556677', 'alamat' => 'Jl. Geger Kalong Hilir No. 23, Bandung', 'email' => 'dewi.k@fithrahinsani.sch.id', 'username' => 'guru.dewi', 'is_active' => true, 'is_wali' => false, 'kelas_wali' => null, 'mapel_utama' => 'Bahasa Inggris'],
        ];
    }

    public static function getStaffTu()
    {
        return [
            ['id' => 1, 'user_id' => 8, 'nip' => '198105052006041002', 'nama' => 'M. Taufik Hidayat, S.Sos.', 'jabatan' => 'Kepala Tata Usaha', 'no_hp' => '081234509876', 'alamat' => 'Jl. Raya Gadobangkong No. 50', 'username' => 'tu.taufik', 'email' => 'taufik.tu@fithrahinsani.sch.id', 'is_active' => true],
            ['id' => 2, 'user_id' => 9, 'nip' => '199408222020012015', 'nama' => 'Nabila Putri Pratama, A.Md.', 'jabatan' => 'Staf Administrasi & Persuratan', 'no_hp' => '085811223344', 'alamat' => 'Komp. Tani Mulya Blok G-12, Ngamprah', 'username' => 'tu.nabila', 'email' => 'nabila.tu@fithrahinsani.sch.id', 'is_active' => true],
            ['id' => 3, 'user_id' => 10, 'nip' => '199602102022031005', 'nama' => 'Farhan Ramadhan, S.Kom.', 'jabatan' => 'Operator Data & SIMS', 'no_hp' => '087822334455', 'alamat' => 'Jl. Sangkuriang No. 15, Cimahi', 'username' => 'tu.farhan', 'email' => 'farhan.tu@fithrahinsani.sch.id', 'is_active' => true],
        ];
    }

    public static function getKelas()
    {
        return [
            ['id' => 1, 'nama_kelas' => 'X-MIPA-1', 'tingkatan_id' => 1, 'tingkatan_nama' => 'Kelas 10', 'jurusan_id' => 1, 'jurusan_kode' => 'MIPA', 'tahun_ajaran_id' => 2, 'wali_kelas_id' => 2, 'wali_kelas_nama' => 'Ustadzah Siti Nurhaliza, S.Pd.', 'kapasitas_max' => 32, 'jumlah_siswa' => 30],
            ['id' => 2, 'nama_kelas' => 'X-MIPA-2', 'tingkatan_id' => 1, 'tingkatan_nama' => 'Kelas 10', 'jurusan_id' => 1, 'jurusan_kode' => 'MIPA', 'tahun_ajaran_id' => 2, 'wali_kelas_id' => null, 'wali_kelas_nama' => 'Belum Ditentukan', 'kapasitas_max' => 32, 'jumlah_siswa' => 28],
            ['id' => 3, 'nama_kelas' => 'X-IPS-1', 'tingkatan_id' => 1, 'tingkatan_nama' => 'Kelas 10', 'jurusan_id' => 2, 'jurusan_kode' => 'IPS', 'tahun_ajaran_id' => 2, 'wali_kelas_id' => null, 'wali_kelas_nama' => 'Belum Ditentukan', 'kapasitas_max' => 32, 'jumlah_siswa' => 29],
            ['id' => 4, 'nama_kelas' => 'XI-MIPA-1', 'tingkatan_id' => 2, 'tingkatan_nama' => 'Kelas 11', 'jurusan_id' => 1, 'jurusan_kode' => 'MIPA', 'tahun_ajaran_id' => 2, 'wali_kelas_id' => 1, 'wali_kelas_nama' => 'Ustadz Hendra Gunawan, M.Pd.', 'kapasitas_max' => 32, 'jumlah_siswa' => 31],
            ['id' => 5, 'nama_kelas' => 'XI-IPS-1', 'tingkatan_id' => 2, 'tingkatan_nama' => 'Kelas 11', 'jurusan_id' => 2, 'jurusan_kode' => 'IPS', 'tahun_ajaran_id' => 2, 'wali_kelas_id' => null, 'wali_kelas_nama' => 'Belum Ditentukan', 'kapasitas_max' => 32, 'jumlah_siswa' => 30],
            ['id' => 6, 'nama_kelas' => 'XII-MIPA-1', 'tingkatan_id' => 3, 'tingkatan_nama' => 'Kelas 12', 'jurusan_id' => 1, 'jurusan_kode' => 'MIPA', 'tahun_ajaran_id' => 2, 'wali_kelas_id' => 4, 'wali_kelas_nama' => 'Ustadzah Rina Maryani, S.Pd.', 'kapasitas_max' => 32, 'jumlah_siswa' => 32],
            ['id' => 7, 'nama_kelas' => 'XII-IPS-1', 'tingkatan_id' => 3, 'tingkatan_nama' => 'Kelas 12', 'jurusan_id' => 2, 'jurusan_kode' => 'IPS', 'tahun_ajaran_id' => 2, 'wali_kelas_id' => null, 'wali_kelas_nama' => 'Belum Ditentukan', 'kapasitas_max' => 32, 'jumlah_siswa' => 27],
        ];
    }

    public static function getPengajaran()
    {
        return [
            ['id' => 1, 'guru_id' => 1, 'guru_nama' => 'Ustadz Hendra Gunawan, M.Pd.', 'mapel_id' => 4, 'mapel_nama' => 'Matematika (Wajib)', 'kelas_id' => 4, 'kelas_nama' => 'XI-MIPA-1', 'semester_id' => 3, 'semester_nama' => 'Ganjil', 'kkm' => 75.00, 'kkm_snapshot' => 75.00, 'bobot_snapshot' => ['uh' => 20, 'tugas' => 20, 'uts' => 25, 'uas' => 35], 'kurikulum_kode' => 'K13_REVISI', 'jumlah_siswa' => 31],
            ['id' => 2, 'guru_id' => 1, 'guru_nama' => 'Ustadz Hendra Gunawan, M.Pd.', 'mapel_id' => 10, 'mapel_nama' => 'Matematika Peminatan', 'kelas_id' => 4, 'kelas_nama' => 'XI-MIPA-1', 'semester_id' => 3, 'semester_nama' => 'Ganjil', 'kkm' => 75.00, 'kkm_snapshot' => 75.00, 'bobot_snapshot' => ['uh' => 20, 'tugas' => 20, 'uts' => 25, 'uas' => 35], 'kurikulum_kode' => 'K13_REVISI', 'jumlah_siswa' => 31],
            ['id' => 3, 'guru_id' => 1, 'guru_nama' => 'Ustadz Hendra Gunawan, M.Pd.', 'mapel_id' => 4, 'mapel_nama' => 'Matematika (Wajib)', 'kelas_id' => 1, 'kelas_nama' => 'X-MIPA-1', 'semester_id' => 3, 'semester_nama' => 'Ganjil', 'kkm' => 75.00, 'kkm_snapshot' => 75.00, 'bobot_snapshot' => ['uh' => 20, 'tugas' => 20, 'uts' => 25, 'uas' => 35], 'kurikulum_kode' => 'K13_REVISI', 'jumlah_siswa' => 30],
            ['id' => 4, 'guru_id' => 2, 'guru_nama' => 'Ustadzah Siti Nurhaliza, S.Pd.', 'mapel_id' => 11, 'mapel_nama' => 'Biologi', 'kelas_id' => 1, 'kelas_nama' => 'X-MIPA-1', 'semester_id' => 3, 'semester_nama' => 'Ganjil', 'kkm' => 75.00, 'kkm_snapshot' => 75.00, 'bobot_snapshot' => ['uh' => 20, 'tugas' => 20, 'uts' => 25, 'uas' => 35], 'kurikulum_kode' => 'K13_REVISI', 'jumlah_siswa' => 30],
            ['id' => 5, 'guru_id' => 3, 'guru_nama' => 'Ustadz Budi Rahardjo, S.Si.', 'mapel_id' => 12, 'mapel_nama' => 'Fisika', 'kelas_id' => 4, 'kelas_nama' => 'XI-MIPA-1', 'semester_id' => 3, 'semester_nama' => 'Ganjil', 'kkm' => 75.00, 'kkm_snapshot' => 75.00, 'bobot_snapshot' => ['uh' => 20, 'tugas' => 20, 'uts' => 25, 'uas' => 35], 'kurikulum_kode' => 'K13_REVISI', 'jumlah_siswa' => 31],
            ['id' => 6, 'guru_id' => 4, 'guru_nama' => 'Ustadzah Rina Maryani, S.Pd.', 'mapel_id' => 13, 'mapel_nama' => 'Kimia', 'kelas_id' => 6, 'kelas_nama' => 'XII-MIPA-1', 'semester_id' => 3, 'semester_nama' => 'Ganjil', 'kkm' => 75.00, 'kkm_snapshot' => 75.00, 'bobot_snapshot' => ['uh' => 20, 'tugas' => 20, 'uts' => 25, 'uas' => 35], 'kurikulum_kode' => 'K13_REVISI', 'jumlah_siswa' => 32],
            ['id' => 7, 'guru_id' => 5, 'guru_nama' => 'Ustadz Abdul Karim, Lc., M.Ag.', 'mapel_id' => 1, 'mapel_nama' => 'Pendidikan Agama Islam', 'kelas_id' => 4, 'kelas_nama' => 'XI-MIPA-1', 'semester_id' => 3, 'semester_nama' => 'Ganjil', 'kkm' => 75.00, 'kkm_snapshot' => 75.00, 'bobot_snapshot' => ['uh' => 20, 'tugas' => 20, 'uts' => 25, 'uas' => 35], 'kurikulum_kode' => 'K13_REVISI', 'jumlah_siswa' => 31],
        ];
    }

    public static function getSiswaList()
    {
        return [
            [
                'id' => 1,
                'user_id' => 11,
                'nis' => '242510001',
                'nisn' => '0071234567',
                'nama' => 'Muhammad Raihan Pratama',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2008-05-14',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'alamat' => 'Jl. Pesantren No. 45, RT 02/05, Cibabat, Cimahi Utara',
                'status_dalam_keluarga' => 'Anak Kandung',
                'anak_ke' => 1,
                'sekolah_asal' => 'SMP IT Fithrah Insani Bandung Barat',
                'tanggal_diterima' => '2024-07-15',
                'kelas_diterima_id' => 1,
                'kelas_diterima_nama' => 'X-MIPA-1',
                'kelas_id' => 4,
                'kelas_nama' => 'XI-MIPA-1',
                'status' => 'aktif',
                'foto_path' => 'https://ui-avatars.com/api/?name=Muhammad+Raihan&background=1E3A5F&color=fff',
                'username' => 'siswa.raihan',
                'ortu' => [
                    ['jenis' => 'ayah', 'nama' => 'Ir. Bambang Pratama, M.T.', 'alamat' => 'Jl. Pesantren No. 45, Cimahi', 'telepon' => '081220011223', 'pekerjaan' => 'Karyawan Swasta (BUMN)'],
                    ['jenis' => 'ibu', 'nama' => 'Hj. Dewi Sartika, S.E.', 'alamat' => 'Jl. Pesantren No. 45, Cimahi', 'telepon' => '081320099887', 'pekerjaan' => 'Ibu Rumah Tangga'],
                ]
            ],
            [
                'id' => 2,
                'user_id' => 12,
                'nis' => '242510002',
                'nisn' => '0072345678',
                'nama' => 'Aisyah Azzahra Putri',
                'tempat_lahir' => 'Cimahi',
                'tanggal_lahir' => '2008-09-22',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'alamat' => 'Komp. Pondok Cileunyi Indah Blok B-14',
                'status_dalam_keluarga' => 'Anak Kandung',
                'anak_ke' => 2,
                'sekolah_asal' => 'SMP Negeri 1 Cimahi',
                'tanggal_diterima' => '2024-07-15',
                'kelas_diterima_id' => 1,
                'kelas_diterima_nama' => 'X-MIPA-1',
                'kelas_id' => 4,
                'kelas_nama' => 'XI-MIPA-1',
                'status' => 'aktif',
                'foto_path' => 'https://ui-avatars.com/api/?name=Aisyah+Azzahra&background=2CA58D&color=fff',
                'username' => 'siswa.aisyah',
                'ortu' => [
                    ['jenis' => 'ayah', 'nama' => 'H. Gunawan Santoso', 'alamat' => 'Komp. Pondok Cileunyi Indah Blok B-14', 'telepon' => '081122334455', 'pekerjaan' => 'Wiraswasta'],
                    ['jenis' => 'ibu', 'nama' => 'Siti Aminah, S.Pd.', 'alamat' => 'Komp. Pondok Cileunyi Indah Blok B-14', 'telepon' => '081122334466', 'pekerjaan' => 'Guru'],
                ]
            ],
            [
                'id' => 3,
                'user_id' => 13,
                'nis' => '242510003',
                'nisn' => '0073456789',
                'nama' => 'Fadhil Ahmad Al-Ghifari',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2008-01-10',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'alamat' => 'Jl. Cibaligo No. 78, Cimindi',
                'status_dalam_keluarga' => 'Anak Kandung',
                'anak_ke' => 1,
                'sekolah_asal' => 'SMP IT Nurul Fikri',
                'tanggal_diterima' => '2024-07-15',
                'kelas_diterima_id' => 1,
                'kelas_diterima_nama' => 'X-MIPA-1',
                'kelas_id' => 4,
                'kelas_nama' => 'XI-MIPA-1',
                'status' => 'aktif',
                'foto_path' => 'https://ui-avatars.com/api/?name=Fadhil+Ahmad&background=E57373&color=fff',
                'username' => 'siswa.fadhil',
                'ortu' => [
                    ['jenis' => 'ayah', 'nama' => 'Rahmat Hidayat', 'alamat' => 'Jl. Cibaligo No. 78, Cimindi', 'telepon' => '081299887766', 'pekerjaan' => 'PNS'],
                ]
            ],
            [
                'id' => 4,
                'user_id' => 14,
                'nis' => '242510004',
                'nisn' => '0074567890',
                'nama' => 'Zahra Nurul Izzati',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2008-11-05',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'alamat' => 'Jl. Kolonel Masturi KM 3, Parongpong',
                'status_dalam_keluarga' => 'Anak Kandung',
                'anak_ke' => 3,
                'sekolah_asal' => 'SMP Al-Azhar Bandung',
                'tanggal_diterima' => '2024-07-15',
                'kelas_diterima_id' => 1,
                'kelas_diterima_nama' => 'X-MIPA-1',
                'kelas_id' => 4,
                'kelas_nama' => 'XI-MIPA-1',
                'status' => 'aktif',
                'foto_path' => 'https://ui-avatars.com/api/?name=Zahra+Nurul&background=4A148C&color=fff',
                'username' => 'siswa.zahra',
                'ortu' => [
                    ['jenis' => 'ayah', 'nama' => 'Prof. Dr. Irwan Setiawan', 'alamat' => 'Parongpong', 'telepon' => '081233445566', 'pekerjaan' => 'Dosen'],
                    ['jenis' => 'ibu', 'nama' => 'Dr. Ratna Juwita, Sp.A', 'alamat' => 'Parongpong', 'telepon' => '081233445577', 'pekerjaan' => 'Dokter Spesialis Anak'],
                ]
            ],
            [
                'id' => 5,
                'user_id' => 15,
                'nis' => '232410088',
                'nisn' => '0061239876',
                'nama' => 'Faris Maulana Yusuf',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2007-03-18',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'alamat' => 'Jl. Somawinata No. 20, Ngamprah',
                'status_dalam_keluarga' => 'Anak Kandung',
                'anak_ke' => 1,
                'sekolah_asal' => 'SMP IT Fithrah Insani',
                'tanggal_diterima' => '2023-07-17',
                'kelas_diterima_id' => 1,
                'kelas_diterima_nama' => 'X-MIPA-1',
                'kelas_id' => 6,
                'kelas_nama' => 'XII-MIPA-1',
                'status' => 'aktif',
                'foto_path' => 'https://ui-avatars.com/api/?name=Faris+Maulana&background=1E3A5F&color=fff',
                'username' => 'siswa.faris',
                'ortu' => [
                    ['jenis' => 'ayah', 'nama' => 'Yusuf Mansur, S.E.', 'alamat' => 'Ngamprah', 'telepon' => '081399881122', 'pekerjaan' => 'Akuntan'],
                ]
            ],
            [
                'id' => 6,
                'user_id' => 16,
                'nis' => '222310015',
                'nisn' => '0059876543',
                'nama' => 'Dina Amelia Rahmah',
                'tempat_lahir' => 'Bandung Barat',
                'tanggal_lahir' => '2006-08-30',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'alamat' => 'Jl. Haji Gofur No. 89, Gadobangkong',
                'status_dalam_keluarga' => 'Anak Kandung',
                'anak_ke' => 2,
                'sekolah_asal' => 'SMP Negeri 2 Padalarang',
                'tanggal_diterima' => '2022-07-18',
                'kelas_diterima_id' => 1,
                'kelas_diterima_nama' => 'X-MIPA-1',
                'kelas_id' => null,
                'kelas_nama' => 'Alumni (Tahun 2025)',
                'status' => 'lulus',
                'foto_path' => 'https://ui-avatars.com/api/?name=Dina+Amelia&background=2CA58D&color=fff',
                'username' => 'alumni.dina',
                'ortu' => [
                    ['jenis' => 'ayah', 'nama' => 'H. Endang Rahmah', 'alamat' => 'Gadobangkong', 'telepon' => '08122339944', 'pekerjaan' => 'Pensiunan'],
                ]
            ],
        ];
    }

    public static function getRaportSiswa($siswa_id = 1)
    {
        return [
            'id' => 1,
            'siswa_id' => 1,
            'siswa' => [
                'nama' => 'Muhammad Raihan Pratama',
                'nis' => '242510001',
                'nisn' => '0071234567',
                'kelas' => 'XI-MIPA-1',
                'semester' => 'Ganjil',
                'tahun_ajaran' => '2025/2026',
                'wali_kelas' => 'Ustadz Hendra Gunawan, M.Pd.',
                'kepala_sekolah' => 'Drs. H. Ahmad Fauzi, M.Pd.',
                'tanggal_raport' => '19 Desember 2025'
            ],
            'status' => 'draft', // status alur: draft -> menunggu_persetujuan_kepsek -> final
            'generated_at' => '2025-12-15 14:30:00',
            'finalized_at' => null,
            'approval_kepsek' => [
                'status' => 'menunggu_pengesahan', // menunggu_pengesahan, disahkan, ditolak
                'pejabat' => 'Drs. H. Ahmad Fauzi, M.Pd.',
                'nip' => '196805121994031004',
                'disahkan_pada' => null,
                'catatan_kepsek' => 'Raport siap disahkan setelah wali kelas mengunci draf final.'
            ],
            'riwayat_kelas_id' => 3,
            'sikap' => [
                [
                    'id' => 1,
                    'jenis_sikap' => 'Sikap Spiritual',
                    'predikat' => 'Sangat Baik',
                    'deskripsi' => 'Selalu taat menjalankan ibadah sholat berjamaah tepat waktu, aktif membaca Al-Qur\'an dan berdoa sebelum beraktivitas.',
                    'is_edited_manual' => false
                ],
                [
                    'id' => 2,
                    'jenis_sikap' => 'Sikap Sosial',
                    'predikat' => 'Baik',
                    'deskripsi' => 'Menunjukkan sikap disiplin, jujur dalam ujian, santun terhadap guru dan memiliki kepedulian tinggi terhadap teman sekelas.',
                    'is_edited_manual' => true
                ],
            ],
            'nilai_kelompok' => [
                'Kelompok A (Umum / Wajib)' => [
                    ['mapel' => 'Pendidikan Agama Islam dan Budi Pekerti', 'kkm' => 75, 'pengetahuan_nilai' => 88, 'pengetahuan_predikat' => 'B', 'pengetahuan_deskripsi' => 'Memahami dengan sangat baik konsep fiqih muamalah dan akhlakul karimah.', 'keterampilan_nilai' => 90, 'keterampilan_predikat' => 'B', 'keterampilan_deskripsi' => 'Sangat terampil mempraktikkan tata cara penyelenggaraan jenazah.', 'is_edited_manual' => false],
                    ['mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'kkm' => 75, 'pengetahuan_nilai' => 84, 'pengetahuan_predikat' => 'B', 'pengetahuan_deskripsi' => 'Mampu menganalisis kasus-kasus pelanggaran hak dan pengingkaran kewajiban warga negara.', 'keterampilan_nilai' => 85, 'keterampilan_predikat' => 'B', 'keterampilan_deskripsi' => 'Terampil menyajikan hasil analisis dinamika demokrasi di Indonesia.', 'is_edited_manual' => false],
                    ['mapel' => 'Bahasa Indonesia', 'kkm' => 75, 'pengetahuan_nilai' => 86, 'pengetahuan_predikat' => 'B', 'pengetahuan_deskripsi' => 'Memahami struktur teks eksplanasi dan teks prosedur kompleks secara rinci.', 'keterampilan_nilai' => 88, 'keterampilan_predikat' => 'B', 'keterampilan_deskripsi' => 'Mahir menyusun teks ceramah dengan pilihan diksi yang santun.', 'is_edited_manual' => false],
                    ['mapel' => 'Matematika (Wajib)', 'kkm' => 75, 'pengetahuan_nilai' => 92, 'pengetahuan_predikat' => 'A', 'pengetahuan_deskripsi' => 'Sangat menguasai konsep induksi matematika, program linear, dan matriks.', 'keterampilan_nilai' => 94, 'keterampilan_predikat' => 'A', 'keterampilan_deskripsi' => 'Sangat terampil menyelesaikan masalah kontekstual menggunakan metode simpleks.', 'is_edited_manual' => true],
                    ['mapel' => 'Sejarah Indonesia', 'kkm' => 75, 'pengetahuan_nilai' => 82, 'pengetahuan_predikat' => 'C', 'pengetahuan_deskripsi' => 'Cukup memahami perkembangan kolonialisme bangsa barat di nusantara.', 'keterampilan_nilai' => 83, 'keterampilan_predikat' => 'B', 'keterampilan_deskripsi' => 'Mampu membuat peta konsep rute pelayaran rempah-rempah.', 'is_edited_manual' => false],
                    ['mapel' => 'Bahasa Inggris', 'kkm' => 75, 'pengetahuan_nilai' => 89, 'pengetahuan_predikat' => 'B', 'pengetahuan_deskripsi' => 'Menguasai fungsi sosial dan unsur kebahasaan surat pribadi dan teks eksposisi.', 'keterampilan_nilai' => 91, 'keterampilan_predikat' => 'A', 'keterampilan_deskripsi' => 'Sangat lancar mempresentasikan argumen formal dalam Bahasa Inggris.', 'is_edited_manual' => false],
                ],
                'Kelompok B (Umum / Wajib)' => [
                    ['mapel' => 'Seni Budaya', 'kkm' => 75, 'pengetahuan_nilai' => 85, 'pengetahuan_predikat' => 'B', 'pengetahuan_deskripsi' => 'Memahami konsep dasar apresiasi karya seni rupa dua dan tiga dimensi.', 'keterampilan_nilai' => 87, 'keterampilan_predikat' => 'B', 'keterampilan_deskripsi' => 'Terampil membuat karya lukis teknik campuran bertema lingkungan.', 'is_edited_manual' => false],
                    ['mapel' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan', 'kkm' => 75, 'pengetahuan_nilai' => 86, 'pengetahuan_predikat' => 'B', 'pengetahuan_deskripsi' => 'Memahami strategi penyerangan dan pertahanan pada permainan bola basket.', 'keterampilan_nilai' => 88, 'keterampilan_predikat' => 'B', 'keterampilan_deskripsi' => 'Terampil melakukan teknik lay up dan chest pass dengan koordinasi baik.', 'is_edited_manual' => false],
                    ['mapel' => 'Prakarya dan Kewirausahaan', 'kkm' => 75, 'pengetahuan_nilai' => 90, 'pengetahuan_predikat' => 'B', 'pengetahuan_deskripsi' => 'Memahami perencanaan usaha pengolahan makanan khas daerah.', 'keterampilan_nilai' => 92, 'keterampilan_predikat' => 'A', 'keterampilan_deskripsi' => 'Mampu memproduksi dan mengemas produk olahan pangan lokal berstandar UMKM.', 'is_edited_manual' => false],
                ],
                'Kelompok C (Peminatan MIPA)' => [
                    ['mapel' => 'Matematika Peminatan', 'kkm' => 75, 'pengetahuan_nilai' => 93, 'pengetahuan_predikat' => 'A', 'pengetahuan_deskripsi' => 'Sangat menguasai rumus trigonometri jumlah dan selisih sudut serta lingkaran.', 'keterampilan_nilai' => 95, 'keterampilan_predikat' => 'A', 'keterampilan_deskripsi' => 'Sangat mahir membuktikan identitas trigonometri tingkat lanjut.', 'is_edited_manual' => false],
                    ['mapel' => 'Biologi', 'kkm' => 75, 'pengetahuan_nilai' => 88, 'pengetahuan_predikat' => 'B', 'pengetahuan_deskripsi' => 'Memahami struktur sel, jaringan tumbuhan, dan sistem gerak pada manusia.', 'keterampilan_nilai' => 89, 'keterampilan_predikat' => 'B', 'keterampilan_deskripsi' => 'Terampil melakukan uji kandungan zat makanan di laboratorium.', 'is_edited_manual' => false],
                    ['mapel' => 'Fisika', 'kkm' => 75, 'pengetahuan_nilai' => 87, 'pengetahuan_predikat' => 'B', 'pengetahuan_deskripsi' => 'Memahami dinamika rotasi, kesetimbangan benda tegar, dan fluida dinamis.', 'keterampilan_nilai' => 88, 'keterampilan_predikat' => 'B', 'keterampilan_deskripsi' => 'Terampil merangkai alat percobaan hukum Archimedes.', 'is_edited_manual' => false],
                    ['mapel' => 'Kimia', 'kkm' => 75, 'pengetahuan_nilai' => 90, 'pengetahuan_predikat' => 'B', 'pengetahuan_deskripsi' => 'Memahami termokimia, laju reaksi, dan pergeseran kesetimbangan kimia.', 'keterampilan_nilai' => 91, 'keterampilan_predikat' => 'A', 'keterampilan_deskripsi' => 'Mahir melakukan titrasi asam-basa dengan ketelitian tinggi.', 'is_edited_manual' => false],
                ],
                'Muatan Lokal' => [
                    ['mapel' => 'Bahasa Sunda', 'kkm' => 70, 'pengetahuan_nilai' => 85, 'pengetahuan_predikat' => 'B', 'pengetahuan_deskripsi' => 'Paham kana carita pondok jeung paguneman tata krama basa sunda.', 'keterampilan_nilai' => 86, 'keterampilan_predikat' => 'B', 'keterampilan_deskripsi' => 'Mampu ngadongengkeun carita pondok make undak usuk basa nu merenah.', 'is_edited_manual' => false],
                    ['mapel' => 'Bahasa Arab / Tahfidz', 'kkm' => 75, 'pengetahuan_nilai' => 94, 'pengetahuan_predikat' => 'A', 'pengetahuan_deskripsi' => 'Hafal Juz 30 & Juz 29 mutqin serta memahami kaidah nahwu shorof dasar.', 'keterampilan_nilai' => 96, 'keterampilan_predikat' => 'A', 'keterampilan_deskripsi' => 'Sangat fasih melantunkan ayat suci Al-Qur\'an dengan makharijul huruf yang tepat.', 'is_edited_manual' => false],
                ]
            ],
            'ekstrakurikuler' => [
                ['kegiatan' => 'Klub Sains & Robotika', 'predikat' => 'A', 'keterangan' => 'Sangat aktif sebagai ketua tim pemrograman robot line follower.'],
                ['kegiatan' => 'Pramuka (Wajib)', 'predikat' => 'A', 'keterangan' => 'Mengikuti seluruh kegiatan perkemahan sabtu-minggu dengan penuh disiplin.'],
            ],
            'prestasi' => [
                ['jenis' => 'Prestasi Akademik', 'keterangan' => 'Juara 2 Olimpiade Sains Nasional (OSN) Tingkat Kabupaten Bidang Matematika 2025.'],
            ],
            'ketidakhadiran' => (function() use ($siswa_id) {
                if (function_exists('session')) {
                    $sess = session()->get('absensi_perwalian_4');
                    if (isset($sess[$siswa_id])) {
                        return [
                            'sakit' => (int)($sess[$siswa_id]['sakit'] ?? 0),
                            'izin' => (int)($sess[$siswa_id]['izin'] ?? 0),
                            'tanpa_keterangan' => (int)($sess[$siswa_id]['tanpa_keterangan'] ?? 0)
                        ];
                    }
                }
                return [
                    'sakit' => ($siswa_id == 1 ? 1 : ($siswa_id == 3 ? 2 : ($siswa_id == 5 ? 3 : 0))),
                    'izin' => ($siswa_id == 1 ? 1 : ($siswa_id == 5 ? 2 : 1)),
                    'tanpa_keterangan' => ($siswa_id == 5 ? 1 : 0)
                ];
            })(),
            'catatan_wali_kelas' => 'Prestasi ananda Raihan sangat membanggakan di bidang eksakta dan keagamaan. Pertahankan motivasi belajar, terus asah kepemimpinan dan kemampuan berbahasa asing.',
            'tanggapan_orang_tua' => 'Alhamdulillah, terima kasih atas bimbingan Bapak/Ibu guru sekalian. Kami akan terus mendampingi belajar ananda di rumah.',
            'status_kelulusan' => 'belum_ditentukan',
        ];
    }

    public static function getSuratMasuk()
    {
        return [
            [
                'id' => 1,
                'nomor_surat' => '421.3/890/Disdik/2025',
                'nomor_agenda' => 'SM-2025-00142',
                'tanggal_surat' => '2025-11-20',
                'tanggal_diterima' => '2025-11-22',
                'pengirim' => 'Dinas Pendidikan Provinsi Jawa Barat',
                'kategori' => 'Edaran Dinas',
                'perihal' => 'Pemberitahuan Pelaksanaan Asesmen Bakat dan Minat (ABM) SMA Tahun 2025',
                'sifat' => 'penting',
                'status' => 'didisposisikan',
                'file_lampiran' => 'surat_edaran_abm_2025.pdf',
                'dicatat_oleh' => 'M. Taufik Hidayat, S.Sos.',
                'disposisi' => [
                    ['id' => 1, 'ditujukan_kepada' => 'Drs. H. Ahmad Fauzi, M.Pd. (Kepala Sekolah)', 'instruksi' => 'Mohon arahan dan pembentukan panitia pelaksana teknis ABM sekolah.', 'batas_waktu' => '2025-11-28', 'status' => 'sedang_diproses', 'catatan_hasil' => 'Diteruskan ke Wakasek Kurikulum.'],
                    ['id' => 2, 'ditujukan_kepada' => 'Farhan Ramadhan, S.Kom. (Operator SIMS)', 'instruksi' => 'Siapkan sinkronisasi data bio-un dan ruang lab komputer.', 'batas_waktu' => '2025-11-30', 'status' => 'belum_ditindak', 'catatan_hasil' => ''],
                ]
            ],
            [
                'id' => 2,
                'nomor_surat' => '056/B/Kemenag-KBB/XI/2025',
                'nomor_agenda' => 'SM-2025-00143',
                'tanggal_surat' => '2025-11-24',
                'tanggal_diterima' => '2025-11-25',
                'pengirim' => 'Kantor Kementerian Agama Kab. Bandung Barat',
                'kategori' => 'Undangan',
                'perihal' => 'Undangan Musabaqah Hifdzil Qur\'an (MHQ) Antar Pelajar Tingkat Jawa Barat',
                'sifat' => 'biasa',
                'status' => 'selesai',
                'file_lampiran' => 'undangan_mhq_kemenag.pdf',
                'dicatat_oleh' => 'Nabila Putri Pratama, A.Md.',
                'disposisi' => [
                    ['id' => 3, 'ditujukan_kepada' => 'Ustadz Abdul Karim, Lc., M.Ag. (Guru PAI)', 'instruksi' => 'Kirimkan delegasi 2 siswa putra dan 2 siswa putri terbaik.', 'batas_waktu' => '2025-12-01', 'status' => 'selesai', 'catatan_hasil' => 'Delegasi sudah didaftarkan.'],
                ]
            ],
            [
                'id' => 3,
                'nomor_surat' => '012/PMR-KBB/X/2025',
                'nomor_agenda' => 'SM-2025-00144',
                'tanggal_surat' => '2025-10-10',
                'tanggal_diterima' => '2025-10-12',
                'pengirim' => 'Palang Merah Indonesia Cabang Kab. Bandung Barat',
                'kategori' => 'Pemberitahuan',
                'perihal' => 'Jadwal Latihan Gabungan & Donor Darah Sukarela Pelajar',
                'sifat' => 'biasa',
                'status' => 'diarsipkan',
                'file_lampiran' => 'latgab_pmi.pdf',
                'dicatat_oleh' => 'Nabila Putri Pratama, A.Md.',
                'disposisi' => []
            ]
        ];
    }

    public static function getSuratKeluar()
    {
        $list = [
            [
                'id' => 1,
                'nomor_surat' => '102/SMA-FI/TU/XI/2025',
                'nomor_draft' => 'DFT-2025-0010',
                'surat_masuk_id' => null,
                'tanggal_surat' => '2025-11-26',
                'kategori' => 'Undangan',
                'tujuan' => 'Seluruh Orang Tua / Wali Siswa Kelas 10, 11, dan 12',
                'perihal' => 'Undangan Pertemuan Evaluasi Tengah Semester & Pembagian Raport Bayangan',
                'sifat' => 'penting',
                'file_dokumen' => 'undangan_ortu_pts_2025.pdf',
                'ditandatangani_oleh' => 'Drs. H. Ahmad Fauzi, M.Pd.',
                'status' => 'terkirim',
                'dibuat_oleh' => 'M. Taufik Hidayat, S.Sos.',
                'ditangani_oleh' => 'M. Taufik Hidayat, S.Sos.',
                'tanggal_kirim' => '2025-11-27'
            ],
            [
                'id' => 2,
                'nomor_surat' => '103/SMA-FI/TU/XII/2025',
                'nomor_draft' => 'DFT-2025-0011',
                'surat_masuk_id' => 1, // Balasan resmi untuk Surat Masuk SM-2025-00142
                'tanggal_surat' => '2025-12-02',
                'kategori' => 'Permohonan Izin',
                'tujuan' => 'Kepala Dinas Pendidikan Provinsi Jawa Barat',
                'perihal' => 'Laporan Kesiapan Infrastruktur & Panitia Teknis ABM 2025 (Tindak Lanjut SM-2025-00142)',
                'sifat' => 'biasa',
                'file_dokumen' => 'surat_tindaklanjut_abm.pdf',
                'ditandatangani_oleh' => 'Drs. H. Ahmad Fauzi, M.Pd.',
                'status' => 'menunggu_ttd',
                'dibuat_oleh' => 'Nabila Putri Pratama, A.Md.',
                'ditangani_oleh' => 'Nabila Putri Pratama, A.Md.',
                'tanggal_kirim' => null
            ],
            [
                'id' => 3,
                'nomor_surat' => null, // Belum memiliki nomor resmi untuk mencegah nomor bolong
                'nomor_draft' => 'DFT-2025-0012',
                'surat_masuk_id' => null,
                'tanggal_surat' => '2025-12-05',
                'kategori' => 'Edaran Dinas',
                'tujuan' => 'Kepala Dinas Lingkungan Hidup Kab. Bandung Barat',
                'perihal' => 'Draf Laporan Program Sekolah Adiwiyata & Pengelolaan Sampah Mandiri',
                'sifat' => 'biasa',
                'file_dokumen' => 'laporan_adiwiyata.pdf',
                'ditandatangani_oleh' => 'Drs. H. Ahmad Fauzi, M.Pd.',
                'status' => 'draft',
                'dibuat_oleh' => 'Farhan Ramadhan, S.Kom.',
                'ditangani_oleh' => 'Farhan Ramadhan, S.Kom.',
                'tanggal_kirim' => null
            ],
            [
                'id' => 4,
                'nomor_surat' => '101/SMA-FI/TU/XI/2025',
                'nomor_draft' => 'DFT-2025-0009',
                'surat_masuk_id' => null,
                'tanggal_surat' => '2025-11-15',
                'kategori' => 'Rekomendasi / Izin',
                'tujuan' => 'Dewan Pembina Yayasan Fithrah Insani',
                'perihal' => 'Laporan Hasil Penilaian Kinerja Guru & Evaluasi Internal Terbatas',
                'sifat' => 'rahasia',
                'file_dokumen' => 'laporan_kinerja_rahasia.pdf',
                'ditandatangani_oleh' => 'Drs. H. Ahmad Fauzi, M.Pd.',
                'status' => 'terkirim',
                'dibuat_oleh' => 'M. Taufik Hidayat, S.Sos.',
                'ditangani_oleh' => 'M. Taufik Hidayat, S.Sos.',
                'tanggal_kirim' => '2025-11-16'
            ]
        ];

        if (function_exists('session')) {
            $overrides = session()->get('surat_keluar_overrides') ?? [];
            foreach ($list as &$s) {
                if (isset($overrides[$s['id']])) {
                    $s = array_merge($s, $overrides[$s['id']]);
                }
            }
        }

        return $list;
    }

    public static function getKategoriSurat()
    {
        return [
            ['id' => 1, 'nama' => 'Undangan Resmi', 'berlaku_untuk' => 'keduanya', 'jumlah_surat' => 12],
            ['id' => 2, 'nama' => 'Edaran Dinas / Pemberitahuan', 'berlaku_untuk' => 'keduanya', 'jumlah_surat' => 25],
            ['id' => 3, 'nama' => 'Permohonan Izin / Rekomendasi', 'berlaku_untuk' => 'keluar', 'jumlah_surat' => 8],
            ['id' => 4, 'nama' => 'Keterangan Aktif Sekolah / Pindah', 'berlaku_untuk' => 'keluar', 'jumlah_surat' => 45],
            ['id' => 5, 'nama' => 'Kerjasama & MoU', 'berlaku_untuk' => 'keduanya', 'jumlah_surat' => 6],
        ];
    }

    public static function getFormatNomorSurat()
    {
        return [
            [
                'id' => 1,
                'jenis' => 'masuk',
                'format_pattern' => 'SM-{tahun}-{nomor_urut_5}',
                'nomor_urut_terakhir' => 144,
                'reset_tahunan' => true,
                'contoh' => 'SM-2025-00145'
            ],
            [
                'id' => 2,
                'jenis' => 'keluar',
                'format_pattern' => '{nomor_urut}/SMA-FI/TU/{bulan_romawi}/{tahun}',
                'nomor_urut_terakhir' => 104,
                'reset_tahunan' => true,
                'contoh' => '105/SMA-FI/TU/XII/2025'
            ]
        ];
    }

    public static function getTugasHarian($pengajaran_id = 1)
    {
        return [
            ['id' => 1, 'judul' => 'Tugas 1: Pembuktian Induksi Matematika', 'tanggal' => '2025-08-15', 'komponen' => 'Tugas & Kuis', 'kategori_penilaian' => 'tugas', 'kkm_snapshot' => 75.0, 'bobot_snapshot' => 20.0, 'jumlah_dinilai' => 31, 'total_siswa' => 31],
            ['id' => 2, 'judul' => 'Tugas 2: Sistem Pertidaksamaan Linear Dua Variabel', 'tanggal' => '2025-09-02', 'komponen' => 'Tugas & Kuis', 'kategori_penilaian' => 'tugas', 'kkm_snapshot' => 75.0, 'bobot_snapshot' => 20.0, 'jumlah_dinilai' => 31, 'total_siswa' => 31],
            ['id' => 3, 'judul' => 'UH 1: Induksi & Program Linear', 'tanggal' => '2025-09-20', 'komponen' => 'Ulangan Harian (UH)', 'kategori_penilaian' => 'uh', 'kkm_snapshot' => 75.0, 'bobot_snapshot' => 20.0, 'jumlah_dinilai' => 31, 'total_siswa' => 31],
            ['id' => 4, 'judul' => 'Tugas 3: Operasi Aljabar Matriks dan Determinan', 'tanggal' => '2025-10-25', 'komponen' => 'Tugas & Kuis', 'kategori_penilaian' => 'tugas', 'kkm_snapshot' => 75.0, 'bobot_snapshot' => 20.0, 'jumlah_dinilai' => 30, 'total_siswa' => 31],
            ['id' => 5, 'judul' => 'UH 2: Matriks & Transformasi Geometri', 'tanggal' => '2025-11-18', 'komponen' => 'Ulangan Harian (UH)', 'kategori_penilaian' => 'uh', 'kkm_snapshot' => 75.0, 'bobot_snapshot' => 20.0, 'jumlah_dinilai' => 31, 'total_siswa' => 31],
        ];
    }

    public static function getDefaultNilaiTugas($pengajaran_id = 1): array
    {
        return [
            1 => [ // Tugas 1 (Tugas & Kuis)
                1 => ['nilai' => 90, 'catatan' => 'Pengerjaan sangat rapi dan lengkap'],
                2 => ['nilai' => 85, 'catatan' => 'Langkah pembuktian sudah tepat'],
                3 => ['nilai' => 80, 'catatan' => 'Perhatikan langkah basis induksi'],
                4 => ['nilai' => 92, 'catatan' => 'Sangat baik, penjelasan runut'],
                5 => ['nilai' => 76, 'catatan' => 'Cukup baik, perlu perbanyak latihan'],
            ],
            2 => [ // Tugas 2 (Tugas & Kuis)
                1 => ['nilai' => 92, 'catatan' => 'Grafik daerah penyelesaian sangat akurat'],
                2 => ['nilai' => 87, 'catatan' => 'Arsiran daerah HP tepat'],
                3 => ['nilai' => 84, 'catatan' => 'Model matematika benar'],
                4 => ['nilai' => 94, 'catatan' => 'Luar biasa, uji titik pojok teliti'],
                5 => ['nilai' => 74, 'catatan' => 'Perhatikan tanda pertidaksamaan pada arsiran'],
            ],
            3 => [ // UH 1 (Ulangan Harian (UH))
                1 => ['nilai' => 91, 'catatan' => 'Hasil evaluasi sangat memuaskan'],
                2 => ['nilai' => 88, 'catatan' => 'Jawaban lengkap dan sistematis'],
                3 => ['nilai' => 78, 'catatan' => 'Tuntas KKM, tingkatkan pemahaman soal cerita'],
                4 => ['nilai' => 94, 'catatan' => 'Sempurna pada bagian induksi'],
                5 => ['nilai' => 72, 'catatan' => 'Di bawah KKM, telah mengikuti pengayaan remedial'],
            ],
            4 => [ // Tugas 3 (Tugas & Kuis)
                1 => ['nilai' => 88, 'catatan' => 'Perhitungan determinan matriks 3x3 benar'],
                2 => ['nilai' => 86, 'catatan' => 'Invers matriks dihitung dengan cermat'],
                3 => ['nilai' => 82, 'catatan' => 'Sifat-sifat determinan dipahami dengan baik'],
                4 => ['nilai' => 90, 'catatan' => 'Penyelesaian SPLDV matriks sangat cepat'],
                5 => ['nilai' => 75, 'catatan' => 'Tuntas batas KKM'],
            ],
            5 => [ // UH 2 (Ulangan Harian (UH))
                1 => ['nilai' => 93, 'catatan' => 'Penguasaan matriks dan transformasi sangat baik'],
                2 => ['nilai' => 88, 'catatan' => 'Komposisi transformasi geometri dikerjakan tepat'],
                3 => ['nilai' => 82, 'catatan' => 'Hasil stabil di atas KKM'],
                4 => ['nilai' => 96, 'catatan' => 'Nilai tertinggi di kelas untuk materi matriks'],
                5 => ['nilai' => 76, 'catatan' => 'Alhamdulillah mencapai KKM'],
            ],
        ];
    }

    public static function getNilaiTugasDetail($pengajaran_id = 1, $tugas_id = 1, $customScores = null): array
    {
        $allScores = $customScores ?? self::getDefaultNilaiTugas($pengajaran_id);
        $taskScores = $allScores[$tugas_id] ?? [];
        $siswaList = array_slice(self::getSiswaList(), 0, 5); // 5 active siswa XI-MIPA-1
        $result = [];

        foreach ($siswaList as $s) {
            $siswaId = $s['id'];
            $scoreData = $taskScores[$siswaId] ?? ['nilai' => 80, 'catatan' => ''];
            $nilai = $scoreData['nilai'] ?? 0;
            $result[] = [
                'siswa_id' => $siswaId,
                'nis' => $s['nis'],
                'nama' => $s['nama'],
                'foto_path' => $s['foto_path'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($s['nama']),
                'nilai' => $nilai,
                'catatan' => $scoreData['catatan'] ?? '',
                'is_tuntas' => ($nilai >= 75.0),
            ];
        }

        return $result;
    }

    public static function getRekapTugasDanUH($pengajaran_id = 1, $customScores = null): array
    {
        $tugasList = self::getTugasHarian($pengajaran_id);
        $allScores = $customScores ?? self::getDefaultNilaiTugas($pengajaran_id);
        $siswaList = array_slice(self::getSiswaList(), 0, 5);
        $matrix = [];

        foreach ($siswaList as $s) {
            $siswaId = $s['id'];
            $tugasScores = [];
            $uhScores = [];
            $detailScores = [];

            foreach ($tugasList as $t) {
                $tId = $t['id'];
                $val = $allScores[$tId][$siswaId]['nilai'] ?? null;
                $detailScores[$tId] = $val;

                if ($val !== null && is_numeric($val)) {
                    if (str_contains($t['komponen'], 'UH') || str_contains($t['komponen'], 'Ulangan')) {
                        $uhScores[] = (float)$val;
                    } else {
                        $tugasScores[] = (float)$val;
                    }
                }
            }

            $avgTugas = !empty($tugasScores) ? round(array_sum($tugasScores) / count($tugasScores), 1) : 0;
            $avgUH = !empty($uhScores) ? round(array_sum($uhScores) / count($uhScores), 1) : 0;

            $matrix[] = [
                'siswa_id' => $siswaId,
                'nis' => $s['nis'],
                'nama' => $s['nama'],
                'foto_path' => $s['foto_path'],
                'scores' => $detailScores,
                'tugas_scores' => $tugasScores,
                'uh_scores' => $uhScores,
                'avg_tugas' => $avgTugas,
                'avg_uh' => $avgUH,
            ];
        }

        return [
            'tugasList' => $tugasList,
            'rekap' => $matrix,
        ];
    }

    public static function getDefaultAbsensiPerwalian($kelas_id = 4): array
    {
        return [
            1 => ['siswa_id' => 1, 'sakit' => 1, 'izin' => 1, 'tanpa_keterangan' => 0, 'catatan' => 'Tertib dan disiplin'],
            2 => ['siswa_id' => 2, 'sakit' => 0, 'izin' => 1, 'tanpa_keterangan' => 0, 'catatan' => 'Sangat rajin hadir'],
            3 => ['siswa_id' => 3, 'sakit' => 2, 'izin' => 1, 'tanpa_keterangan' => 0, 'catatan' => 'Ada surat izin dokter'],
            4 => ['siswa_id' => 4, 'sakit' => 0, 'izin' => 0, 'tanpa_keterangan' => 0, 'catatan' => 'Kehadiran sempurna 100%'],
            5 => ['siswa_id' => 5, 'sakit' => 3, 'izin' => 2, 'tanpa_keterangan' => 1, 'catatan' => 'Perlu pembinaan kehadiran'],
        ];
    }

    public static function getLegerMapelList(): array
    {
        return [
            ['id' => 1, 'kode' => 'PAI', 'nama' => 'Pendidikan Agama Islam', 'kkm' => 75],
            ['id' => 2, 'kode' => 'PPKN', 'nama' => 'Pendidikan Pancasila & Kewarganegaraan', 'kkm' => 75],
            ['id' => 3, 'kode' => 'BIND', 'nama' => 'Bahasa Indonesia', 'kkm' => 75],
            ['id' => 4, 'kode' => 'MAT-W', 'nama' => 'Matematika (Wajib)', 'kkm' => 75],
            ['id' => 5, 'kode' => 'SEJ', 'nama' => 'Sejarah Indonesia', 'kkm' => 75],
            ['id' => 6, 'kode' => 'BING', 'nama' => 'Bahasa Inggris', 'kkm' => 75],
            ['id' => 7, 'kode' => 'SBD', 'nama' => 'Seni Budaya', 'kkm' => 75],
            ['id' => 8, 'kode' => 'PJOK', 'nama' => 'PJOK', 'kkm' => 75],
            ['id' => 9, 'kode' => 'PKWU', 'nama' => 'Prakarya & Kewirausahaan', 'kkm' => 75],
            ['id' => 10, 'kode' => 'MAT-P', 'nama' => 'Matematika Peminatan', 'kkm' => 75],
            ['id' => 11, 'kode' => 'BIO', 'nama' => 'Biologi', 'kkm' => 75],
            ['id' => 12, 'kode' => 'FIS', 'nama' => 'Fisika', 'kkm' => 75],
            ['id' => 13, 'kode' => 'KIM', 'nama' => 'Kimia', 'kkm' => 75],
            ['id' => 17, 'kode' => 'BSUN', 'nama' => 'Bahasa Sunda', 'kkm' => 75],
            ['id' => 18, 'kode' => 'BARB', 'nama' => 'Bahasa Arab / Tahfidz', 'kkm' => 75],
        ];
    }

    public static function getLegerNilaiKelas($kelas_id = 4, $customAbsensi = null): array
    {
        $mapelList = self::getLegerMapelList();
        $siswaList = array_slice(self::getSiswaList(), 0, 5);
        $absensi = $customAbsensi ?? (function_exists('session') && session()->get('absensi_perwalian_' . $kelas_id) ? session()->get('absensi_perwalian_' . $kelas_id) : self::getDefaultAbsensiPerwalian($kelas_id));

        // Ambil nilai Matematika Wajib dari session jika ada perubahan
        $matWajibScores = [];
        if (function_exists('session')) {
            $sessMatrix = session()->get('siswa_nilai_matrix_1');
            if ($sessMatrix) {
                foreach ($sessMatrix as $row) {
                    $matWajibScores[$row['siswa_id']] = (float)($row['pengetahuan']['nilai_akhir'] ?? 90);
                }
            }
        }

        $baseScores = [
            1 => [ // Muhammad Raihan Pratama
                'PAI' => 88, 'PPKN' => 84, 'BIND' => 86, 'MAT-W' => ($matWajibScores[1] ?? 92.5), 'SEJ' => 82,
                'BING' => 89, 'SBD' => 85, 'PJOK' => 88, 'PKWU' => 86, 'MAT-P' => 91,
                'BIO' => 90, 'FIS' => 87, 'KIM' => 89, 'BSUN' => 86, 'BARB' => 92
            ],
            2 => [ // Aisyah Azzahra Putri
                'PAI' => 90, 'PPKN' => 88, 'BIND' => 88, 'MAT-W' => ($matWajibScores[2] ?? 88.3), 'SEJ' => 85,
                'BING' => 92, 'SBD' => 88, 'PJOK' => 86, 'PKWU' => 88, 'MAT-P' => 87,
                'BIO' => 92, 'FIS' => 85, 'KIM' => 88, 'BSUN' => 88, 'BARB' => 94
            ],
            3 => [ // Fadhil Ahmad Al-Ghifari
                'PAI' => 84, 'PPKN' => 80, 'BIND' => 82, 'MAT-W' => ($matWajibScores[3] ?? 81.3), 'SEJ' => 78,
                'BING' => 80, 'SBD' => 82, 'PJOK' => 88, 'PKWU' => 80, 'MAT-P' => 79,
                'BIO' => 82, 'FIS' => 78, 'KIM' => 80, 'BSUN' => 80, 'BARB' => 85
            ],
            4 => [ // Zahra Nurul Izzati
                'PAI' => 95, 'PPKN' => 92, 'BIND' => 94, 'MAT-W' => ($matWajibScores[4] ?? 95.7), 'SEJ' => 90,
                'BING' => 96, 'SBD' => 90, 'PJOK' => 90, 'PKWU' => 92, 'MAT-P' => 94,
                'BIO' => 96, 'FIS' => 92, 'KIM' => 94, 'BSUN' => 92, 'BARB' => 98
            ],
            5 => [ // Aldi Kurniawan
                'PAI' => 78, 'PPKN' => 76, 'BIND' => 76, 'MAT-W' => ($matWajibScores[5] ?? 73.8), 'SEJ' => 75,
                'BING' => 76, 'SBD' => 78, 'PJOK' => 84, 'PKWU' => 76, 'MAT-P' => 74,
                'BIO' => 76, 'FIS' => 72, 'KIM' => 74, 'BSUN' => 75, 'BARB' => 78
            ],
        ];

        $rows = [];
        foreach ($siswaList as $s) {
            $sId = $s['id'];
            $mapelScores = $baseScores[$sId] ?? [];
            $total = 0;
            $count = count($mapelScores);
            $hasRemedial = false;

            foreach ($mapelScores as $k => $val) {
                $total += $val;
                if ($val < 75.0) {
                    $hasRemedial = true;
                }
            }

            $avg = $count > 0 ? round($total / $count, 1) : 0;
            $sAbsensi = $absensi[$sId] ?? ['sakit' => 0, 'izin' => 0, 'tanpa_keterangan' => 0];

            $rows[] = [
                'siswa_id' => $sId,
                'nis' => $s['nis'],
                'nama' => $s['nama'],
                'foto_path' => $s['foto_path'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($s['nama']),
                'mapel_scores' => $mapelScores,
                'total_nilai' => $total,
                'rata_rata' => $avg,
                'ranking' => 0, // dihitung di bawah
                'sakit' => (int)($sAbsensi['sakit'] ?? 0),
                'izin' => (int)($sAbsensi['izin'] ?? 0),
                'alpa' => (int)($sAbsensi['tanpa_keterangan'] ?? ($sAbsensi['alpa'] ?? 0)),
                'is_tuntas' => !$hasRemedial,
            ];
        }

        // Sort desc berdasarkan rata_rata untuk ranking
        usort($rows, fn($a, $b) => $b['rata_rata'] <=> $a['rata_rata']);
        $rank = 1;
        foreach ($rows as &$r) {
            $r['ranking'] = $rank++;
        }

        return [
            'mapelList' => $mapelList,
            'rows' => $rows,
            'kelas' => 'XI-MIPA-1',
            'wali_kelas' => 'Ustadz Hendra Gunawan, M.Pd.',
            'tahun_ajaran' => '2025/2026 - Ganjil'
        ];
    }

    public static function getSiswaNilaiMatrix()
    {
        return [
            [
                'siswa_id' => 1,
                'nis' => '242510001',
                'nama' => 'Muhammad Raihan Pratama',
                'pengetahuan' => ['uh' => 92, 'tugas' => 90, 'uts' => 94, 'uas' => 93, 'nilai_akhir' => 92.5, 'predikat' => 'A'],
                'keterampilan' => ['praktik' => 95, 'proyek' => 92, 'portofolio' => 94, 'nilai_akhir' => 93.8, 'predikat' => 'A']
            ],
            [
                'siswa_id' => 2,
                'nis' => '242510002',
                'nama' => 'Aisyah Azzahra Putri',
                'pengetahuan' => ['uh' => 88, 'tugas' => 86, 'uts' => 88, 'uas' => 90, 'nilai_akhir' => 88.3, 'predikat' => 'B'],
                'keterampilan' => ['praktik' => 90, 'proyek' => 88, 'portofolio' => 90, 'nilai_akhir' => 89.4, 'predikat' => 'B']
            ],
            [
                'siswa_id' => 3,
                'nis' => '242510003',
                'nama' => 'Fadhil Ahmad Al-Ghifari',
                'pengetahuan' => ['uh' => 80, 'tugas' => 82, 'uts' => 78, 'uas' => 84, 'nilai_akhir' => 81.3, 'predikat' => 'C'],
                'keterampilan' => ['praktik' => 85, 'proyek' => 82, 'portofolio' => 80, 'nilai_akhir' => 82.6, 'predikat' => 'C']
            ],
            [
                'siswa_id' => 4,
                'nis' => '242510004',
                'nama' => 'Zahra Nurul Izzati',
                'pengetahuan' => ['uh' => 95, 'tugas' => 92, 'uts' => 96, 'uas' => 98, 'nilai_akhir' => 95.7, 'predikat' => 'A'],
                'keterampilan' => ['praktik' => 96, 'proyek' => 94, 'portofolio' => 95, 'nilai_akhir' => 95.1, 'predikat' => 'A']
            ],
            [
                'siswa_id' => 5,
                'nis' => '242510005',
                'nama' => 'Aldi Kurniawan',
                'pengetahuan' => ['uh' => 74, 'tugas' => 75, 'uts' => 70, 'uas' => 72, 'nilai_akhir' => 72.5, 'predikat' => 'D'],
                'keterampilan' => ['praktik' => 78, 'proyek' => 76, 'portofolio' => 75, 'nilai_akhir' => 76.5, 'predikat' => 'C']
            ],
        ];
    }

    public static function getArsipData()
    {
        return [
            'alumni' => [
                ['nama' => 'Dina Amelia Rahmah', 'nis' => '222310015', 'tahun_lulus' => '2024/2025', 'kelas_terakhir' => 'XII-MIPA-1', 'status' => 'Lulus'],
                ['nama' => 'Rizky Ramadhan', 'nis' => '222310016', 'tahun_lulus' => '2024/2025', 'kelas_terakhir' => 'XII-IPS-1', 'status' => 'Lulus'],
                ['nama' => 'Aditya Pratama', 'nis' => '232410050', 'tahun_lulus' => '2024/2025', 'kelas_terakhir' => 'XI-MIPA-2', 'status' => 'Pindah (Mutasi Keluar)'],
            ],
            'kenaikan_kelas' => [
                ['tahun' => '2024/2025', 'nama' => 'Muhammad Raihan Pratama', 'kelas_asal' => 'X-MIPA-1', 'kelas_tujuan' => 'XI-MIPA-1', 'status' => 'Naik Kelas', 'catatan' => 'Peringkat 2 Paralel'],
                ['tahun' => '2024/2025', 'nama' => 'Aisyah Azzahra Putri', 'kelas_asal' => 'X-MIPA-1', 'kelas_tujuan' => 'XI-MIPA-1', 'status' => 'Naik Kelas', 'catatan' => 'Sangat Baik'],
                ['tahun' => '2024/2025', 'nama' => 'Faris Maulana Yusuf', 'kelas_asal' => 'XI-MIPA-1', 'kelas_tujuan' => 'XII-MIPA-1', 'status' => 'Naik Kelas', 'catatan' => 'Lulus Seluruh KKM'],
            ],
            'raport' => [
                ['tahun' => '2024/2025', 'semester' => 'Genap', 'nama' => 'Muhammad Raihan Pratama', 'kelas' => 'X-MIPA-1', 'finalized_at' => '2025-06-20', 'file_pdf' => 'raport_raihan_sm2_2025.pdf'],
                ['tahun' => '2024/2025', 'semester' => 'Ganjil', 'nama' => 'Muhammad Raihan Pratama', 'kelas' => 'X-MIPA-1', 'finalized_at' => '2024-12-20', 'file_pdf' => 'raport_raihan_sm1_2024.pdf'],
                ['tahun' => '2024/2025', 'semester' => 'Genap', 'nama' => 'Dina Amelia Rahmah', 'kelas' => 'XII-MIPA-1', 'finalized_at' => '2025-05-15', 'file_pdf' => 'raport_dina_lulus_2025.pdf'],
            ],
            'mutasi' => [
                ['nama' => 'Aditya Pratama', 'nis' => '232410050', 'jenis' => 'Pindah Keluar', 'tanggal' => '2025-01-10', 'asal_tujuan' => 'SMA Negeri 3 Bandung', 'keterangan' => 'Mengikuti kepindahan tugas orang tua ke Bandung kota'],
                ['nama' => 'Bilal Al-Fatih', 'nis' => '242510099', 'jenis' => 'Pindah Masuk', 'tanggal' => '2025-08-01', 'asal_tujuan' => 'SMA IT Al-Multazam Kuningan', 'keterangan' => 'Diterima di kelas XI-MIPA-1'],
            ],
            'dokumen' => [
                ['nama_siswa' => 'Muhammad Raihan Pratama', 'jenis_dokumen' => 'Ijazah SMP', 'file_path' => 'ijazah_smp_raihan.pdf', 'tanggal_upload' => '2024-07-20'],
                ['nama_siswa' => 'Muhammad Raihan Pratama', 'jenis_dokumen' => 'Kartu Keluarga & Akta Lahir', 'file_path' => 'kk_akta_raihan.pdf', 'tanggal_upload' => '2024-07-20'],
                ['nama_siswa' => 'Dina Amelia Rahmah', 'jenis_dokumen' => 'Surat Keterangan Lulus (SKL)', 'file_path' => 'skl_dina_2025.pdf', 'tanggal_upload' => '2025-05-20'],
            ],
            'penugasan_guru' => [
                ['tahun' => '2024/2025', 'guru' => 'Ustadz Hendra Gunawan, M.Pd.', 'mapel' => 'Matematika (Wajib)', 'kelas' => 'X-MIPA-1, X-MIPA-2', 'semester' => 'Ganjil & Genap'],
                ['tahun' => '2024/2025', 'guru' => 'Ustadzah Siti Nurhaliza, S.Pd.', 'mapel' => 'Biologi', 'kelas' => 'XI-MIPA-1, XI-MIPA-2', 'semester' => 'Ganjil & Genap'],
            ]
        ];
    }

    // State global siklus akademik saat ini
    public static function getSistemState(): array
    {
        return [
            'ta_aktif_id' => 2,
            'ta_aktif_nama' => '2025/2026',
            'semester_aktif_id' => 3,
            'semester_aktif_nama' => 'Ganjil',
            
            // Gate: apakah boleh generate raport?
            'kelengkapan_nilai_kelas' => [
                // kelas_id => berapa persen nilai sudah lengkap
                4 => [ // XI-MIPA-1
                    'persen' => 85,
                    'mapel_belum' => ['Fisika (Ustadz Budi)', 'Bahasa Sunda'],
                    'boleh_generate' => false
                ],
                6 => [ // XII-MIPA-1
                    'persen' => 100,
                    'mapel_belum' => [],
                    'boleh_generate' => true
                ],
            ],

            // Rincian kelengkapan nilai per mapel untuk kelas 4 (XI-MIPA-1)
            'kelengkapan_mapel_detail' => [
                4 => [
                    ['mapel' => 'Matematika (Wajib)', 'guru' => 'Ustadz Hendra Gunawan, M.Pd.', 'status' => 'lengkap', 'terisi' => 31, 'total' => 31, 'keterangan' => 'Lengkap (31/31)'],
                    ['mapel' => 'Matematika Peminatan', 'guru' => 'Ustadz Hendra Gunawan, M.Pd.', 'status' => 'lengkap', 'terisi' => 31, 'total' => 31, 'keterangan' => 'Lengkap (31/31)'],
                    ['mapel' => 'Pendidikan Agama Islam', 'guru' => 'Ustadz Abdul Karim, Lc., M.Ag.', 'status' => 'lengkap', 'terisi' => 31, 'total' => 31, 'keterangan' => 'Lengkap (31/31)'],
                    ['mapel' => 'Biologi', 'guru' => 'Ustadzah Siti Nurhaliza, S.Pd.', 'status' => 'lengkap', 'terisi' => 31, 'total' => 31, 'keterangan' => 'Lengkap (31/31)'],
                    ['mapel' => 'Kimia', 'guru' => 'Ustadzah Rina Maryani, S.Pd.', 'status' => 'lengkap', 'terisi' => 31, 'total' => 31, 'keterangan' => 'Lengkap (31/31)'],
                    ['mapel' => 'Bahasa Inggris', 'guru' => 'Ustadzah Dewi Kartika, M.Pd.', 'status' => 'lengkap', 'terisi' => 31, 'total' => 31, 'keterangan' => 'Lengkap (31/31)'],
                    ['mapel' => 'Fisika', 'guru' => 'Ustadz Budi Rahardjo, S.Si.', 'status' => 'belum_lengkap', 'terisi' => 29, 'total' => 31, 'keterangan' => 'Belum lengkap (29/31) - 2 siswa belum dinilai'],
                    ['mapel' => 'Bahasa Sunda', 'guru' => '-', 'status' => 'belum_ada_penugasan', 'terisi' => 0, 'total' => 31, 'keterangan' => 'Belum ada penugasan guru'],
                ]
            ],
            
            // Gate: apakah raport semester genap semua sudah final?
            // (prasyarat untuk buka wizard TA baru)
            'raport_genap_semua_final' => false,
            'raport_genap_progress' => '0 dari 7 kelas selesai (semester genap belum dimulai)',
            
            // Gate: apakah kenaikan kelas semua sudah disubmit wali?
            'kenaikan_semua_disubmit' => false,
            
            // Status unlock requests yang pending
            'unlock_requests_pending' => self::getUnlockRequests(),
        ];
    }

    public static function getUnlockRequests(): array
    {
        if (function_exists('session')) {
            $sessionRequests = session()->get('unlock_requests_pending');
            if (is_array($sessionRequests)) {
                return $sessionRequests;
            }
            $st = session()->get('unlock_request_status_1');
            if ($st === 'approved' || $st === 'rejected') {
                return [];
            }
        }

        return [
            [
                'id' => 1,
                'siswa_id' => 5,
                'siswa_nama' => 'Aldi Kurniawan',
                'siswa_nis' => '242510005',
                'kelas' => 'XI-MIPA-1',
                'semester' => 'Ganjil 2025/2026',
                'alasan' => 'Perbaikan kekeliruan input nilai tugas praktik Biologi',
                'diminta_oleh' => 'Ustadz Hendra Gunawan, M.Pd.',
                'diminta_pada' => '2025-12-20 09:15',
                'status' => 'pending'
            ]
        ];
    }

    public static function getKenaikanKelasList(): array
    {
        $base = [
            ['id' => 1, 'nis' => '242510001', 'nisn' => '0071234561', 'nama' => 'Muhammad Raihan Pratama', 'kelas_asal' => 'XI-MIPA-1', 'tingkatan' => 11, 'rata_rata' => 91.2, 'status' => 'naik', 'kelas_tujuan' => 'XII-MIPA-1', 'tanggal_pleno' => '2025-12-18', 'catatan' => 'Peringkat 1 Umum - Naik ke Kelas XII-MIPA-1'],
            ['id' => 2, 'nis' => '242510002', 'nisn' => '0071234562', 'nama' => 'Aisyah Azzahra Putri', 'kelas_asal' => 'XI-MIPA-1', 'tingkatan' => 11, 'rata_rata' => 88.6, 'status' => 'naik', 'kelas_tujuan' => 'XII-MIPA-1', 'tanggal_pleno' => '2025-12-18', 'catatan' => 'Sangat Baik - Naik ke Kelas XII-MIPA-1'],
            ['id' => 3, 'nis' => '242510003', 'nisn' => '0071234563', 'nama' => 'Fadhil Ahmad Al-Ghifari', 'kelas_asal' => 'XI-MIPA-1', 'tingkatan' => 11, 'rata_rata' => 82.0, 'status' => 'naik', 'kelas_tujuan' => 'XII-MIPA-1', 'tanggal_pleno' => '2025-12-18', 'catatan' => 'Tingkatkan konsistensi - Naik ke Kelas XII-MIPA-1'],
            ['id' => 4, 'nis' => '242510004', 'nisn' => '0071234564', 'nama' => 'Zahra Nurul Izzati', 'kelas_asal' => 'XI-MIPA-1', 'tingkatan' => 11, 'rata_rata' => 94.8, 'status' => 'naik', 'kelas_tujuan' => 'XII-MIPA-1', 'tanggal_pleno' => '2025-12-18', 'catatan' => 'Prestasi Unggul - Naik ke Kelas XII-MIPA-1'],
            ['id' => 5, 'nis' => '242510005', 'nisn' => '0071234565', 'nama' => 'Aldi Kurniawan', 'kelas_asal' => 'XI-MIPA-1', 'tingkatan' => 11, 'rata_rata' => 75.4, 'status' => 'naik', 'kelas_tujuan' => 'XII-MIPA-1', 'tanggal_pleno' => '2025-12-18', 'catatan' => 'Tuntas bersyarat - Naik ke Kelas XII-MIPA-1'],
            ['id' => 7, 'nis' => '242510019', 'nisn' => '0071234579', 'nama' => 'Bagas Firmansyah', 'kelas_asal' => 'X-MIPA-1', 'tingkatan' => 10, 'rata_rata' => 64.2, 'status' => 'tinggal_kelas', 'kelas_tujuan' => 'X-MIPA-1', 'tanggal_pleno' => '2025-12-18', 'catatan' => 'Kehadiran < 75% - Diputuskan Tinggal di Kelas X'],
            ['id' => 6, 'nis' => '232410088', 'nisn' => '0061234599', 'nama' => 'Faris Maulana Yusuf', 'kelas_asal' => 'XII-MIPA-1', 'tingkatan' => 12, 'rata_rata' => 89.4, 'status' => 'lulus', 'kelas_tujuan' => 'Alumni', 'nomor_ijazah' => 'DN-02/M-SMA/26/001234', 'tanggal_pleno' => '2025-12-19', 'catatan' => 'Lulus Ujian Sekolah & Memenuhi Syarat Kelulusan'],
        ];

        if (function_exists('session')) {
            $sessionPleno = session()->get('pleno_kenaikan_data') ?? [];
            if (!empty($sessionPleno)) {
                foreach ($base as &$item) {
                    $sId = $item['id'];
                    if (isset($sessionPleno[$sId])) {
                        if (!empty($sessionPleno[$sId]['status_usulan'])) {
                            $item['status'] = $sessionPleno[$sId]['status_usulan'];
                        }
                        if (!empty($sessionPleno[$sId]['kelas_tujuan'])) {
                            $item['kelas_tujuan'] = $sessionPleno[$sId]['kelas_tujuan'];
                        }
                        if (!empty($sessionPleno[$sId]['catatan'])) {
                            $item['catatan'] = $sessionPleno[$sId]['catatan'];
                        }
                        if (($sessionPleno[$sId]['status_pleno'] ?? '') === 'disahkan_pleno') {
                            $item['tanggal_pleno'] = date('Y-m-d');
                        }
                    }
                }
            }
        }

        return $base;
    }

    // =========================================================================
    // PRESENSI HARIAN PER PERTEMUAN & JURNAL KBM GURU MATA PELAJARAN
    // =========================================================================

    public static function getDefaultPertemuanList($pengajaran_id = 1): array
    {
        return [
            [
                'id' => 1,
                'pertemuan_ke' => 1,
                'tanggal' => '2025-07-21',
                'jam_ke' => 'Jam ke 1-2 (07:15 - 08:45)',
                'materi_pokok' => 'Kontrak Belajar & Pengantar Induksi Matematika',
                'metode' => 'Ceramah Interaktif & Diskusi Kelas',
                'catatan_jurnal' => 'Orientasi silabus dan pengenalan konsep dasar penalaran deduktif & induktif. Siswa sangat antusias dan tertib.',
                'status' => 'selesai',
                'rekap' => ['hadir' => 5, 'sakit' => 0, 'izin' => 0, 'alpa' => 0, 'dispensasi' => 0, 'total' => 5]
            ],
            [
                'id' => 2,
                'pertemuan_ke' => 2,
                'tanggal' => '2025-07-28',
                'jam_ke' => 'Jam ke 1-2 (07:15 - 08:45)',
                'materi_pokok' => 'Prinsip Induksi Matematika Sederhana',
                'metode' => 'Latihan Terbimbing & Diskusi Kelompok',
                'catatan_jurnal' => 'Membahas langkah basis n=1 dan langkah induksi n=k ke n=k+1. Sebagian besar siswa dapat membuktikan deret aritmetika.',
                'status' => 'selesai',
                'rekap' => ['hadir' => 4, 'sakit' => 1, 'izin' => 0, 'alpa' => 0, 'dispensasi' => 0, 'total' => 5]
            ],
            [
                'id' => 3,
                'pertemuan_ke' => 3,
                'tanggal' => '2025-08-04',
                'jam_ke' => 'Jam ke 1-2 (07:15 - 08:45)',
                'materi_pokok' => 'Penerapan Induksi Matematika pada Keterbagian Bilangan',
                'metode' => 'Problem Based Learning (PBL)',
                'catatan_jurnal' => 'Pembuktian bentuk keterbagian aljabar. Perlu penguatan pada konsep dasar pemfaktoran aljabar.',
                'status' => 'selesai',
                'rekap' => ['hadir' => 5, 'sakit' => 0, 'izin' => 0, 'alpa' => 0, 'dispensasi' => 0, 'total' => 5]
            ],
            [
                'id' => 4,
                'pertemuan_ke' => 4,
                'tanggal' => '2025-08-11',
                'jam_ke' => 'Jam ke 1-2 (07:15 - 08:45)',
                'materi_pokok' => 'Sistem Pertidaksamaan Linear Dua Variabel (SPtLDV)',
                'metode' => 'Eksplorasi Perangkat Lunak & Pemodelan Masalah',
                'catatan_jurnal' => 'Menentukan daerah himpunan penyelesaian (DHP) dengan arsiran. Ananda Raihan izin dispensasi mengikuti lomba tahfidz tingkat kota.',
                'status' => 'selesai',
                'rekap' => ['hadir' => 4, 'sakit' => 0, 'izin' => 0, 'alpa' => 0, 'dispensasi' => 1, 'total' => 5]
            ],
            [
                'id' => 5,
                'pertemuan_ke' => 5,
                'tanggal' => '2025-08-18',
                'jam_ke' => 'Jam ke 1-2 (07:15 - 08:45)',
                'materi_pokok' => 'Fungsi Tujuan & Uji Titik Pojok Program Linear',
                'metode' => 'Studi Kasus Kontekstual Keuangan UMKM',
                'catatan_jurnal' => 'Menyusun model matematika fungsi kendala dan nilai optimum laba usaha. Ananda Aisyah izin keperluan keluarga.',
                'status' => 'selesai',
                'rekap' => ['hadir' => 4, 'sakit' => 0, 'izin' => 1, 'alpa' => 0, 'dispensasi' => 0, 'total' => 5]
            ],
            [
                'id' => 6,
                'pertemuan_ke' => 6,
                'tanggal' => '2025-08-25',
                'jam_ke' => 'Jam ke 1-2 (07:15 - 08:45)',
                'materi_pokok' => 'Konsep Dasar Matriks & Operasi Penjumlahan/Pengurangan',
                'metode' => 'Presentasi Visual & Latihan Terbimbing',
                'catatan_jurnal' => 'Pengenalan ordo matriks, elemen baris dan kolom. Ananda Aldi tidak hadir tanpa surat keterangan (Alpa).',
                'status' => 'selesai',
                'rekap' => ['hadir' => 4, 'sakit' => 0, 'izin' => 0, 'alpa' => 1, 'dispensasi' => 0, 'total' => 5]
            ],
            [
                'id' => 7,
                'pertemuan_ke' => 7,
                'tanggal' => '2025-09-01',
                'jam_ke' => 'Jam ke 1-2 (07:15 - 08:45)',
                'materi_pokok' => 'Perkalian Matriks & Sifat-sifat Operasi Matriks',
                'metode' => 'Peer Tutoring (Tutor Sebaya)',
                'catatan_jurnal' => 'Syarat perkalian matriks dikuasai baik oleh seluruh siswa. Diskusi kelompok berjalan dinamis.',
                'status' => 'selesai',
                'rekap' => ['hadir' => 5, 'sakit' => 0, 'izin' => 0, 'alpa' => 0, 'dispensasi' => 0, 'total' => 5]
            ],
            [
                'id' => 8,
                'pertemuan_ke' => 8,
                'tanggal' => '2025-09-08',
                'jam_ke' => 'Jam ke 1-2 (07:15 - 08:45)',
                'materi_pokok' => 'Determinan & Invers Matriks Ordo 2x2',
                'metode' => 'Demonstrasi Rumus & Uji Pemahaman Mandiri',
                'catatan_jurnal' => '',
                'status' => 'belum_diisi',
                'rekap' => ['hadir' => 0, 'sakit' => 0, 'izin' => 0, 'alpa' => 0, 'dispensasi' => 0, 'total' => 5]
            ],
        ];
    }

    public static function getDefaultPresensiDetailMap($pengajaran_id = 1): array
    {
        return [
            1 => [
                1 => ['status' => 'H', 'catatan' => ''],
                2 => ['status' => 'H', 'catatan' => ''],
                3 => ['status' => 'H', 'catatan' => ''],
                4 => ['status' => 'H', 'catatan' => ''],
                5 => ['status' => 'H', 'catatan' => ''],
            ],
            2 => [
                1 => ['status' => 'H', 'catatan' => ''],
                2 => ['status' => 'H', 'catatan' => ''],
                3 => ['status' => 'S', 'catatan' => 'Surat dokter terlampir'],
                4 => ['status' => 'H', 'catatan' => ''],
                5 => ['status' => 'H', 'catatan' => ''],
            ],
            3 => [
                1 => ['status' => 'H', 'catatan' => ''],
                2 => ['status' => 'H', 'catatan' => ''],
                3 => ['status' => 'H', 'catatan' => ''],
                4 => ['status' => 'H', 'catatan' => ''],
                5 => ['status' => 'H', 'catatan' => ''],
            ],
            4 => [
                1 => ['status' => 'D', 'catatan' => 'Dispensasi lomba tahfidz kota'],
                2 => ['status' => 'H', 'catatan' => ''],
                3 => ['status' => 'H', 'catatan' => ''],
                4 => ['status' => 'H', 'catatan' => ''],
                5 => ['status' => 'H', 'catatan' => ''],
            ],
            5 => [
                1 => ['status' => 'H', 'catatan' => ''],
                2 => ['status' => 'I', 'catatan' => 'Izin acara keluarga resmi'],
                3 => ['status' => 'H', 'catatan' => ''],
                4 => ['status' => 'H', 'catatan' => ''],
                5 => ['status' => 'H', 'catatan' => ''],
            ],
            6 => [
                1 => ['status' => 'H', 'catatan' => ''],
                2 => ['status' => 'H', 'catatan' => ''],
                3 => ['status' => 'H', 'catatan' => ''],
                4 => ['status' => 'H', 'catatan' => ''],
                5 => ['status' => 'A', 'catatan' => 'Tanpa keterangan, telah dilaporkan ke wali kelas'],
            ],
            7 => [
                1 => ['status' => 'H', 'catatan' => ''],
                2 => ['status' => 'H', 'catatan' => ''],
                3 => ['status' => 'H', 'catatan' => ''],
                4 => ['status' => 'H', 'catatan' => ''],
                5 => ['status' => 'H', 'catatan' => ''],
            ],
            8 => [
                1 => ['status' => 'H', 'catatan' => ''],
                2 => ['status' => 'H', 'catatan' => ''],
                3 => ['status' => 'H', 'catatan' => ''],
                4 => ['status' => 'H', 'catatan' => ''],
                5 => ['status' => 'H', 'catatan' => ''],
            ],
        ];
    }

    public static function getRekapPresensiMapel($pengajaran_id = 1, $customPertemuan = null, $customDetail = null): array
    {
        $pertemuanList = $customPertemuan ?? self::getDefaultPertemuanList($pengajaran_id);
        $detailMap = $customDetail ?? self::getDefaultPresensiDetailMap($pengajaran_id);
        $siswaList = array_slice(self::getSiswaList(), 0, 5);

        // Hitung total pertemuan yang statusnya 'selesai'
        $pertemuanSelesai = array_filter($pertemuanList, fn($p) => $p['status'] === 'selesai');
        $totalSelesai = count($pertemuanSelesai);

        $matrix = [];
        $totalHadirKelas = 0;
        $totalKesempatanKelas = 0;

        foreach ($siswaList as $s) {
            $sId = $s['id'];
            $kehadiran = [];
            $h = 0;
            $sakit = 0;
            $izin = 0;
            $alpa = 0;
            $disp = 0;

            foreach ($pertemuanList as $p) {
                $pId = $p['id'];
                $statusP = $p['status'];
                
                if ($statusP === 'selesai') {
                    $val = $detailMap[$pId][$sId]['status'] ?? 'H';
                    $catatan = $detailMap[$pId][$sId]['catatan'] ?? '';
                    $kehadiran[$pId] = [
                        'status' => $val,
                        'catatan' => $catatan,
                    ];

                    if ($val === 'H') $h++;
                    elseif ($val === 'S') $sakit++;
                    elseif ($val === 'I') $izin++;
                    elseif ($val === 'A') $alpa++;
                    elseif ($val === 'D') $disp++;
                } else {
                    $kehadiran[$pId] = [
                        'status' => '-',
                        'catatan' => '',
                    ];
                }
            }

            // Persentase kehadiran: (Hadir + Dispensasi) / Pertemuan Selesai * 100
            $persen = ($totalSelesai > 0) ? round((($h + $disp) / $totalSelesai) * 100, 1) : 100.0;
            $isTuntas = ($persen >= 85.0);

            $totalHadirKelas += ($h + $disp);
            $totalKesempatanKelas += $totalSelesai;

            $matrix[] = [
                'siswa_id' => $sId,
                'nis' => $s['nis'],
                'nama' => $s['nama'],
                'foto_path' => $s['foto_path'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($s['nama']),
                'kehadiran' => $kehadiran,
                'total_hadir' => $h,
                'total_sakit' => $sakit,
                'total_izin' => $izin,
                'total_alpa' => $alpa,
                'total_dispensasi' => $disp,
                'persentase' => $persen,
                'is_tuntas' => $isTuntas,
            ];
        }

        $rataRataKelas = ($totalKesempatanKelas > 0) ? round(($totalHadirKelas / $totalKesempatanKelas) * 100, 1) : 100.0;

        return [
            'pertemuanList' => $pertemuanList,
            'totalPertemuan' => count($pertemuanList),
            'pertemuanSelesaiCount' => $totalSelesai,
            'targetPertemuan' => 16, // Standar 16 pertemuan per semester
            'rataRataKelas' => $rataRataKelas,
            'rekap' => $matrix,
        ];
    }

    // =========================================================================
    // 1. ENTITAS SISWA_RIWAYAT_KELAS (HISTORIS MULTI-TAHUN AJARAN)
    // =========================================================================

    public static function getSiswaRiwayatKelas(): array
    {
        return [
            // Muhammad Raihan Pratama (ID: 1)
            ['id' => 1, 'siswa_id' => 1, 'tahun_ajaran_id' => 1, 'tahun_ajaran_nama' => '2024/2025', 'semester_id' => 1, 'semester_nama' => 'Ganjil', 'kelas_id' => 1, 'kelas_nama' => 'X-MIPA-1', 'status_siswa' => 'Aktif', 'urutan_absen' => 1, 'rata_rata' => 89.4, 'ranking' => 2],
            ['id' => 2, 'siswa_id' => 1, 'tahun_ajaran_id' => 1, 'tahun_ajaran_nama' => '2024/2025', 'semester_id' => 2, 'semester_nama' => 'Genap', 'kelas_id' => 1, 'kelas_nama' => 'X-MIPA-1', 'status_siswa' => 'Naik', 'urutan_absen' => 1, 'rata_rata' => 90.2, 'ranking' => 2],
            ['id' => 3, 'siswa_id' => 1, 'tahun_ajaran_id' => 2, 'tahun_ajaran_nama' => '2025/2026', 'semester_id' => 3, 'semester_nama' => 'Ganjil', 'kelas_id' => 4, 'kelas_nama' => 'XI-MIPA-1', 'status_siswa' => 'Aktif', 'urutan_absen' => 1, 'rata_rata' => 91.2, 'ranking' => 1],
            ['id' => 4, 'siswa_id' => 1, 'tahun_ajaran_id' => 2, 'tahun_ajaran_nama' => '2025/2026', 'semester_id' => 4, 'semester_nama' => 'Genap', 'kelas_id' => 4, 'kelas_nama' => 'XI-MIPA-1', 'status_siswa' => 'Aktif', 'urutan_absen' => 1, 'rata_rata' => null, 'ranking' => null],
            
            // Aisyah Azzahra Putri (ID: 2)
            ['id' => 5, 'siswa_id' => 2, 'tahun_ajaran_id' => 1, 'tahun_ajaran_nama' => '2024/2025', 'semester_id' => 1, 'semester_nama' => 'Ganjil', 'kelas_id' => 1, 'kelas_nama' => 'X-MIPA-1', 'status_siswa' => 'Aktif', 'urutan_absen' => 2, 'rata_rata' => 87.5, 'ranking' => 3],
            ['id' => 6, 'siswa_id' => 2, 'tahun_ajaran_id' => 1, 'tahun_ajaran_nama' => '2024/2025', 'semester_id' => 2, 'semester_nama' => 'Genap', 'kelas_id' => 1, 'kelas_nama' => 'X-MIPA-1', 'status_siswa' => 'Naik', 'urutan_absen' => 2, 'rata_rata' => 88.0, 'ranking' => 3],
            ['id' => 7, 'siswa_id' => 2, 'tahun_ajaran_id' => 2, 'tahun_ajaran_nama' => '2025/2026', 'semester_id' => 3, 'semester_nama' => 'Ganjil', 'kelas_id' => 4, 'kelas_nama' => 'XI-MIPA-1', 'status_siswa' => 'Aktif', 'urutan_absen' => 2, 'rata_rata' => 88.6, 'ranking' => 2],
            
            // Fadhil Ahmad Al-Ghifari (ID: 3)
            ['id' => 8, 'siswa_id' => 3, 'tahun_ajaran_id' => 1, 'tahun_ajaran_nama' => '2024/2025', 'semester_id' => 1, 'semester_nama' => 'Ganjil', 'kelas_id' => 1, 'kelas_nama' => 'X-MIPA-1', 'status_siswa' => 'Aktif', 'urutan_absen' => 3, 'rata_rata' => 81.0, 'ranking' => 4],
            ['id' => 9, 'siswa_id' => 3, 'tahun_ajaran_id' => 1, 'tahun_ajaran_nama' => '2024/2025', 'semester_id' => 2, 'semester_nama' => 'Genap', 'kelas_id' => 1, 'kelas_nama' => 'X-MIPA-1', 'status_siswa' => 'Naik', 'urutan_absen' => 3, 'rata_rata' => 81.5, 'ranking' => 4],
            ['id' => 10, 'siswa_id' => 3, 'tahun_ajaran_id' => 2, 'tahun_ajaran_nama' => '2025/2026', 'semester_id' => 3, 'semester_nama' => 'Ganjil', 'kelas_id' => 4, 'kelas_nama' => 'XI-MIPA-1', 'status_siswa' => 'Aktif', 'urutan_absen' => 3, 'rata_rata' => 82.0, 'ranking' => 3],

            // Zahra Nurul Izzati (ID: 4)
            ['id' => 11, 'siswa_id' => 4, 'tahun_ajaran_id' => 1, 'tahun_ajaran_nama' => '2024/2025', 'semester_id' => 1, 'semester_nama' => 'Ganjil', 'kelas_id' => 1, 'kelas_nama' => 'X-MIPA-1', 'status_siswa' => 'Aktif', 'urutan_absen' => 4, 'rata_rata' => 93.8, 'ranking' => 1],
            ['id' => 12, 'siswa_id' => 4, 'tahun_ajaran_id' => 1, 'tahun_ajaran_nama' => '2024/2025', 'semester_id' => 2, 'semester_nama' => 'Genap', 'kelas_id' => 1, 'kelas_nama' => 'X-MIPA-1', 'status_siswa' => 'Naik', 'urutan_absen' => 4, 'rata_rata' => 94.5, 'ranking' => 1],
            ['id' => 13, 'siswa_id' => 4, 'tahun_ajaran_id' => 2, 'tahun_ajaran_nama' => '2025/2026', 'semester_id' => 3, 'semester_nama' => 'Ganjil', 'kelas_id' => 4, 'kelas_nama' => 'XI-MIPA-1', 'status_siswa' => 'Aktif', 'urutan_absen' => 4, 'rata_rata' => 94.8, 'ranking' => 1],

            // Aldi Kurniawan (ID: 5)
            ['id' => 14, 'siswa_id' => 5, 'tahun_ajaran_id' => 1, 'tahun_ajaran_nama' => '2024/2025', 'semester_id' => 1, 'semester_nama' => 'Ganjil', 'kelas_id' => 1, 'kelas_nama' => 'X-MIPA-1', 'status_siswa' => 'Aktif', 'urutan_absen' => 5, 'rata_rata' => 74.0, 'ranking' => 5],
            ['id' => 15, 'siswa_id' => 5, 'tahun_ajaran_id' => 1, 'tahun_ajaran_nama' => '2024/2025', 'semester_id' => 2, 'semester_nama' => 'Genap', 'kelas_id' => 1, 'kelas_nama' => 'X-MIPA-1', 'status_siswa' => 'Naik', 'urutan_absen' => 5, 'rata_rata' => 75.0, 'ranking' => 5],
            ['id' => 16, 'siswa_id' => 5, 'tahun_ajaran_id' => 2, 'tahun_ajaran_nama' => '2025/2026', 'semester_id' => 3, 'semester_nama' => 'Ganjil', 'kelas_id' => 4, 'kelas_nama' => 'XI-MIPA-1', 'status_siswa' => 'Aktif', 'urutan_absen' => 5, 'rata_rata' => 75.4, 'ranking' => 5],

            // Faris Maulana Yusuf (ID: 6) - Kelas 12 Lulus
            ['id' => 17, 'siswa_id' => 6, 'tahun_ajaran_id' => 1, 'tahun_ajaran_nama' => '2024/2025', 'semester_id' => 2, 'semester_nama' => 'Genap', 'kelas_id' => 4, 'kelas_nama' => 'XI-MIPA-1', 'status_siswa' => 'Naik', 'urutan_absen' => 6, 'rata_rata' => 88.5, 'ranking' => 3],
            ['id' => 18, 'siswa_id' => 6, 'tahun_ajaran_id' => 2, 'tahun_ajaran_nama' => '2025/2026', 'semester_id' => 3, 'semester_nama' => 'Ganjil', 'kelas_id' => 6, 'kelas_nama' => 'XII-MIPA-1', 'status_siswa' => 'Aktif', 'urutan_absen' => 6, 'rata_rata' => 89.4, 'ranking' => 2],
            ['id' => 19, 'siswa_id' => 6, 'tahun_ajaran_id' => 2, 'tahun_ajaran_nama' => '2025/2026', 'semester_id' => 4, 'semester_nama' => 'Genap', 'kelas_id' => 6, 'kelas_nama' => 'XII-MIPA-1', 'status_siswa' => 'Lulus', 'urutan_absen' => 6, 'rata_rata' => 91.8, 'ranking' => 1],

            // Siswa Mutasi Keluar: Aditya Pratama (ID: 7)
            ['id' => 20, 'siswa_id' => 7, 'tahun_ajaran_id' => 1, 'tahun_ajaran_nama' => '2024/2025', 'semester_id' => 1, 'semester_nama' => 'Ganjil', 'kelas_id' => 2, 'kelas_nama' => 'XI-MIPA-2', 'status_siswa' => 'Pindah Keluar', 'urutan_absen' => 10, 'rata_rata' => 80.5, 'ranking' => null],

            // Siswa Mutasi Masuk: Bilal Al-Fatih (ID: 8)
            ['id' => 21, 'siswa_id' => 8, 'tahun_ajaran_id' => 2, 'tahun_ajaran_nama' => '2025/2026', 'semester_id' => 3, 'semester_nama' => 'Ganjil', 'kelas_id' => 4, 'kelas_nama' => 'XI-MIPA-1', 'status_siswa' => 'Aktif', 'urutan_absen' => 7, 'rata_rata' => 84.0, 'ranking' => 4],
        ];
    }

    public static function getRiwayatKelasBySiswa($siswa_id): array
    {
        $all = self::getSiswaRiwayatKelas();
        $overrides = [];
        if (function_exists('session')) {
            try {
                $overrides = session()->get('siswa_riwayat_kelas_overrides') ?? [];
            } catch (\Throwable $e) {
                $overrides = [];
            }
        }
        if (isset($overrides[$siswa_id])) {
            foreach ($all as &$r) {
                if ($r['siswa_id'] == $siswa_id && ($r['semester_nama'] ?? '') === 'Ganjil' && ($r['tahun_ajaran_nama'] ?? '') === '2025/2026') {
                    $r['status_siswa'] = $overrides[$siswa_id]['status_siswa'];
                    $r['catatan'] = $overrides[$siswa_id]['catatan'];
                }
            }
        }
        return array_values(array_filter($all, fn($r) => $r['siswa_id'] == $siswa_id));
    }

    // =========================================================================
    // 2. STATUS PLENO KENAIKAN KELAS ROMBEL & VALIDASI URUTAN SISTEM
    // =========================================================================

    public static function getStatusPlenoRombel(): array
    {
        $list = [
            ['kelas_id' => 1, 'nama_kelas' => 'X-MIPA-1', 'wali_kelas' => 'Ustadzah Siti Nurhaliza, S.Pd.', 'tingkat' => 10, 'status_pleno' => 'selesai', 'tanggal_pleno' => '2025-12-18', 'pengesah' => 'Drs. H. Ahmad Fauzi, M.Pd.', 'jumlah_siswa' => 30, 'naik' => 30, 'tinggal' => 0],
            ['kelas_id' => 2, 'nama_kelas' => 'X-MIPA-2', 'wali_kelas' => 'Ustadz Budi Rahardjo, S.Si.', 'tingkat' => 10, 'status_pleno' => 'selesai', 'tanggal_pleno' => '2025-12-18', 'pengesah' => 'Drs. H. Ahmad Fauzi, M.Pd.', 'jumlah_siswa' => 28, 'naik' => 28, 'tinggal' => 0],
            ['kelas_id' => 3, 'nama_kelas' => 'X-IPS-1', 'wali_kelas' => 'Ustadzah Dewi Kartika, M.Pd.', 'tingkat' => 10, 'status_pleno' => 'selesai', 'tanggal_pleno' => '2025-12-18', 'pengesah' => 'Drs. H. Ahmad Fauzi, M.Pd.', 'jumlah_siswa' => 29, 'naik' => 29, 'tinggal' => 0],
            ['kelas_id' => 4, 'nama_kelas' => 'XI-MIPA-1', 'wali_kelas' => 'Ustadz Hendra Gunawan, M.Pd.', 'tingkat' => 11, 'status_pleno' => 'sedang_berlangsung', 'tanggal_pleno' => null, 'pengesah' => null, 'jumlah_siswa' => 31, 'naik' => 30, 'tinggal' => 1],
            ['kelas_id' => 5, 'nama_kelas' => 'XI-IPS-1', 'wali_kelas' => 'Ustadz Abdul Karim, Lc., M.Ag.', 'tingkat' => 11, 'status_pleno' => 'belum_mulai', 'tanggal_pleno' => null, 'pengesah' => null, 'jumlah_siswa' => 30, 'naik' => 0, 'tinggal' => 0],
            ['kelas_id' => 6, 'nama_kelas' => 'XII-MIPA-1', 'wali_kelas' => 'Ustadzah Rina Maryani, S.Pd.', 'tingkat' => 12, 'status_pleno' => 'selesai', 'tanggal_pleno' => '2025-12-19', 'pengesah' => 'Drs. H. Ahmad Fauzi, M.Pd.', 'jumlah_siswa' => 32, 'lulus' => 32, 'belum_lulus' => 0],
            ['kelas_id' => 7, 'nama_kelas' => 'XII-IPS-1', 'wali_kelas' => 'M. Taufik Hidayat, S.Sos.', 'tingkat' => 12, 'status_pleno' => 'selesai', 'tanggal_pleno' => '2025-12-19', 'pengesah' => 'Drs. H. Ahmad Fauzi, M.Pd.', 'jumlah_siswa' => 27, 'lulus' => 27, 'belum_lulus' => 0],
        ];

        if (function_exists('session')) {
            $isDisahkan = session()->get('pleno_disahkan_resmi');
            $sessionPleno = session()->get('pleno_kenaikan_data') ?? [];

            $hasDisahkan = false;
            foreach ($sessionPleno as $item) {
                if (($item['status_pleno'] ?? '') === 'disahkan_pleno') {
                    $hasDisahkan = true;
                    break;
                }
            }

            if ($isDisahkan || $hasDisahkan) {
                foreach ($list as &$r) {
                    if ($r['kelas_id'] == 4 || $r['kelas_id'] == 5) {
                        $r['status_pleno'] = 'selesai';
                        $r['tanggal_pleno'] = date('Y-m-d');
                        $r['pengesah'] = 'Drs. H. Ahmad Fauzi, M.Pd.';
                        if ($r['kelas_id'] == 5) {
                            $r['naik'] = 30;
                        }
                    }
                }
            }
        }

        return $list;
    }

    public static function isSemuaPlenoSelesai(): bool
    {
        $list = self::getStatusPlenoRombel();
        foreach ($list as $r) {
            if ($r['status_pleno'] !== 'selesai') {
                return false;
            }
        }
        return true;
    }

    // =========================================================================
    // 3. KOMPETENSI DASAR (KD) & DESKRIPSI CAPAIAN PEMBELAJARAN (CP)
    // =========================================================================

    public static function getKompetensiDasar($mapel_id = 4, $tingkatan_id = 2): array
    {
        return [
            ['id' => 1, 'kode_kd' => 'KD 3.1', 'judul' => 'Induksi Matematika', 'deskripsi' => 'Menjelaskan metode pembuktian pernyataan matematis barisan dan keterbagian dengan induksi matematika.'],
            ['id' => 2, 'kode_kd' => 'KD 3.2', 'judul' => 'Program Linear Dua Variabel', 'deskripsi' => 'Menjelaskan program linear dua variabel dan metode penyelesaian masalah kontekstual optimasi.'],
            ['id' => 3, 'kode_kd' => 'KD 3.3', 'judul' => 'Matriks & Operasi Matriks', 'deskripsi' => 'Menjelaskan kesamaan matriks dan melakukan operasi aljabar pada matriks ordo 2x2 dan 3x3.'],
            ['id' => 4, 'kode_kd' => 'KD 3.4', 'judul' => 'Determinan & Invers Matriks', 'deskripsi' => 'Menganalisis sifat-sifat determinan dan invers matriks serta penyelesaian sistem persamaan linear.'],
        ];
    }

    public static function generateDeskripsiCapaian($nilaiAkhir, $aspek = 'pengetahuan'): string
    {
        if ($aspek === 'pengetahuan') {
            if ($nilaiAkhir >= 92) {
                return 'Sangat menguasai seluruh kompetensi dasar, terutama pembuktian induksi matematika dan pemodelan program linear dua variabel.';
            } elseif ($nilaiAkhir >= 83) {
                return 'Menguasai dengan baik konsep matriks dan program linear. Perlu sedikit peningkatan pada pembuktian keterbagian bilangan aljabar.';
            } elseif ($nilaiAkhir >= 75) {
                return 'Tuntas mencapai kriteria minimal kompetensi. Memahami operasi dasar matriks, namun perlu penguatan pada konsep determinan dan invers.';
            } else {
                return 'Belum mencapai ketuntasan KKM. Memerlukan bimbingan remedial khusus pada materi sistem pertidaksamaan linear dan induksi matematika.';
            }
        } else {
            if ($nilaiAkhir >= 92) {
                return 'Sangat terampil menyelesaikan masalah kontekstual program linear dan mahir mengoperasikan perhitungan invers matriks secara sistematis.';
            } elseif ($nilaiAkhir >= 83) {
                return 'Terampil menyajikan model matematika dan menyelesaikan perhitungan determinan matriks dengan rapi dan teliti.';
            } elseif ($nilaiAkhir >= 75) {
                return 'Cukup terampil dalam menggambar daerah himpunan penyelesaian, perlu peningkatan ketelitian saat menghitung perkalian antar matriks.';
            } else {
                return 'Perlu pendampingan praktikum terbimbing dalam memodelkan persoalan kontekstual ke dalam bentuk sistem pertidaksamaan linear.';
            }
        }
    }

    // =========================================================================
    // 4. MODUL UJIAN SEKOLAH (US) & FORMULA NILAI AKHIR KELULUSAN KELAS 12
    // =========================================================================

    public static function getFormulaKelulusan(): array
    {
        return [
            'bobot_rapor' => 60, // 60% rata-rata rapor semester
            'bobot_ujian_sekolah' => 40, // 40% rata-rata nilai ujian sekolah (US)
            'jumlah_semester_raport' => 6, // configurable: 5 atau 6 semester
            'kkm_kelulusan' => 75.0,
            'keterangan' => 'Nilai Akhir Kelulusan = (60% x Rata-rata Rapor) + (40% x Rata-rata Ujian Sekolah)'
        ];
    }

    public static function getUjianSekolahData(): array
    {
        return [
            'mapel_ujian' => [
                ['id' => 1, 'kode' => 'PAI', 'nama' => 'Pendidikan Agama Islam', 'kkm' => 75],
                ['id' => 2, 'kode' => 'PPKN', 'nama' => 'Pendidikan Pancasila & Kewarganegaraan', 'kkm' => 75],
                ['id' => 3, 'kode' => 'BIND', 'nama' => 'Bahasa Indonesia', 'kkm' => 75],
                ['id' => 4, 'kode' => 'MAT-W', 'nama' => 'Matematika (Wajib)', 'kkm' => 75],
                ['id' => 5, 'kode' => 'BING', 'nama' => 'Bahasa Inggris', 'kkm' => 75],
                ['id' => 6, 'kode' => 'BIO', 'nama' => 'Biologi', 'kkm' => 75],
                ['id' => 7, 'kode' => 'FIS', 'nama' => 'Fisika', 'kkm' => 75],
                ['id' => 8, 'kode' => 'KIM', 'nama' => 'Kimia', 'kkm' => 75],
            ],
            'siswa_kelas12' => [
                [
                    'siswa_id' => 6,
                    'nis' => '232410088',
                    'nama' => 'Faris Maulana Yusuf',
                    'kelas' => 'XII-MIPA-1',
                    'rata_rapor_smt_1_5' => 92.0,
                    'nilai_us' => [
                        'PAI' => 94, 'PPKN' => 90, 'BIND' => 92, 'MAT-W' => 91,
                        'BING' => 93, 'BIO' => 92, 'FIS' => 89, 'KIM' => 91
                    ],
                    'rata_us' => 91.5,
                    'nilai_akhir' => 91.8, // (0.60 * 92.0) + (0.40 * 91.5) = 55.2 + 36.6 = 91.8
                    'status_kelulusan' => 'LULUS',
                    'nomor_ijazah' => 'DN-02/M-SMA/K13/2025/0091823'
                ]
            ]
        ];
    }

    // =========================================================================
    // 5. AUDIT TRAIL REVISI NILAI (LOG_PERUBAHAN_NILAI PASCA BUKA KUNCI)
    // =========================================================================

    public static function getLogPerubahanNilai(): array
    {
        return [
            [
                'id' => 1,
                'siswa_id' => 5,
                'siswa_nama' => 'Aldi Kurniawan',
                'siswa_nis' => '242510005',
                'kelas' => 'XI-MIPA-1',
                'mapel' => 'Biologi',
                'komponen' => 'Praktik (Keterampilan)',
                'nilai_sebelum' => 68.0,
                'nilai_sesudah' => 78.0,
                'diubah_oleh' => 'Ustadzah Siti Nurhaliza, S.Pd.',
                'alasan' => 'Koreksi kekeliruan input lembar kerja praktikum jaringan tumbuhan',
                'disetujui_oleh' => 'Drs. H. Ahmad Fauzi, M.Pd. (Kepala Sekolah)',
                'waktu_perubahan' => '2025-12-20 11:30:15'
            ],
            [
                'id' => 2,
                'siswa_id' => 3,
                'siswa_nama' => 'Fadhil Ahmad Al-Ghifari',
                'siswa_nis' => '242510003',
                'kelas' => 'XI-MIPA-1',
                'mapel' => 'Matematika (Wajib)',
                'komponen' => 'Tugas & Kuis (Pengetahuan)',
                'nilai_sebelum' => 75.0,
                'nilai_sesudah' => 82.0,
                'diubah_oleh' => 'Ustadz Hendra Gunawan, M.Pd.',
                'alasan' => 'Susulan penilaian tugas proyek terapan matriks yang sempat terlewat verifikasi',
                'disetujui_oleh' => 'Drs. H. Ahmad Fauzi, M.Pd. (Kepala Sekolah)',
                'waktu_perubahan' => '2025-12-19 16:45:00'
            ]
        ];
    }

    // =========================================================================
    // 6. TRANSKRIP NILAI KUMULATIF 6 SEMESTER
    // =========================================================================

    public static function getTranskripLengkapSiswa($siswa_id = 1): array
    {
        $siswaList = self::getSiswaList();
        $siswa = $siswaList[0];
        foreach ($siswaList as $s) {
            if ($s['id'] == $siswa_id) {
                $siswa = $s;
                break;
            }
        }

        return [
            'siswa' => $siswa,
            'sekolah' => self::getSekolah(),
            'semesters' => [
                ['tingkat' => 'Kelas X', 'semester' => 1, 'tahun_ajaran' => '2024/2025', 'kelas' => 'X-MIPA-1', 'rata_rata' => 89.4, 'predikat' => 'A', 'peringkat' => 2, 'ranking' => 2, 'status_kenaikan' => 'Tuntas'],
                ['tingkat' => 'Kelas X', 'semester' => 2, 'tahun_ajaran' => '2024/2025', 'kelas' => 'X-MIPA-1', 'rata_rata' => 90.2, 'predikat' => 'A', 'peringkat' => 2, 'ranking' => 2, 'status_kenaikan' => 'Naik ke Kelas XI'],
                ['tingkat' => 'Kelas XI', 'semester' => 3, 'tahun_ajaran' => '2025/2026', 'kelas' => 'XI-MIPA-1', 'rata_rata' => 91.2, 'predikat' => 'A', 'peringkat' => 1, 'ranking' => 1, 'status_kenaikan' => 'Tuntas'],
                ['tingkat' => 'Kelas XI', 'semester' => 4, 'tahun_ajaran' => '2025/2026', 'kelas' => 'XI-MIPA-1', 'rata_rata' => 92.0, 'predikat' => 'A', 'peringkat' => 1, 'ranking' => 1, 'status_kenaikan' => 'Sedang Berjalan'],
                ['tingkat' => 'Kelas XII', 'semester' => 5, 'tahun_ajaran' => '2026/2027', 'kelas' => 'XII-MIPA-1', 'rata_rata' => 93.1, 'predikat' => 'A', 'peringkat' => 1, 'ranking' => 1, 'status_kenaikan' => 'Rencana Kenaikan'],
                ['tingkat' => 'Kelas XII', 'semester' => 6, 'tahun_ajaran' => '2026/2027', 'kelas' => 'XII-MIPA-1', 'rata_rata' => 93.5, 'predikat' => 'A', 'peringkat' => 1, 'ranking' => 1, 'status_kenaikan' => 'Lulus Satuan Pendidikan'],
            ],
            'mata_pelajaran' => [
                ['kode' => 'PAI', 'nama' => 'Pendidikan Agama Islam', 'nilai_rata' => 91.5, 'predikat' => 'A'],
                ['kode' => 'PPKN', 'nama' => 'Pendidikan Pancasila & Kewarganegaraan', 'nilai_rata' => 88.0, 'predikat' => 'B'],
                ['kode' => 'BIND', 'nama' => 'Bahasa Indonesia', 'nilai_rata' => 90.0, 'predikat' => 'A'],
                ['kode' => 'MAT-W', 'nama' => 'Matematika (Wajib)', 'nilai_rata' => 94.0, 'predikat' => 'A'],
                ['kode' => 'SEJ', 'nama' => 'Sejarah Indonesia', 'nilai_rata' => 86.5, 'predikat' => 'B'],
                ['kode' => 'BING', 'nama' => 'Bahasa Inggris', 'nilai_rata' => 91.0, 'predikat' => 'A'],
                ['kode' => 'MAT-P', 'nama' => 'Matematika Peminatan', 'nilai_rata' => 95.0, 'predikat' => 'A'],
                ['kode' => 'BIO', 'nama' => 'Biologi', 'nilai_rata' => 90.5, 'predikat' => 'A'],
                ['kode' => 'FIS', 'nama' => 'Fisika', 'nilai_rata' => 89.0, 'predikat' => 'B'],
                ['kode' => 'KIM', 'nama' => 'Kimia', 'nilai_rata' => 92.0, 'predikat' => 'A'],
            ],
            'rata_rata_kumulatif' => 91.5,
            'predikat_kumulatif' => 'A (Sangat Baik)',
            'total_jam_pelajaran' => 192,
        ];
    }
}


