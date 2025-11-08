@extends('app')
@section('content')

<style>
    .set-bg {
	    background-repeat: no-repeat;
	    background-size: contain;
	    background-position: top right;
    }
</style>

<section class="hero">
    <div class="hero__slider owl-carousel">
        @foreach ($banners as $ban)
        <div class="hero__items set-bg" data-setbg="{{ asset("storage/".$ban->images->path) }}">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-7 col-md-8">
                        <div class="hero__text">
                            <h2>{{$ban->title}}</h2>
                            <p>{{$ban->description}}</p>
                        </div>
                    </div>
                </div>

                    @if ($fb->facebook_url)
                        <div class="hero__social">
                            <a href="{{ $fb->facebook_url }}"><i class="fa fa-facebook"></i></a>
                        </div>
                    @endif
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Categories Section Begin -->
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>{{__('messages.Categories section')}}</h2>
                <br>
                <a href="{{ route('shop') }}" style="background-color: #000; color: #fff; padding: 10px 20px; border-radius: 4px; text-decoration: none; display: inline-block;">
                    {{__('messages.Shop now')}}
                </a>
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->


<!-- Product Section Begin -->
<section class="product spad">
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <ul class="filter__controls">
                    <li class="filter-btn active" data-type="featured">{{__('messages.Sale')}}</li>
                    <li class="filter-btn" data-type="new">{{__('messages.Latest products')}}</li>
                    <li style="background-color: #000; color: #fff; padding: 8px 16px; border-radius: 4px;">
                        <a href="{{ route('shop') }}" style="color: #fff; text-decoration: none; display: block;">
                            {{__('messages.Shop')}} <span class="arrow_right"></span>
                        </a>
                    </li>
                </ul>                
            </div>
        </div>
        <div class="row product__filter">
            @foreach ($featuredProducts as $pro)
                @include('product-card')
            @endforeach
        </div>
    </div>
</section>
<!-- Product Section End -->


@endsection

@section('script')
<script>
$(document).ready(function () {
    $('.filter-btn').on('click', function () {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');

        const type = $(this).data('type');
        const url = @json(route('filter.products.type'));

        $.ajax({
            url: url,
            method: 'GET',
            data: { type: type },
            success: function (res) {
                $('.product__filter').html(res.html);
                $('.set-bg').each(function () {
                    var bg = $(this).data('setbg');
                    $(this).css('background-image', 'url(' + bg + ')');
                });
            },
            error: function (xhr) {
                alert('حدث خطأ أثناء تحميل المنتجات.');
                console.error(xhr.responseText);
            }
        });
    });
});
</script>
@endsection
