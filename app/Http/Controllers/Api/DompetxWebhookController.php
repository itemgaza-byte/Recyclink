<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DompetxWebhookController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function handle(Request $request)
    {
        // 1. Catat payload webhook ke file log untuk keperluan debugging/tracing
        Log::info('DompetX Webhook Received', $request->all());

        // 2. Ambil reference (order_code) dan status dari DompetX
        $reference = $request->input('reference');
        $status = $request->input('status'); // Biasanya bernilai 'SUCCESS', 'PAID', atau 'FAILED'

        if (!$reference) {
            return response()->json(['message' => 'Missing reference'], 400);
        }

        // 3. Cari pesanan berdasarkan order_code
        $order = Order::where('order_code', $reference)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Pastikan order memiliki payment, jika tidak kita buatkan dummy untuk ditandai lunas
        if (!$order->payment) {
            // Karena ini webhook, kita buatkan record payment yang menandakan pembayaran berhasil dari DompetX
            $systemUser = User::whereHas('roles', function($q){ $q->where('name', 'admin'); })->first() ?: User::first();
            
            $payment = \App\Models\Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->input('method', 'dompetx'),
                'payment_gateway' => 'dompetx',
                'payment_reference' => $request->input('transactionId', 'dompetx-'.$reference),
                'amount' => $order->total_amount,
                'payment_status' => \App\Models\Payment::STATUS_PENDING,
                'payment_number' => 'PAY-' . now()->format('YmdHis') . '-' . rand(1000, 9999),
            ]);
            $order->load('payment');
        }

        // 4. Proses status webhook
        try {
            $systemUser = User::whereHas('roles', function($q){ $q->where('name', 'admin'); })->first() ?: User::first();
            
            if (in_array(strtoupper($status), ['SUCCESS', 'PAID', 'SETTLED'])) {
                // Jangan markAsPaid kalau sudah paid
                if ($order->payment->payment_status !== \App\Models\Payment::STATUS_PAID) {
                    $this->paymentService->markAsPaid($systemUser, $order->payment);
                }
            } elseif (in_array(strtoupper($status), ['FAILED', 'EXPIRED', 'CANCELED'])) {
                if ($order->payment->payment_status !== \App\Models\Payment::STATUS_FAILED && $order->payment->payment_status !== \App\Models\Payment::STATUS_PAID) {
                    $this->paymentService->markAsFailed($order->payment);
                }
            }
            
            return response()->json(['message' => 'Webhook handled successfully'], 200);
        } catch (\Exception $e) {
            Log::error('DompetX Webhook Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error handling webhook'], 500);
        }
    }
}
