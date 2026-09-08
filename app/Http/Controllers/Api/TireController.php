<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tires = Tire::orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data ban motor berhasil diambil',
            'data' => $tires,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'       => 'required|string|max:255',
            'harga'      => 'required|numeric|min:0',
            'stok'       => 'required|integer|min:0',
            'jenis_ban'  => 'required|string',
            'merek'      => 'required|string',
            'ukuran_ban' => 'required|string',
            'posisi_ban' => 'required|string',
            'material'   => 'required|string',
            'diameter'   => 'required|string',
            'tipe'       => 'required|string',
            'gambar'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'  => 'nullable|string',
            'fitur'      => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->only([
            'nama', 'harga', 'stok', 'jenis_ban', 'merek', 
            'ukuran_ban', 'posisi_ban', 'material', 'diameter', 
            'tipe', 'deskripsi', 'fitur'
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('tires', 'public');
        }

        $tire = Tire::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Ban motor berhasil ditambahkan',
            'data' => $tire,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tire = Tire::find($id);

        if (!$tire) {
            return response()->json([
                'status' => false,
                'message' => 'Ban motor tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data ban motor berhasil diambil',
            'data' => $tire,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tire = Tire::find($id);

        if (!$tire) {
            return response()->json([
                'status' => false,
                'message' => 'Ban motor tidak ditemukan',
                'data' => null,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama'       => 'sometimes|required|string|max:255',
            'harga'      => 'sometimes|required|numeric|min:0',
            'stok'       => 'sometimes|required|integer|min:0',
            'jenis_ban'  => 'sometimes|required|string',
            'merek'      => 'sometimes|required|string',
            'ukuran_ban' => 'sometimes|required|string',
            'posisi_ban' => 'sometimes|required|string',
            'material'   => 'sometimes|required|string',
            'diameter'   => 'sometimes|required|string',
            'tipe'       => 'sometimes|required|string',
            'gambar'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'  => 'nullable|string',
            'fitur'      => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->only([
            'nama', 'harga', 'stok', 'jenis_ban', 'merek', 
            'ukuran_ban', 'posisi_ban', 'material', 'diameter', 
            'tipe', 'deskripsi', 'fitur'
        ]);

        if ($request->hasFile('gambar')) {
            if ($tire->gambar) {
                Storage::disk('public')->delete($tire->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('tires', 'public');
        }

        $tire->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Ban motor berhasil diperbarui',
            'data' => $tire,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tire = Tire::find($id);

        if (!$tire) {
            return response()->json([
                'status' => false,
                'message' => 'Ban motor tidak ditemukan',
                'data' => null,
            ], 404);
        }

        if ($tire->gambar) {
            Storage::disk('public')->delete($tire->gambar);
        }

        $tire->delete();

        return response()->json([
            'status' => true,
            'message' => 'Ban motor berhasil dihapus',
            'data' => null,
        ], 200);
    }
}
