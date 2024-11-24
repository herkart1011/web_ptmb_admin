<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\pdam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function register()
    {
        return view('user/register', ['title' => 'Register']);
    }

    public function register_action(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:tb_user,username',
            'password' => 'required|string|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration success. Please login!');
    }

    public function login()
    {
        return view('user/login', ['title' => 'Login']);
    }

    public function login_action(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('username', 'password'))) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                $request->session()->put('is_admin', true);
            }

            return redirect()->intended('/');
        }

        return back()->withErrors(['username' => 'The provided credentials do not match our records.']);
    }

    public function password()
    {
        return view('user/password', ['title' => 'Change Password']);
    }

    public function password_action(Request $request)
    {
        $request->validate([
            'old_password' => 'required|current_password',
            'new_password' => 'required|string|confirmed',
        ]);

        $user = Auth::user();
        $user->update(['password' => Hash::make($request->new_password)]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Password changed successfully. Please login with your new password.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget('is_admin');

        return redirect('/');
    }

    public function editData()
    {
        return view('user/edit-data', ['title' => 'Edit Data']);
    }

    public function searchUser(Request $request)
    {
        $request->validate(['search_username' => 'required|string|max:255']);

        $user = User::where('username', $request->search_username)->first();

        return $user
            ? redirect()->route('edit-data')->with(['user' => $user, 'title' => 'Edit Data'])
            : redirect()->route('edit-data')->with(['error' => 'User tidak ditemukan.']);
    }

    public function searchPelanggan(Request $request)
    {
        $request->validate(['search_nomor_id_pelanggan' => 'required|string|max:255']);

        $pelanggan = pdam::where('nosamw', $request->search_nomor_id_pelanggan)->first();

        return $pelanggan
            ? redirect()->route('edit-data')->with(['pelanggan' => $pelanggan, 'title' => 'Edit Data'])
            : redirect()->route('edit-data')->with(['error' => 'Pelanggan tidak ditemukan.']);
    }

    public function updateDataPersonal(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:tb_user,username,' . $request->user_id . ',user_id',
            'password' => 'nullable|string|confirmed',
        ]);

        $user = User::find($request->user_id);

        if ($user) {
            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            ]);

            return redirect()->route('edit-data')->with('success', 'Data personal berhasil diperbarui!');
        }

        return redirect()->route('edit-data')->with('error', 'Data pengguna tidak ditemukan.');
    }

    public function updateDataPenggantian(Request $request)
    {
        $request->validate([
            'nosamw' => 'required|integer',
            'nilaikubik' => 'required|string|max:255',
            'nobody_wmb' => 'required|string|max:255',
        ]);

        $pelanggan = pdam::find($request->nosamw);

        if ($pelanggan) {
            $pelanggan->update([
                'nilaikubik' => $request->nilaikubik,
                'nobody_wmb' => $request->nobody_wmb,
            ]);

            return redirect()->route('edit-data')->with('success', 'Data penggantian berhasil diperbarui!');
        }

        return redirect()->route('edit-data')->with('error', 'Data pelanggan tidak ditemukan.');
    }
}
