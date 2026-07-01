@extends('layouts.app')

@section('title', 'Penugasan Guru')

@section('content')

    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Master Data — Penugasan Guru</h2>
                @if ($semesterAktif)
                    <div class="text-secondary mt-1">
                        Semester aktif: {{ $semesterAktif->nama }} {{ $semesterAktif->tahunAjaran->nama }}
                    </div>
                @else
                    <div class="text-danger mt-1">Belum ada semester aktif. Aktifkan semester terlebih dahulu.</div>
                @endif
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                    Tambah Penugasan
                </button>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Guru</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th class="w-1"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penugasan as $p)
                        <tr>
                            <td>{{ $p->guru->name }}</td>
                            <td>{{ $p->mataPelajaran->nama }}</td>
                            <td>{{ $p->kelas->nama_lengkap }}</td>
                            <td>
                                <form action="{{ route('master.penugasan-guru.destroy', $p->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus penugasan ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-secondary">
                                Belum ada penugasan untuk semester ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal modal-blur fade" id="modal-tambah" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('master.penugasan-guru.store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Penugasan Guru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Semester</label>
                            <select name="semester_id" class="form-select @error('semester_id') is-invalid @enderror">
                                <option value="">-- Pilih Semester --</option>
                                @foreach ($semester as $sm)
                                    <option value="{{ $sm->id }}"
                                        {{ old('semester_id', $semesterAktif?->id) == $sm->id ? 'selected' : '' }}>
                                        {{ $sm->nama }} {{ $sm->tahunAjaran->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('semester_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Guru</label>
                            <select name="guru_id" class="form-select @error('guru_id') is-invalid @enderror">
                                <option value="">-- Pilih Guru --</option>
                                @foreach ($guru as $g)
                                    <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>
                                        {{ $g->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('guru_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mata Pelajaran</label>
                            <select name="mata_pelajaran_id" class="form-select @error('mata_pelajaran_id') is-invalid @enderror">
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                @foreach ($mataPelajaran as $mp)
                                    <option value="{{ $mp->id }}" {{ old('mata_pelajaran_id') == $mp->id ? 'selected' : '' }}>
                                        {{ $mp->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mata_pelajaran_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <select name="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary ms-auto">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection