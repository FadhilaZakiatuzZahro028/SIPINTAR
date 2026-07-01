@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')

    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Master Data — Siswa</h2>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                    Tambah Siswa
                </button>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Nama Orang Tua</th>
                        <th>No. HP Orang Tua</th>
                        <th class="w-1"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($siswa as $s)
                        <tr>
                            <td>{{ $s->nis }}</td>
                            <td>{{ $s->nama }}</td>
                            <td>{{ $s->jenis_kelamin_lengkap }}</td>
                            <td>{{ $s->nama_orang_tua ?? '-' }}</td>
                            <td>{{ $s->no_hp_orang_tua ?? '-' }}</td>
                            <td class="d-flex gap-1">
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $s->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('master.siswa.destroy', $s->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus siswa {{ $s->nama }}?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- Modal Edit per baris --}}
                        <div class="modal modal-blur fade" id="modal-edit-{{ $s->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('master.siswa.update', $s->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Siswa — {{ $s->nama }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">NIS</label>
                                                <input type="text" name="nis" class="form-control" value="{{ $s->nis }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nama</label>
                                                <input type="text" name="nama" class="form-control" value="{{ $s->nama }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-select">
                                                    <option value="L" {{ $s->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                    <option value="P" {{ $s->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Lahir</label>
                                                <input type="date" name="tanggal_lahir" class="form-control" value="{{ $s->tanggal_lahir?->format('Y-m-d') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Alamat</label>
                                                <textarea name="alamat" class="form-control" rows="2">{{ $s->alamat }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nama Orang Tua</label>
                                                <input type="text" name="nama_orang_tua" class="form-control" value="{{ $s->nama_orang_tua }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">No. HP Orang Tua</label>
                                                <input type="text" name="no_hp_orang_tua" class="form-control" value="{{ $s->no_hp_orang_tua }}">
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
                            <td colspan="6" class="text-center text-secondary">Belum ada data siswa.</td>
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
                <form action="{{ route('master.siswa.store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">NIS</label>
                            <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" placeholder="contoh: 12345" value="{{ old('nis') }}">
                            @error('nis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="contoh: Budi Santoso" value="{{ old('nama') }}">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir <span class="text-secondary">(opsional)</span></label>
                            <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}">
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat <span class="text-secondary">(opsional)</span></label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Orang Tua <span class="text-secondary">(opsional)</span></label>
                            <input type="text" name="nama_orang_tua" class="form-control @error('nama_orang_tua') is-invalid @enderror" value="{{ old('nama_orang_tua') }}">
                            @error('nama_orang_tua')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. HP Orang Tua <span class="text-secondary">(opsional)</span></label>
                            <input type="text" name="no_hp_orang_tua" class="form-control @error('no_hp_orang_tua') is-invalid @enderror" value="{{ old('no_hp_orang_tua') }}">
                            @error('no_hp_orang_tua')
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