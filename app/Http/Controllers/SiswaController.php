<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::orderBy('nama')->get();

        return view('master.siswa.index', compact('siswa'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:siswa,nis',
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'nama_orang_tua' => 'nullable|string|max:100',
            'no_hp_orang_tua' => 'nullable|string|max:20',
        ]);

        Siswa::create($validated);

        return back()->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nis' => [
                'required',
                'string',
                'max:20',
                Rule::unique('siswa', 'nis')->ignore($siswa->id),
            ],
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'nama_orang_tua' => 'nullable|string|max:100',
            'no_hp_orang_tua' => 'nullable|string|max:20',
        ]);

        $siswa->update($validated);

        return back()->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return back()->with('success', 'Siswa berhasil dihapus.');
    }
}