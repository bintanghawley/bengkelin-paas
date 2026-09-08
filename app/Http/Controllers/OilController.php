<?php

namespace App\Http\Controllers;

use App\Models\Oil;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OilController extends Controller
{
    public function index(Request $request)
    {
        $query = Oil::query();

        // 1. Filter Search
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->input('search') . '%');
        }

        // 2. Filter Kategori (Jenis Oli)
        if ($request->has('jenis_oli') && is_array($request->input('jenis_oli'))) {
            $query->whereIn('jenis_oli', $request->input('jenis_oli'));
        }

        // 3. Filter Kekentalan
        if ($request->has('kekentalan') && is_array($request->input('kekentalan'))) {
            $query->whereIn('kekentalan', $request->input('kekentalan'));
        }

        // 4. Filter Ukuran
        if ($request->has('ukuran') && is_array($request->input('ukuran'))) {
            $query->whereIn('ukuran', $request->input('ukuran'));
        }

        // 5. Filter Tipe Oli
        if ($request->has('tipe_oli') && is_array($request->input('tipe_oli'))) {
            $query->whereIn('tipe_oli', $request->input('tipe_oli'));
        }

        // 6. Filter Range Harga
        $minDbHarga = Oil::min('harga') ?? 0;
        $maxDbHarga = Oil::max('harga') ?? 500000;

        $hargaMin = $request->input('harga_min', $minDbHarga);
        $hargaMax = $request->input('harga_max', $maxDbHarga);
        $query->whereBetween('harga', [$hargaMin, $hargaMax]);

        // 7. Sorting
        $sort = $request->input('sort');
        if ($sort === 'Harga Paling Murah') {
            $query->orderBy('harga', 'asc');
        } elseif ($sort === 'Harga Tertinggi') {
            $query->orderBy('harga', 'desc');
        } else {
            $query->latest();
        }

        // Paginate max 24 items
        $oils = $query->paginate(24)->appends($request->all());

        return view('toko.oli-motor', compact('oils', 'minDbHarga', 'maxDbHarga'));
    }

    public function show($id)
    {
        $oil = Oil::findOrFail($id);
        return view('toko.oli-motor-detail', compact('oil'));
    }

    public function checkout($id)
    {
        $oil = Oil::findOrFail($id);

        if ($oil->stok <= 0) {
            return back()->with('error', 'Stok oli motor ini sedang kosong!');
        }

        $user = Auth::user();
        return view('toko.oli-motor-checkout', compact('oil', 'user'));
    }

    public function buy(Request $request, $id)
    {
        $oil = Oil::findOrFail($id);

        if ($oil->stok <= 0) {
            return back()->with('error', 'Stok oli motor ini sedang kosong!');
        }

        $request->validate([
            'jumlah' => 'required|integer|min:1|max:' . $oil->stok,
            'alamat' => 'required_if:metode_pembayaran,COD|nullable|string|max:500',
            'telepon' => 'required_if:metode_pembayaran,COD|nullable|string|max:20',
            'metode_pembayaran' => 'required|in:COD,Transfer Bank',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $jumlah = (int) $request->input('jumlah');
        $totalHarga = $oil->harga * $jumlah;

        // Kurangi stok
        $oil->decrement('stok', $jumlah);

        $purchaseStatus = $request->input('metode_pembayaran') === 'Transfer Bank' 
            ? 'menunggu_pembayaran' 
            : 'diproses';

        // Buat purchase
        $purchase = Purchase::create([
            'user_id'           => Auth::id(),
            'barang_id'         => $oil->id,
            'barang_nama'       => $oil->nama,
            'harga'             => $oil->harga,
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
            ->with('success', 'Pembelian oli berhasil! Pesanan Anda sedang diproses.');
    }
}
