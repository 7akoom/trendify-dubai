@extends('app')

@section('styles')
<style>
    .payment-methods .form-check {
        padding: 15px;
        border: 1px solid #e1e1e1;
        border-radius: 5px;
        transition: all 0.3s ease;
        margin-bottom: 10px;
    }
    
    .payment-methods .form-check:hover {
        border-color: #7fad39;
        background-color: #f9f9f9;
    }
    
    .payment-methods .form-check input:checked + label {
        color: #7fad39;
        font-weight: 600;
    }
    
    #online-payment-notice {
        background-color: #d1ecf1;
        border-color: #bee5eb;
        color: #0c5460;
        border-radius: 5px;
        padding: 12px;
    }
    
    .checkout__input input.error {
        border-color: #dc3545 !important;
    }
    
    #place-order-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    
    .checkout__title {
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <form action="{{route('checkout')}}" method="POST" id="checkout-form">
                @csrf

                <div class="row">
                    <!-- Billing Details Column -->
                    <div class="col-lg-8 col-md-6">
                        <h6 class="checkout__title">{{__('messages.Billing')}}</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>{{__('messages.FirstName')}} <span class="text-danger">*</span></p>
                                    <input name="addr[billing][first_name]" type="text" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>{{__('messages.LastName')}} <span class="text-danger">*</span></p>
                                    <input name="addr[billing][last_name]" type="text" required>
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>{{__('messages.Address')}} <span class="text-danger">*</span></p>
                            <input name="addr[billing][street_address]" type="text"
                                placeholder="{{__('messages.Street')}}" class="checkout__input__add" required>
                            <input name="addr[billing][city]" type="text" 
                                placeholder="{{__('messages.City')}}" required>
                            <input name="addr[billing][state]" type="text" 
                                placeholder="{{__('messages.State')}}">
                            <input name="addr[billing][country]" type="text" 
                                placeholder="{{__('messages.Country')}}" required>
                        </div>
                        <div class="checkout__input">
                            <p>{{__('messages.PostalCode')}}</p>
                            <input name="addr[billing][postal_code]" type="text">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>{{__('messages.Phone')}} <span class="text-danger">*</span></p>
                                    <input name="addr[billing][phone]" type="text" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>{{__('messages.Email')}} <span class="text-danger">*</span></p>
                                    <input name="addr[billing][email]" type="email" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Summary Column -->
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
                                        @if ($item->product->is_featured && $item->product->price->discount_price)
                                            {{$item->product->price->discount_price * $item->qty}}
                                        @else
                                            {{$item->product->price->sale_price * $item->qty}}
                                        @endif
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                            <ul class="checkout__total__all">
                                @if(isset($shippingCosts))
                                <li>{{__('messages.shipping_costs')}} <span>{{$shippingCosts ?? 0}}</span></li>
                                @endif
                                <li>{{__('messages.Total')}} <span>{{$total}}</span></li>
                                <input name="total" type="hidden" value="{{$total}}">
                            </ul>
                            
                            <button type="submit" class="site-btn" id="place-order-btn">
                                <span id="btn-text">{{__('messages.PlaceOrder')}}</span>
                                <span id="btn-loading" style="display:none;">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    {{__('messages.processing') ?? 'جاري المعالجة...'}}
                                </span>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Shipping Details Column -->
                    <div class="col-lg-8 col-md-6">
                        <hr>
                        <br>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="sameAsBilling">
                            <label class="form-check-label" for="sameAsBilling">
                                {{ __('messages.SameAsBilling') ?? 'نفس تفاصيل الدفع' }}
                            </label>
                        </div>

                        <h6 class="checkout__title">{{__('messages.Shipping')}}</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>{{__('messages.FirstName')}} <span class="text-danger">*</span></p>
                                    <input name="addr[shipping][first_name]" type="text" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>{{__('messages.LastName')}} <span class="text-danger">*</span></p>
                                    <input name="addr[shipping][last_name]" type="text" required>
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>{{__('messages.Address')}} <span class="text-danger">*</span></p>
                            <input name="addr[shipping][street_address]" type="text"
                                placeholder="{{__('messages.Street')}}" class="checkout__input__add" required>
                            <input name="addr[shipping][city]" type="text" 
                                placeholder="{{__('messages.City')}}" required>
                            <input name="addr[shipping][state]" type="text" 
                                placeholder="{{__('messages.State')}}">
                            <input name="addr[shipping][country]" type="text" 
                                placeholder="{{__('messages.Country')}}" required>
                        </div>
                        <div class="checkout__input">
                            <p>{{__('messages.PostalCode')}}</p>
                            <input name="addr[shipping][postal_code]" type="text">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>{{__('messages.Phone')}} <span class="text-danger">*</span></p>
                                    <input name="addr[shipping][phone]" type="text" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>{{__('messages.Email')}} <span class="text-danger">*</span></p>
                                    <input name="addr[shipping][email]" type="email" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="checkout__input">
                            <p>{{__('messages.Notes')}}
                                <span class="text-secondary">({{__('messages.NotesPlaceHolder')}})</span>
                            </p>
                            <input name="notes" type="text">
                        </div>

                        <!-- Payment Method Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="checkout__title">{{__('messages.payment_method') ?? 'طريقة الدفع'}}</h6>
                                
                                <div class="payment-methods">
                                    <!-- Cash on Delivery -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="cash" 
                                            name="payment_method" value="cash" checked>
                                        <label class="form-check-label" for="cash">
                                            <i class="fas fa-money-bill-wave me-2"></i>
                                            {{__('messages.cash') ?? 'الدفع عند الاستلام'}}
                                        </label>
                                    </div>

                                    <!-- Online Payment -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="online" 
                                            name="payment_method" value="online">
                                        <label class="form-check-label" for="online">
                                            {{__('messages.credit_card') ?? 'البطاقة الائتمانية'}}
                                        </label>
                                    </div>
                                </div>

                                <!-- Online Payment Notice -->
                                <div class="alert alert-info mt-3" id="online-payment-notice" style="display:none;">
                                    <strong>{{__('messages.payment_notice') ?? 'ملاحظة:'}}</strong>
                                    {{__('messages.payment_redirect') ?? 'سيتم تحويلك إلى بوابة الدفع الآمنة (N-Genius) لإتمام عملية الدفع بشكل آمن.'}}
                                </div>
                            </div>
                        </div>
                        <br>
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
        // Same as billing checkbox functionality
        const checkbox = document.getElementById('sameAsBilling');
        
        checkbox.addEventListener('change', function () {
            const fields = ['first_name', 'last_name', 'street_address', 'city', 'state', 'country', 'postal_code', 'phone', 'email'];
            
            fields.forEach(field => {
                const billing = document.querySelector(`[name="addr[billing][${field}]"]`);
                const shipping = document.querySelector(`[name="addr[shipping][${field}]"]`);
                
                if (checkbox.checked) {
                    shipping.value = billing.value;
                    shipping.readOnly = true;
                } else {
                    shipping.readOnly = false;
                    shipping.value = '';
                }
            });
        });

        // Auto-update shipping fields when billing fields change (if checkbox is checked)
        const billingFields = document.querySelectorAll('[name^="addr[billing]"]');
        billingFields.forEach(field => {
            field.addEventListener('input', function() {
                if (checkbox.checked) {
                    const fieldName = this.name.replace('billing', 'shipping');
                    const shippingField = document.querySelector(`[name="${fieldName}"]`);
                    if (shippingField) {
                        shippingField.value = this.value;
                    }
                }
            });
        });

        // Payment method selection
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const notice = document.getElementById('online-payment-notice');
                const btnText = document.getElementById('btn-text');
                
                if (this.value === 'online') {
                    notice.style.display = 'block';
                    btnText.textContent = '{{__("messages.proceed_to_payment") ?? "المتابعة للدفع"}}';
                } else {
                    notice.style.display = 'none';
                    btnText.textContent = '{{__("messages.PlaceOrder")}}';
                }
            });
        });

        // Form submission handling
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            const btn = document.getElementById('place-order-btn');
            const btnText = document.getElementById('btn-text');
            const btnLoading = document.getElementById('btn-loading');
            
            // Show loading state
            btn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline-block';
            
            if (paymentMethod === 'online') {
                // Add a small delay for better UX
                setTimeout(() => {
                    btnLoading.innerHTML = ' {{__("messages.redirecting_to_payment") ?? "جاري التحويل لبوابة الدفع الآمنة..."}}';
                }, 500);
            }
        });

        // Error handling for failed submission
        @if($errors->any())
            document.getElementById('place-order-btn').disabled = false;
            document.getElementById('btn-text').style.display = 'inline-block';
            document.getElementById('btn-loading').style.display = 'none';
        @endif
    });
</script>
@endsection