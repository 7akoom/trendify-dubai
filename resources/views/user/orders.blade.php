@extends('user.app')
@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 ms-6"> {{__('orders.OrdCount')}}: {{ $orders->count() }}</h5>
    </div>

    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>{{__('orders.Order List')}}</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                        {{__('orders.OrdNum')}}
                      </th>
                      <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        {{__('orders.CliName')}}
                      </th>
                      <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        {{__('categories.Status')}}
                      </th>
                      <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        {{__('orders.PaySt')}}
                      </th>
                      <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        {{__('orders.Tot')}}
                      </th>
                      <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        {{__('main.Created')}}
                      </th>
                      <th class="text-secondary text-center opacity-7">{{__('main.Actions')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($orders as $ord)
                        <tr id="row-{{ $ord->id }}">
                            <td class="align-middle text-center">{{ $ord->order_number }}</td>
                            <td class="align-middle text-center">{{ $ord->user->name }}</td>
                            <td class="align-middle text-center"><span class="badge {{ $ord->order_status_badge_class }}">
                                {{ $ord->status }}
                            </span>
                            </td>
                            <td class="align-middle text-center">{{ $ord->payment_status }}</td>
                            <td class="align-middle text-center">{{ $ord->total }}</td>
                            <td class="align-middle text-center">{{ $ord->created_at->format('Y-m-d') }}</td>
                            <td class="align-middle text-center">
                              <div class="d-flex justify-content-center gap-3">
                                  <a href="{{ route('user.order.details', $ord->id) }}" class="text-primary">
                                      {{ __('main.Details') }}
                                  </a>
                          
                                  <a href="{{route('user.cancell.order', $ord->id)}}">
                                      {{ __('main.Cancell') }}
                                  </a>
                              </div>
                          </td>
                          
                        </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>

@endsection