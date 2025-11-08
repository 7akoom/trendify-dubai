@foreach ($products as $pro)
    @include('product-card', ['pro' => $pro])
@endforeach
