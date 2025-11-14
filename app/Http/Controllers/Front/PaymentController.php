<?php

namespace App\Http\Controllers\Front;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Payment\NGeniusPaymentService;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(
        private NGeniusPaymentService $paymentService
    ) {}

    /**
     * Handle payment callback from N-Genius
     */
    public function callback(Request $request)
    {
        $orderRef = $request->get('ref');

        if (!$orderRef) {
            return redirect()->route('shop')
                ->withErrors('معلومات الدفع غير صحيحة');
        }

        try {
            $success = $this->paymentService->processCallback($orderRef);

            if ($success) {
                return redirect()->route('shop')
                    ->with('success', 'تم الدفع بنجاح! شكراً لك على طلبك.');
            } else {
                return redirect()->route('shop')
                    ->withErrors('فشلت عملية الدفع. الرجاء المحاولة مرة أخرى.');
            }
        } catch (\Exception $e) {
            Log::error('Payment Callback Error', [
                'message' => $e->getMessage(),
                'reference' => $orderRef
            ]);

            return redirect()->route('shop')
                ->withErrors('حدث خطأ في معالجة الدفع');
        }
    }

    /**
     * Handle webhook from N-Genius
     */
    public function webhook(Request $request)
    {
        Log::info('N-Genius Webhook', $request->all());

        try {
            $eventType = $request->input('eventName');
            $order = $request->input('order');

            if ($order && isset($order['reference'])) {
                $this->paymentService->processCallback($order['reference']);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Webhook Processing Error', [
                'message' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return response()->json(['error' => 'Processing failed'], 500);
        }
    }

    /**
     * Check payment status (for AJAX polling if needed)
     */
    public function status($reference)
    {
        $payment = Payment::where('payment_reference', $reference)->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        return response()->json([
            'status' => $payment->status,
            'is_successful' => $payment->isSuccessful(),
            'is_failed' => $payment->isFailed()
        ]);
    }
}
