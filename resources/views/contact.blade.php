@extends('app')
@section('content')

<style>
    .contact__hero {
        width: 100%;
        height: auto;
        margin-top: -40px; /* ارفع الصورة لأعلى */
    }

    .contact__hero img {
        width: 100%;
        height: auto;
        display: block;
    }
</style>

<div class="contact__hero">
    <img src="{{ asset('assets/front/img/contact.jpg') }}" alt="Contact">
</div>

<section class="contact spad">
    <div class="container">
        
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="contact__text">
                    <div class="section-title">
                        <span>{{__('contact.Info')}}</span>
                        <h2>{{__('contact.Contact')}}</h2>
                        <p>{{__('contact.P')}}</p>
                    </div>
                    <ul>
                        <li>
                            <h4>{{__('contact.Address')}}</h4>
                            {{-- <p>195 E Parker Square Dr, Parker, CO 801 <br />+43 982-314-0958</p> --}}
                            <p>info@trendify-dubai.com</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="contact__form">
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="name" placeholder="{{ __('contact.Name') }}" required>
                                 @error('name')
                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="phone" placeholder="{{ __('contact.Phone') }}" required>
                                 @error('phone')
                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <input type="email" name="email" placeholder="{{ __('contact.Email') }}" required>
                                 @error('email')
                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <textarea name="message" placeholder="{{ __('contact.Message') }}" required></textarea>
                                <button type="submit" class="site-btn">{{ __('contact.Send') }}</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection