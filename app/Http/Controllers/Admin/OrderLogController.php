<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderLog;
use App\Services\OrderLogService;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderLog\StoreOrderLogRequest;
use App\Http\Requests\OrderLog\UpdateOrderLogRequest;
use App\Traits\WebResponse;

class OrderLogController extends Controller
{
    // use WebResponse;

    // public function __construct(private OrderLogService $service) {}

    // public function index()
    // {
    //     $logs = $this->service->all();
    //     return view('order_logs.index', compact('logs'));
    // }

    // public function create()
    // {
    //     $orders = Order::select('id', 'order_number')->get();
    //     return view('order_logs.create', compact('orders'));
    // }

    // public function store(StoreOrderLogRequest $request)
    // {
    //     $this->service->create($request->validated());
    //     return $this->redirectWithMessage('order_logs.index', 'Order log created.');
    // }

    // public function show(OrderLog $orderLog)
    // {
    //     $orderLog->load('order');
    //     return view('order_logs.show', compact('orderLog'));
    // }

    // public function edit(OrderLog $orderLog)
    // {
    //     $orders = Order::select('id', 'order_number')->get();
    //     return view('order_logs.edit', compact('orderLog', 'orders'));
    // }

    // public function update(UpdateOrderLogRequest $request, OrderLog $orderLog)
    // {
    //     $this->service->update($orderLog, $request->validated());
    //     return $this->redirectWithMessage('order_logs.index', 'Order log updated.');
    // }

    // public function destroy(OrderLog $orderLog)
    // {
    //     $this->service->delete($orderLog);
    //     return $this->redirectWithMessage('order_logs.index', 'Order log deleted.');
    // }
}
