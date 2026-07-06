<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class DompetxController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function checkout(Order $order)
    {
        // Pastikan hanya pembeli pesanan ini yang bisa mengakses
        if ($order->buyer_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Tampilkan halaman simulasi DompetX
        return view('dompetx.checkout', compact('order'));
    }

    public function process(Request $request, Order $order)
    {
        if ($order->buyer_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Simulasi pembayaran berhasil di DompetX
            $method = $request->input('method', 'ewallet');
            
            // Format yang diterima oleh PaymentService
            $paymentData = [
                'payment_method' => $method,
                'amount' => $order->total_amount,
                // tambahkan bukti dummy jika dibutuhkan validasi (di sistem Recyclink manual payment biasanya butuh bukti transfer)
                'proof_of_payment' => 'dummy_dompetx_proof.jpg', 
            ];
            
            $payment = $this->paymentService->createManualPayment($order->buyer, $order, $paymentData);
            
            // Langsung tandai lunas sebagai simulasi gateway sukses
            $this->paymentService->markAsPaid($order->buyer, $payment);

            return redirect()->route('buyer.orders.show', $order)->with('success', 'Pembayaran melalui DompetX berhasil divalidasi!');
        } catch (\Exception $e) {
            return redirect()->route('buyer.orders.show', $order)->with('error', 'Gagal memproses pembayaran DompetX: ' . $e->getMessage());
        }
    }
}
