<h2>Hello {{ $order->billingAddress->first_name . ' ' . $order->billingAddress->last_name }}!</h2>

<p>Your request has been successfully received with: <strong>#{{ $order->order_number }}</strong></p>

<p>Total amount: {{ number_format($order->total, 2) }}$</p>

<p>Thank you for shopping with us!</p>
