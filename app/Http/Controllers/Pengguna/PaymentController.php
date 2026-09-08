<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display the payment details page.
     */
    public function show(Payment $payment)
    {
        // Safety check: ensure the payment belongs to the authenticated user's purchases
        $purchases = $payment->purchases;
        if ($purchases->isEmpty() || $purchases->first()->user_id !== auth()->id()) {
            abort(403, 'Akses tidak sah.');
        }

        // Check if the payment has expired
        if ($payment->status === 'pending' && now()->greaterThan($payment->expired_at)) {
            DB::transaction(function () use ($payment) {
                $payment->update(['status' => 'expired']);
                $payment->purchases()->update(['status' => 'dibatalkan']);
            });

            return redirect()->route('pengguna.payments.expired', $payment->id);
        }

        // Redirect based on current status if it's already processed
        if ($payment->status === 'paid') {
            return redirect()->route('pengguna.payments.success', $payment->id);
        }

        if ($payment->status === 'expired') {
            return redirect()->route('pengguna.payments.expired', $payment->id);
        }

        return view('pengguna.payments.show', compact('payment', 'purchases'));
    }

    /**
     * Select payment method and generate payment code.
     */
    public function selectMethod(Request $request, Payment $payment)
    {
        $this->authorizePayment($payment);

        $request->validate([
            'payment_method' => 'required|string',
        ]);

        if ($payment->status !== 'pending' || now()->greaterThan($payment->expired_at)) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Pembayaran tidak aktif atau sudah kadaluarsa.',
                ], 422);
            }

            return back()->with('error', 'Pembayaran tidak aktif atau sudah kadaluarsa.');
        }

        $method = $request->input('payment_method');
        $code = null;

        // Generate dummy codes depending on method
        if (str_contains($method, 'Virtual Account')) {
            // 88 + 14 random digits
            $code = '88'.str_pad((string) mt_rand(1, 99999999999999), 14, '0', STR_PAD_LEFT);
        } elseif (in_array($method, ['DANA', 'OVO', 'GoPay', 'ShopeePay'])) {
            // E-wallet phone number format
            $code = '08'.str_pad((string) mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);
        } elseif (in_array($method, ['Alfamart', 'Indomaret'])) {
            // Convenience store payment code
            $code = 'ALFA'.mt_rand(100000, 999999);
            if ($method === 'Indomaret') {
                $code = 'INDO'.mt_rand(100000, 999999);
            }
        } elseif ($method === 'QRIS') {
            $code = 'PAY-'.$payment->invoice_number;
        }

        $payment->update([
            'payment_method' => $method,
            'payment_code' => $code,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'payment_method' => $method,
                'payment_code' => $code,
            ]);
        }

        return back()->with('success', 'Metode pembayaran berhasil dipilih.');
    }

    /**
     * Simulate successful payment.
     */
    public function pay(Payment $payment)
    {
        $this->authorizePayment($payment);

        if ($payment->status !== 'pending' || now()->greaterThan($payment->expired_at)) {
            return back()->with('error', 'Pembayaran tidak dapat diproses.');
        }

        DB::transaction(function () use ($payment) {
            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            // Set all associated purchases status to 'diproses'
            $payment->purchases()->update([
                'status' => 'diproses',
            ]);
        });

        return redirect()->route('pengguna.payments.success', $payment->id)
            ->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
    }

    /**
     * Display success page.
     */
    public function success(Payment $payment)
    {
        $this->authorizePayment($payment);

        if ($payment->status !== 'paid') {
            return redirect()->route('pengguna.payments.show', $payment->id);
        }

        $purchases = $payment->purchases;

        return view('pengguna.payments.success', compact('payment', 'purchases'));
    }

    /**
     * Display expired page.
     */
    public function expired(Payment $payment)
    {
        $this->authorizePayment($payment);

        if ($payment->status !== 'expired') {
            return redirect()->route('pengguna.payments.show', $payment->id);
        }

        return view('pengguna.payments.expired', compact('payment'));
    }

    private function authorizePayment(Payment $payment): void
    {
        abort_unless($payment->purchases()->where('user_id', auth()->id())->exists(), 403, 'Akses tidak sah.');
    }
}
