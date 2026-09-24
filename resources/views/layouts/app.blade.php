<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Space Grotesk', 'sans-serif'],
                        mono: ['IBM Plex Mono', 'monospace'],
                    },
                    colors: {
                        ink: '#0F1216',
                        surface: '#171B21',
                        surface2: '#1E232B',
                        line: '#2B323D',
                        amber: {
                            DEFAULT: '#DFA23C',
                            soft: 'rgba(223,162,60,0.12)',
                            hover: '#EBB158',
                        },
                        rust: {
                            DEFAULT: '#B4573F',
                            soft: 'rgba(180,87,63,0.12)',
                        },
                        leaf: {
                            DEFAULT: '#5AA579',
                            soft: 'rgba(90,165,121,0.12)',
                        },
                        steel: {
                            DEFAULT: '#4C8FBD',
                            soft: 'rgba(76,143,189,0.12)',
                        },
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap');
        body { background:#F5F3EE; }
        ::-webkit-scrollbar{ width:8px; height:8px; }
        ::-webkit-scrollbar-thumb{ background:#D8D3C6; border-radius:999px; }
        ::-webkit-scrollbar-track{ background:transparent; }
        .nav-item { transition: transform .18s ease, background-color .18s ease, color .18s ease; }
        .nav-item:hover { transform: translateX(3px); }
    </style>
</head>
<body class="font-sans antialiased text-[#20242B]">
    @php
        $role = auth()->user()->role;
        // Aksen warna otomatis mengikuti role: admin = amber, petugas = steel, peminjam = leaf
        $accent = match($role) {
            'admin' => 'amber',
            'petugas' => 'steel',
            default => 'leaf',
        };
        $roleLabel = match($role) {
            'admin' => 'Panel Admin',
            'petugas' => 'Panel Petugas',
            default => 'Panel Peminjam',
        };
    @endphp
    <div class="flex h-screen overflow-hidden">

        {{-- ===================== SIDEBAR ===================== --}}
        <aside class="w-64 bg-ink text-[#EDEAE0] flex-col hidden md:flex border-r border-line">

            <div class="p-6 border-b border-white/[0.06]">
                <div class="flex items-center gap-2.5">
                    <div class="relative w-9 h-9 rounded-lg bg-surface2 border border-line flex items-center justify-center flex-shrink-0">
                        <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none">
                            <path d="M12.6 2.6l8.8 8.8c.8.8.8 2 0 2.8l-7.2 7.2c-.8.8-2 .8-2.8 0l-8.8-8.8c-.4-.4-.6-.9-.6-1.4V3.6c0-.6.4-1 1-1h7.6c.5 0 1 .2 1.4.6z" stroke="#EDEAE0" stroke-width="1.6" stroke-linejoin="round"/>
                            <circle cx="7" cy="7.4" r="1.4" class="fill-{{ $accent }}"/>
                        </svg>
                        <span class="absolute -top-1 -right-1 w-2 h-2 rounded-full bg-{{ $accent }} animate-pulse"></span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold tracking-wide leading-tight">{{ $roleLabel }}</p>
                        <p class="text-[11px] font-mono text-[#5C6472] mt-0.5">Sistem Peminjaman Alat</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">

                {{-- MENU KHUSUS ADMIN --}}
                @if($role === 'admin')
                    <p class="flex items-center gap-2 px-3 mb-2 text-[10px] font-mono text-[#5C6472] tracking-widest uppercase">
                        <span>Menu utama</span><span class="flex-1 h-px bg-white/[0.06]"></span>
                    </p>

                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-item group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium relative
                        {{ request()->routeIs('admin.dashboard') ? 'bg-surface2 text-white shadow-[0_0_16px_-4px_rgba(223,162,60,0.35)]' : 'text-[#9AA2AF] hover:bg-surface hover:text-white' }}">
                        @if(request()->routeIs('admin.dashboard'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-[3px] bg-{{ $accent }} rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.alat.index') }}"
                        class="nav-item group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium relative
                        {{ request()->routeIs('admin.alat*') ? 'bg-surface2 text-white shadow-[0_0_16px_-4px_rgba(223,162,60,0.35)]' : 'text-[#9AA2AF] hover:bg-surface hover:text-white' }}">
                        @if(request()->routeIs('admin.alat*'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-[3px] bg-{{ $accent }} rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Kelola alat
                    </a>

                    <a href="{{ route('admin.kategori.index') }}"
                        class="nav-item group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium relative
                        {{ request()->routeIs('admin.kategori*') ? 'bg-surface2 text-white shadow-[0_0_16px_-4px_rgba(223,162,60,0.35)]' : 'text-[#9AA2AF] hover:bg-surface hover:text-white' }}">
                        @if(request()->routeIs('admin.kategori*'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-[3px] bg-{{ $accent }} rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 11V6a3 3 0 013-3z" />
                        </svg>
                        Kelola kategori
                    </a>

                    <p class="flex items-center gap-2 px-3 mb-2 mt-5 text-[10px] font-mono text-[#5C6472] tracking-widest uppercase">
                        <span>Transaksi</span><span class="flex-1 h-px bg-white/[0.06]"></span>
                    </p>

                    <a href="{{ route('admin.peminjaman.index') }}"
                        class="nav-item group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium relative
                        {{ request()->routeIs('admin.peminjaman*') ? 'bg-surface2 text-white shadow-[0_0_16px_-4px_rgba(223,162,60,0.35)]' : 'text-[#9AA2AF] hover:bg-surface hover:text-white' }}">
                        @if(request()->routeIs('admin.peminjaman*'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-[3px] bg-{{ $accent }} rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Kelola peminjaman
                    </a>

                    <a href="{{ route('admin.pengembalian.index') }}"
                        class="nav-item group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium relative
                        {{ request()->routeIs('admin.pengembalian*') ? 'bg-surface2 text-white shadow-[0_0_16px_-4px_rgba(223,162,60,0.35)]' : 'text-[#9AA2AF] hover:bg-surface hover:text-white' }}">
                        @if(request()->routeIs('admin.pengembalian*'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-[3px] bg-{{ $accent }} rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Kelola pengembalian
                    </a>

                    <p class="flex items-center gap-2 px-3 mb-2 mt-5 text-[10px] font-mono text-[#5C6472] tracking-widest uppercase">
                        <span>Lainnya</span><span class="flex-1 h-px bg-white/[0.06]"></span>
                    </p>

                    <a href="{{ route('admin.log.index') }}"
                        class="nav-item group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium relative
                        {{ request()->routeIs('admin.log*') ? 'bg-surface2 text-white shadow-[0_0_16px_-4px_rgba(223,162,60,0.35)]' : 'text-[#9AA2AF] hover:bg-surface hover:text-white' }}">
                        @if(request()->routeIs('admin.log*'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-[3px] bg-{{ $accent }} rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Log aktivitas
                    </a>

                    <a href="{{ route('admin.user.index') }}"
                        class="nav-item group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium relative
                        {{ request()->routeIs('admin.user*') ? 'bg-surface2 text-white shadow-[0_0_16px_-4px_rgba(223,162,60,0.35)]' : 'text-[#9AA2AF] hover:bg-surface hover:text-white' }}">
                        @if(request()->routeIs('admin.user*'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-[3px] bg-{{ $accent }} rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 100-8 4 4 0 000 8zm6 3c0 1.657-3.134 3-7 3s-7-1.343-7-3" />
                        </svg>
                        Kelola user
                    </a>

                {{-- MENU KHUSUS PETUGAS --}}
                @elseif($role === 'petugas')
                    <p class="flex items-center gap-2 px-3 mb-2 text-[10px] font-mono text-[#5C6472] tracking-widest uppercase">
                        <span>Menu utama</span><span class="flex-1 h-px bg-white/[0.06]"></span>
                    </p>

                    <a href="{{ route('petugas.peminjaman.index') }}"
                        class="nav-item group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium relative
                        {{ request()->routeIs('petugas.peminjaman*') ? 'bg-surface2 text-white shadow-[0_0_16px_-4px_rgba(76,143,189,0.35)]' : 'text-[#9AA2AF] hover:bg-surface hover:text-white' }}">
                        @if(request()->routeIs('petugas.peminjaman*'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-[3px] bg-{{ $accent }} rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="flex-1">Persetujuan peminjaman</span>
                        @if(isset($countMenunggu) && $countMenunggu > 0)
                            <span class="text-[10px] font-mono font-semibold bg-{{ $accent }} text-ink rounded-full px-1.5 py-0.5 min-w-[18px] text-center leading-none">{{ $countMenunggu }}</span>
                        @endif
                    </a>

                    <a href="{{ route('petugas.pengembalian.index') }}"
                        class="nav-item group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium relative
                        {{ request()->routeIs('petugas.pengembalian*') ? 'bg-surface2 text-white shadow-[0_0_16px_-4px_rgba(76,143,189,0.35)]' : 'text-[#9AA2AF] hover:bg-surface hover:text-white' }}">
                        @if(request()->routeIs('petugas.pengembalian*'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-[3px] bg-{{ $accent }} rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Pemantauan pengembalian
                    </a>

                    <a href="{{ route('petugas.laporan.index') }}"
                        class="nav-item group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium relative
                        {{ request()->routeIs('petugas.laporan*') ? 'bg-surface2 text-white shadow-[0_0_16px_-4px_rgba(76,143,189,0.35)]' : 'text-[#9AA2AF] hover:bg-surface hover:text-white' }}">
                        @if(request()->routeIs('petugas.laporan*'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-[3px] bg-{{ $accent }} rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 17v-2a4 4 0 014-4h4m0 0l-3-3m3 3l-3 3M4 7h6m-6 4h6m-6 4h4" />
                        </svg>
                        Cetak laporan
                    </a>

                {{-- MENU KHUSUS PEMINJAM --}}
                @elseif($role === 'peminjam')
                    <p class="flex items-center gap-2 px-3 mb-2 text-[10px] font-mono text-[#5C6472] tracking-widest uppercase">
                        <span>Menu utama</span><span class="flex-1 h-px bg-white/[0.06]"></span>
                    </p>

                    <a href="{{ route('peminjam.katalog') }}"
                        class="nav-item group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium relative
                        {{ request()->routeIs('peminjam.katalog') ? 'bg-surface2 text-white shadow-[0_0_16px_-4px_rgba(90,165,121,0.35)]' : 'text-[#9AA2AF] hover:bg-surface hover:text-white' }}">
                        @if(request()->routeIs('peminjam.katalog'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-[3px] bg-{{ $accent }} rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        Katalog alat
                    </a>

                    <a href="{{ route('peminjam.riwayat') }}"
                        class="nav-item group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium relative
                        {{ request()->routeIs('peminjam.riwayat') ? 'bg-surface2 text-white shadow-[0_0_16px_-4px_rgba(90,165,121,0.35)]' : 'text-[#9AA2AF] hover:bg-surface hover:text-white' }}">
                        @if(request()->routeIs('peminjam.riwayat'))
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-[3px] bg-{{ $accent }} rounded-r"></span>
                        @endif
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Riwayat &amp; pengembalian
                    </a>
                @endif

            </nav>

            <div class="p-4 border-t border-white/[0.06] space-y-3">
                <div class="flex items-center gap-3 px-1">
                    <div class="w-9 h-9 rounded-full bg-{{ $accent }}-soft text-{{ $accent }} flex items-center justify-center font-mono font-semibold text-sm flex-shrink-0 ring-2 ring-{{ $accent }}/30 ring-offset-2 ring-offset-ink">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-mono text-[#5C6472]">Masuk sebagai</p>
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-rust-soft hover:bg-rust text-rust hover:text-white text-sm font-medium px-4 py-2.5 rounded-lg transition border border-rust/25 hover:border-rust">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- ===================== KONTEN ===================== --}}
        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white border-b border-[#E7E2D5] h-16 flex items-center px-6 z-10 flex-shrink-0">
                <div class="text-lg font-semibold text-[#20242B]">
                    @yield('header-title', 'Dashboard')
                </div>
            </header>

            <main class="flex-1 p-6">
                @if(session('success'))
                <div class="mb-4 bg-leaf-soft border border-leaf/30 text-[#2F6B48] px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="mb-4 bg-rust-soft border border-rust/30 text-rust px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m0 3.75h.007M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
                @endif

                @if($errors->any())
                <div class="mb-4 bg-rust-soft border border-rust/30 text-rust px-4 py-3 rounded-lg text-sm">
                    <ul class="list-disc list-inside space-y-0.5">
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