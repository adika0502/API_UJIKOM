<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use App\Models\User;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use App\Models\DetailPinjam;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ========================
    // DASHBOARD
    // ========================

    // Menampilkan Dashboard Admin & Log Aktivitas
    public function index()
    {
        $logs = LogAktivitas::with('user')->latest()->take(10)->get();
        $totalAlat = Alat::count();
        $peminjamanAktif = Peminjaman::whereIn('status', ['dipinjam', 'telat'])->count();
        $pengembalianBulanIni = Pengembalian::whereMonth('tgl_kembali', now()->month)->count();
        $totalUser = User::count();

        return view('admin.dashboard', compact('logs', 'totalAlat', 'peminjamanAktif', 'pengembalianBulanIni', 'totalUser'));
    }

    // ========================
    // KELOLA ALAT
    // ========================

    // 1. Menampilkan daftar alat
    public function indexAlat(Request $request)
    {
        $search = $request->input('search');

        $alats = Alat::with('kategori')
            ->when($search, function ($query, $search) {
                return $query->where('nama_alat', 'like', "%{$search}%")
                    ->orWhere('status_kondisi', 'like', "%{$search}%")
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('nama_kategori', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.alat.index', compact('alats', 'search'));
    }

    // 2. Menampilkan form tambah alat
    public function createAlat()
    {
        $kategoris = Kategori::all();
        return view('admin.alat.create', compact('kategoris'));
    }

    // 3. Menyimpan alat baru
    public function storeAlat(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:1',
            'status_kondisi' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'stok.min' => 'Stok alat baru minimal harus 1.',
        ]);

        $data = $request->all();

        // Handle Upload Gambar jika ada
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/alat'), $filename);
            $data['gambar'] = 'storage/alat/' . $filename;
        }

        Alat::create($data);

        // Catat Log Aktivitas
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Menambahkan alat baru: ' . $request->nama_alat
        ]);

        return redirect()->route('admin.alat.index')->with('success', 'Data alat berhasil ditambahkan.');
    }

    // 4. Menampilkan form edit alat
    public function editAlat($id)
    {
        $alat = Alat::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.alat.edit', compact('alat', 'kategoris'));
    }

    // 5. Memperbarui data alat
    public function updateAlat(Request $request, $id)
    {
        $alat = Alat::findOrFail($id);

        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'status_kondisi' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Handle Update Gambar jika ada file baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($alat->gambar && file_exists(public_path($alat->gambar))) {
                unlink(public_path($alat->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/alat'), $filename);
            $data['gambar'] = 'storage/alat/' . $filename;
        }

        $alat->update($data);

        return redirect()->route('admin.alat.index')->with('success', 'Data alat berhasil diperbarui.');
    }

    // 6. Menghapus data alat
    public function destroyAlat($id)
    {
        $alat = Alat::findOrFail($id);

        // Cek apakah alat ini masih ada di peminjaman yang belum selesai
        $sedangDipinjam = DetailPinjam::whereHas('peminjaman', function ($query) {
                $query->whereIn('status', ['diajukan', 'dipinjam', 'telat', 'dikembalikan']);
            })
            ->where('alat_id', $alat->id)
            ->exists();

        if ($sedangDipinjam) {
            return redirect()->route('admin.alat.index')
                ->with('error', 'Alat sedang dipinjam, tidak dapat dihapus');
        }

        // Hapus file gambar fisik jika ada
        if ($alat->gambar && file_exists(public_path($alat->gambar))) {
            unlink(public_path($alat->gambar));
        }

        $alat->delete();

        return redirect()->route('admin.alat.index')->with('success', 'Data alat berhasil dihapus.');
    }

    // ========================
    // KELOLA KATEGORI
    // ========================

    // 1. Menampilkan daftar kategori
    public function indexKategori(Request $request)
    {
        $search = $request->input('search');

        $kategoris = Kategori::when($search, function ($query, $search) {
            return $query->where('nama_kategori', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.kategori.index', compact('kategoris', 'search'));
    }

    // 2. Menampilkan form tambah kategori
    public function createKategori()
    {
        return view('admin.kategori.create');
    }

    // 3. Menyimpan kategori baru
    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // 4. Menampilkan form edit kategori
    public function editKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    // 5. Memperbarui kategori
    public function updateKategori(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $id,
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    // 6. Menghapus kategori
    public function destroyKategori($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Cek apakah kategori masih dipakai oleh alat
        if ($kategori->alat()->count() > 0) {
            return redirect()->route('admin.kategori.index')
                ->with('error', 'Kategori masih digunakan oleh alat, tidak dapat dihapus');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

    // ========================
    // KELOLA PEMINJAMAN
    // ========================

    // 1. Menampilkan daftar peminjaman
    public function indexPeminjaman(Request $request)
    {
        $search = $request->input('search');

        $peminjamans = Peminjaman::with(['user', 'detailPinjam.alat', 'pengembalian'])
            ->when($search, function ($query, $search) {
                return $query->where('status', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.peminjaman.index', compact('peminjamans', 'search'));
    }

    // 2. Menampilkan form tambah peminjaman
    public function createPeminjaman()
    {
        $users = User::where('role', 'peminjam')->get(); // Atau ambil semua user jika bebas
        $alats = Alat::where('stok', '>', 0)->get();
        return view('admin.peminjaman.create', compact('users', 'alats'));
    }

    // 3. Menyimpan data peminjaman baru
    public function storePeminjaman(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali_plan' => 'required|date|after_or_equal:tgl_pinjam',
            'alat_id' => 'required|array',
            'alat_id.*' => 'exists:alats,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Buat transaksi utama peminjaman
            $peminjaman = Peminjaman::create([
                'user_id' => $request->user_id,
                'tgl_pinjam' => $request->tgl_pinjam,
                'tgl_kembali_plan' => $request->tgl_kembali_plan,
                'status' => 'diajukan', // Status awal
            ]);

            // Simpan detail alat yang dipinjam
            foreach ($request->alat_id as $index => $alatId) {
                $jumlahPinjam = $request->jumlah[$index];

                $alat = Alat::findOrFail($alatId);

                // Validasi stok
                if ($alat->stok < $jumlahPinjam) {
                    throw new \Exception("Stok alat '{$alat->nama_alat}' tidak mencukupi.");
                }

                DetailPinjam::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_id' => $alatId,
                    'jumlah' => $jumlahPinjam,
                ]);

                // Stok dikurangi saat status berubah jadi 'dipinjam' (lihat updateStatusPeminjaman)
            }

            DB::commit();
            return redirect()->route('admin.peminjaman.index')->with('success', 'Data peminjaman berhasil diajukan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    // 4. Memperbarui status peminjaman (alur satu arah: diajukan -> dipinjam -> telat/dikembalikan -> selesai)
    public function updateStatusPeminjaman(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('detailPinjam.alat')->findOrFail($id);

        $request->validate([
            'status' => 'required|in:diajukan,dipinjam,selesai,dikembalikan,telat',
        ]);

        // Guard di sisi server: kalau peminjaman ini sudah punya record Pengembalian
        // (sudah diverifikasi & diproses petugas lewat Kelola Pengembalian),
        // jangan biarkan diubah lagi lewat dropdown ini.
        // Dicek dari record Pengembalian, BUKAN dari nama status — karena status
        // 'telat' punya dua makna: (1) masih dipinjam tapi lewat tenggat (belum final),
        // dan (2) sudah dikembalikan tapi kena denda telat (sudah final).
        if ($peminjaman->pengembalian()->exists()) {
            return back()->with('error', 'Peminjaman ini sudah diproses lewat Kelola Pengembalian dan tidak bisa diubah lewat sini.');
        }

        $statusLama = $peminjaman->status;
        $statusBaru = $request->status;

        if ($statusLama === $statusBaru) {
            return back()->with('error', "Status sudah '{$statusLama}'.");
        }

        // Transisi yang diizinkan (satu arah, tidak bisa mundur)
        $transisi = [
            'diajukan'     => ['dipinjam'],
            'dipinjam'     => ['telat', 'dikembalikan', 'selesai'],
            'telat'        => ['dikembalikan', 'selesai'],
            'dikembalikan' => ['selesai'],
            'selesai'      => [],
        ];

        if (!in_array($statusBaru, $transisi[$statusLama] ?? [])) {
            return back()->with('error', "Status tidak bisa diubah dari '{$statusLama}' ke '{$statusBaru}'.");
        }

        // Stok "tertahan" selama alat belum diproses kembali oleh petugas
        // (stok baru kembali di storePengembalian atau saat keluar dari kelompok ini).
        $tertahan = ['dipinjam', 'telat', 'dikembalikan'];
        $tertahanLama = in_array($statusLama, $tertahan);
        $tertahanBaru = in_array($statusBaru, $tertahan);

        DB::beginTransaction();
        try {
            if (!$tertahanLama && $tertahanBaru) {
                // Baru resmi dipinjam sekarang -> kurangi stok
                foreach ($peminjaman->detailPinjam as $detail) {
                    $alat = $detail->alat;
                    if ($alat->stok < $detail->jumlah) {
                        throw new \Exception("Stok alat {$alat->nama_alat} tidak mencukupi untuk dipinjam.");
                    }
                    $alat->decrement('stok', $detail->jumlah);
                }
            } elseif ($tertahanLama && !$tertahanBaru) {
                // Keluar dari kelompok tertahan (ke selesai) -> kembalikan stok
                foreach ($peminjaman->detailPinjam as $detail) {
                    $detail->alat->increment('stok', $detail->jumlah);
                }
            }
            // Perpindahan antar status tertahan (mis. dipinjam -> telat) tidak mengubah stok.

            $peminjaman->update(['status' => $statusBaru]);

            LogAktivitas::create([
                'user_id' => auth()->id(),
                'aktivitas' => "Mengubah status peminjaman #{$peminjaman->id} dari '{$statusLama}' menjadi '{$statusBaru}'",
            ]);

            DB::commit();
            return redirect()->route('admin.peminjaman.index')->with('success', 'Status peminjaman berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // 5. Menghapus data peminjaman
    public function destroyPeminjaman($id)
    {
        $peminjaman = Peminjaman::with('detailPinjam')->findOrFail($id);

        // Tolak hapus kalau peminjaman masih aktif (alat belum beneran kembali)
        if (in_array($peminjaman->status, ['dipinjam', 'telat', 'dikembalikan'])) {
            return redirect()->route('admin.peminjaman.index')
                ->with('error', 'Data peminjaman masih aktif, tidak dapat dihapus');
        }

        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }

    // ========================
    // KELOLA PENGEMBALIAN
    // ========================

    // 1. Menampilkan riwayat pengembalian
    public function indexPengembalian(Request $request)
    {
        $search = $request->input('search');

        $pengembalians = Pengembalian::with(['peminjaman.user', 'peminjaman.detailPinjam.alat', 'petugas'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('peminjaman.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pengembalian.index', compact('pengembalians', 'search'));
    }

    // 2. Menampilkan daftar peminjaman yang sudah diajukan pengembaliannya oleh peminjam (menunggu verifikasi petugas)
    public function selectPengembalian()
    {
        // Hanya peminjaman berstatus 'dikembalikan' (sudah diajukan lewat
        // PeminjamController::ajukanPengembalian) yang boleh muncul di sini.
        // Tidak memakai 'dipinjam'/'telat' karena keduanya berarti alat masih
        // di tangan peminjam dan belum ada pengajuan pengembalian sama sekali.
        $peminjamans = Peminjaman::with(['user', 'detailPinjam.alat'])
            ->where('status', 'dikembalikan')
            ->whereDoesntHave('pengembalian')
            ->latest()
            ->get();

        return view('admin.pengembalian.pilih', compact('peminjamans'));
    }

    // 3. Menampilkan form proses pengembalian untuk 1 peminjaman
    public function createPengembalian($id)
    {
        $peminjaman = Peminjaman::with(['user', 'detailPinjam.alat'])->findOrFail($id);

        // Hitung estimasi denda kalau dikembalikan hari ini
        $estimasiDenda = Pengembalian::hitungDenda($peminjaman->tgl_kembali_plan, now()->toDateString());

        return view('admin.pengembalian.create', compact('peminjaman', 'estimasiDenda'));
    }

    // 4. Menyimpan data pengembalian
    public function storePengembalian(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('detailPinjam.alat')->findOrFail($id);

        // Guard: cegah pengembalian diproses dua kali (stok akan bertambah dobel)
        if ($peminjaman->pengembalian()->exists()) {
            return redirect()->route('admin.pengembalian.index')
                ->with('error', 'Pengembalian untuk peminjaman ini sudah diproses.');
        }

        $request->validate([
            'tgl_kembali' => 'required|date',
            'kondisi_kembali' => 'required|string|max:100',
        ]);

        DB::beginTransaction();
        try {
            // Hitung denda otomatis berdasarkan keterlambatan (bukan dari input form)
            $denda = Pengembalian::hitungDenda($peminjaman->tgl_kembali_plan, $request->tgl_kembali);

            // Tentukan status akhir sesuai enum yang valid: 'dikembalikan' atau 'telat'
            $statusAkhir = $denda > 0 ? 'telat' : 'dikembalikan';

            Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'tgl_kembali' => $request->tgl_kembali,
                'kondisi_kembali' => $request->kondisi_kembali,
                'denda' => $denda,
                'petugas_id' => auth()->id(),
            ]);

            // Kembalikan stok untuk semua alat yang dipinjam
            foreach ($peminjaman->detailPinjam as $detail) {
                $detail->alat->increment('stok', $detail->jumlah);
            }

            $peminjaman->update(['status' => $statusAkhir]);

            LogAktivitas::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Memproses pengembalian alat untuk peminjaman #' . $peminjaman->id . " (status: {$statusAkhir}, denda: Rp{$denda})",
            ]);

            DB::commit();
            return redirect()->route('admin.pengembalian.index')->with('success', 'Pengembalian berhasil diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    // 5. Menampilkan form edit pengembalian
    public function editPengembalian($id)
    {
        $pengembalian = Pengembalian::with(['peminjaman.user', 'peminjaman.detailPinjam.alat'])->findOrFail($id);
        return view('admin.pengembalian.edit', compact('pengembalian'));
    }

    // 6. Memperbarui data pengembalian
    public function updatePengembalian(Request $request, $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        $request->validate([
            'tgl_kembali' => 'required|date',
            'kondisi_kembali' => 'required|string|max:100',
            'denda' => 'nullable|integer|min:0',
        ]);

        $pengembalian->update([
            'tgl_kembali' => $request->tgl_kembali,
            'kondisi_kembali' => $request->kondisi_kembali,
            'denda' => $request->denda ?? 0,
        ]);

        return redirect()->route('admin.pengembalian.index')->with('success', 'Data pengembalian berhasil diperbarui.');
    }

    // 7. Menghapus data pengembalian (membatalkan proses pengembalian)
    public function destroyPengembalian($id)
    {
        $pengembalian = Pengembalian::with('peminjaman.detailPinjam.alat')->findOrFail($id);
        $peminjaman = $pengembalian->peminjaman;

        DB::beginTransaction();
        try {
            // Kurangi lagi stok karena pengembalian dibatalkan
            foreach ($peminjaman->detailPinjam as $detail) {
                $detail->alat->decrement('stok', $detail->jumlah);
            }

            $peminjaman->update(['status' => 'dipinjam']);
            $pengembalian->delete();

            DB::commit();
            return redirect()->route('admin.pengembalian.index')->with('success', 'Data pengembalian berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // ========================
    // LOG AKTIVITAS
    // ========================

    public function indexLog(Request $request)
    {
        $search = $request->input('search');

        $logs = LogAktivitas::with('user')
            ->when($search, function ($query, $search) {
                return $query->where('aktivitas', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.log.index', compact('logs', 'search'));
    }

    // ========================
    // KELOLA USER
    // (Manajemen User: Admin, Petugas, Peminjam)
    // Mendukung fitur search dan pagination
    // ========================

    public function indexUser(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10) // Tampilkan 10 data per halaman
            ->withQueryString(); // Memastikan parameter search tetap ada saat pindah halaman

        return view('admin.user.index', compact('users', 'search'));
    }

    public function createUser()
    {
        return view('admin.user.create');
    }

    // Menyimpan user baru ke database
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,petugas,peminjam',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    // Memperbarui data user
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,petugas,peminjam',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'no_hp' => $request->no_hp,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.index')->with('success', 'Data user berhasil diperbarui.');
    }

    // Menghapus user
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        // Cek apakah user masih punya peminjaman yang aktif (belum selesai)
        $adaPeminjamanAktif = Peminjaman::where('user_id', $user->id)
            ->whereIn('status', ['diajukan', 'dipinjam', 'telat', 'dikembalikan'])
            ->exists();

        if ($adaPeminjamanAktif) {
            return redirect()->route('admin.user.index')
                ->with('error', 'User masih memiliki peminjaman aktif');
        }

        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }
}