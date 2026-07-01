<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenugasanGuru extends Model
{
    protected $table = 'penugasan_guru';

    protected $fillable = [
        'semester_id',
        'guru_id',
        'mata_pelajaran_id',
        'kelas_id',
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}