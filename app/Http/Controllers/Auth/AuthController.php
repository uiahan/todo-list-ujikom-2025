<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        return view('pages.auth.login');
    }

    public function login(Request $request) {
        $data = $request->only('username', 'password');

        if (Auth::attempt($data)) {
            $user = Auth::user();

            if ($user->role == 'admin') {
                return redirect()->route('dashboard.admin')->with('success', 'Berhasil login, halloo selamat datang.');
            } elseif ($user->role == 'tasker') {
                return redirect()->route('dashboard.tasker')->with('success', 'Berhasil login, halloo selamat datang.');
            } if ($user->role == 'worker') {
                return redirect()->route('dashboard.worker')->with('success', 'Berhasil login, halloo selamat datang.');
            }
        }
        return redirect()->back()->with('error', 'username atau password salah');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index')->with('success', 'Berhasil logout.');
    }
}
