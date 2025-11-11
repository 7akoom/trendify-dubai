@extends('app')
@section('content')

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <form action="{{route('checkout')}}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <h6 class="checkout__title">{{__('messages.Billing')}}</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>{{__('messages.FirstName')}}</p>
                                    <input name="addr[billing][first_name]" type="text">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>{{__('messages.LastName')}}</p>
                                    <input name="addr[billing][last_name]" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>{{__('messages.Address')}}</p>
                            <input name="addr[billing][street_address]" type="text"
                                placeholder="{{__('messages.Street')}}" class="checkout__input__add">
                            <input name="addr[billing][city]" type="text" placeholder="{{__('messages.City')}}">
                            <input name="addr[billing][state]" type="text" placeholder="{{__('messages.State')}}">
                            <input name="addr[billing][country]" type="text" placeholder="{{__('messages.Country')}}">
                        </div>
                        <div class="checkout__input">
                            <p>{{__('messages.PostalCode')}}</p>
                            <input name="addr[billing][postal_code]" type="text">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>{{__('messages.Phone')}}</p>
                                    <input name="addr[billing][phone]" type="text">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>{{__('messages.Email')}}</p>
                                    <input name="addr[billing][email]" type="email">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4 class="order__title">{{__('messages.Order')}}</h4>
                            <div class="checkout__order__products">{{__('messages.Product')}}
                                <span>{{__('messages.Sum')}}</span>
                            </div>
                            <ul class="checkout__total__products">
                                @foreach ($cart as $item)
                                <li>{{ sprintf('%02d', $loop->iteration) }}. {{$item->product->name}}
                                    <span>
                                        @if ($item->product->is_featured)
                                        <h5>{{$item->product->price->discount_price ?? 1 * $item->qty}}</h5>
                                        @else
                                        <h5>{{$item->product->price->sale_price * $item->qty}}</h5>
                                        @endif
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                            <ul class="checkout__total__all">
                                <li>{{__('messages.shipping_costs')}} <span>{{$shippingCosts}}</span></li>
                                <li>{{__('messages.Total')}} <span>{{$total}}</span></li>
                                <input name="total" type="hidden" value="{{$total}}">
                            </ul>
                            <button type="submit" class="site-btn">{{__('messages.PlaceOrder')}}</button>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6">
                        <hr>
                        <br>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="sameAsBilling">
                            <label class="form-check-label" for="sameAsBilling">
                                {{ __('messages.SameAsBilling') ?? 'نفس تفاصيل الدفع' }}
                            </label>
                        </div>

                        <br>
                        <h6 class="checkout__title">{{__('messages.Shipping')}}</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>{{__('messages.FirstName')}}</p>
                                    <input name="addr[shipping][first_name]" type="text">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>{{__('messages.LastName')}}</p>
                                    <input name="addr[shipping][last_name]" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>{{__('messages.Address')}}</p>
                            <input name="addr[shipping][street_address]" type="text"
                                placeholder="{{__('messages.Street')}}" class="checkout__input__add">
                            <input name="addr[shipping][city]" type="text" placeholder="{{__('messages.City')}}">
                            <input name="addr[shipping][state]" type="text" placeholder="{{__('messages.State')}}">
                            <input name="addr[shipping][country]" type="text" placeholder="{{__('messages.Country')}}">
                        </div>
                        <div class="checkout__input">
                            <p>{{__('messages.PostalCode')}}</p>
                            <input name="addr[shipping][postal_code]" type="text">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>{{__('messages.Phone')}}</p>
                                    <input name="addr[shipping][phone]" type="text">
                                </div>
                            </div>

                            <div class="checkout__input">
                                <p>{{__('messages.Notes')}}<span
                                        class="checkout__input__checkbox text-secondary">({{__('messages.NotesPlaceHolder')}})</span>
                                </p>
                                <input name="notes" type="text">
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>{{__('messages.Email')}}</p>
                                    <input name="addr[shipping][email]" type="email">
                                </div>
                            </div>




                        </div>

                        <div class="row">
                            <div class="form-check col-12">
                                <input class="form-check-input" type="radio" id="credit_card" name="flexRadioDefault"
                                    id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1" value='credit_card'>
                                    {{__('messages.credit_card')}}
                                </label>
                            </div>
                            </br>
                            <div class="form-check col-12">
                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2" value="cache">
                                    {{__('messages.cache')}}
                                </label>
                            </div>
                        </div>
                        <br>
                        <div class="row d-none" id="credit">

                                <h6 class="checkout__title col-12">{{__('messages.Payment_info')}}</h6>

                                <div class="col-12">
                                    <div class="checkout-payment-form">
                                        <div class="single-form form-default">
                                            <label>{{__('messages.Cardholder Name')}}</label>
                                            <div class="checkout__input">
                                                <input type="text" placeholder="{{__('messages.Cardholder Name')}}">
                                            </div>
                                        </div>
                                        <div class="single-form form-default">
                                            <label>{{ __('messages.Card Number') }}</label>
                                            <div class="checkout__input">
                                                <input type="text" placeholder="0000 0000 0000 0000">
                                            </div>
                                        </div>
                                        <div class="payment-card-info">
                                            <div class="single-form form-default mm-yy">
                                                <label>{{ __('messages.Expiration') }}</label>
                                                <div class="expiration d-flex">
                                                    <div class="checkout__input">
                                                        <input type="text" placeholder="MM">
                                                    </div>
                                                    <div class="checkout__input">
                                                        <input type="text" placeholder="YYYY">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="checkout__input">
                                                <label>{{ __('messages.CVC/CVV') }} <span><i class="mdi mdi-alert-circle"></i></span></label>
                                                <div class="form-input form">
                                                    <input type="text" placeholder="***">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                        </div>
                    </div>


            </form>
        </div>
    </div>
</section>
<!-- Checkout Section End -->

@endsection

@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkbox = document.getElementById('sameAsBilling');

        checkbox.addEventListener('change', function () {
            const fields = ['first_name', 'last_name', 'street_address', 'city', 'state', 'country', 'postal_code', 'phone', 'email'];

            fields.forEach(field => {
                const billing = document.querySelector(`[name="addr[billing][${field}]"]`);
                const shipping = document.querySelector(`[name="addr[shipping][${field}]"]`);

                if (checkbox.checked) {
                    shipping.value = billing.value;
                } else {
                    shipping.value = '';
                }
            });
        });
    });
</script>
<script>
    $(document).on('click','#credit_card',function(){
    $('#credit').removeClass('d-none');
})
</script>
@endsection