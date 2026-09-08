<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::with('items')->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data layanan servis berhasil diambil',
            'data' => $services,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'           => 'required|string|max:255',
            'deskripsi'      => 'required|string',
            'harga_mulai'    => 'required|integer|min:0',
            'estimasi_waktu' => 'required|string|max:100',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'items'          => 'nullable|array',
            'items.*'        => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $service = DB::transaction(function () use ($validated, $request) {
            $slug = Str::slug($validated['nama']);
            $baseSlug = $slug;
            $counter = 1;
            while (Service::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }

            $gambarPath = null;
            if ($request->hasFile('gambar')) {
                $gambarPath = $request->file('gambar')->store('services', 'public');
            }

            $service = Service::create([
                'nama'           => $validated['nama'],
                'slug'           => $slug,
                'deskripsi'      => $validated['deskripsi'],
                'harga_mulai'    => $validated['harga_mulai'],
                'estimasi_waktu' => $validated['estimasi_waktu'],
                'gambar'         => $gambarPath,
            ]);

            if (!empty($validated['items'])) {
                foreach ($validated['items'] as $item) {
                    if (!empty(trim($item))) {
                        ServiceItem::create([
                            'service_id'     => $service->id,
                            'nama_pekerjaan' => trim($item),
                        ]);
                    }
                }
            }

            return $service;
        });

        $service->load('items');

        return response()->json([
            'status' => true,
            'message' => 'Layanan servis berhasil ditambahkan',
            'data' => $service,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $service = Service::with('items')->find($id);

        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'Layanan servis tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data layanan servis berhasil diambil',
            'data' => $service,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'Layanan servis tidak ditemukan',
                'data' => null,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama'           => 'sometimes|required|string|max:255',
            'deskripsi'      => 'sometimes|required|string',
            'harga_mulai'    => 'sometimes|required|integer|min:0',
            'estimasi_waktu' => 'sometimes|required|string|max:100',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'items'          => 'nullable|array',
            'items.*'        => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $service = DB::transaction(function () use ($validated, $request, $service) {
            $data = [];
            
            if (isset($validated['nama'])) {
                $slug = Str::slug($validated['nama']);
                $baseSlug = $slug;
                $counter = 1;
                while (Service::where('slug', $slug)->where('id', '!=', $service->id)->exists()) {
                    $slug = $baseSlug . '-' . $counter++;
                }
                $data['nama'] = $validated['nama'];
                $data['slug'] = $slug;
            }

            if (isset($validated['deskripsi'])) {
                $data['deskripsi'] = $validated['deskripsi'];
            }

            if (isset($validated['harga_mulai'])) {
                $data['harga_mulai'] = $validated['harga_mulai'];
            }

            if (isset($validated['estimasi_waktu'])) {
                $data['estimasi_waktu'] = $validated['estimasi_waktu'];
            }

            if ($request->hasFile('gambar')) {
                if ($service->gambar) {
                    Storage::disk('public')->delete($service->gambar);
                }
                $data['gambar'] = $request->file('gambar')->store('services', 'public');
            }

            $service->update($data);

            if (isset($validated['items'])) {
                // Hapus semua item lama lalu buat ulang
                $service->items()->delete();

                foreach ($validated['items'] as $item) {
                    if (!empty(trim($item))) {
                        ServiceItem::create([
                            'service_id'     => $service->id,
                            'nama_pekerjaan' => trim($item),
                        ]);
                    }
                }
            }

            return $service;
        });

        $service->load('items');

        return response()->json([
            'status' => true,
            'message' => 'Layanan servis berhasil diperbarui',
            'data' => $service,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'Layanan servis tidak ditemukan',
                'data' => null,
            ], 404);
        }

        if ($service->gambar) {
            Storage::disk('public')->delete($service->gambar);
        }

        $service->delete(); // cascade will delete items

        return response()->json([
            'status' => true,
            'message' => 'Layanan servis berhasil dihapus',
            'data' => null,
        ], 200);
    }
}
