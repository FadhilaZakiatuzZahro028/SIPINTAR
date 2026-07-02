<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\QrPresensi;
use App\Models\PengaturanSekolah;
use Illuminate\Http\Request;

class PresensiPublikController extends Controller
{
    public function tampilkan(string $token)
    {
        $qr = QrPresensi::where('token', $token)->first();

        if (!$qr || $qr->isKadaluarsa()) {
            return view('presensi.scan-invalid');
        }

        $kelas = $qr->kelas;

        $daftarSiswa = $kelas->siswaKelas()->with('siswa')->get()->pluck('siswa');

        return view('presensi.scan', compact('qr', 'kelas', 'daftarSiswa', 'token'));
    }

    public function simpan(Request $request, string $token)
    {
        $qr = QrPresensi::where('token', $token)->first();

        if (!$qr || $qr->isKadaluarsa()) {
            return view('presensi.scan-invalid');
        }

        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        if (Presensi::sudahPresensiHariIni($validated['siswa_id'])) {
            return back()->withErrors(['siswa_id' => 'Kamu sudah presensi hari ini.']);
        }

        $sekolah = PengaturanSekolah::ambil();

        $jarak = $this->hitungJarakMeter(
            $validated['latitude'],
            $validated['longitude'],
            $sekolah->latitude,
            $sekolah->longitude
        );

        if ($jarak > $sekolah->radius_meter) {
            return back()->withErrors([
                'siswa_id' => 'Lokasi kamu berada di luar radius sekolah (' . round($jarak) . ' meter dari titik sekolah). Presensi ditolak.'
            ]);
        }

        Presensi::create([
            'siswa_id' => $validated['siswa_id'],
            'kelas_id' => $qr->kelas_id,
            'tanggal' => now()->toDateString(),
            'status' => 'Hadir',
            'waktu' => now(),
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        return view('presensi.scan-sukses');
    }

    private function hitungJarakMeter($lat1, $lon1, $lat2, $lon2): float
    {
        $radiusBumi = 6371000; // meter

        $lat1Rad = deg2rad($lat1);
        $lat2Rad = deg2rad($lat2);
        $deltaLat = deg2rad($lat2 - $lat1);
        $deltaLon = deg2rad($lon2 - $lon1);

        $a = sin($deltaLat / 2) ** 2 +
             cos($lat1Rad) * cos($lat2Rad) *
             sin($deltaLon / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $radiusBumi * $c;
    }
}