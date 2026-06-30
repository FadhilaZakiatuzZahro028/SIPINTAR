<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password - SIPINTAR</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="d-flex flex-column">
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <h1 class="navbar-brand navbar-brand-autodark">SIPINTAR</h1>
                <p class="text-secondary">Sistem Informasi Presensi Pintar</p>
            </div>

            <div class="card card-md">
                <div class="card-body">
                    <h2 class="h2 text-center mb-2">Lupa Password</h2>
                    <p class="text-secondary text-center mb-4">Masukkan email Anda, kami akan kirimkan link untuk reset password.</p>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('password.email') }}" method="POST" autocomplete="off">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="nama@sekolah.sch.id" autofocus required>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">Kirim Link Reset Password</button>
                        </div>
                    </form>

                    <div class="text-center text-secondary mt-3">
                        <a href="{{ route('login') }}" tabindex="-1">Kembali ke Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>