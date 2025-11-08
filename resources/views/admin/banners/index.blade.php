@extends('admin.layout')
@section('content')

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.banners.create') }}" class="btn bg-gradient-primary">
            {{__('main.Add')}}
        </a>
        <h5 class="mb-0 ms-6">{{__('banners.BanCount')}}: {{ $banners->count() }}</h5>
    </div>

    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>{{__('banners.Banners List')}}</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                        {{__('banners.Title')}}
                      </th>
                      <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                        {{__('banners.Desc')}}
                      </th>
                      <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        {{__('banners.Img')}}
                      </th>
                      <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        {{__('categories.Status')}}
                      </th>
                      <th class="text-secondary text-center opacity-7">{{__('main.Actions')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($banners as $ban)
                        <tr id="row-{{ $ban->id }}">
                            <td class="align-middle text-center">{{ $ban->title }}</td>
                            <td class="align-middle text-center">{{ \Illuminate\Support\Str::limit($ban->description, 30) }}</td>
                            <td class="align-middle text-center">
                              @if ($ban->images)
                                <img src="{{ asset('storage/' . $ban->images->path) }}"
                                alt="Featured Image"
                                style="width: 50px; height: 50px; object-fit: cover;"
                                class="rounded">
                              @endif
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge badge-sm {{ $ban->isActiveBadgeClass }}">
                                    {{ $ban->isActiveLabel }}
                                </span>
                            </td>
                            <td class="align-middle text-center">
                                <a href="{{ route('admin.banners.edit', $ban->id) }}">
                                    {{__('main.Edit')}}
                                </a>

                                <a href="#"
                                   class="delete-btn text-danger font-weight-bold m-3"
                                   data-id="{{ $ban->id }}">
                                   {{__('main.Delete')}}
                                </a>
                                <form id="delete-form-{{ $ban->id }}"
                                      action="{{ route('admin.banners.destroy', $ban->id) }}"
                                      method="POST"
                                      style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
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
