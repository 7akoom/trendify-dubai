@extends('admin.layout')
@section('content')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">{{__('categories.EditCat')}}:  {{ $category->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category->id) }}"
                          method="POST"
                          class="ajax-form"
                          data-redirect="{{ route('admin.categories.index') }}">
                          @csrf
                          @method('PUT')

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group mb-3">
                                  <label for="name">{{__('categories.Name')}}</label>
                                  <input type="text"
                                         class="form-control"
                                         id="name"
                                         name="name"
                                         value="{{ old('name', $category->name) }}">
                                  @error('name')
                                      <span class="text-danger d-block mt-1">{{ $message }}</span>
                                  @enderror
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group mb-3">
                                  <label for="department_id">{{__('categories.ChDep')}}</label>
                                  <select name="department_id"
                                          id="department_id"
                                          class="custom-form-select">
                                          <option value="">{{__('categories.ChDep')}}</option>
                                      @foreach ($departments as $dep)
                                          <option value="{{ $dep->id }}"
                                            {{ old('department_id', $category->department_id) == $dep->id ? 'selected' : '' }}>
                                              {{ $dep->name }}
                                          </option>
                                      @endforeach
                                  </select>
                                  @error('department_id')
                                      <small class="text-danger">{{ $message }}</small>
                                  @enderror
                              </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="is_active">{{__('categories.Status')}}</label>
                                    <select name="is_active"
                                            id="is_active"
                                            class="custom-form-select">
                                        <option value="1"
                                            {{ old('is_active', $category->is_active) == '1' ? 'selected' : '' }}>
                                            {{__('categories.Active')}}
                                        </option>
                                        <option value="0"
                                            {{ old('is_active', $category->is_active) == '0' ? 'selected' : '' }}>
                                            {{__('categories.inActive')}}
                                        </option>
                                    </select>
                                    @error('is_active')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                          </div>

                          <div class="text-end">
                              <button type="submit" class="btn btn-primary">{{__('main.Save')}}</button>
                              <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">{{__('main.Back')}}</a>
                          </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection