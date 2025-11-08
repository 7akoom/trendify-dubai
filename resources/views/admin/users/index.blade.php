@extends('admin.layout')
@section('content')

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 ms-6">{{__('users.UsCount')}}: {{ $users->count() }}</h5>
      </div>

    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>{{__('users.Users List')}}</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                        <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">{{__('users.Name')}}</th>
                        <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('messages.Email')}}</th>
                        <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('messages.Phone')}}</th>
                        <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('categories.Status')}}</th>
                        <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('main.Created')}}</th>
                        <th class="text-secondary text-center opacity-7">{{__('main.Actions')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $user)
                        <tr id="row-{{ $user->id }}">
                        <td class="align-middle text-center">{{$user->name}}</td>
                        <td class="align-middle text-center">{{$user->email}}</td>
                        <td class="align-middle text-center">{{$user->phone}}</td>
                        <td class="align-middle text-center">
                            <span class="badge badge-sm {{ $user->is_active_badge_class }}">
                                {{ $user->is_active_label }}
                            </span>
                        </td>
                        <td class="align-middle text-center">{{$user->created_at->format('Y-m-d')}}</td>
                        <td class="align-middle text-center">
                            <a href="{{ route('admin.users.toggleStatus', $user->id) }}" class="font-weight-bold m-3">
                                {{ $user->status ? __('users.Block') : __('users.unBlock') }}
                            </a>                                                        
                           
                            <a href="#" 
                                class="delete-btn text-danger font-weight-bold m-3" 
                                data-id="{{ $user->id }}">
                                {{__('main.Delete')}}
                            </a>
                            <form id="delete-form-{{ $user->id }}" 
                                action="{{ route('admin.users.destroy', $user->id) }}" 
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