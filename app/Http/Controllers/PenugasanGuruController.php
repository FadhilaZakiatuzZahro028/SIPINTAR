<?php

namespace App\Http\Controllers;

use App\Models\PenugasanGuru;
use App\Models\Semester;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class PenugasanGuruController extends Controller
{
    public function index()
    {
        $semesterAktif = Semester::aktif();

        $penugasan = PenugasanGuru::with(['guru', 'mataPelajaran', 'kelas'])
            ->where('semester_id', $semesterAktif?->id)
            ->orderBy('kelas_id')
            ->get();

        $semester = Semester::with('tahunAjaran')->orderBy('id', 'desc')->get();
        $guru = User::whereIn('role', ['guru', 'guru_bk'])->orderBy('name')->get();
        $mataPelajaran = MataPelajaran::orderBy('nama')->get();
        $kelas = Kelas::where('tahun_ajaran_id', $semesterAktif?->tahunAjaran?->id)
            ->orderBy('tingkat')
            ->orderBy('jurusan')
            ->orderBy('nomor')
            ->get();

        return view('master.penugasan-guru.index', compact(
            'penugasan', 'semesterAktif', 'semester', 'guru', 'mataPelajaran', 'kelas'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'semester_id' => 'required|exists:semester,id',
            'guru_id' => 'required|exists:users,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $exists = PenugasanGuru::where($validated)->exists();

        if ($exists) {
            return back()->withErrors([
                'guru_id' => 'Penugasan ini sudah ada.'
            ])->withInput();
        }

        PenugasanGuru::create($validated);

        return back()->with('success', 'Penugasan guru berhasil ditambahkan.');
    }

    public function destroy(PenugasanGuru $penugasanGuru)
    {
        $penugasanGuru->delete();

        return back()->with('success', 'Penugasan guru berhasil dihapus.');
    }
}