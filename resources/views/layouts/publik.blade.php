<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Presensi - SIPINTAR')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div class="page">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-tight py-4">

                    <div class="text-center mb-4">
                        <h1 class="h2">SIPINTAR</h1>
                        <div class="text-secondary">Sistem Presensi</div>
                    </div>

                    @yield('content')

                </div>
            </div>
        </div>
    </div>

    @stack('scripts')

</body>
</html>