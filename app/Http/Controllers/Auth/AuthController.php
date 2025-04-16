<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->only('username', 'password');

        if (Auth::attempt($data)) {
            $user = Auth::user();

            if ($user->role == 'admin') {
                return redirect()->route('dashboard.admin')->with('success', 'Login successfully.');
            } elseif ($user->role == 'tasker') {
                return redirect()->route('dashboard.tasker')->with('success', 'Login successfully.');
            }
            if ($user->role == 'worker') {
                return redirect()->route('dashboard.worker')->with('success', 'Login successfully.');
            }
        }
        return redirect()->back()->with('error', 'Wrong username or password!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index')->with('success', 'Successfully logged out.');
    }

    public function registerShow()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'required|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => 'worker',
        ]);

        return redirect()->route('index')->with('success', 'Account created! Please login.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('pages.auth.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('profile')) {
            // Hapus file lama
            if ($user->profile && Storage::exists('public/' . $user->profile)) {
                Storage::delete('public/' . $user->profile);
            }

            $file = $request->file('profile');
            $path = $file->store('profile', 'public');
            $user->profile = $path;
        }

        // Update data
        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->phone_number = $validated['phone_number'];
        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password changed successfully!');
    }

}
