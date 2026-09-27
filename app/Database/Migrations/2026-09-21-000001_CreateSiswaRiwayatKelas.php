<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiswaRiwayatKelas extends Migration
{
    public function up()
    {
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
            'tahun_ajaran_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'semester' => [
                'type'       => 'ENUM',
                'constraint' => ['ganjil', 'genap'],
                'default'    => 'ganjil',
            ],
            'kelas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'wali_kelas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'status_siswa' => [
                'type'       => 'ENUM',
                'constraint' => ['aktif', 'naik', 'tinggal_kelas', 'mutasi_keluar', 'lulus', 'alumni'],
                'default'    => 'aktif',
            ],
            'urutan_absen' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => true,
            ],
            'rata_rata' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
            ],
            'ranking' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => true,
            ],
            'catatan' => [
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
        $this->forge->addKey(['siswa_id', 'tahun_ajaran_id', 'semester']);
        $this->forge->addKey('kelas_id');
        $this->forge->createTable('siswa_riwayat_kelas', true);
    }

    public function down()
    {
        $this->forge->dropTable('siswa_riwayat_kelas', true);
    }
}
