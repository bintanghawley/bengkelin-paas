<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SparepartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spareparts = Sparepart::orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data sparepart berhasil diambil',
            'data' => $spareparts,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'            => 'required|string|max:255',
            'harga'           => 'required|numeric|min:0',
            'stok'            => 'required|integer|min:0',
            'jenis_sparepart' => 'required|string',
            'merek'           => 'required|string',
            'gambar'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'       => 'nullable|string',
            'fitur'           => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->only([
            'nama', 'harga', 'stok', 'jenis_sparepart', 
            'merek', 'deskripsi', 'fitur'
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('spareparts', 'public');
        }

        $sparepart = Sparepart::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Sparepart berhasil ditambahkan',
            'data' => $sparepart,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sparepart = Sparepart::find($id);

        if (!$sparepart) {
            return response()->json([
                'status' => false,
                'message' => 'Sparepart tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data sparepart berhasil diambil',
            'data' => $sparepart,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $sparepart = Sparepart::find($id);

        if (!$sparepart) {
            return response()->json([
                'status' => false,
                'message' => 'Sparepart tidak ditemukan',
                'data' => null,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama'            => 'sometimes|required|string|max:255',
            'harga'           => 'sometimes|required|numeric|min:0',
            'stok'            => 'sometimes|required|integer|min:0',
            'jenis_sparepart' => 'sometimes|required|string',
            'merek'           => 'sometimes|required|string',
            'gambar'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'       => 'nullable|string',
            'fitur'           => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->only([
            'nama', 'harga', 'stok', 'jenis_sparepart', 
            'merek', 'deskripsi', 'fitur'
        ]);

        if ($request->hasFile('gambar')) {
            if ($sparepart->gambar) {
                Storage::disk('public')->delete($sparepart->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('spareparts', 'public');
        }

        $sparepart->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Sparepart berhasil diperbarui',
            'data' => $sparepart,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sparepart = Sparepart::find($id);

        if (!$sparepart) {
            return response()->json([
                'status' => false,
                'message' => 'Sparepart tidak ditemukan',
                'data' => null,
            ], 404);
        }

        if ($sparepart->gambar) {
            Storage::disk('public')->delete($sparepart->gambar);
        }

        $sparepart->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sparepart berhasil dihapus',
            'data' => null,
        ], 200);
    }
}
