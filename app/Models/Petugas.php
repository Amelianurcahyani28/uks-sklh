<?php

namespace App\Models;

use Database\Factories\PetugasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'role_title', 'class_name', 'major', 'gender', 'phone', 'schedule', 'status', 'bio', 'photo'])]
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
     * Boot model events untuk memastikan format nama kelas selalu terisi jurusan otomatis saat disimpan.
     */
    protected static function booted(): void
    {
        static::saving(function (Petugas $petugas): void {
            if (! empty($petugas->class_name) && ! empty($petugas->major)) {
                $petugas->class_name = static::formatClassNameWithMajor($petugas->class_name, $petugas->major);
            }
        });
    }

    /**
     * Relasi ke jadwal piket petugas.
     */
    public function jadwals(): HasMany
    {
        return $this->hasMany(PetugasJadwal::class, 'petugas_id');
    }

    /**
     * Accessor untuk mendapatkan nama kelas yang rapi dan otomatis disertai jurusan.
     */
    public function getFormattedClassNameAttribute(): ?string
    {
        return static::formatClassNameWithMajor($this->class_name, $this->major);
    }

    /**
     * Format nama kelas otomatis agar menyertakan jurusan jika belum ada (contoh: X 1 + BCF => X BCF 1, XI + BCF => XI BCF).
     */
    public static function formatClassNameWithMajor(?string $className, ?string $major): ?string
    {
        if (! $className) {
            return null;
        }

        $className = trim(preg_replace('/\s+/', ' ', $className));
        $major = $major ? trim($major) : null;

        if (! $major) {
            return $className;
        }

        // Jika kelas sudah mengandung jurusan ini secara tepat, kembalikan langsung
        if (preg_match('/\b'.preg_quote($major, '/').'\b/i', $className)) {
            return $className;
        }

        // Daftar singkatan jurusan umum di SMKN 1 Ciomas
        $knownMajors = ['PPLG', 'BCF', 'ANIM', 'ANIMASI', 'TO', 'TPFL'];
        $patternMajors = implode('|', $knownMajors);

        // Jika kelas mengandung jurusan lain yang lama, ganti dengan jurusan yang baru dipilih
        if (preg_match('/\b('.$patternMajors.')\b/i', $className)) {
            return preg_replace('/\b('.$patternMajors.')\b/i', strtoupper($major), $className);
        }

        // Cek pola standar kelas sekolah:
        // Level: X, XI, XII, 10, 11, 12, VII, VIII, IX, dll.
        // Bagian kedua (opsional): nomor rombel / angka seperti 1, 2, 3 atau I, II, III atau A, B
        if (preg_match('/^(?:kelas\s*)?(X{1,2}I{0,3}|I?X|V?I{1,3}|1[0-2]|[7-9])(?:[\s\-\.\/]*([0-9]+|[A-Za-z]+))?$/i', $className, $matches)) {
            $level = strtoupper($matches[1]);
            $levelMap = [
                '10' => 'X',
                '11' => 'XI',
                '12' => 'XII',
                '7' => 'VII',
                '8' => 'VIII',
                '9' => 'IX',
            ];
            if (isset($levelMap[$level])) {
                $level = $levelMap[$level];
            }

            $section = isset($matches[2]) && $matches[2] !== '' ? trim($matches[2]) : null;

            if ($section !== null) {
                return "{$level} {$major} {$section}";
            }

            return "{$level} {$major}";
        }

        return "{$className} {$major}";
    }
}
