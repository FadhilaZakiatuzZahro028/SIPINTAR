<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanSekolah extends Model
{
    protected $table = 'pengaturan_sekolah';

    protected $fillable = [
        'nama_sekolah',
        'latitude',
        'longitude',
        'radius_meter',
    ];

    public static function ambil()
{
    return static::first() ?? static::create([
        'nama_sekolah' => null,
        'latitude' => 0,
        'longitude' => 0,
        'radius_meter' => 100,
    ]);
}
}