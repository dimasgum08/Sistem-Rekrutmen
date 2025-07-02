<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Register\RegisterRequest;
use App\Models\Applicant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Login',
        ];

        return view('auth.index', $data);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Masukan email anda',
            'password.required' => 'Masukan password anda'
        ]);

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return redirect()->back()->with(['message' => 'Email tidak ditemukan', 'type' => 'error']);
            }
            if (Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
                return redirect()->route('apps.dashboard')->with(['message' => 'Login berhasil, selamat datang ' . $user->name . '!', 'type' => 'success']);
            }

            return redirect()->back()->with(['message' => 'Username atau password salah', 'type' => 'error']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'type' => 'error']);
        }
    }


    public function register()
    {
        $data = [
            'title' => 'Buat Akun',
        ];

        return view('auth.register', $data);
    }

    public function store(RegisterRequest $request)
    {
        try {
            $applicant = Applicant::create($request->only(['name', 'email', 'telp', 'address', 'gender']));
            $request->merge(['password' => Hash::make($request->password), 'applicant_id' => $applicant->id]);
            $user = User::create($request->only(['name', 'email', 'username', 'password', 'applicant_id']));
            $user->assignRole('Applicant');
            Auth::login($user);
            return redirect()->route('apps.dashboard')->with(['message' => 'Register berhasil, selamat datang ' . $user->name . '!', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Error:' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with(['message' => 'Logout berhasil', 'type' => 'success']);
    }
}
