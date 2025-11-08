@extends('admin.layout')
@section('content')

<div class="container-fluid py-4">
    <div class="card shadow">
        <div class="card-header">
            <h5 class="mb-0">{{__('banners.EditBan')}}: {{$banner->title}}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.banners.update', $banner->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="title">{{__('banners.Title')}}</label>
                            <input type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   id="title"
                                   name="title"
                                   value="{{ old('title', $banner->title) }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="status">{{__('banners.Status')}}</label>
                            <select name="status"
                                    id="status"
                                    class="custom-form-select @error('status') is-invalid @enderror">
                                <option value="1" {{ old('status', $banner->status) == 1 ? 'selected' : '' }}>{{__('categories.inActive')}}</option>
                                <option value="0" {{ old('status', $banner->status) == 0 ? 'selected' : '' }}>{{__('categories.inActive')}}</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="description">{{__('banners.Desc')}}</label>
                            <textarea id="description"
                                      name="description"
                                      rows="4"
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $banner->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                @if($banner->images)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">{{__('banners.CurImg')}}:</label>
                            <div class="d-flex flex-wrap gap-3">
                                    <div class="position-relative text-center">
                                        <img src="{{ asset('storage/' . $banner->images->path) }}"
                                            alt="Product Image"
                                            style="width: 120px; height: 120px; object-fit: cover; border: 3px solid {{ $banner->images->is_featured ? '#cb0c9f' : '#ccc' }}; border-radius: 8px;">

                                            <button type="button"
                                                    class="btn btn-sm btn-danger delete-image"
                                                    data-id="{{ $banner->images->id }}"
                                                    style="position: absolute; top: 5px; left: 5px; padding: 2px 6px; font-size: 14px;">
                                                &times;
                                            </button>
                                    </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <label for="image">{{__('banners.Img')}}</label>
                            <input type="file"
                                   id="image"
                                   name="image"
                                   class="form-control @error('image') is-invalid @enderror @error('image') is-invalid @enderror"
                                   accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">{{__('main.Save')}}</button>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">{{__('main.Back')}}</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection