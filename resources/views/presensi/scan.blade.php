@extends('layouts.publik')

@section('title', 'Presensi - ' . $kelas->nama_lengkap)

@section('content')

    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center mb-1">{{ $kelas->nama_lengkap }}</h2>
            <div class="text-secondary text-center mb-4">{{ now()->translatedFormat('l, d F Y') }}</div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form id="form-presensi" action="{{ route('presensi.scan.simpan', $token) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Pilih Nama Kamu</label>
                    <select name="siswa_id" id="siswa_id" class="form-select" required>
                        <option value="">-- Pilih Nama --</option>
                        @foreach ($daftarSiswa as $siswa)
                            <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <div id="status-lokasi" class="text-secondary text-center mb-3"></div>

                <button type="button" id="btn-presensi" class="btn btn-primary w-100">
                    Ambil Lokasi & Presensi
                </button>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.getElementById('btn-presensi').addEventListener('click', function () {
        const siswaId = document.getElementById('siswa_id').value;
        const statusEl = document.getElementById('status-lokasi');
        const btn = this;

        if (!siswaId) {
            statusEl.textContent = 'Silakan pilih nama kamu terlebih dahulu.';
            statusEl.classList.add('text-danger');
            return;
        }

        if (!navigator.geolocation) {
            statusEl.textContent = 'Browser kamu tidak mendukung layanan lokasi.';
            statusEl.classList.add('text-danger');
            return;
        }

        btn.disabled = true;
        statusEl.classList.remove('text-danger');
        statusEl.textContent = 'Mengambil lokasi kamu...';

        navigator.geolocation.getCurrentPosition(
            function (position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
                statusEl.textContent = 'Lokasi ditemukan, mengirim presensi...';
                document.getElementById('form-presensi').submit();
            },
            function (error) {
                btn.disabled = false;
                statusEl.classList.add('text-danger');
                statusEl.textContent = 'Gagal mengambil lokasi. Pastikan izin lokasi diaktifkan, lalu coba lagi.';
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    });
</script>
@endpush