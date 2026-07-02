@extends('layouts.app')

@section('title', 'Pengaturan Lokasi Sekolah')

@section('content')

    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Pengaturan Lokasi Sekolah</h2>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <form action="{{ route('master.pengaturan-sekolah.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Nama Sekolah <span class="text-secondary">(opsional)</span></label>
                    <input type="text" name="nama_sekolah" class="form-control @error('nama_sekolah') is-invalid @enderror" value="{{ old('nama_sekolah', $pengaturan->nama_sekolah) }}">
                    @error('nama_sekolah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude', $pengaturan->latitude) }}" placeholder="contoh: -6.2088361">
                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude', $pengaturan->longitude) }}" placeholder="contoh: 106.8455239">
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Radius Toleransi (meter)</label>
                    <input type="number" name="radius_meter" class="form-control @error('radius_meter') is-invalid @enderror" value="{{ old('radius_meter', $pengaturan->radius_meter) }}" min="10" max="1000">
                    @error('radius_meter')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-hint">Siswa yang scan QR di luar radius ini dari titik sekolah akan ditolak.</small>
                </div>

                <div class="alert alert-info">
                    Cara ambil koordinat: buka Google Maps, cari lokasi sekolah, klik kanan pada titik yang tepat, lalu klik angka koordinat yang muncul paling atas untuk menyalinnya. Salin nilai pertama ke Latitude dan nilai kedua ke Longitude.
                </div>

            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </div>
        </form>
    </div>

@endsection