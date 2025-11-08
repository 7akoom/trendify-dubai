<div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__option">
            <div class="offcanvas__links">
                @if(auth()->check())
                                    <a href="{{ route('user.logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                       {{ __('messages.Sign out') }}
                                    </a>
                            
                                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <a href="{{ route('user.orders') }}">{{ __('messages.MyOrders') }}</a>
                                @else
                                    <a href="{{ route('user.login') }}">{{ __('messages.Signin') }}</a>
                                @endif
            </div>
            <div class="offcanvas__top__hover">
                <div class="header__top__hover">
                    <span>{{ app()->getLocale() == 'ar' ? 'ع' : 'En' }} <i class="arrow_carrot-down"></i></span>
                    <ul>
                        <li><a style="color:#fff;" href="{{ route('lang.switch', 'en') }}">En</a></li>
                        <li><a style="color:#fff;" href="{{ route('lang.switch', 'ar') }}">ع</a></li>
                    </ul>
                </div>  
            </div>
        </div>
        <div class="offcanvas__nav__option">
            <a href="{{route('cart.index')}}"><img src="{{ asset("assets/front/img/icon/cart.png") }}" alt=""> <span id="mobile-cart-count">{{$cartCount}}</span></a>
            <div class="price" id="mobile-cart-total">
                {{ $cartTotal }} 
            </div>
                    <span class="currency">
                        @if(App::getLocale() === 'ar') د.إ @else AED @endif
                      </span>
        </div>
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__text">
            <p>{{__('messages.Nav title')}}</p>
        </div>
    </div>