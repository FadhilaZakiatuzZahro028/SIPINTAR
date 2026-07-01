@extends('layouts.app')

@section('title', 'Tahun Ajaran & Semester')

@section('content')

    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Master Data — Tahun Ajaran & Semester
                </h2>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah-tahun-ajaran">
                    Tambah Tahun Ajaran
                </button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah-semester">
                    Tambah Semester
                </button>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Tahun Ajaran</th>
                        <th>Periode</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th class="w-1"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tahunAjaran as $ta)
                        @forelse ($ta->semesters as $semester)
                            <tr>
    <td>{{ $ta->nama }}</td>
    <td>{{ $ta->tanggal_mulai }} s/d {{ $ta->tanggal_selesai }}</td>
    <td>{{ $semester->nama }}</td>
    <td>
        @if ($semester->is_aktif)
            <span class="badge bg-green">Aktif</span>
        @else
            <span class="badge bg-secondary-lt">Tidak Aktif</span>
        @endif
    </td>
    <td>
        @if (!$semester->is_aktif)
            <form action="{{ route('master.semester.aktifkan', $semester->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-sm btn-success">
                    Aktifkan
                </button>
            </form>
        @endif
    </td>
</tr>
                        @empty
                            <tr>
                                <td>{{ $ta->nama }}</td>
                                <td>{{ $ta->tanggal_mulai }} s/d {{ $ta->tanggal_selesai }}</td>
                                <td colspan="3" class="text-secondary">Belum ada semester</td>
                            </tr>
                        @endforelse
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-secondary">Belum ada data tahun ajaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal: Tambah Tahun Ajaran --}}
    <div class="modal modal-blur fade" id="modal-tambah-tahun-ajaran" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('master.tahun-ajaran.store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Tahun Ajaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Tahun Ajaran</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="contoh: 2025/2026" value="{{ old('nama') }}">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai') }}">
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai') }}">
                            @error('tanggal_selesai')
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

    {{-- Modal: Tambah Semester --}}
    <div class="modal modal-blur fade" id="modal-tambah-semester" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('master.semester.store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Semester</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tahun Ajaran</label>
                            <select name="tahun_ajaran_id" class="form-select @error('tahun_ajaran_id') is-invalid @enderror">
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                @foreach ($tahunAjaran as $ta)
                                    <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tahun_ajaran_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Semester</label>
                            <select name="nama" class="form-select @error('nama') is-invalid @enderror">
                                <option value="">-- Pilih Semester --</option>
                                <option value="Ganjil" {{ old('nama') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ old('nama') == 'Genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai') }}">
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai') }}">
                            @error('tanggal_selesai')
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