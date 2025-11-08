<style>
    .product__item.sale .product__item__pic .label {
        background: #d92929 !important;
        color: #fff !important;
    }
</style>

<div class="col-lg-4 col-md-6 col-sm-6">
    <div class="product__item sale">
        <a href="{{ route('product.show', $pro->id) }}">
            <div class="product__item__pic set-bg" data-setbg="{{ asset('storage/' . ($pro->featuredImage->path ?? 'default.jpg')) }}">
                @if ($pro->is_featured)
                    <span class="label">تخفيضات</span>
                @endif
                @if ($pro->is_new)
                    <span class="label" style="background: #000 !important;position: absolute;left: 0;top: 60px;">جديد</span>
                @endif
                <ul class="product__hover">
                    @foreach ($pro->sizes as $si)
                        <li style="width: 24px; height: 24px; border-radius: 4px; background-color: #000; border: 1px solid #ccc;color:#fff; text-align:center; line-height:24px; font-size:12px;">
                            {{ $si?->name }}
                        </li>
                    @endforeach
                </ul>  
            </div>
        </a>
        
        <div class="product__item__text">
            <h6>{{$pro->name}}</h6>
            <a href="#" data-id="{{$pro->id}}" class="add-cart">+ أضف إلى السلة</a>
            @if ($pro->is_featured)
                <h5>{{ $pro->price->discount_price }}</h5>
                <span style="text-decoration: line-through;">{{ $pro->price->sale_price }}</span>
            @else
                <h5>{{ $pro->price->sale_price }}</h5>
            @endif

            <div class="product__color__select">
                @foreach ($pro->colors as $color)
                        <span style="display: inline-block; width: 24px; height: 24px; border-radius: 50%; background-color: #{{ $color->hex }}; border: 1px solid #ccc;"></span>
                @endforeach
            </div>
        </div>
    </div>
</div>