@extends('layouts.app')

@section('title', 'Profil Saya - Peminjam')
@section('header-title', 'Profil Saya')

@section('content')
    @if(session('success'))
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl shadow-sm text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl shadow-sm text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-md bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col items-center text-center mb-6">
            @if($user->foto_profile)
                <img src="{{ asset($user->foto_profile) }}" alt="Foto Profil"
                    class="w-28 h-28 rounded-full object-cover mb-4 ring-2 ring-emerald-500/30 ring-offset-2">
            @else
                <div class="w-28 h-28 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-4xl mb-4">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
            <p class="font-bold text-gray-900 text-lg">{{ $user->name }}</p>
            <p class="text-sm text-gray-500">{{ $user->email }}</p>
        </div>

        <form action="{{ route('peminjam.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Pilih Foto Baru</label>
                <input type="file" name="foto_profile" accept="image/*" required
                    class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                <p class="text-xs text-gray-400 mt-1">Format JPG/PNG, maksimal 2MB.</p>
            </div>
            <button type="submit"
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 rounded-xl text-sm font-semibold transition shadow-sm">
                Simpan Foto Profil
            </button>
        </form>
    </div>
@endsection