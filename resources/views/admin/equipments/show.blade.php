@extends('layouts.app')
@section('content')
    <section>
        <form id="equipment-form" name="equipment_form" method="post" action="{{ url('admin/equipments/save') }}"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="equipment_id" id="equipment_id" value="{{ $equipment->id ?? '' }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header pb-1 border-bottom">
                            <h4 class="card-title">PRODUCT INFORMATION</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="custom-control custom-switch switch-lg custom-switch-success mr-1">
                                                    <input type="checkbox" class="custom-control-input"
                                                           id="equipment-status-{{ $equipment->id ?? '' }}"
                                                           {{ ($equipment->status ?? 0) == 1 ? 'checked' : '' }} name="status"
                                                           value="1">
                                                    <label class="custom-control-label"
                                                           for="equipment-status-{{ $equipment->id ?? '' }}">
                                                    </label>
                                                </div>
                                                <label class="font-small-3 text-bold-700 pb-0">Enabled</label>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-12">
                                        <div class="form-group">
                                            <label>PRODUCT</label>
                                            <select class="ui search dropdown w-100">
                                                <option value="">Equipment</option>
                                                <option value="1">Equipment</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>PRODUCT NAME </label>
                                            <input type="text" class="form-control" name="title" id="title"
                                                   placeholder="Proudct Name" value="{{ $equipment->title ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>PRODUCT DESCRIPTION </label>
                                            <textarea class="form-control" name="short_description"
                                                      id="short_description"
                                                      placeholder="Proudct Name">{{ $equipment->short_description ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>QUANTITY</label>
                                            <input type="text" class="form-control" name="quantity" id="quantity"
                                                   placeholder="Input Qty." value="{{ $equipment->quantity ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>PRICE</label>
                                            <input type="text" class="form-control" name="price" id="price"
                                                   placeholder="Price"
                                                   value="{{ number_format($equipment->price ?? 0,2) ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>CATEGORY</label>
                                            <select class="ui search dropdown w-100" id="category_id" name="category_id[]" multiple>
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ in_array($category->id, explode(',', ($equipment->category_id ?? ''))) ? 'selected' : '' }}>
                                                        {{ $category->category_title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>TAX RATE</label>
                                            <select class="ui search dropdown w-100">
                                                <option value="">Select Tax</option>
                                                <option value="AED">AED</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-md-12">
                                        <div class="form-group">
                                            <label>PRODUCT DESCRIPTION</label>
                                            <fieldset class="form-group">
                                                <textarea class="form-control" id="description" name="description" rows="3"
                                                    placeholder="Add information to display for the product.">{{ $equipment->description ?? '' }}</textarea>
                                    </fieldset>
                                </div>
                            </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header pb-1 border-bottom">
                            <h4 class="card-title">ROASTER & SELLER INFORMATION</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ROASTER BRAND</label>
                                            <select class="ui search dropdown w-100" name="brand_id" id="brand_id">
                                                <option value="">Select Roaster Brand</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ ($equipment->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ROASTER TYPE</label>
                                            <select class="ui search dropdown w-100" id="roster_type_id"
                                                    name="roster_type_id">
                                                <option value="">Select Roaster Type</option>
                                                @foreach ($coffeeTypes as $type)
                                                    <option
                                                        value="{{ $type->id }}" {{ ($equipment->roster_type_id ?? '') == $type->id ? 'selected' : '' }}>
                                                        {{ $type->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                        <div class="form-group">
                                            <label>SELLER</label>
                                            <select class="ui search dropdown w-100" name="seller_id" id="seller_id">
                                                <option value="">Select Seller</option>
                                                @foreach ($sellers as $seller)
                                                    <option value="{{ $seller->id }}"
                                                        {{ ($equipment->seller_id ?? '') == $seller->id ? 'selected' : '' }}>
                                                        {{ $seller->seller_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>PRODUCT COMMISSION</label>
                                            <input class="form-control" type="number" name="commission_fee"
                                                   id="commission_fee" value="{{ $equipment->commission_fee ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>COMMISSION TYPE</label>
                                            <select name="commission_type" id="commission_type" class="form-control">
                                                <option
                                                    value="percentage" {{ ($equipment->commission_type ?? '') == 'percentage' ? 'selected' : '' }}>
                                                    Percentage
                                                </option>
                                                <option
                                                    value="amount" {{ ($equipment->commission_type ?? '') == 'amount' ? 'selected' : '' }}>
                                                    Fixed Amount
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header pb-1 border-bottom">
                            <h4 class="card-title">PRODUCT IMAGES</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    {{-- @if (!empty($equipment->images)) --}}
                                    {{-- @foreach ($equipment->images as $key => $image) --}}
                                    @for($i = 0; $i < 3; $i++)
                                        @php
                                            $key = $i;
                                            $image = $equipment->images[$key] ?? [];
                                        @endphp
                                        <div class="col-md-4  text-center border-right">
                                            <div class="form-group mb-0">
                                                <div class="add-new-banner-div">
                                                    <div class="enable-img d-flex align-items-center">
                                                        <input type="file" name="image_{{ $key }}"
                                                               class="d-none" accept="image/*" id="image_{{$key}}">
                                                        <img
                                                            src="{{ asset($image->image_path ?? 'assets/images/product-uplode.png')}}"
                                                            id="preview_image_{{ $key }}"
                                                            onclick="$('#image_{{$key}}').click()">
                                                    </div>
                                                </div>
                                                <p class="font-medium-2 text-bold-700 text-center pt-1">
                                                    {{ $key == 0 ? 'PRIMARY IMAGE' : 'ALTERNATE IMAGE ' . $key }}
                                                </p>
                                            </div>
                                        </div>
                                    @endfor
                                    {{-- @endforeach --}}
                                    {{-- @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header pb-1 border-bottom">
                            <h4 class="card-title">PRODUCT INFORMATION - ADDITIONAL</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>PRODUCT DESCRIPTION</label>
                                                    <fieldset class="form-group">
                                                    <textarea class="form-control" id="description" name="description"
                                                              rows="3"
                                                              placeholder="Add information to display for the product.">{{ $equipment->description ?? '' }}</textarea>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>SEARCH TAGS</label>
                                                    <input type="text" class="form-control" name="tags" id="tags"
                                                           value="{{ $equipment->tags ?? '' }}"
                                                           placeholder="List Search Tags (i.e aeropress, organic, decaf etc.)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-md-6">
                    <button type="submit"
                            class="btn btn-primary font-weight-bold btn-lg w-100 waves-effect waves-light">SAVE
                    </button>
                </div>
            </div>
        </form>
    </section>
@endsection


@section('scripts')
    <script type="text/javascript">
        $('#image_0').change(function (e) {
            var fileName = e.target.files[0].name;

            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("preview_image_0").src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        });
        $('#image_1').change(function (e) {
            var fileName = e.target.files[0].name;

            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("preview_image_1").src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        });
        $('#image_2').change(function (e) {
            var fileName = e.target.files[0].name;

            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("preview_image_2").src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection
