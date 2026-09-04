<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <aside class="w-64 bg-gradient-to-b from-gray-900 to-gray-950 text-white flex flex-col hidden md:flex">
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-lg bg-emerald-500 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21H3m16 0h-5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 6v-3a1 1 0 011-1h0a1 1 0 011 1v3" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold tracking-wide leading-tight">
                            @if(auth()->user()->role === 'admin') PANEL ADMIN
                            @elseif(auth()->user()->role === 'petugas') PANEL PETUGAS
                            @else PANEL PEMINJAM
                            @endif
                        </p>
                        <p class="text-[11px] text-gray-400">Sistem Peminjaman Alat</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">

                {{-- MENU KHUSUS ADMIN --}}
                @if(auth()->user()->role === 'admin')
                    <p class="px-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-2">Menu Utama</p>

                    <a href="{{ route('admin.dashboard') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition relative
                        {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        @if(request()->routeIs('admin.dashboard'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-emerald-500 rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.alat.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition relative
                        {{ request()->routeIs('admin.alat*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        @if(request()->routeIs('admin.alat*'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-emerald-500 rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Kelola Alat
                    </a>

                    <a href="{{ route('admin.kategori.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition relative
                        {{ request()->routeIs('admin.kategori*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        @if(request()->routeIs('admin.kategori*'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-emerald-500 rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 11V6a3 3 0 013-3z" />
                        </svg>
                        Kelola Kategori
                    </a>

                    <p class="px-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-2 mt-5">Transaksi</p>

                    <a href="{{ route('admin.peminjaman.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition relative
                        {{ request()->routeIs('admin.peminjaman*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        @if(request()->routeIs('admin.peminjaman*'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-emerald-500 rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Kelola Peminjaman
                    </a>

                    <a href="{{ route('admin.pengembalian.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition relative
                        {{ request()->routeIs('admin.pengembalian*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        @if(request()->routeIs('admin.pengembalian*'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-emerald-500 rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Kelola Pengembalian
                    </a>

                    <p class="px-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-2 mt-5">Lainnya</p>

                    <a href="{{ route('admin.log.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition relative
                        {{ request()->routeIs('admin.log*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        @if(request()->routeIs('admin.log*'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-emerald-500 rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Log Aktivitas
                    </a>

                    <a href="{{ route('admin.user.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition relative
                        {{ request()->routeIs('admin.user*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        @if(request()->routeIs('admin.user*'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-emerald-500 rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 100-8 4 4 0 000 8zm6 3c0 1.657-3.134 3-7 3s-7-1.343-7-3" />
                        </svg>
                        Kelola User
                    </a>

                {{-- MENU KHUSUS PETUGAS --}}
                @elseif(auth()->user()->role === 'petugas')
                    <a href="{{ route('petugas.peminjaman.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition relative
                        {{ request()->routeIs('petugas.peminjaman*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        @if(request()->routeIs('petugas.peminjaman*'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-emerald-500 rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Persetujuan Peminjaman
                    </a>

                    <a href="{{ route('petugas.pengembalian.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition relative
                        {{ request()->routeIs('petugas.pengembalian*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        @if(request()->routeIs('petugas.pengembalian*'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-emerald-500 rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Pemantauan Pengembalian
                    </a>

                    <a href="{{ route('petugas.laporan.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition relative
                        {{ request()->routeIs('petugas.laporan*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        @if(request()->routeIs('petugas.laporan*'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-emerald-500 rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4m0 0l-3-3m3 3l-3 3M4 7h6m-6 4h6m-6 4h4" />
                        </svg>
                        Cetak Laporan
                    </a>

                {{-- MENU KHUSUS PEMINJAM --}}
                @elseif(auth()->user()->role === 'peminjam')
                    <a href="{{ route('peminjam.katalog') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition relative
                        {{ request()->routeIs('peminjam.katalog') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        @if(request()->routeIs('peminjam.katalog'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-emerald-500 rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        Katalog Alat
                    </a>

                    <a href="{{ route('peminjam.riwayat') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition relative
                        {{ request()->routeIs('peminjam.riwayat') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        @if(request()->routeIs('peminjam.riwayat'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-1 bg-emerald-500 rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Riwayat & Pengembalian
                    </a>
                @endif

            </nav>

            <div class="p-4 border-t border-white/10 space-y-3">
                <div class="flex items-center gap-3 px-1">
                    <div class="w-9 h-9 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-sm flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-gray-400">Logged in as</p>
                        <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition border border-red-500/20 hover:border-red-500">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>
        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white shadow-sm h-16 flex items-center px-6 z-10">
                <div class="text-lg font-semibold text-gray-800">
                    @yield('header-title', 'Dashboard')
                </div>
            </header>
            <main class="flex-1 p-6">
                @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
                @endif
                @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>