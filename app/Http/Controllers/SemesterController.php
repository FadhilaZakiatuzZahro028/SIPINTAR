<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SemesterController extends Controller
{
    public function index()
    {
        $tahunAjaran = TahunAjaran::with('semesters')->latest()->get();

        return view('master.semester.index', compact('tahunAjaran'));
    }

    public function storeTahunAjaran(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:20|unique:tahun_ajaran,nama',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ]);

        TahunAjaran::create($validated);

        return back()->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function storeSemester(Request $request)
{
    $validated = $request->validate([
        'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        'nama' => [
            'required',
            'in:Ganjil,Genap',
            Rule::unique('semester')->where(function ($query) use ($request) {
                return $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
            }),
        ],
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after:tanggal_mulai',
    ]);

    Semester::create($validated);

    return back()->with('success', 'Semester berhasil ditambahkan.');
}


public function aktifkan(Semester $semester)
{
    $semester->jadikanAktif();

    return back()->with('success', "Semester {$semester->nama} {$semester->tahunAjaran->nama} sekarang aktif.");
}


}