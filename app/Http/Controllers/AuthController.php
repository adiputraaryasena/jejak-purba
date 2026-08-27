<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Process Masuk Mode Tamu (Guest) - Diperbaiki agar tidak error 500
    public function playAsGuest(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:20',
        ]);

        // Menggunakan kolom standar (name dan email dummy unik) agar tidak error jika kolom custom belum dimigrasi di Railway
        $user = User::create([
            'name' => $request->username,
            'email' => 'guest_' . time() . rand(100,999) . '@jejakpurba.test',
            'password' => Hash::make('guest12345'),
        ]);

        Auth::login($user);

        return redirect()->route('game.home');
    }

    // Process Register Akun
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('game.home');
    }

    // Process Login Akun
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('game.home');
        }

        return back()->withErrors(['email' => 'Email atau password salah!']);
    }

    // Process Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}