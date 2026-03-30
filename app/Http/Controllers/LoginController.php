<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function show() // anomali
    {
        return view('kasir');
    }

    public function auth(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role == 'Admin') {
                return redirect()->route('dashboard');
            } elseif (Auth::user()->role == 'Kasir') {
                return view('kasir');
            }
        }

        // Jika login gagal, kirim error ke session
        return redirect()->back()->withErrors(['login' => 'Email atau Password salah'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
