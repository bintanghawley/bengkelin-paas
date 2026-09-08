<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServisController extends Controller
{
    public function index()
    {
        $services = Service::withCount('items')->orderBy('created_at', 'asc')->get();
        return view('toko.servis', compact('services'));
    }

    public function show(string $slug)
    {
        $service = Service::where('slug', $slug)->with('items')->firstOrFail();
        return view('toko.servis-detail', compact('service'));
    }
}


