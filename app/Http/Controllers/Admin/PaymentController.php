<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of all payments.
     */
    public function index()
    {
        $payments = Payment::with('purchases.user')
            ->latest()
            ->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Display details of a specific payment.
     */
    public function show(Payment $payment)
    {
        $purchases = $payment->purchases;
        return view('admin.payments.show', compact('payment', 'purchases'));
    }

    /**
     * Simulate payment callback (success or failed) from Admin.
     */
    public function simulate(Request $request, Payment $payment)
    {
        $request->validate([
            'action' => 'required|in:success,failed',
        ]);

        $action = $request->input('action');

        DB::transaction(function () use ($action, $payment) {
            if ($action === 'success') {
                $payment->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);

                $payment->purchases()->update([
                    'status' => 'diproses',
                ]);
            } else {
                $payment->update([
                    'status' => 'failed',
                ]);

                $payment->purchases()->update([
                    'status' => 'dibatalkan',
                ]);
            }
        });

        $message = $action === 'success' 
            ? 'Pembayaran berhasil disimulasikan sebagai BERHASIL.' 
            : 'Pembayaran berhasil disimulasikan sebagai GAGAL.';

        return back()->with('success', $message);
    }
}
