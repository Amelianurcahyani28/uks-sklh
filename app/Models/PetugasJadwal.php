<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['petugas_id', 'day', 'day_number', 'shift_time', 'room', 'notes', 'status'])]
class PetugasJadwal extends Model
{
    use HasFactory;

    protected $table = 'petugas_jadwals';

    /**
     * Relasi ke model Petugas UKS.
     */
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'petugas_id');
    }

    /**
     * Daftar hari piket sekolah (Senin - Jumat).
     *
     * @return array<int, string>
     */
    public static function daysList(): array
    {
        return [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
        ];
    }

    /**
     * Daftar seluruh nama hari dalam seminggu.
     *
     * @return array<int, string>
     */
    public static function allDaysList(): array
    {
        return [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];
    }
}
