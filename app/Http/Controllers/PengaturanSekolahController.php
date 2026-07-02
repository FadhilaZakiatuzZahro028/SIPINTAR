<?php

namespace App\Http\Controllers;

use App\Models\PengaturanSekolah;
use Illuminate\Http\Request;

class PengaturanSekolahController extends Controller
{
    public function index()
{
    $pengaturan = PengaturanSekolah::ambil();

    return view('master.pengaturan-sekolah.index', compact('pengaturan'));
}

public function update(Request $request)
{
    $validated = $request->validate([
        'nama_sekolah' => 'nullable|string|max:255',
        'latitude' => 'required|numeric|between:-90,90',
        'longitude' => 'required|numeric|between:-180,180',
        'radius_meter' => 'required|integer|min:10|max:1000',
    ]);

    $pengaturan = PengaturanSekolah::ambil();
    $pengaturan->update($validated);

    return back()->with('success', 'Pengaturan lokasi sekolah berhasil disimpan.');
}
}