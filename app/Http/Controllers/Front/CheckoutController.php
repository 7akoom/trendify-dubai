<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Front\OrderService;
use App\Services\Payment\NGeniusPaymentService;
use App\Repositories\CartRepositoryInterface;

class CheckoutController extends Controller
{
    public function __construct(
        private CartRepositoryInterface $cartRepo,
        private OrderService $orderService,
        private NGeniusPaymentService $paymentService
    ) {}

    public function create()
    {
        if ($this->cartRepo->count() == 0) {
            return redirect()->route('shop');
        }

        $cart = $this->cartRepo->get();
        $total = $this->cartRepo->total();
        return view('check-out', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        try {
            // Create order
            $order = $this->orderService->storeOrder($request->all());

            if (!$order) {
                return back()->withErrors('حدث خطأ أثناء تنفيذ الطلب');
            }

            // Check payment method
            if ($order->payment_method === 'online' || $order->payment_method === 'card') {
                // Initialize N-Genius payment
                $paymentResult = $this->paymentService->createPaymentOrder($order);

                if ($paymentResult && $paymentResult['success']) {
                    // Redirect to N-Genius payment page
                    Log::info('Redirecting to payment URL: ' . $paymentResult['payment_url']);
                    return redirect()->away($paymentResult['payment_url']);
                } else {
                    // Payment initialization failed
                    $order->update(['payment_status' => \App\Enums\PaymentStatus::Failed->value]);

                    return redirect()->route('shop')
                        ->withErrors('فشل في معالجة الدفع. الرجاء المحاولة مرة أخرى.');
                }
            }

            // Cash on delivery
            return redirect()->route('shop')
                ->with('success', __('messages.order_success'));
        } catch (\Throwable $th) {
            Log::error('Checkout Error', [
                'message' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);

            return back()->withErrors('حدث خطأ أثناء تنفيذ الطلب');
        }
    }
}
