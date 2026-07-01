<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mataPelajaran = MataPelajaran::orderBy('nama')->get();

        return view('master.mata-pelajaran.index', compact('mataPelajaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:mata_pelajaran,kode',
            'nama' => 'required|string|max:100',
        ]);

        MataPelajaran::create($validated);

        return back()->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $validated = $request->validate([
            'kode' => [
                'required',
                'string',
                'max:10',
                Rule::unique('mata_pelajaran', 'kode')->ignore($mataPelajaran->id),
            ],
            'nama' => 'required|string|max:100',
        ]);

        $mataPelajaran->update($validated);

        return back()->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->delete();

        return back()->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}