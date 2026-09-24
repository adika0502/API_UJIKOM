@extends('layouts.app')

@section('title', 'Laporan Peminjaman - Dashboard Petugas')
@section('header-title', 'Laporan Peminjaman & Pengembalian Alat')

@section('content')

    @php
        $telatCountLaporan = $laporans->filter(function ($p) {
            return in_array($p->status, ['dipinjam', 'telat']) && $p->tgl_kembali_plan->lt(today());
        })->count();
    @endphp

    {{-- Ringkasan cepat --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $laporans->count() }}</p>
                <p class="text-sm text-gray-500">Total Data</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $laporans->where('status', 'selesai')->count() }}</p>
                <p class="text-sm text-gray-500">Selesai</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $telatCountLaporan }}</p>
                <p class="text-sm text-gray-500">Telat</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 12v-2m0-8a9 9 0 110 8 9 9 0 010-8z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($laporans->sum(fn($i) => $i->pengembalian->denda ?? 0), 0, ',', '.') }}</p>
                <p class="text-sm text-gray-500">Total Denda</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200 mb-6">
        <div class="p-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-gray-800 text-white flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800">Filter Laporan</h3>
                <p class="text-sm text-gray-500">Saring data berdasarkan status dan rentang tanggal pinjam</p>
            </div>
        </div>
        <form action="{{ route('petugas.laporan.index') }}" method="GET" class="p-5 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Status Peminjaman</label>
                <select name="status" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    <option value="">Semua Status</option>
                    <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="telat" {{ request('status') == 'telat' ? 'selected' : '' }}>Telat</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Dari Tanggal (Pinjam)</label>
                <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}"
                    class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Sampai Tanggal (Pinjam)</label>
                <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}"
                    class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="flex-1 flex items-center justify-center gap-2 bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 text-sm font-semibold rounded-lg transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                    </svg>
                    Filter
                </button>
                <a href="{{ route('petugas.laporan.index') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-2 text-sm rounded-lg transition flex items-center justify-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Tabel Hasil & Tombol Cetak --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200">
        <div class="p-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white flex flex-col sm:flex-row justify-between sm:items-center gap-3">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Hasil Rekap Laporan</h3>
                <p class="text-sm text-gray-500">{{ $laporans->count() }} data ditemukan</p>
            </div>
            <a href="{{ route('petugas.laporan.cetak', request()->all()) }}" target="_blank"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 text-sm font-semibold rounded-lg transition shadow-sm hover:shadow flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a1 1 0 001-1v-4H8v4a1 1 0 001 1zm8-10V5a1 1 0 00-1-1H8a1 1 0 00-1 1v4h10z"/>
                </svg>
                Cetak / Print Laporan
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="py-3 px-4 border-b">No</th>
                        <th class="py-3 px-4 border-b">Peminjam</th>
                        <th class="py-3 px-4 border-b">Tgl Pinjam</th>
                        <th class="py-3 px-4 border-b">Rencana Kembali</th>
                        <th class="py-3 px-4 border-b">Status</th>
                        <th class="py-3 px-4 border-b">Detail Alat</th>
                        <th class="py-3 px-4 border-b text-right">Denda</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @forelse($laporans as $index => $item)
                        @php
                            $isTelatDinamis = in_array($item->status, ['dipinjam', 'telat']) && $item->tgl_kembali_plan->lt(today());
                            $statusTampil = $isTelatDinamis ? 'telat' : $item->status;
                            $badgeMap = [
                                'selesai'  => ['bg-emerald-100 text-emerald-700', 'bg-emerald-500'],
                                'dipinjam' => ['bg-blue-100 text-blue-700', 'bg-blue-500'],
                                'telat'    => ['bg-red-100 text-red-700', 'bg-red-500 animate-pulse'],
                                'diajukan' => ['bg-amber-100 text-amber-700', 'bg-amber-500'],
                            ];
                            [$badgeClass, $dotClass] = $badgeMap[$statusTampil] ?? ['bg-gray-100 text-gray-700', 'bg-gray-400'];
                            $denda = $item->pengembalian->denda ?? 0;
                        @endphp
                        <tr class="hover:bg-gray-50 transition align-top even:bg-gray-50/40">
                            <td class="py-3 px-4 border-b text-gray-400">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 border-b">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-600 to-gray-800 text-white flex items-center justify-center text-xs font-bold flex-shrink-0">
                                        {{ strtoupper(substr($item->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $item->user->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 border-b">{{ $item->tgl_pinjam->format('d-m-Y') }}</td>
                            <td class="py-3 px-4 border-b">{{ $item->tgl_kembali_plan->format('d-m-Y') }}</td>
                            <td class="py-3 px-4 border-b">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                                    {{ ucfirst($statusTampil) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 border-b">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($item->detailPinjam as $detail)
                                        <span class="text-xs bg-gray-100 text-gray-600 rounded-full px-2 py-0.5">
                                            {{ $detail->alat->nama_alat ?? '-' }} <span class="text-gray-400">×{{ $detail->jumlah }}</span>
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-3 px-4 border-b text-right font-semibold {{ $denda > 0 ? 'text-red-600' : 'text-gray-400' }}">
                                Rp {{ number_format($denda, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">Tidak ada data pada periode ini</p>
                                    <p class="text-sm text-gray-400 mt-1">Coba ubah status atau rentang tanggal pencarian.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection