@extends('app')
@section('content')

<section class="shop spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="shop__sidebar">
                    <div class="shop__sidebar__accordion">
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseOne">{{__('messages.Categories')}}</a>
                                </div>
                                <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__categories">
                                            <ul class="nice-scroll">
                                                @foreach ($categories as $cat)
                                                    <li>
                                                        <a href="#" class="category-filter" data-id="{{ $cat->id }}">
                                                            {{ $cat->name }} ({{ $cat->products_count }})
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row" id="product-list">
                    @foreach ($products as $pro)
                        @include('product-card', ['pro' => $pro])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    $(document).ready(function () {        
        $(document).on('click', '.category-filter', function (e) {
            e.preventDefault();
            const categoryId = $(this).data('id');
            const url = @json(route('filter.products.by.category'));

            $.ajax({
                url: url,
                method: 'GET',
                data: { category_id: categoryId },
                success: function (response) {
                    $('#product-list').html('');
                    $('#product-list').append(response.html);
                    $('.set-bg').each(function () {
                        var bg = $(this).data('setbg');
                        $(this).css({
                            'background-image': 'url(' + bg + ')',
                        });
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