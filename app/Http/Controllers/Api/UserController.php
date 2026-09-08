<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data users berhasil diambil',
            'data' => $users,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'nomor_telepon' => ['required', 'string', 'regex:/^08[0-9]{8,11}$/', 'unique:users,nomor_telepon'],
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,mekanik,pengguna',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $user = User::create([
            'name' => $validated['name'],
            'nomor_telepon' => $validated['nomor_telepon'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User berhasil ditambahkan',
            'data' => $user,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil diambil',
            'data' => $user,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan',
                'data' => null,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'nomor_telepon' => [
                'sometimes',
                'required',
                'string',
                'regex:/^08[0-9]{8,11}$/',
                Rule::unique('users', 'nomor_telepon')->ignore($user->id)
            ],
            'password' => 'nullable|string|min:6',
            'role' => 'sometimes|required|in:admin,mekanik,pengguna',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $data = [];
        if (isset($validated['name'])) {
            $data['name'] = $validated['name'];
        }
        if (isset($validated['nomor_telepon'])) {
            $data['nomor_telepon'] = $validated['nomor_telepon'];
        }
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }
        if (isset($validated['role'])) {
            $data['role'] = $validated['role'];
        }

        $user->update($data);

        return response()->json([
            'status' => true,
            'message' => 'User berhasil diperbarui',
            'data' => $user,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan',
                'data' => null,
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User berhasil dihapus',
            'data' => null,
        ], 200);
    }
}
