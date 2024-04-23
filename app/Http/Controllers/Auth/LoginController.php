<?php
// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Jika autentikasi berhasil, arahkan pengguna ke halaman selamat datang
            return redirect()->route('welcome');
        }

        // Jika autentikasi gagal, kembali ke halaman login dengan pesan kesalahan
        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput($request->only('email'));
    }
}