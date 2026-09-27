<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuditLogPerubahanNilai extends Migration
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
            'siswa_nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'siswa_nis' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'mapel' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'komponen' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'nilai_sebelum' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'nilai_sesudah' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'diubah_oleh' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'alasan' => [
                'type' => 'TEXT',
            ],
            'disetujui_oleh' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['siswa_id', 'created_at']);
        $this->forge->createTable('audit_log_nilai', true);
    }

    public function down()
    {
        $this->forge->dropTable('audit_log_nilai', true);
    }
}
