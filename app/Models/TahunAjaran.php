<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';

    protected $fillable = [
        'nama',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    public function semesters()
{
    return $this->hasMany(Semester::class);
}

public function kelas()
{
    return $this->hasMany(Kelas::class);
}
}