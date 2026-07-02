<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensi';

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tanggal',
        'status',
        'waktu',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu' => 'datetime',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public static function sudahPresensiHariIni(int $siswaId): bool
    {
        return static::where('siswa_id', $siswaId)
            ->whereDate('tanggal', now()->toDateString())
            ->exists();
    }
}