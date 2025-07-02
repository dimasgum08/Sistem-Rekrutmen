<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\JobVacancy;
use Carbon\Carbon;

class JobVacancySeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            'Frontend Developer',
            'Backend Developer',
            'UI/UX Designer',
            'DevOps Engineer',
            'Project Manager',
            'Mobile Developer',
            'Data Analyst',
            'System Administrator',
            'Digital Marketing Specialist',
            'Customer Support',
        ];

        $placements = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Remote'];

        $contents = [
            '<h5>Deskripsi Pekerjaan</h5>
            <p>Kami mencari seorang <strong>{position}</strong> yang handal untuk mendukung pengembangan sistem aplikasi yang handal dan efisien.</p>

            <h6>Tugas dan Tanggung Jawab</h6>
            <ul>
                <li>Melaksanakan pengembangan dan pemeliharaan aplikasi.</li>
                <li>Berkoordinasi dengan tim untuk mengidentifikasi kebutuhan sistem.</li>
                <li>Mengimplementasikan fitur baru dengan standar kode yang tinggi.</li>
                <li>Menjaga dokumentasi teknis yang baik.</li>
            </ul>

            <h6>Kualifikasi</h6>
            <ul>
                <li>Pendidikan minimal S1 Informatika/Teknik Komputer.</li>
                <li>Pengalaman kerja minimal 2 tahun di bidang terkait.</li>
                <li>Menguasai tools & teknologi sesuai posisi.</li>
                <li>Mampu bekerja secara tim dan mandiri.</li>
            </ul>

            <h6>Persyaratan Tambahan</h6>
            <ul>
                <li>Berpikir analitis dan detail.</li>
                <li>Kemampuan komunikasi yang baik.</li>
                <li>Siap bekerja dengan deadline.</li>
                <li>Memiliki portofolio proyek (jika ada).</li>
            </ul>',

            '<h5>Deskripsi Pekerjaan</h5>
            <p>Posisi <strong>{position}</strong> dibutuhkan untuk mendukung pengembangan sistem dan produk digital kami.</p>

            <h6>Tanggung Jawab</h6>
            <ul>
                <li>Membangun dan mengelola aplikasi berbasis web/mobile.</li>
                <li>Menganalisis kebutuhan pengguna dan menerapkannya ke dalam sistem.</li>
                <li>Melakukan integrasi API serta unit testing.</li>
                <li>Menangani bug dan perbaikan rutin.</li>
            </ul>

            <h6>Kualifikasi Minimum</h6>
            <ul>
                <li>Pendidikan minimal D3/S1.</li>
                <li>Pengalaman kerja minimal 1 tahun (Fresh Graduate dipertimbangkan).</li>
                <li>Terbiasa menggunakan Git, CI/CD tools.</li>
                <li>Memahami prinsip OOP dan MVC.</li>
            </ul>

            <h6>Catatan Khusus</h6>
            <ul>
                <li>Fleksibel untuk bekerja hybrid atau remote.</li>
                <li>Berorientasi pada solusi.</li>
                <li>Keinginan belajar tinggi.</li>
            </ul>',
        ];

        $data = [];

        for ($i = 1; $i <= 20; $i++) {
            $position = $positions[array_rand($positions)];
            $slug = Str::slug($position . " " . $i);
            $contentTemplate = $contents[array_rand($contents)];
            $content = str_replace('{position}', $position, $contentTemplate);

            $data[] = [
                'title' => $position,
                'slug' => $slug,
                'placement' => $placements[array_rand($placements)],
                'content' => $content,
                'date_posted' => Carbon::now()->subDays(rand(0, 20)),
                'deadline' => Carbon::now()->addDays(rand(-5, 15)),
                'is_posted' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        JobVacancy::insert($data);
    }
}
