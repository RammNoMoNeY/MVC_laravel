<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function halaman_register() {

        return view('auth.register');
    }

    public function proses_register(Request $request) {
        $validateData = $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'password_confirm' => 'required|same:password'

        ], [
            'nama.required' => 'Kolom Nama tidak boleh kosong !',
            'email.required' => 'Kolom Email tidak boleh kosong !',
            'email.unique' => 'Email sudah digunakan !',
            'password.required' => 'Kolom password tidak boleh kosong !',
            'password_confirm.required' => 'Kolom Konfirmasi password tidak boleh kosong !',
            'password_confirm.same' => 'Password tidak sama !',
        ]);
        
        $user = new User();

        $user->name = $request->nama;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if ($user->save() ) {
            return redirect('/login')->with([
                'notifikasi' => 'Register berhasil !',
                'type' => 'success'
            ]);

        } else {
            return redirect()->back()->with([
                'notifikasi' => 'Register gagal, Coba Kembali !',
                'type' => 'error'
            ]);
        
        }

    }

    public function halaman_login() {
        return view('auth.login');
    }

    public function proses_login(Request $request) {
        $validateData = $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ], [
            'email.required' => 'Kolom Email tidak boleh kosong !',
            'email.exists' => 'Email atau Password salah !',
            'password.required' => 'Kolom password tidak boleh kosong !',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            return redirect('/student')->with([
                'notifikasi' => 'Login berhasil !',
                'type' => 'success'
            ]);

        } else {
            return redirect()->back()->withErrors([
                'notifikasi' => 'Login gagal, E-Mail atau Password salah!',
                'type' => 'error'
            ])->withInput($request->except('password'));
        }
    }

    public function proses_logout(Request $request)
    {
        Auth::logout();

        return redirect('/login')->with([
            'notifikasi' => 'Logout berhasil !',
            'type' => 'success'
        ]);
    }

}
