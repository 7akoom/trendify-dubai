@extends('admin.layout')
@section('content')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0"> {{__('departments.EditDep')}}: {{ $department->name }}</h5>
                </div>
                <div class="card-body">
                    <form 
                        action="{{ route('admin.departments.update', $department->id) }}"
                        method="POST" id="edit-department-form"
                        class="ajax-form"
                        data-redirect="{{ route('admin.departments.index') }}">
                        @csrf
                        @method('PUT')

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="name">{{__('departments.Name')}}</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $department->name) }}">
                                @error('name')
                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">{{__('main.Save')}}</button>
                            <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">{{__('main.Back')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


