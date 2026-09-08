<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
{
    // Ambil semua data produk dari database
    $products = Product::all(); 

    // Return ke file blade tempat kamu menaruh grid HTML tadi
    // Misalnya nama filenya: resources/views/home.blade.php atau resources/views/products.blade.php
    return view('home', compact('products')); 
}
    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required',
            'harga'    => 'required|numeric',
            'stok'     => 'required|numeric',
            'kategori' => 'required|in:sparepart,ban,oli',
            'gambar'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['nama', 'harga', 'stok', 'kategori', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            $uploaded = $this->uploadGambar($request->file('gambar'), 'products');
            if ($uploaded) {
                $data['gambar'] = $uploaded;
            }
        }

        Product::create($data);
        return back()->with('success', 'Barang berhasil ditambah!');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama'     => 'required',
            'harga'    => 'required|numeric',
            'stok'     => 'required|numeric',
            'kategori' => 'required|in:sparepart,ban,oli',
            'gambar'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['nama', 'harga', 'stok', 'kategori', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            if ($product->gambar && !str_starts_with($product->gambar, 'img/')) {
                $disk = config('filesystems.default', 'public');
                try {
                    Storage::disk($disk)->delete($product->gambar);
                } catch (\Throwable $e) {
                    Storage::disk('public')->delete($product->gambar);
                }
            }
            $uploaded = $this->uploadGambar($request->file('gambar'), 'products');
            if ($uploaded) {
                $data['gambar'] = $uploaded;
            }
        }

        $product->update($data);
        return back()->with('success', 'Produk diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->gambar && !str_starts_with($product->gambar, 'img/')) {
            $disk = config('filesystems.default', 'public');
            try {
                Storage::disk($disk)->delete($product->gambar);
            } catch (\Throwable $e) {
                Storage::disk('public')->delete($product->gambar);
            }
        }
        
        $product->delete();
        return back()->with('success', 'Barang dihapus!');
    }

    private function uploadGambar($file, string $folder): ?string
    {
        $defaultDisk = config('filesystems.default', 'public');

        if ($defaultDisk === 's3') {
            try {
                $path = $file->store($folder, 's3');
                if ($path) {
                    return $path;
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning("S3 upload failed: " . $e->getMessage());
            }
        }

        try {
            $path = $file->store($folder, 'public');
            if ($path) {
                return $path;
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Public storage upload failed: " . $e->getMessage());
        }

        return null;
    }
}