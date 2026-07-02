@extends('layouts.app')

@section('title', 'Kelas')

@section('content')

    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Master Data — Kelas</h2>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                    Tambah Kelas
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
                        <th>Kelas</th>
                        <th>Wali Kelas</th>
                        <th class="w-1"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kelas as $k)
                        <tr>
                            <td>{{ $k->tahunAjaran->nama }}</td>
                            <td>{{ $k->nama_lengkap }}</td>
                            <td>{{ $k->waliKelas->name ?? '-' }}</td>
                            <td class="d-flex gap-1">
    <a href="{{ route('presensi.qr.tampilkan', $k->id) }}" class="btn btn-sm btn-outline-success" target="_blank">
        Tampilkan QR
    </a>
    <a href="{{ route('master.kelas.kelola-siswa', $k->id) }}" class="btn btn-sm btn-outline-primary">
        Kelola Siswa
    </a>
    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $k->id }}">
        Edit Wali Kelas
    </button>
    <form action="{{ route('master.kelas.destroy', $k->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus kelas {{ $k->nama_lengkap }}?')">
            Hapus
        </button>
    </form>
</td>
                        </tr>

                        {{-- Modal Edit Wali Kelas --}}
                        <div class="modal modal-blur fade" id="modal-edit-{{ $k->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('master.kelas.update', $k->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Wali Kelas — {{ $k->nama_lengkap }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Wali Kelas</label>
                                                <select name="wali_kelas_id" class="form-select">
                                                    <option value="">-- Tidak Ada --</option>
                                                    @foreach ($guru as $g)
                                                        <option value="{{ $g->id }}" {{ $k->wali_kelas_id == $g->id ? 'selected' : '' }}>
                                                            {{ $g->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
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

                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-secondary">Belum ada kelas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah Kelas --}}
    <div class="modal modal-blur fade" id="modal-tambah" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('master.kelas.store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kelas</h5>
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
                            <label class="form-label">Tingkat</label>
                            <select name="tingkat" class="form-select @error('tingkat') is-invalid @enderror">
                                <option value="">-- Pilih Tingkat --</option>
                                <option value="X" {{ old('tingkat') == 'X' ? 'selected' : '' }}>X</option>
                                <option value="XI" {{ old('tingkat') == 'XI' ? 'selected' : '' }}>XI</option>
                                <option value="XII" {{ old('tingkat') == 'XII' ? 'selected' : '' }}>XII</option>
                            </select>
                            @error('tingkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jurusan</label>
                            <select name="jurusan" class="form-select @error('jurusan') is-invalid @enderror">
                                <option value="">-- Pilih Jurusan --</option>
                                <option value="IPA" {{ old('jurusan') == 'IPA' ? 'selected' : '' }}>IPA</option>
                                <option value="IPS" {{ old('jurusan') == 'IPS' ? 'selected' : '' }}>IPS</option>
                            </select>
                            @error('jurusan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor Kelas</label>
                            <input type="number" name="nomor" class="form-control @error('nomor') is-invalid @enderror" min="1" max="20" placeholder="contoh: 1" value="{{ old('nomor') }}">
                            @error('nomor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Wali Kelas <span class="text-secondary">(opsional)</span></label>
                            <select name="wali_kelas_id" class="form-select @error('wali_kelas_id') is-invalid @enderror">
                                <option value="">-- Tidak Ada --</option>
                                @foreach ($guru as $g)
                                    <option value="{{ $g->id }}" {{ old('wali_kelas_id') == $g->id ? 'selected' : '' }}>
                                        {{ $g->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('wali_kelas_id')
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