<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('login'); // Mengarahkan ke file resources/views/auth/register.blade.php
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Login user yang baru dibuat
        Auth::login($user);

        // Jika sukses, kirim respons JSON untuk redirect
        return response()->json([
            'status' => 'success',
            'redirect' => url('/dashboard')
        ]);
    }

    public function showLoginForm()
    {
        return view('login'); // Mengarahkan ke file resources/views/auth/login.blade.php
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Jika sukses, kirim respons JSON untuk redirect
            return response()->json([
                'status' => 'success',
                'redirect' => url('/dashboard')
            ]);
        }
        
        // Jika otentikasi gagal, lempar ValidationException secara manual
        // Ini akan otomatis diubah menjadi respons JSON error 422 oleh Laravel
        throw ValidationException::withMessages([
           'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Redirect ke halaman utama
    }
}
