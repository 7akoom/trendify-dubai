@extends('admin.layout')
@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-4 col-sm-6 mb-lg-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
            <div class="row">
                <div class="col-8">
                <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">{{__('dashboard.UsersCount')}}</p>
                    <h5 class="font-weight-bolder mb-0">
                    {{$users}}
                    </h5>
                </div>
                </div>
                <div class="col-4 text-start">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="col-lg-4 col-sm-6 mb-lg-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
            <div class="row">
                <div class="col-8">
                <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">{{__('dashboard.ProductsCount')}}</p>
                    <h5 class="font-weight-bolder mb-0">
                        {{$products}}
                    </h5>
                </div>
                </div>
                <div class="col-4 text-start">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="col-lg-4 col-sm-6 mb-lg-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
            <div class="row">
                <div class="col-8">
                <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">{{__('dashboard.OrdersCount')}}</p>
                    <h5 class="font-weight-bolder mb-0">
                        {{$orders}}
                    </h5>
                </div>
                </div>
                <div class="col-4 text-start">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
  
    {{-- <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <div class="d-flex flex-column h-100">
                                <p class="mb-1 pt-2 text-bold">بناها المطورون</p>
                                <h5 class="font-weight-bolder">Soft UI Dashboard</h5>
                                <p class="mb-5">من الألوان والبطاقات والطباعة إلى العناصر المعقدة ، ستجد الوثائق الكاملة.</p>
                                <a class="text-dark font-weight-bold ps-1 mb-0 icon-move-left mt-auto" href="javascript:;">
                                اقرأ المستندات
                                <i class="fas fa-arrow-left text-sm ms-1" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 me-auto ms-0 text-center">
                            <div class="bg-gradient-primary border-radius-lg min-height-200">
                                <img src="{{ asset('assets/back/img/shapes/waves-white.svg') }}" class="position-absolute h-100 top-0 d-md-block d-none" alt="waves">
                                <div class="position-relative pt-5 pb-4">
                                    <img class="max-width-500 w-100 position-relative z-index-2" src="{{ asset('assets/back/img/illustrations/rocket-white.png') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card h-100 p-3">
                <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('../assets/img/ivancik.jpg');">
                    <span class="mask bg-gradient-dark"></span>
                    <div class="card-body position-relative z-index-1 p-3 h-100">
                    <div class="d-flex flex-column h-100">
                        <h5 class="text-white font-weight-bolder mb-4 pt-2">العمل مع الصواريخ</h5>
                        <p class="text-white mb-5">تكوين الثروة هو لعبة تطوري حديثة ذات حصيلة إيجابية. الأمر كله يتعلق بمن يغتنم الفرصة أولاً هذه بطاقة بسيطة.</p>
                        <a class="text-white font-weight-bold ps-1 mb-0 icon-move-left mt-auto" href="javascript:;">اقرأ المستندات
                            <i class="fas fa-arrow-left text-sm ms-1" aria-hidden="true"></i>
                        </a>
                    </div>
            </div>
            </div>
        </div>
    </div> --}}
</div>

@endsection