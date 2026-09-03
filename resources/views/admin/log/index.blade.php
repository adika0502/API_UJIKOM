@extends('layouts.app')
@section('title', 'Log Aktivitas')
@section('header-title', 'Log Aktivitas Sistem')
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
            <h3 class="text-xl font-bold text-gray-900">Log Aktivitas</h3>
            <p class="text-sm text-gray-500 mt-0.5">{{ $logs->total() }} aktivitas tercatat</p>
        </div>

        <form method="GET" action="{{ route('admin.log.index') }}" class="flex w-full md:w-96">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari aktivitas atau nama user..."
                    class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-300 rounded-l-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-2.5 text-sm font-semibold rounded-r-xl transition whitespace-nowrap">
                Cari
            </button>
            @if($search ?? false)
                <a href="{{ route('admin.log.index') }}"
                    class="ml-2 bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-2.5 text-sm rounded-xl flex items-center transition">
                    ✕
                </a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="py-3.5 px-6 border-b border-gray-100 font-semibold">User</th>
                    <th class="py-3.5 px-6 border-b border-gray-100 font-semibold">Aktivitas</th>
                    <th class="py-3.5 px-6 border-b border-gray-100 font-semibold text-right">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($logs as $log)
                @php
                    $teks = strtolower($log->aktivitas);
                    [$icon, $iconBg, $iconColor] = match(true) {
                        str_contains($teks, 'hapus') || str_contains($teks, 'batal') => [
                            'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
                            'bg-red-50', 'text-red-500'
                        ],
                        str_contains($teks, 'tambah') || str_contains($teks, 'diajukan') => [
                            'M12 4v16m8-8H4',
                            'bg-emerald-50', 'text-emerald-500'
                        ],
                        str_contains($teks, 'perbarui') || str_contains($teks, 'edit') || str_contains($teks, 'ubah') => [
                            'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
                            'bg-amber-50', 'text-amber-500'
                        ],
                        str_contains($teks, 'pengembalian') => [
                            'M9 14l-4-4m0 0l4-4m-4 4h11a4 4 0 010 8h-1',
                            'bg-blue-50', 'text-blue-500'
                        ],
                        default => [
                            'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                            'bg-gray-100', 'text-gray-500'
                        ],
                    };
                @endphp
                <tr class="hover:bg-gray-50/70 transition">
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold flex items-center justify-center flex-shrink-0">
                                {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                            </div>
                            <span class="font-semibold text-gray-900">{{ $log->user->name ?? 'Sistem' }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600">
                        <div class="flex items-start gap-2.5">
                            <div class="w-7 h-7 rounded-lg {{ $iconBg }} {{ $iconColor }} flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
                                </svg>
                            </div>
                            <span>{{ $log->aktivitas }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="text-xs font-medium text-gray-700">{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }}</div>
                        <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-16">
                        <div class="flex flex-col items-center justify-center text-center">
                            <svg class="w-14 h-14 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500 font-medium">Belum ada log aktivitas</p>
                            <p class="text-sm text-gray-400 mt-1">Aktivitas admin dan petugas akan tercatat di sini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
        {{ $logs->links() }}
    </div>
</div>
@endsection