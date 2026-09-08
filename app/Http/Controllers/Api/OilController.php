<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Oil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $oils = Oil::orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data oli motor berhasil diambil',
            'data' => $oils,
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
            'jenis_oli'  => 'required|string',
            'kekentalan' => 'required|string',
            'ukuran'     => 'required|string',
            'tipe_oli'   => 'required|string',
            'merek'      => 'required|string',
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
            'nama', 'harga', 'stok', 'jenis_oli', 'kekentalan', 
            'ukuran', 'tipe_oli', 'merek', 'deskripsi', 'fitur'
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('oils', 'public');
        }

        $oil = Oil::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Oli motor berhasil ditambahkan',
            'data' => $oil,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $oil = Oil::find($id);

        if (!$oil) {
            return response()->json([
                'status' => false,
                'message' => 'Oli motor tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data oli motor berhasil diambil',
            'data' => $oil,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $oil = Oil::find($id);

        if (!$oil) {
            return response()->json([
                'status' => false,
                'message' => 'Oli motor tidak ditemukan',
                'data' => null,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama'       => 'sometimes|required|string|max:255',
            'harga'      => 'sometimes|required|numeric|min:0',
            'stok'       => 'sometimes|required|integer|min:0',
            'jenis_oli'  => 'sometimes|required|string',
            'kekentalan' => 'sometimes|required|string',
            'ukuran'     => 'sometimes|required|string',
            'tipe_oli'   => 'sometimes|required|string',
            'merek'      => 'sometimes|required|string',
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
            'nama', 'harga', 'stok', 'jenis_oli', 'kekentalan', 
            'ukuran', 'tipe_oli', 'merek', 'deskripsi', 'fitur'
        ]);

        if ($request->hasFile('gambar')) {
            if ($oil->gambar) {
                Storage::disk('public')->delete($oil->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('oils', 'public');
        }

        $oil->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Oli motor berhasil diperbarui',
            'data' => $oil,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $oil = Oil::find($id);

        if (!$oil) {
            return response()->json([
                'status' => false,
                'message' => 'Oli motor tidak ditemukan',
                'data' => null,
            ], 404);
        }

        if ($oil->gambar) {
            Storage::disk('public')->delete($oil->gambar);
        }

        $oil->delete();

        return response()->json([
            'status' => true,
            'message' => 'Oli motor berhasil dihapus',
            'data' => null,
        ], 200);
    }
}
