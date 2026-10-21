<?php

namespace App\Models;

use Database\Factories\PetugasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'role_title', 'gender', 'phone', 'schedule', 'status', 'bio', 'photo'])]
class Petugas extends Model
{
    /** @use HasFactory<PetugasFactory> */
    use HasFactory;

    /**
     * Nama tabel di database.
     *
     * @var string
     */
    protected $table = 'petugas';

    /**
     * Relasi ke jadwal piket petugas.
     */
    public function jadwals(): HasMany
    {
        return $this->hasMany(PetugasJadwal::class, 'petugas_id');
    }
}
