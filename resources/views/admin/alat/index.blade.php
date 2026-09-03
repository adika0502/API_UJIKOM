@extends('layouts.app')

@section('title', 'Kelola Alat - Panel Admin')
@section('header-title', 'Manajemen Data Alat')

@section('content')
    @if(session('success'))
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-lg shadow-sm text-sm flex items-center gap-2">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200">
        <!-- Header -->
        <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-slate-50 to-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Daftar Alat Laboratorium</h3>
                <p class="text-sm text-gray-500 mt-0.5">{{ $alats->total() }} alat terdaftar</p>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <!-- Form Search -->
                <form action="{{ route('admin.alat.index') }}" method="GET" class="flex w-full md:w-80">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama alat, kategori..."
                            class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-300 rounded-l-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-2.5 text-sm font-semibold rounded-r-xl transition whitespace-nowrap">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.alat.index') }}"
                            class="ml-2 bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-2.5 text-sm rounded-xl flex items-center transition">
                            ✕
                        </a>
                    @endif
                </form>

                <!-- Tombol Tambah -->
                <a href="{{ route('admin.alat.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition whitespace-nowrap flex items-center gap-1.5 shadow-sm shadow-blue-200">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Alat
                </a>
            </div>
        </div>

        <!-- Grid Card Alat -->
        <div class="p-6">
            @forelse($alats as $alat)
            @empty
            @endforelse

            @if($alats->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @foreach($alats as $alat)
                        <div class="group bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg hover:border-blue-200 transition-all duration-200">
                            <!-- Gambar -->
                            <div class="relative h-40 bg-gray-50 flex items-center justify-center overflow-hidden">
                                @if($alat->gambar)
                                    <img src="{{ asset($alat->gambar) }}" alt="{{ $alat->nama_alat }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="flex flex-col items-center text-gray-300">
                                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h.01M4 4h16v16H4V4z" />
                                        </svg>
                                        <span class="text-xs mt-1">Tidak ada gambar</span>
                                    </div>
                                @endif

                                <!-- Badge Kondisi -->
                                <span class="absolute top-3 right-3 px-2.5 py-1 text-xs font-semibold rounded-full shadow-sm
                                    @if(strtolower($alat->status_kondisi) == 'baik') bg-emerald-500 text-white
                                    @elseif(str_contains(strtolower($alat->status_kondisi), 'ringan')) bg-amber-500 text-white
                                    @else bg-red-500 text-white @endif">
                                    {{ $alat->status_kondisi }}
                                </span>
                            </div>

                            <!-- Info -->
                            <div class="p-4">
                                <h4 class="font-bold text-gray-900 text-base truncate">{{ $alat->nama_alat }}</h4>
                                <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $alat->kategori->nama_kategori ?? '-' }}</p>

                                <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        <span class="text-sm font-semibold text-gray-700">{{ $alat->stok }}</span>
                                        <span class="text-xs text-gray-400">stok</span>
                                    </div>
                                </div>

                                <!-- Aksi -->
                                <div class="flex items-center gap-2 mt-4">
                                    <a href="{{ route('admin.alat.edit', $alat->id) }}"
                                        class="flex-1 text-center bg-amber-50 hover:bg-amber-100 text-amber-700 px-3 py-2 rounded-lg text-xs font-semibold transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.alat.destroy', $alat->id) }}"
                                        method="POST" onsubmit="return confirm('Yakin ingin menghapus alat ini?')" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 px-3 py-2 rounded-lg text-xs font-semibold transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="text-gray-500 font-medium">Belum ada data alat</p>
                    <p class="text-sm text-gray-400 mt-1">Klik "Tambah Alat" untuk menambahkan data baru.</p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        <div class="px-6 pb-6">
            {{ $alats->links() }}
        </div>
    </div>
@endsection