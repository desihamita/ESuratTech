<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;

class UserController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }

    public function login_proses(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'name' => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($request->only('name', 'password'))) {
            return redirect()->route('home.index')->with('success', 'Welcome!');
        } else {
            return redirect()->route('login')->with('failed', 'Email atau password salah!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    public function register()
    {
        return view('pages.auth.register');
    }

    public function register_proses(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::Create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful, please login.');
    }
}
