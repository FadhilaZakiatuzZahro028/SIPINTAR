@extends('layouts.app')

@section('title', 'QR Presensi - ' . $kelas->nama_lengkap)

@section('content')

    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">QR Presensi — {{ $kelas->nama_lengkap }}</h2>
                <div class="text-secondary">{{ now()->translatedFormat('l, d F Y') }}</div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body text-center py-5">

            <div id="qrcode-container" class="d-flex justify-content-center mb-4"></div>

            <div class="h1 mb-2" id="countdown-text">--:--</div>
            <div class="text-secondary mb-4">Sisa waktu QR ini berlaku</div>

            <div class="text-secondary">
                Siswa: buka kamera HP, scan QR di atas, lalu pilih nama kamu dari daftar kelas.
            </div>

        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    new QRCode(document.getElementById("qrcode-container"), {
        text: "{{ $urlScan }}",
        width: 320,
        height: 320,
    });

    let sisaDetik = {{ $sisaDetik }};

    function updateCountdown() {
        if (sisaDetik <= 0) {
            location.reload();
            return;
        }

        const menit = Math.floor(sisaDetik / 60);
        const detik = sisaDetik % 60;
        document.getElementById('countdown-text').textContent =
            String(menit).padStart(2, '0') + ':' + String(detik).padStart(2, '0');

        sisaDetik--;
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
</script>
@endpush