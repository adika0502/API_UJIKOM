<?php

namespace Database\Seeders;

use App\Models\Alat;
use Illuminate\Database\Seeder;

class AlatSeeder extends Seeder
{
    public function run(): void
    {
       $alat = [
    [
        'kategori_id' => 1,
        'nama_alat' => 'Router Mikrotik RB941-2nD',
        'stok' => 15,
        'status_kondisi' => 'Baik',
        'deskripsi' => 'Router nirkabel rumahan yang cocok untuk praktik jaringan dasar.',
        'gambar' => '1786588577_infocus.jpg',
    ],
    [
        'kategori_id' => 2,
        'nama_alat' => 'Kamera DSLR Canon EOS 3000D',
        'stok' => 5,
        'status_kondisi' => 'Baik',
        'deskripsi' => 'Kamera pemula untuk kebutuhan dokumentasi dan pembuatan aset media.',
        'gambar' => '1788234166_camera.jpg',
    ],
    [
        'kategori_id' => 3,
        'nama_alat' => 'Mini PC Intel NUC 11',
        'stok' => 8,
        'status_kondisi' => 'Baik',
        'deskripsi' => 'Perangkat komputasi ringkas untuk server lokal skala kecil.',
        'gambar' => '1786593240_komputer.jpg',
    ],
    [
        'kategori_id' => 4,
        'nama_alat' => 'Tang Crimping RJ45/RJ11 Proskit',
        'stok' => 20,
        'status_kondisi' => 'Baik',
        'deskripsi' => 'Alat potong dan pasang konektor kabel UTP.',
        'gambar' => '1786590063_printer.jpg',
    ],
    [
        'kategori_id' => 5,
        'nama_alat' => 'Adapter HDMI to VGA dengan Audio',
        'stok' => 25,
        'status_kondisi' => 'Baik',
        'deskripsi' => 'Konverter display untuk menyambungkan perangkat modern ke proyektor lama.',
        'gambar' => '1787189456_ubi.jpg',
    ],
];

        foreach ($alat as $item) {
            Alat::create($item);
        }
    }
}