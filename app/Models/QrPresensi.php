<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class QrPresensi extends Model
{
    protected $table = 'qr_presensi';

    protected $fillable = [
        'kelas_id',
        'tanggal',
        'token',
        'kadaluarsa_pada',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'kadaluarsa_pada' => 'datetime',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function isKadaluarsa(): bool
    {
        return $this->kadaluarsa_pada->isPast();
    }

    public static function ambilAtauBuat(int $kelasId): self
    {
        $tokenAktif = static::where('kelas_id', $kelasId)
            ->where('tanggal', Carbon::today())
            ->where('kadaluarsa_pada', '>', now())
            ->latest()
            ->first();

        if ($tokenAktif) {
            return $tokenAktif;
        }

        return static::create([
            'kelas_id' => $kelasId,
            'tanggal' => Carbon::today(),
            'token' => Str::random(48),
            'kadaluarsa_pada' => now()->addMinutes(30),
        ]);
    }
}