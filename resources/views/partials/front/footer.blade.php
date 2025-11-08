<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__logo">
                        <a href="#"><img style="width: 200px" src="{{ asset("assets/front/img/footer-logo.png") }}" alt=""></a>
                    </div>
                    <p>{{__('messages.Footer title')}}</p>
                    <a href="#"><img src="{{ asset("assets/front/img/payment.png") }}" alt=""></a>
                </div>
            </div>
            <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
                <div class="footer__widget">
                    <h6>{{__('messages.Links')}}</h6>
                    @php
                        $fb = App\Models\Setting::where('id',1)->first();
                    @endphp
                    <ul>
                        <li><a href="{{route('home')}}">{{__('messages.Home')}}</a></li>
                        <li><a href="{{ route('shop') }}">{{__('messages.Shop')}}</a></li>
                        <li><a href="{{ route('cart.index') }}">{{__('messages.Cart')}}</a></li>
                        @if ($fb->facebook_url)
                            <li><a href="{{ $fb->facebook_url }}">{{__('messages.fb')}}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="footer__copyright__text">
                    <p>Copyright ©
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                        All rights reserved
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>