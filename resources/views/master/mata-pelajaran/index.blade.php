@extends('layouts.app')

@section('title', 'Mata Pelajaran')

@section('content')

    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Master Data — Mata Pelajaran</h2>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                    Tambah Mata Pelajaran
                </button>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Mata Pelajaran</th>
                        <th class="w-1"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mataPelajaran as $mapel)
                        <tr>
                            <td>{{ $mapel->kode }}</td>
                            <td>{{ $mapel->nama }}</td>
                            <td class="d-flex gap-1">
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $mapel->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('master.mata-pelajaran.destroy', $mapel->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus mata pelajaran ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- Modal Edit per baris --}}
                        <div class="modal modal-blur fade" id="modal-edit-{{ $mapel->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('master.mata-pelajaran.update', $mapel->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Mata Pelajaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Kode</label>
                                                <input type="text" name="kode" class="form-control" value="{{ $mapel->kode }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nama Mata Pelajaran</label>
                                                <input type="text" name="nama" class="form-control" value="{{ $mapel->nama }}">
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
                            <td colspan="3" class="text-center text-secondary">Belum ada mata pelajaran.</td>
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
                <form action="{{ route('master.mata-pelajaran.store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Mata Pelajaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kode</label>
                            <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" placeholder="contoh: MTK" value="{{ old('kode') }}">
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Mata Pelajaran</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="contoh: Matematika" value="{{ old('nama') }}">
                            @error('nama')
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