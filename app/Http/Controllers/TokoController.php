<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokoController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->get('kategori'); // null, 'sparepart', 'ban', 'oli'

        $query = Product::where('stok', '>', 0);

        if ($kategori && in_array($kategori, ['sparepart', 'ban', 'oli'])) {
            $query->where('kategori', $kategori);
        }

        $products = $query->latest()->get();

        return view('toko.index', compact('products', 'kategori'));
    }

    public function show($id)
    {
        $product = Product::where('stok', '>', 0)->findOrFail($id);

        return view('toko.show', compact('product'));
    }

    public function checkout($id)
    {
        $product = Product::where('stok', '>', 0)->findOrFail($id);
        $user = Auth::user();

        return view('toko.checkout', compact('product', 'user'));
    }

    public function buy(Request $request, $id)
    {
        $product = Product::where('stok', '>', 0)->findOrFail($id);

        $request->validate([
            'jumlah' => 'required|integer|min:1|max:' . $product->stok,
            'alamat' => 'required_if:metode_pembayaran,COD|nullable|string|max:500',
            'telepon' => 'required_if:metode_pembayaran,COD|nullable|string|max:20',
            'metode_pembayaran' => 'required|in:COD,Transfer Bank',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $jumlah = (int) $request->input('jumlah');
        $totalHarga = $product->harga * $jumlah;

        // Kurangi stok
        $product->decrement('stok', $jumlah);

        $purchaseStatus = $request->input('metode_pembayaran') === 'Transfer Bank' 
            ? 'menunggu_pembayaran' 
            : 'diproses';

        $purchase = Purchase::create([
            'user_id'           => Auth::id(),
            'barang_id'         => $product->id,
            'barang_nama'       => $product->nama,
            'harga'             => $product->harga,
            'jumlah'            => $jumlah,
            'total_harga'       => $totalHarga,
            'alamat'            => $request->input('alamat'),
            'telepon'           => $request->input('telepon'),
            'metode_pembayaran' => $request->input('metode_pembayaran'),
            'catatan'           => $request->input('catatan'),
            'status'            => $purchaseStatus,
        ]);

        if ($request->input('metode_pembayaran') === 'Transfer Bank') {
            $payment = \App\Models\Payment::create([
                'invoice_number' => \App\Models\Payment::generateInvoice(),
                'amount'         => $totalHarga,
                'status'         => 'pending',
                'expired_at'     => now()->addHour(),
            ]);

            $purchase->update(['payment_id' => $payment->id]);

            return redirect()->route('pengguna.payments.show', $payment->id);
        }

        return redirect()->route('toko.result', $purchase->id)
            ->with('success', 'Pembelian berhasil! Pesanan Anda sedang diproses.');
    }

    public function result(Purchase $purchase)
    {
        // Pastikan user hanya bisa lihat pembelian miliknya
        if ($purchase->user_id !== Auth::id()) {
            abort(403);
        }

        return view('toko.hasil', compact('purchase'));
    }
}
