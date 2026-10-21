<?php

namespace Database\Seeders;

use App\Models\Petugas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetugasSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $petugasList = [
            [
                'name' => 'Ns. Siti Rahmawati, S.Kep',
                'role_title' => 'Koordinator & Tenaga Medis UKS',
                'gender' => 'P',
                'phone' => '0812-3456-7890',
                'schedule' => 'Senin (07:30 - 15:30 WIB)',
                'status' => 'aktif',
                'bio' => 'Bertanggung jawab atas operasional medis harian, penanganan darurat, dan koordinasi rujukan fasilitas kesehatan.',
            ],
            [
                'name' => 'Ahmad Fauzi, A.Md.Kep',
                'role_title' => 'Petugas Medis & P3K',
                'gender' => 'L',
                'phone' => '0857-1234-9876',
                'schedule' => 'Selasa (07:30 - 15:30 WIB)',
                'status' => 'aktif',
                'bio' => 'Siaga penanganan pertolongan pertama (P3K), pengelolaan logistik obat dasar, dan observasi siswa sakit di ruang UKS.',
            ],
            [
                'name' => 'Dra. Hj. Nurjanah, M.Pd',
                'role_title' => 'Pembina UKS & PMR',
                'gender' => 'P',
                'phone' => '0813-9876-5432',
                'schedule' => 'Rabu (08:00 - 14:00 WIB)',
                'status' => 'aktif',
                'bio' => 'Pembimbing program kesehatan sekolah dan koordinator pembinaan ekstrakurikuler Palang Merah Remaja (PMR).',
            ],
            [
                'name' => 'Rian Pratama',
                'role_title' => 'Ketua Tim Relawan PMR Siswa',
                'gender' => 'L',
                'phone' => '0896-5432-1098',
                'schedule' => 'Kamis (09:30 - 14:30 WIB)',
                'status' => 'aktif',
                'bio' => 'Koordinator relawan siswa PMR Wira SMKN 1 Ciomas yang siaga membantu operasional dan pendampingan siswa di ruang UKS.',
            ],
            [
                'name' => 'Maya Anggraeni, S.Kep',
                'role_title' => 'Petugas Medis & Konseling UKS',
                'gender' => 'P',
                'phone' => '0821-8765-4321',
                'schedule' => 'Jumat (07:30 - 14:30 WIB)',
                'status' => 'aktif',
                'bio' => 'Pelayanan medis umum, edukasi kesehatan reproduksi, serta konseling psikososial siswa sakit.',
            ],
        ];

        foreach ($petugasList as $item) {
            Petugas::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
