@extends('layouts.app')

@section('title', 'Kelola Pengembalian')
@section('header-title', 'Riwayat Pengembalian Alat')

@section('content')

@if(session('success'))
    <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-lg shadow-sm text-sm flex items-center gap-2">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg shadow-sm text-sm">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200">
    <!-- Header -->
    <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-slate-50 to-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h3 class="text-xl font-bold text-gray-900">Riwayat Pengembalian</h3>
            <p class="text-sm text-gray-500 mt-0.5">{{ $pengembalians->total() }} transaksi tercatat</p>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <form action="{{ route('admin.pengembalian.index') }}" method="GET" class="flex w-full md:w-80">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam..."
                        class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-300 rounded-l-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-2.5 text-sm font-semibold rounded-r-xl transition whitespace-nowrap">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.pengembalian.index') }}"
                        class="ml-2 bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-2.5 text-sm rounded-xl flex items-center transition">
                        ✕
                    </a>
                @endif
            </form>

            <a href="{{ route('admin.pengembalian.pilih') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition whitespace-nowrap flex items-center gap-1.5 shadow-sm shadow-blue-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Proses Pengembalian
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="py-3.5 px-6 border-b border-gray-100 font-semibold">Peminjam</th>
                    <th class="py-3.5 px-6 border-b border-gray-100 font-semibold">Alat Dikembalikan</th>
                    <th class="py-3.5 px-6 border-b border-gray-100 font-semibold">Tgl Kembali</th>
                    <th class="py-3.5 px-6 border-b border-gray-100 font-semibold">Kondisi</th>
                    <th class="py-3.5 px-6 border-b border-gray-100 font-semibold">Denda</th>
                    <th class="py-3.5 px-6 border-b border-gray-100 font-semibold">Petugas</th>
                    <th class="py-3.5 px-6 border-b border-gray-100 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($pengembalians as $p)
                <tr class="hover:bg-gray-50/70 transition">
                    <td class="py-4 px-6 font-semibold text-gray-900">
                        {{ $p->peminjaman->user->name ?? 'N/A' }}
                    </td>

                    <td class="py-4 px-6 text-gray-600">
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($p->peminjaman->detailPinjam as $detail)
                                <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-700 text-xs px-2.5 py-1 rounded-lg">
                                    <span class="font-medium">{{ $detail->alat->nama_alat ?? 'Alat' }}</span>
                                    <span class="text-gray-400">×{{ $detail->jumlah }}</span>
                                </span>
                            @endforeach
                        </div>
                    </td>

                    <td class="py-4 px-6 text-gray-600 text-xs font-medium">
                        {{ \Carbon\Carbon::parse($p->tgl_kembali)->format('d/m/Y') }}
                    </td>

                    <td class="py-4 px-6">
                        @php
                            $kondisiColor = match(true) {
                                str_contains(strtolower($p->kondisi_kembali), 'baik') => 'bg-emerald-100 text-emerald-800',
                                str_contains(strtolower($p->kondisi_kembali), 'hilang') => 'bg-red-100 text-red-800',
                                str_contains(strtolower($p->kondisi_kembali), 'berat') => 'bg-orange-100 text-orange-800',
                                default => 'bg-amber-100 text-amber-800',
                            };
                        @endphp
                        <span class="{{ $kondisiColor }} text-xs px-3 py-1 rounded-full font-semibold">{{ $p->kondisi_kembali }}</span>
                    </td>

                    <td class="py-4 px-6">
                        @if($p->denda > 0)
                            <span class="font-semibold text-red-600">Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                        @else
                            <span class="text-gray-400">Rp 0</span>
                        @endif
                    </td>

                    <td class="py-4 px-6 text-gray-600">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center flex-shrink-0">
                                {{ strtoupper(substr($p->petugas->name ?? '-', 0, 1)) }}
                            </div>
                            {{ $p->petugas->name ?? '-' }}
                        </div>
                    </td>

                    <td class="py-4 px-6 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <a href="{{ route('admin.pengembalian.edit', $p->id) }}"
                                class="bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-semibold px-4 py-1.5 rounded-lg transition w-full text-center">
                                Edit
                            </a>
                            <form action="{{ route('admin.pengembalian.destroy', $p->id) }}" method="POST"
                                onsubmit="return confirm('Yakin batalkan pengembalian ini? Stok akan dikurangi lagi dan status peminjaman kembali ke Dipinjam.')" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold px-4 py-1.5 rounded-lg transition w-full">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-16">
                        <div class="flex flex-col items-center justify-center text-center">
                            <svg class="w-14 h-14 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500 font-medium">Belum ada data pengembalian</p>
                            <p class="text-sm text-gray-400 mt-1">Klik "Proses Pengembalian" untuk mencatat pengembalian alat.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
        {{ $pengembalians->links() }}
    </div>
</div>
@endsection