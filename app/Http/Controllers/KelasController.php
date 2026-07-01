<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['tahunAjaran', 'waliKelas'])
            ->orderBy('tahun_ajaran_id', 'desc')
            ->orderBy('tingkat')
            ->orderBy('jurusan')
            ->orderBy('nomor')
            ->get();

        $tahunAjaran = TahunAjaran::orderBy('nama')->get();
        $guru = User::whereIn('role', ['guru', 'guru_bk'])->orderBy('name')->get();

        return view('master.kelas.index', compact('kelas', 'tahunAjaran', 'guru'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan' => 'required|in:IPA,IPS',
            'nomor' => 'required|integer|min:1|max:20',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);

        // Cek duplikat
        $exists = Kelas::where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
            ->where('tingkat', $validated['tingkat'])
            ->where('jurusan', $validated['jurusan'])
            ->where('nomor', $validated['nomor'])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'nomor' => 'Kelas ' . $validated['tingkat'] . '-' . $validated['jurusan'] . '-' . $validated['nomor'] . ' sudah ada di tahun ajaran ini.'
            ])->withInput();
        }

        Kelas::create($validated);

        return back()->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function update(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);

        $kelas->update($validated);

        return back()->with('success', 'Wali kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();

        return back()->with('success', 'Kelas berhasil dihapus.');
    }
}