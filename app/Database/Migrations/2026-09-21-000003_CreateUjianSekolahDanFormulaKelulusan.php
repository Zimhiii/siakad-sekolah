<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUjianSekolahDanFormulaKelulusan extends Migration
{
    public function up()
    {
        // 1. Tabel Formula Kelulusan
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tahun_ajaran_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'bobot_rapor' => [
                'type'       => 'INT',
                'constraint' => 3,
                'default'    => 60,
            ],
            'bobot_us' => [
                'type'       => 'INT',
                'constraint' => 3,
                'default'    => 40,
            ],
            'jumlah_semester_raport' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
                'default'    => 6, // 5 semester (Ganjil Kls 12) atau 6 semester (Genap Kls 12)
            ],
            'kkm_kelulusan' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 75.00,
            ],
            'status_aktif' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'keterangan' => [
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
        $this->forge->addKey('tahun_ajaran_id');
        $this->forge->createTable('formula_kelulusan', true);

        // 2. Tabel Nilai Ujian Sekolah (US)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'siswa_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'mapel_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tahun_ajaran_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nilai_teori' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0.00,
            ],
            'nilai_praktik' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
            ],
            'nilai_akhir_us' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0.00,
            ],
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->addKey(['siswa_id', 'mapel_id', 'tahun_ajaran_id']);
        $this->forge->createTable('ujian_sekolah', true);
    }

    public function down()
    {
        $this->forge->dropTable('ujian_sekolah', true);
        $this->forge->dropTable('formula_kelulusan', true);
    }
}
