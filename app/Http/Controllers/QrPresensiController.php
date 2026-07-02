<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\QrPresensi;

class QrPresensiController extends Controller
{
    public function tampilkan(Kelas $kelas)
    {
        $qr = QrPresensi::ambilAtauBuat($kelas->id);

        $urlScan = url('/presensi/scan/' . $qr->token);
        $sisaDetik = now()->diffInSeconds($qr->kadaluarsa_pada, false);

        return view('presensi.qr', compact('kelas', 'qr', 'urlScan', 'sisaDetik'));
    }
}