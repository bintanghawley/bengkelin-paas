<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        $redirect = $request->query('redirect');
        if (is_string($redirect) && $this->isSafeRedirect($redirect)) {
            $request->session()->put('url.intended', $redirect);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_telepon' => ['required', 'regex:/^08[0-9]{8,11}$/'],
            'password' => 'required',
        ], [
            'nomor_telepon.required' => 'Nomor telepon wajib diisi',
            'nomor_telepon.regex' => 'Format nomor telepon tidak valid (contoh: 08xxxxxxxxxx)',
            'password.required' => 'Password wajib diisi',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()->toArray(),
                ], 422);
            }

            return back()->withErrors($validator)->withInput($request->only('nomor_telepon'));
        }

        if (! Auth::attempt($validator->validated())) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor telepon atau password salah',
                ], 401);
            }

            return back()->withInput($request->only('nomor_telepon'))->with('error', 'Nomor telepon atau password salah');
        }

        $request->session()->regenerate();
        $redirectUrl = Auth::user()->role === 'pengguna'
            ? redirect()->intended($this->getRedirectUrl('pengguna'))->getTargetUrl()
            : $this->getRedirectUrl(Auth::user()->role);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'redirect' => $redirectUrl,
            ]);
        }

        return redirect($redirectUrl)->with('success', 'Login berhasil');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nomor_telepon' => ['required', 'regex:/^08[0-9]{8,11}$/', 'unique:users,nomor_telepon'],
            'password' => 'required|min:6',
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'nomor_telepon.required' => 'Nomor telepon wajib diisi',
            'nomor_telepon.regex' => 'Format nomor telepon tidak valid (contoh: 08xxxxxxxxxx)',
            'nomor_telepon.unique' => 'Nomor telepon sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()->toArray(),
                ], 422);
            }

            return back()->withErrors($validator)->withInput($request->only('name', 'nomor_telepon'));
        }

        $validated = $validator->validated();

        $user = User::create([
            'name' => $validated['name'],
            'nomor_telepon' => $validated['nomor_telepon'],
            'password' => Hash::make($validated['password']),
            'role' => 'pengguna',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        $redirectUrl = route('pengguna.dashboard', ['section' => 'profil']);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil',
                'redirect' => $redirectUrl,
            ]);
        }

        return redirect($redirectUrl)->with('success', 'Registrasi berhasil');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logout berhasil');
    }

    private function isSafeRedirect(string $redirect): bool
    {
        if (str_starts_with($redirect, '/')) {
            return ! str_starts_with($redirect, '//');
        }

        return str_starts_with($redirect, url('/').'/');
    }

    private function redirectByRole(string $role)
    {
        return redirect($this->getRedirectUrl($role));
    }

    private function getRedirectUrl(string $role): string
    {
        if ($role === 'admin') {
            return route('admin.dashboard', ['section' => 'profile']);
        }
        if ($role === 'mekanik') {
            return route('mekanik.dashboard', ['section' => 'profil']);
        }

        return route('pengguna.dashboard', ['section' => 'profil']);
    }
}
