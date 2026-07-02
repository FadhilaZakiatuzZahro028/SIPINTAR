<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'nama_orang_tua',
        'no_hp_orang_tua',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function getJenisKelaminLengkapAttribute()
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }
    public function siswaKelas()
{
    return $this->hasMany(SiswaKelas::class);
}
}