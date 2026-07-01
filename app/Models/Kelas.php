<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'tahun_ajaran_id',
        'wali_kelas_id',
        'tingkat',
        'jurusan',
        'nomor',
    ];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    public function getNamaLengkapAttribute()
    {
        return "{$this->tingkat}-{$this->jurusan}-{$this->nomor}";
    }
}