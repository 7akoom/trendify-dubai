@extends('admin.layout')
@section('content')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">{{__('messages.Site info')}}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update', $setting->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="email">{{__('messages.Email')}}</label>
                                <input type="email" class="form-control" id="email" name="email"  value="{{ old('email', $setting->email) }}">
                                @error('email')
                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="phone">{{__('messages.Phone')}}</label>
                                <input type="text" class="form-control" id="phone" name="phone"   value="{{ old('phone', $setting->phone) }}">
                                @error('phone')
                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="facebook_url">{{__('messages.fb_url')}}</label>
                                <input type="text" class="form-control" id="facebook_url" name="facebook_url"  value="{{ old('facebook_url', $setting->facebook_url) }}">
                                @error('facebook_url')
                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="instagram_url">{{__('messages.insta_url')}}</label>
                                <input type="text" class="form-control" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $setting->instagram_url) }}">
                                @error('instagram_url')
                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="shipping_costs">{{__('messages.shipping_costs')}}</label>
                                <input type="number" class="form-control" id="shipping_costs" name="shipping_costs" value="{{ old('shipping_costs', $setting->shipping_costs ?? '') }}">
                                @error('shipping_costs')
                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="address">{{__('messages.Address')}}</label>
                                <input type="text" class="form-control" id="address" name="address"  value="{{ old('address', $setting->address) }}">
                                @error('address')
                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">{{__('main.Save')}}</button>
                            <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">{{__('main.Back')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
