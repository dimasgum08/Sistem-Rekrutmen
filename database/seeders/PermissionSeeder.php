<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = collect([
            # Dashboard Permissions
            ['name' => 'read-dashboard', 'display_name' => 'Baca Dashboard'],

            # User Permissions
            ['name' => 'read-users', 'display_name' => 'Baca Pengguna'],
            ['name' => 'create-users', 'display_name' => 'Buat Pengguna'],
            ['name' => 'update-users', 'display_name' => 'Ubah Pengguna'],
            ['name' => 'delete-users', 'display_name' => 'Hapus Pengguna'],

            # Role Permissions
            ['name' => 'read-roles', 'display_name' => 'Baca Peran'],
            ['name' => 'change-roles', 'display_name' => 'Ubah Hak Akses'],

            # Applicant
            ['name' => 'read-applicant', 'display_name' => 'Baca Pelamar'],
            ['name' => 'create-applicant', 'display_name' => 'Buat Pelamar'],
            ['name' => 'update-applicant', 'display_name' => 'Ubah Pelamar'],
            ['name' => 'delete-applicant', 'display_name' => 'Hapus Pelamar'],

            # Vacancies
            ['name' => 'read-vacancies', 'display_name' => 'Baca Lowongan'],
            ['name' => 'create-vacancies', 'display_name' => 'Buat Lowongan'],
            ['name' => 'update-vacancies', 'display_name' => 'Ubah Lowongan'],
            ['name' => 'delete-vacancies', 'display_name' => 'Hapus Lowongan'],

            # Criteria
            ['name' => 'read-criteria', 'display_name' => 'Baca Kriteria'],
            ['name' => 'create-criteria', 'display_name' => 'Buat Kriteria'],
            ['name' => 'update-criteria', 'display_name' => 'Ubah Kriteria'],
            ['name' => 'delete-criteria', 'display_name' => 'Hapus Kriteria'],

            # Documents
            ['name' => 'read-documents', 'display_name' => 'Baca Berkas'],
            ['name' => 'create-documents', 'display_name' => 'Unggah Berkas'],
            ['name' => 'update-documents', 'display_name' => 'Ubah Berkas'],
            ['name' => 'delete-documents', 'display_name' => 'Hapus Berkas'],

            # Interview Schedules
            ['name' => 'read-interviews', 'display_name' => 'Lihat Jadwal Wawancara'],
            ['name' => 'create-interviews', 'display_name' => 'Buat Jadwal Wawancara'],
            ['name' => 'update-interviews', 'display_name' => 'Ubah Jadwal Wawancara'],
            ['name' => 'delete-interviews', 'display_name' => 'Hapus Jadwal Wawancara'],
        ]);

        $this->insertPermissions($permissions, 'web');
    }

    private function insertPermissions($permissions, $guard = 'web') {
        Permission::insert($permissions->map(function($item) use ($guard) {
            return [
                'name' => $item['name'],
                'display_name' => $item['display_name'],
                'guard_name' => $guard,
                'created_at' => now(),
                'updated_at' => now()
            ];
        })->toArray());
    }
}
