<?php

namespace App\Http\Controllers;

use App\Models\Oil;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\Sparepart;
use App\Models\Tire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    /**
     * Show the cart checkout page.
     * The cart items are passed as JSON from the frontend (localStorage).
     */
    public function checkout(Request $request)
    {
        $user = Auth::user();

        return view('toko.cart-checkout', compact('user'));
    }

    /**
     * Process the cart checkout.
     * Expects: items[] (JSON array), alamat, telepon, metode_pembayaran, catatan
     */
    public function buy(Request $request)
    {
        $request->validate([
            'items' => 'required|string',  // JSON string of cart items
            'alamat' => 'required_if:metode_pembayaran,COD|nullable|string|max:500',
            'telepon' => 'required_if:metode_pembayaran,COD|nullable|string|max:20',
            'metode_pembayaran' => 'required|in:COD,Transfer Bank',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $cartItems = json_decode($request->input('items'), true);

        if (empty($cartItems)) {
            return back()->with('error', 'Keranjang kosong. Tidak ada item untuk di-checkout.');
        }

        // Filter only checked items
        $checkedItems = array_filter($cartItems, fn ($item) => ($item['checked'] ?? true) !== false);

        if (empty($checkedItems)) {
            return back()->with('error', 'Pilih minimal satu produk untuk di-checkout.');
        }

        $purchaseIds = [];
        $totalAmount = 0;
        $purchaseStatus = $request->input('metode_pembayaran') === 'Transfer Bank'
            ? 'menunggu_pembayaran'
            : 'diproses';

        DB::transaction(function () use ($checkedItems, $request, &$purchaseIds, &$totalAmount, $purchaseStatus) {
            foreach ($checkedItems as $item) {
                $rawId = $item['id'] ?? null;
                $kategori = strtolower($item['kategori'] ?? '');
                $qty = max(1, (int) ($item['qty'] ?? 1));
                $harga = (float) ($item['harga'] ?? 0);
                $nama = $item['nama'] ?? 'Produk';

                // Extract numeric ID if prefixed (e.g. "tire-5" -> 5)
                if (is_string($rawId) && str_contains($rawId, '-')) {
                    $parts = explode('-', $rawId);
                    $numericId = (int) end($parts);
                } else {
                    $numericId = (int) $rawId;
                }

                $model = $this->resolveModel($kategori);
                if (! $model) {
                    throw ValidationException::withMessages([
                        'items' => 'Kategori produk tidak valid.',
                    ]);
                }

                $product = $model::lockForUpdate()->find($numericId);
                if (! $product) {
                    throw ValidationException::withMessages([
                        'items' => 'Produk tidak ditemukan.',
                    ]);
                }

                if ($product->stok < $qty) {
                    throw ValidationException::withMessages([
                        'items' => "Stok {$product->nama} tidak mencukupi. Tersisa {$product->stok}.",
                    ]);
                }

                $product->decrement('stok', $qty);
                $nama = $product->nama;
                $harga = $product->harga;

                $purchase = Purchase::create([
                    'user_id' => Auth::id(),
                    'barang_id' => $numericId,
                    'barang_nama' => $nama,
                    'harga' => $harga,
                    'jumlah' => $qty,
                    'total_harga' => $harga * $qty,
                    'alamat' => $request->input('alamat'),
                    'telepon' => $request->input('telepon'),
                    'metode_pembayaran' => $request->input('metode_pembayaran'),
                    'catatan' => $request->input('catatan'),
                    'status' => $purchaseStatus,
                ]);

                $purchaseIds[] = $purchase->id;
                $totalAmount += $purchase->total_harga;
            }
        });

        if ($request->input('metode_pembayaran') === 'Transfer Bank') {
            $payment = DB::transaction(function () use ($totalAmount, $purchaseIds) {
                $payment = Payment::create([
                    'invoice_number' => Payment::generateInvoice(),
                    'amount' => $totalAmount,
                    'status' => 'pending',
                    'expired_at' => now()->addHour(),
                ]);

                Purchase::whereIn('id', $purchaseIds)->update(['payment_id' => $payment->id]);

                return $payment;
            });

            return redirect()->route('pengguna.payments.show', $payment->id);
        }

        // After successful purchase, redirect with the list of purchase IDs
        // so the frontend knows to clear those items from cart
        $purchaseIdStr = implode(',', $purchaseIds);

        return redirect()->route('cart.result', ['ids' => $purchaseIdStr])
            ->with('success', 'Checkout berhasil! '.count($purchaseIds).' item pesanan sedang diproses.');
    }

    /**
     * Show the cart checkout result page.
     */
    public function result(Request $request)
    {
        $ids = explode(',', $request->query('ids', ''));
        $ids = array_filter(array_map('intval', $ids));

        $purchases = Purchase::where('user_id', Auth::id())
            ->whereIn('id', $ids)
            ->get();

        return view('toko.cart-result', compact('purchases'));
    }

    private function resolveModel(string $kategori): ?string
    {
        return match ($kategori) {
            'ban motor', 'ban', 'tire' => Tire::class,
            'oli motor', 'oli', 'oil' => Oil::class,
            'sparepart', 'spare part' => Sparepart::class,
            default => null,
        };
    }
}
