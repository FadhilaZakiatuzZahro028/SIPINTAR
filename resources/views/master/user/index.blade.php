@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')

    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Master Data — Akun Guru</h2>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                    Tambah Akun Guru
                </button>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIP</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="w-1"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $u)
                        <tr>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->nip ?? '-' }}</td>
                            <td>
                                @if ($u->role === 'guru')
                                    <span class="badge bg-blue-lt">Guru</span>
                                @else
                                    <span class="badge bg-purple-lt">Guru BK</span>
                                @endif
                            </td>
                            <td>
                                @if ($u->is_active)
                                    <span class="badge bg-green">Aktif</span>
                                @else
                                    <span class="badge bg-secondary-lt">Nonaktif</span>
                                @endif
                            </td>
                            <td class="d-flex gap-1">
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $u->id }}">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-reset-{{ $u->id }}">
                                    Reset Password
                                </button>
                                <form action="{{ route('master.users.destroy', $u->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus akun {{ $u->name }}?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- Modal Edit --}}
                        <div class="modal modal-blur fade" id="modal-edit-{{ $u->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('master.users.update', $u->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Akun — {{ $u->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nama</label>
                                                <input type="text" name="name" class="form-control" value="{{ $u->name }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control" value="{{ $u->email }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">NIP <span class="text-secondary">(opsional)</span></label>
                                                <input type="text" name="nip" class="form-control" value="{{ $u->nip }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Role</label>
                                                <select name="role" class="form-select">
                                                    <option value="guru" {{ $u->role === 'guru' ? 'selected' : '' }}>Guru</option>
                                                    <option value="guru_bk" {{ $u->role === 'guru_bk' ? 'selected' : '' }}>Guru BK</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-check">
                                                    <input type="checkbox" name="is_active" class="form-check-input" {{ $u->is_active ? 'checked' : '' }}>
                                                    <span class="form-check-label">Akun Aktif</span>
                                                </label>
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

                        {{-- Modal Reset Password --}}
                        <div class="modal modal-blur fade" id="modal-reset-{{ $u->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('master.users.reset-password', $u->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <div class="modal-header">
                                            <h5 class="modal-title">Reset Password — {{ $u->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Password Baru</label>
                                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Konfirmasi Password</label>
                                                <input type="password" name="password_confirmation" class="form-control">
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary ms-auto">Reset</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-secondary">Belum ada akun guru.</td>
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
                <form action="{{ route('master.users.store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Akun Guru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIP <span class="text-secondary">(opsional)</span></label>
                            <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}">
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror">
                                <option value="">-- Pilih Role --</option>
                                <option value="guru" {{ old('role') === 'guru' ? 'selected' : '' }}>Guru</option>
                                <option value="guru_bk" {{ old('role') === 'guru_bk' ? 'selected' : '' }}>Guru BK</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" checked>
                                <span class="form-check-label">Akun Aktif</span>
                            </label>
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