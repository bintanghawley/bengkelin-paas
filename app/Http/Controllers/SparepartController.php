<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SparepartController extends Controller
{
    public function index(Request $request)
    {
        $query = Sparepart::query();

        // 1. Filter Search
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->input('search') . '%');
        }

        // 2. Filter Kategori (Jenis Sparepart)
        if ($request->has('jenis_sparepart') && is_array($request->input('jenis_sparepart'))) {
            $query->whereIn('jenis_sparepart', $request->input('jenis_sparepart'));
        }

        // 3. Filter Merek
        if ($request->has('merek') && is_array($request->input('merek'))) {
            $query->whereIn('merek', $request->input('merek'));
        }

        // 4. Filter Range Harga
        $minDbHarga = Sparepart::min('harga') ?? 0;
        $maxDbHarga = Sparepart::max('harga') ?? 500000;

        $hargaMin = $request->input('harga_min', $minDbHarga);
        $hargaMax = $request->input('harga_max', $maxDbHarga);
        $query->whereBetween('harga', [$hargaMin, $hargaMax]);

        // 5. Sorting
        $sort = $request->input('sort');
        if ($sort === 'Harga Paling Murah') {
            $query->orderBy('harga', 'asc');
        } elseif ($sort === 'Harga Tertinggi') {
            $query->orderBy('harga', 'desc');
        } else {
            $query->latest();
        }

        // Paginate max 24 items
        $spareparts = $query->paginate(24)->appends($request->all());

        return view('toko.sparepart', compact('spareparts', 'minDbHarga', 'maxDbHarga'));
    }

    public function show($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        return view('toko.sparepart-detail', compact('sparepart'));
    }

    public function checkout($id)
    {
        $sparepart = Sparepart::findOrFail($id);

        if ($sparepart->stok <= 0) {
            return back()->with('error', 'Stok sparepart ini sedang kosong!');
        }

        $user = Auth::user();
        return view('toko.sparepart-checkout', compact('sparepart', 'user'));
    }

    public function buy(Request $request, $id)
    {
        $sparepart = Sparepart::findOrFail($id);

        if ($sparepart->stok <= 0) {
            return back()->with('error', 'Stok sparepart ini sedang kosong!');
        }

        $request->validate([
            'jumlah' => 'required|integer|min:1|max:' . $sparepart->stok,
            'alamat' => 'required_if:metode_pembayaran,COD|nullable|string|max:500',
            'telepon' => 'required_if:metode_pembayaran,COD|nullable|string|max:20',
            'metode_pembayaran' => 'required|in:COD,Transfer Bank',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $jumlah = (int) $request->input('jumlah');
        $totalHarga = $sparepart->harga * $jumlah;

        // Kurangi stok
        $sparepart->decrement('stok', $jumlah);

        $purchaseStatus = $request->input('metode_pembayaran') === 'Transfer Bank' 
            ? 'menunggu_pembayaran' 
            : 'diproses';

        // Buat purchase
        $purchase = Purchase::create([
            'user_id'           => Auth::id(),
            'barang_id'         => $sparepart->id,
            'barang_nama'       => $sparepart->nama,
            'harga'             => $sparepart->harga,
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
            ->with('success', 'Pembelian sparepart berhasil! Pesanan Anda sedang diproses.');
    }
}
