<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPINTAR')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div class="page">

        {{-- Sidebar --}}
        <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <h1 class="navbar-brand">
                    <a href="{{ url('/dashboard') }}">SIPINTAR</a>
                </h1>

                <div class="navbar-collapse collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/dashboard') }}">
                                <span class="nav-link-title">Dashboard</span>
                            </a>
                        </li>

                        @if (auth()->user()->role === 'admin')
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#navbar-master" data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <span class="nav-link-title">Master Data</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('master.semester.index') }}">Tahun Ajaran & Semester</a>
<a class="dropdown-item" href="{{ route('master.mata-pelajaran.index') }}">Mata Pelajaran</a>
<a class="dropdown-item" href="{{ route('master.kelas.index') }}">Kelas</a>
<a class="dropdown-item" href="{{ route('master.siswa.index') }}">Siswa</a>
<a class="dropdown-item" href="{{ route('master.users.index') }}">Akun Guru</a>
<a class="dropdown-item" href="{{ route('master.penugasan-guru.index') }}">Penugasan Guru</a>        </div>
    </li>
@endif

                        {{-- Nanti ditambah: Presensi, Nilai, Laporan, AI Chat --}}
                    </ul>
                </div>
            </div>
        </aside>

        {{-- Konten utama --}}
        <div class="page-wrapper">

            {{-- Navbar atas --}}
            <header class="navbar navbar-expand-md d-print-none">
                <div class="container-xl">
                    <div class="navbar-nav flex-row order-md-last ms-auto">
                        @auth
                            <span class="nav-link">{{ auth()->user()->name }}</span>
                        @endauth
                    </div>
                </div>
            </header>

            <div class="page-body">
                <div class="container-xl">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>

        </div>
    </div>

</body>
</html>