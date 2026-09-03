@extends('layouts.app')

@section('title', 'Dashboard Admin - Sistem Peminjaman')
@section('header-title', 'Ringkasan Aktivitas Sistem')

@section('content')
    <!-- Alert Selamat Datang -->
    <div class="mb-6 flex items-center gap-3 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-900 p-4 rounded-r-lg shadow-sm">
        <span class="text-emerald-500 text-xl">●</span>
        <p>
            Selamat datang, <strong class="font-semibold">{{ auth()->user()->name }}</strong>! Anda login sebagai hak akses
            <span class="ml-1 uppercase font-mono text-xs font-bold bg-emerald-600 text-white px-2 py-1 rounded">
                {{ auth()->user()->role }}
            </span>
        </p>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4 hover:shadow-md transition">
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 text-xl font-bold">
                📦
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide">Total Alat</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalAlat }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4 hover:shadow-md transition">
            <div class="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 text-xl font-bold">
                🔄
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide">Peminjaman Aktif</p>
                <p class="text-2xl font-bold text-gray-800">{{ $peminjamanAktif }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4 hover:shadow-md transition">
            <div class="w-12 h-12 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600 text-xl font-bold">
                ✅
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide">Pengembalian Bulan Ini</p>
                <p class="text-2xl font-bold text-gray-800">{{ $pengembalianBulanIni }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4 hover:shadow-md transition">
            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600 text-xl font-bold">
                👥
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide">Total User</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalUser }}</p>
            </div>
        </div>
    </div>

    <!-- Tabel Log Aktivitas -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <div class="p-5 border-b border-gray-200 bg-gray-50 flex items-center justify-between flex-wrap gap-3">
            <h3 class="text-lg font-bold text-gray-800">Log Aktivitas Terbaru</h3>

            <div class="flex items-center gap-4 text-xs text-gray-500">
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-blue-500"></span>Import</span>
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500"></span>Approve</span>
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-amber-500"></span>Request</span>
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-red-500"></span>Return/Denda</span>
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-purple-500"></span>Konfigurasi</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="py-3 px-4 border-b">Waktu</th>
                        <th class="py-3 px-4 border-b">User</th>
                        <th class="py-3 px-4 border-b">Aktivitas</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @forelse($logs as $log)
                        @php
                            $text = strtolower($log->aktivitas);
                            $dotColor = 'bg-gray-400';
                            if (str_contains($text, 'import')) $dotColor = 'bg-blue-500';
                            elseif (str_contains($text, 'setuju') || str_contains($text, 'approve')) $dotColor = 'bg-emerald-500';
                            elseif (str_contains($text, 'ajukan') || str_contains($text, 'mengajukan')) $dotColor = 'bg-amber-500';
                            elseif (str_contains($text, 'kembali') || str_contains($text, 'telat') || str_contains($text, 'denda')) $dotColor = 'bg-red-500';
                            elseif (str_contains($text, 'ubah') || str_contains($text, 'konfigurasi')) $dotColor = 'bg-purple-500';
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4 border-b font-mono text-xs text-gray-500 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i:s') }}
                            </td>
                            <td class="py-3 px-4 border-b font-medium text-gray-900 whitespace-nowrap">
                                {{ $log->user->name ?? 'Sistem' }}
                            </td>
                            <td class="py-3 px-4 border-b">
                                <div class="flex items-start gap-2">
                                    <span class="w-2 h-2 mt-1.5 rounded-full {{ $dotColor }} flex-shrink-0"></span>
                                    <span>{{ $log->aktivitas }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-6 text-center text-gray-500">Belum ada log aktivitas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
