<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showSignup() {
        return view('auth.signup');
    }

    public function signup(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => now(), 'updated_at' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil terdaftar! Silakan Sign In.');
    }

    public function showSignin() {
        return view('auth.signin');
    }

    public function signin(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // Mengembalikan input email lama (old) agar user tidak repot mengetik ulang jika password salah
        return back()->withInput($request->only('email'))->withErrors([
            'auth_error' => 'Password salah atau email tidak terdaftar.',
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}