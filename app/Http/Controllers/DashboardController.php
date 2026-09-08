<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard', ['section' => 'profile']);
        }

        if ($role === 'mekanik') {
            return redirect()->route('mekanik.dashboard', ['section' => 'profil']);
        }

        return redirect()->route('pengguna.dashboard', ['section' => 'profil']);
    }
}
