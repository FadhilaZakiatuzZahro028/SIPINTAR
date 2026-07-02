@extends('layouts.app')

@section('title', 'Kelola Siswa - ' . $kelas->nama_lengkap)

@section('content')

    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <div class="page-pretitle">{{ $kelas->tahunAjaran->nama }}</div>
                <h2 class="page-title">Kelola Siswa — {{ $kelas->nama_lengkap }}</h2>
            </div>
            <div class="col-auto">
                <a href="{{ route('master.kelas.index') }}" class="btn btn-link">
                    &laquo; Kembali ke Daftar Kelas
                </a>
            </div>
        </div>
    </div>

    <div class="row row-cards mt-3">

        {{-- Kolom kiri: siswa yang sudah masuk kelas ini --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Siswa di Kelas Ini ({{ $siswaSudahMasuk->count() }})</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswaSudahMasuk as $sk)
                                <tr>
                                    <td>{{ $sk->siswa->nis }}</td>
                                    <td>{{ $sk->siswa->nama }}</td>
                                    <td>
                                        <form action="{{ route('master.kelas.hapus-siswa', [$kelas->id, $sk->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Keluarkan {{ $sk->siswa->nama }} dari kelas ini?')">
                                                Keluarkan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-secondary">Belum ada siswa di kelas ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Kolom kanan: siswa yang belum ditempatkan --}}
        <div class="col-md-6">
            <div class="card">
                <form action="{{ route('master.kelas.simpan-siswa', $kelas->id) }}" method="POST">
                    @csrf

                    <div class="card-header">
                        <h3 class="card-title">Siswa Belum Ditempatkan ({{ $siswaBelumDitempatkan->count() }})</h3>
                    </div>

                    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th class="w-1"></th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($siswaBelumDitempatkan as $s)
                                    <tr>
                                        <td>
                                            <input class="form-check-input" type="checkbox" name="siswa_id[]" value="{{ $s->id }}">
                                        </td>
                                        <td>{{ $s->nis }}</td>
                                        <td>{{ $s->nama }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-secondary">Semua siswa sudah ditempatkan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($siswaBelumDitempatkan->count() > 0)
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Tambahkan ke Kelas</button>
                        </div>
                    @endif
                </form>
            </div>
        </div>

    </div>

@endsection