<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSnapshotPenugasanDanStatusPleno extends Migration
{
    public function up()
    {
        // 1. Snapshot KKM & Bobot pada Penugasan / Penilaian
        // Membuat tabel penugasan jika belum ada, atau menambahkan kolom snapshot
        if (!$this->db->tableExists('penugasan')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'pengajaran_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'judul' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'kategori_penilaian' => [
                    'type'       => 'ENUM',
                    'constraint' => ['tugas', 'uh', 'uts', 'uas', 'praktik', 'proyek'],
                    'default'    => 'tugas',
                ],
                'kkm_snapshot' => [
                    'type'       => 'DECIMAL',
                    'constraint' => '5,2',
                    'default'    => 75.00,
                ],
                'bobot_snapshot' => [
                    'type'       => 'DECIMAL',
                    'constraint' => '5,2',
                    'default'    => 20.00,
                ],
                'tanggal_penugasan' => [
                    'type' => 'DATE',
                    'null' => true,
                ],
                'tenggat_waktu' => [
                    'type' => 'DATE',
                    'null' => true,
                ],
                'deskripsi' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addKey('pengajaran_id');
            $this->forge->createTable('penugasan', true);
        } else {
            $fields = [
                'kkm_snapshot' => [
                    'type'       => 'DECIMAL',
                    'constraint' => '5,2',
                    'default'    => 75.00,
                    'after'      => 'judul'
                ],
                'bobot_snapshot' => [
                    'type'       => 'DECIMAL',
                    'constraint' => '5,2',
                    'default'    => 20.00,
                    'after'      => 'kkm_snapshot'
                ],
                'kategori_penilaian' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'default'    => 'tugas',
                    'after'      => 'bobot_snapshot'
                ],
            ];
            $this->forge->addColumn('penugasan', $fields);
        }

        // 2. Status Pleno pada Tabel Rombel Kelas
        if ($this->db->tableExists('kelas')) {
            $kelasFields = [
                'status_pleno' => [
                    'type'       => 'ENUM',
                    'constraint' => ['belum_mulai', 'sedang_berlangsung', 'selesai'],
                    'default'    => 'belum_mulai',
                ],
                'tanggal_pleno' => [
                    'type' => 'DATE',
                    'null' => true,
                ],
                'pengesah_pleno' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
            ];
            $this->forge->addColumn('kelas', $kelasFields);
        }
    }

    public function down()
    {
        if ($this->db->tableExists('penugasan')) {
            $this->forge->dropColumn('penugasan', ['kkm_snapshot', 'bobot_snapshot', 'kategori_penilaian']);
        }
        if ($this->db->tableExists('kelas')) {
            $this->forge->dropColumn('kelas', ['status_pleno', 'tanggal_pleno', 'pengesah_pleno']);
        }
    }
}
