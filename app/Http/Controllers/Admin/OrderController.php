<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Backend\OrderService;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct(private OrderService $service) {}

    public function index()
    {
        $orders = $this->service->all();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order = $this->service->show($order);
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        Log::info('Order with relations:', $order->toArray());
        $order = $this->service->show($order);
        $statuses = \App\Enums\OrderStatus::cases();
        $payment = PaymentStatus::cases();
        return view('admin.orders.edit', compact('order', 'statuses', 'payment'));
    }

    public function update(Request $request, Order $order)
    {
        $this->service->updateOrder($order, $request->all());
        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'تم تحديث الطلب بنجاح');
    }

    public function userOrders()
    {
        $orders = $this->service->userOrders();
        return view('user.orders', compact('orders'));
    }

    public function userOrderDetails(Order $order)
    {
        $order = $this->service->show($order);
        return view('user.order_details', compact('order'));
    }

    public function cancellOrder(Order $order)
    {
        $result = $this->service->cancellOrder($order);

        if (!$result) {
            return redirect()->back()->with('error', 'لا يمكن إلغاء هذا الطلب.');
        }

        return redirect()->back()->with('success', 'تم إلغاء الطلب بنجاح.');
    }

    public function destroy(Order $order)
    {
        $deleted = $this->service->deleteOrder($order);

        if (!$deleted) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف الطلب.');
        }

        return redirect()->back()->with('success', 'تم حذف الطلب بنجاح.');
    }
}
