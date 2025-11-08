@extends('admin.layout')
@section('content')

<div class="container-fluid py-4">
    <div class="card shadow">
        <div class="card-header">
            <h5 class="mb-0">{{__('products.AddNPro')}}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name">{{__('products.Name')}}</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="category_id">{{__('products.ChCat')}}</label>
                            <select name="category_id"
                                    id="category_id"
                                    class="custom-form-select @error('category_id') is-invalid @enderror">
                                <option value="">{{__('products.ChCat')}}</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                            {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="is_active">{{__('banners.Status')}}</label>
                            <select name="is_active"
                                    id="is_active"
                                    class="custom-form-select @error('is_active') is-invalid @enderror">
                                <option value="1" {{ old('is_active','1') === '1' ? 'selected' : '' }}>{{__('categories.Active')}}</option>
                                <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>{{__('categories.inActive')}}</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="is_featured">{{__('products.Discount')}}</label>
                            <select name="is_featured"
                                    id="is_featured"
                                    class="custom-form-select @error('is_featured') is-invalid @enderror">
                                <option value="1" {{ old('is_featured','0') === '1' ? 'selected' : '' }}>{{__('products.Yes')}}</option>
                                <option value="0" {{ old('is_featured','0') === '0' ? 'selected' : '' }}>{{__('products.No')}}</option>
                            </select>
                            @error('is_featured')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="is_new">{{__('products.New')}}</label>
                            <select name="is_new"
                                    id="is_new"
                                    class="custom-form-select @error('is_new') is-invalid @enderror">
                                <option value="1" {{ old('is_new','0') === '1' ? 'selected' : '' }}>{{__('products.Yes')}}</option>
                                <option value="0" {{ old('is_new','0') === '0' ? 'selected' : '' }}>{{__('products.No')}}</option>
                            </select>
                            @error('is_new')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="qty">{{__('products.Qty')}}</label>
                            <input type="number"
                                   class="form-control @error('qty') is-invalid @enderror"
                                   id="qty"
                                   name="qty"
                                   value="{{ old('qty') }}">
                            @error('qty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="purchase_price">{{__('products.PurPrice')}}</label>
                            <input type="number"
                                   class="form-control @error('purchase_price') is-invalid @enderror"
                                   id="purchase_price"
                                   name="purchase_price"
                                   value="{{ old('purchase_price') }}">
                            @error('purchase_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="sale_price">{{__('products.SaPrice')}}</label>
                            <input type="number"
                                   class="form-control @error('sale_price') is-invalid @enderror"
                                   id="sale_price"
                                   name="sale_price"
                                   value="{{ old('sale_price') }}">
                            @error('sale_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="discount_price">{{__('products.DisPrice')}}</label>
                            <input type="number"
                                   class="form-control @error('discount_price') is-invalid @enderror"
                                   id="discount_price"
                                   name="discount_price"
                                   value="{{ old('discount_price') }}">
                            @error('discount_price')
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
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <label for="images">{{__('products.Img')}}</label>
                            <input type="file"
                                   id="images"
                                   name="images[]"
                                   class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror"
                                   multiple
                                   accept="image/*">
                            @error('images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="has_variants">{{__('products.IsVar')}}</label>
                            <select id="has_variants" name="has_variants" class="form-control">
                                <option value="0" {{ old('has_variants') == '0' ? 'selected' : '' }}>{{__('products.No')}}</option>
                                <option value="1" {{ old('has_variants') == '1' ? 'selected' : '' }}>{{__('products.Yes')}}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="variants-container" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">{{__('products.ProCol')}}</h5>
                                    <button type="button" class="btn btn-sm btn-primary" onclick="addColor()">
                                        <i class="fas fa-plus"></i> {{__('main.Add')}}
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div id="colors-wrapper"></div>
                                    @error('colors')
                                        <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">{{__('products.ProSi')}}</h5>
                                    <button type="button" class="btn btn-sm btn-primary" onclick="addSize()">
                                        <i class="fas fa-plus"></i> {{__('main.Add')}}
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div id="sizes-wrapper"></div>
                                    @error('sizes')
                                        <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">{{__('main.Save')}}</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">{{__('main.Back')}}</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('has_variants').addEventListener('change', function() {
        document.getElementById('variants-container').style.display = this.value == '1' ? 'block' : 'none';
        if(this.value == '1') {
            if(document.getElementById('colors-wrapper').children.length === 0) addColor();
            if(document.getElementById('sizes-wrapper').children.length === 0) addSize();
        }
    });
    
    function addColor() {
        const wrapper = document.getElementById('colors-wrapper');
        const index = wrapper.querySelectorAll('.color-row').length;
        const chooseColorText = "{{ __('products.ChCol') }}";
        const deleteText = "{{ __('main.Delete') }}";
        const html = `
        <div class="row color-row mb-3 align-items-center">
            <div class="col-md-8">
                <select name="colors[${index}][color_id]" class="form-control">
                    <option value="">${chooseColorText}</option>
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.color-row').remove()">
                    <i class="fas fa-trash"></i> ${deleteText}
                </button>
            </div>
        </div>`;
        
        wrapper.insertAdjacentHTML('beforeend', html);
    }
    
    function addSize() {
        const wrapper = document.getElementById('sizes-wrapper');
        const index = wrapper.querySelectorAll('.size-row').length;
        const chooseSizeText = "{{ __('products.ChSi') }}";
        const deleteText = "{{ __('main.Delete') }}";
        const html = `
        <div class="row size-row mb-3 align-items-center">
            <div class="col-md-8">
                <select name="sizes[${index}][size_id]" class="form-control">
                    <option value="">${chooseSizeText}</option>
                    @foreach($sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.size-row').remove()">
                    <i class="fas fa-trash"></i> ${deleteText}
                </button>
            </div>
        </div>`;
        
        wrapper.insertAdjacentHTML('beforeend', html);
    }
    </script>
@endsection