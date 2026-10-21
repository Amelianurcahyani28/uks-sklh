<?php

namespace Database\Seeders;

use App\Models\Petugas;
use App\Models\PetugasJadwal;
use Illuminate\Database\Seeder;

class PetugasJadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siti = Petugas::where('name', 'like', '%Siti%')->first();
        $fauzi = Petugas::where('name', 'like', '%Fauzi%')->first();
        $nurjanah = Petugas::where('name', 'like', '%Nurjanah%')->first();
        $rian = Petugas::where('name', 'like', '%Rian%')->first();
        $maya = Petugas::where('name', 'like', '%Maya%')->first();

        // Fallback jika belum di-seed
        if (! $siti || ! $fauzi || ! $maya) {
            $this->call(PetugasSeeder::class);
            $siti = Petugas::where('name', 'like', '%Siti%')->first();
            $fauzi = Petugas::where('name', 'like', '%Fauzi%')->first();
            $nurjanah = Petugas::where('name', 'like', '%Nurjanah%')->first();
            $rian = Petugas::where('name', 'like', '%Rian%')->first();
            $maya = Petugas::where('name', 'like', '%Maya%')->first();
        }

        $jadwals = [
            // Senin (1)
            [
                'day' => 'Senin',
                'day_number' => 1,
                'petugas_id' => $siti?->id,
                'shift_time' => '07:30 - 15:30 WIB',
                'room' => 'Ruang UKS Utama',
                'notes' => 'Pemeriksaan Medis, Anamnesa & Tensi Darah Siswa',
                'status' => 'aktif',
            ],
            // Selasa (2)
            [
                'day' => 'Selasa',
                'day_number' => 2,
                'petugas_id' => $fauzi?->id,
                'shift_time' => '07:30 - 15:30 WIB',
                'room' => 'Ruang UKS Utama',
                'notes' => 'Penanganan P3K, Perawatan Cedera Ringan & Logistik Obat',
                'status' => 'aktif',
            ],
            // Rabu (3)
            [
                'day' => 'Rabu',
                'day_number' => 3,
                'petugas_id' => $nurjanah?->id,
                'shift_time' => '08:00 - 14:00 WIB',
                'room' => 'Ruang UKS Utama',
                'notes' => 'Pembinaan PHBS, Konseling Kesehatan & Edukasi Siswa',
                'status' => 'aktif',
            ],
            // Kamis (4)
            [
                'day' => 'Kamis',
                'day_number' => 4,
                'petugas_id' => $rian?->id,
                'shift_time' => '09:30 - 14:30 WIB',
                'room' => 'Ruang UKS Utama',
                'notes' => 'Siaga Relawan PMR, Pendampingan Siswa Sakit & Observasi',
                'status' => 'aktif',
            ],
            // Jumat (5)
            [
                'day' => 'Jumat',
                'day_number' => 5,
                'petugas_id' => $maya?->id,
                'shift_time' => '07:30 - 14:30 WIB',
                'room' => 'Ruang UKS Utama',
                'notes' => 'Pemeriksaan Rutin, Konseling & Rekapitulasi Medis Mingguan',
                'status' => 'aktif',
            ],
        ];

        foreach ($jadwals as $item) {
            if ($item['petugas_id']) {
                PetugasJadwal::updateOrCreate(
                    [
                        'day_number' => $item['day_number'],
                        'petugas_id' => $item['petugas_id'],
                    ],
                    $item
                );
            }
        }
    }
}
