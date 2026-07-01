<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semester';

    protected $fillable = [
        'tahun_ajaran_id',
        'nama',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public static function aktif()
{
    return static::where('is_aktif', true)->first();
}

public function jadikanAktif()
{
    static::where('is_aktif', true)->update(['is_aktif' => false]);
    $this->update(['is_aktif' => true]);
}
}