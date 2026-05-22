<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class HomeController extends Controller
{
    // Dashboard dengan Hitungan Chart & Ringkasan Tugas
    public function index() {
        $userId = Auth::id();
        $user = Auth::user();

        $totalPlus = DB::table('jam_kerjas')->where('user_id', $userId)->where('jenis', 'Plus')->sum('jumlah_jam');
        $totalMinus = DB::table('jam_kerjas')->where('user_id', $userId)->where('jenis', 'Minus')->sum('jumlah_jam');
        $saldoJam = $totalPlus - $totalMinus;

        $tugasBelum = DB::table('todos')->where('user_id', $userId)->where('status', 'Belum')->count();

        return view('dashboard', compact('user', 'saldoJam', 'totalPlus', 'totalMinus', 'tugasBelum'));
    }

    // Tampilan Menu Keamanan Password
    public function editPassword() {
        return view('password', ['user' => Auth::user()]);
    }

    // Proses Update Kata Sandi Akun dengan Validasi Kuat
    public function updatePassword(Request $request) {
        $request->validate([
            'old_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return back()->withErrors(['error' => 'Konfirmasi Password Lama Anda Salah!']);
        }

        DB::table('users')->where('id', Auth::id())->update([
            'password' => Hash::make($request->password),
            'updated_at' => now()
        ]);

        return redirect()->route('home')->with('success', 'Kata sandi akun Anda berhasil diperbarui!');
    }

    // Manajemen Tugas (To-Do)
    public function halamanTugas() {
        $todos = DB::table('todos')->where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('tugas', ['user' => Auth::user(), 'todos' => $todos]);
    }

    public function storeTodo(Request $request) {
        DB::table('todos')->insert([
            'user_id' => Auth::id(), 'judul_tugas' => $request->judul_tugas,
            'kategori' => $request->kategori, 'status' => 'Belum', 'created_at' => now()
        ]);
        return redirect()->route('tugas.index');
    }

    public function updateTodo($id) {
        DB::table('todos')->where('id', $id)->where('user_id', Auth::id())->update(['status' => 'Selesai']);
        return redirect()->route('tugas.index');
    }

    // Manajemen Rekap Jam Praktik
    public function halamanJam() {
        $jamKerja = DB::table('jam_kerjas')->where('user_id', Auth::id())->orderBy('tanggal', 'desc')->get();
        return view('jam_kerja', ['user' => Auth::user(), 'jamKerja' => $jamKerja]);
    }

    public function storeJam(Request $request) {
        DB::table('jam_kerjas')->insert([
            'user_id' => Auth::id(), 'keterangan' => $request->keterangan,
            'jenis' => $request->jenis, 'jumlah_jam' => $request->jumlah_jam,
            'tanggal' => $request->tanggal, 'created_at' => now()
        ]);
        return redirect()->route('jam.index');
    }
}