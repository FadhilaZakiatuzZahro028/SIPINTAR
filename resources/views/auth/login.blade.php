<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIPINTAR</title>
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
                    <h2 class="h2 text-center mb-4">Login ke Akun Anda</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" autocomplete="off">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="nama@sekolah.sch.id" autofocus required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">
    Password
    <span class="form-label-description">
        <a href="{{ route('password.request') }}">Lupa password?</a>
    </span>
</label>
                            <div class="input-group input-group-flat">
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-check">
                                <input type="checkbox" name="remember" class="form-check-input"/>
                                <span class="form-check-label">Ingat saya di perangkat ini</span>
                            </label>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>