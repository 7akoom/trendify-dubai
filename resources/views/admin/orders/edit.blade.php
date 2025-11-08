@extends('admin.layout')
@section('content')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('orders.OrdNum') }}: {{ $order->order_number }}</h5>
                    <h5 class="mb-0">{{ __('orders.Tot') }}: {{ $order->total }} @if(App::getLocale() === 'ar') د.إ @else AED @endif</h5>
                    <h5 class="mb-0">{{ __('main.Created') }}: {{ $order->created_at }}</h5>
                </div>                
                <div class="card-body">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="order_number">{{__('orders.OrdNum')}}</label>
                                    <input type="text" class="form-control" id="order_number" name="order_number"
                                        value="{{ old('order_number', $order->order_number ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="total">{{__('orders.Tot')}}</label>
                                    <input type="number" class="form-control" id="total" name="total"
                                        value="{{ old('total', $order->total ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="user_name">{{__('orders.CliName')}}</label>
                                    <input type="text" class="form-control" id="user_name" name="user_name"
                                        value="{{ old('user_name', $order->user->name ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="user_email">{{__('messages.Email')}}</label>
                                    <input type="email" class="form-control" id="user_email" name="user_email"
                                        value="{{ old('user_email', $order->user->email ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="user_phone">{{__('messages.Phone')}}</label>
                                    <input type="text" class="form-control" id="user_phone" name="user_phone"
                                        value="{{ old('user_phone', $order->user->phone ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="payment_method">{{__('orders.PayMth')}}</label>
                                    <input type="text" class="form-control" id="payment_method" name="payment_method"
                                        value="{{ old('payment_method', $order->payment_method ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="status">{{ __('categories.Status') }}</label>
                                    <select class="form-control" id="status" name="status">
                                        @foreach ($statuses as $statusOption)
                                            <option value="{{ $statusOption->value }}" @selected(old('status', $order->status) == $statusOption->value)>
                                                {{ $statusOption->value }}
                                            </option>
                                        @endforeach
                                    </select>                                
                                </div>
                            </div>   
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="payment_status">{{ __('orders.PaySt') }}</label>
                                    <select class="form-control" id="payment_status" name="payment_status">
                                        @foreach ($payment as $pay)
                                            <option value="{{ $pay->value }}" @selected(old('payment_status', $order->payment_status) == $pay->value)>
                                                {{ $pay->value }}
                                            </option>
                                        @endforeach
                                    </select>                                
                                </div>
                            </div>  
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                        #
                                    </th>
                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{__('orders.ProName')}}
                                    </th>
                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{__('orders.PurPrice')}}
                                    </th>
                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{__('orders.DisPrice')}}
                                    </th>
                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{__('orders.SaPrice')}}
                                    </th>
                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{__('orders.Qty')}}
                                    </th>
                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{__('orders.Amount')}}
                                    </th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderDetails as $pro)
                                        <tr id="row-{{ $pro->id }}">
                                            <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                            <td class="align-middle text-center">{{ $pro->product_name }}</td>
                                            <td class="align-middle text-center">{{ $pro->purchase_price }}</td>
                                            <td class="align-middle text-center">{{ $pro->discount_price }}</td>
                                            <td class="align-middle text-center">{{ $pro->sale_price }}</td>
                                            <td class="align-middle text-center">{{ $pro->quantity }}</td>                                      
                                            <td class="align-middle text-center">{{ $pro->amount }}</td>                                      
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group mb-0">
                                    <label for="notes">{{__('orders.Note')}}</label>
                                    <input type="text" class="form-control" id="notes" name="notes"
                                        value="{{ old('notes', $order->notes ?? '') }}" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <h6 class="checkout__title mb-2 mt-2">{{__('messages.Billing')}}</h6>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="first_name">{{__('messages.FirstName')}}</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="{{ old('first_name', $order->billingAddress->first_name ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="last_name">{{__('messages.LastName')}}</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="{{ old('last_name', $order->billingAddress->last_name ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="street">{{__('messages.Street')}}</label>
                                    <input type="text" class="form-control" id="street" name="street"
                                        value="{{ old('street', $order->billingAddress->street_address ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="city">{{__('messages.City')}}</label>
                                    <input type="text" class="form-control" id="city" name="city"
                                        value="{{ old('city', $order->billingAddress->city ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="state">{{__('messages.State')}}</label>
                                    <input type="text" class="form-control" id="state" name="state"
                                        value="{{ old('state', $order->billingAddress->state ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="zip">{{__('messages.PostalCode')}}</label>
                                    <input type="text" class="form-control" id="zip" name="zip"
                                        value="{{ old('zip', $order->billingAddress->postal_code ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="email">{{__('messages.Email')}}</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email', $order->billingAddress->email ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="phone">{{__('messages.Phone')}}</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ old('phone', $order->billingAddress->phone ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="country">{{__('messages.Country')}}</label>
                                    <input type="text" class="form-control" id="country" name="country"
                                        value="{{ old('country', $order->billingAddress->country ?? '') }}" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <h6 class="checkout__title mb-2 mt-2">{{__('messages.Shipping')}}</h6>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="first_name">{{__('messages.FirstName')}}</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="{{ old('first_name', $order->shippingAddress->first_name ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="last_name">{{__('messages.LastName')}}</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="{{ old('last_name', $order->shippingAddress->last_name ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="street">{{__('messages.Street')}}</label>
                                    <input type="text" class="form-control" id="street" name="street"
                                        value="{{ old('street', $order->shippingAddress->street_address ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="city">{{__('messages.City')}}</label>
                                    <input type="text" class="form-control" id="city" name="city"
                                        value="{{ old('city', $order->shippingAddress->city ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="state">{{__('messages.State')}}</label>
                                    <input type="text" class="form-control" id="state" name="state"
                                        value="{{ old('state', $order->shippingAddress->state ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="zip">{{__('messages.PostalCode')}}</label>
                                    <input type="text" class="form-control" id="zip" name="zip"
                                        value="{{ old('zip', $order->shippingAddress->postal_code ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="email">{{__('messages.Email')}}</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email', $order->shippingAddress->email ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="phone">{{__('messages.Phone')}}</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ old('phone', $order->shippingAddress->phone ?? '') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="country">{{__('messages.Country')}}</label>
                                    <input type="text" class="form-control" id="country" name="country"
                                        value="{{ old('country', $order->shippingAddress->country ?? '') }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">{{__('main.Save')}}</button>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">{{__('main.Back')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
