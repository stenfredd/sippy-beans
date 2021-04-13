@extends('layouts.app')
@section('content')
<section>
    @if($errors->any())
        <ul class="bg-danger p-1 pl-3" style="border-radius: 5px;">
            {!! implode('', $errors->all('<li class="text-white">:message</li>')) !!}
        </ul>
    @endif
    <form id="product-form" name="product-form" action="{{ url('admin/products/save') }}" enctype="multipart/form-data"
        method="POST">
        @csrf
        <input type="hidden" name="product_id" id="product_id" value="{{ $product->id ?? '' }}">
        <input type="hidden" name="add_variant" id="add_variant" value="">
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
                                                    id="order-status-{{ $product->id ?? ''}}"
                                                    {{ ($product->status ?? '') == 1 ? 'checked' : '' }} value="1"
                                                    name="status">
                                                <label class="custom-control-label"
                                                    for="order-status-{{ $product->id ?? ''}}"></label>
                                            </div>
                                            <label class="font-small-3 text-bold-700 pb-0">Enabled</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>PRODUCT NAME </label>
                                        <input type="text" class="form-control" name="product_name" id="product_name"
                                            placeholder="Proudct Name" value="{{ $product->product_name ?? '' }}">
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label>QUANTITY</label>
                                        <input type="text" class="form-control" name="promo value"
                                            placeholder="Input Qty.">
                                    </div>
                                </div> --}}
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label>TAX RATE</label>
                                        <select class="ui search dropdown w-100">
                                            <option value="">Select Tax</option>
                                            <option value="AED">AED</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>PRODUCT DESCRIPTION</label>
                                        <fieldset class="form-group">
                                            <textarea class="form-control" id="description" name="description" rows="3"
                                                placeholder="Add information to display for the product.">{{ $product->description ?? '' }}</textarea>
                                        </fieldset>
                                    </div>
                                </div>
                                {{-- <div class="col-md-12">
                                    <div class="form-group">
                                        <label>REWARD POINTS</label>
                                        <input type="number" class="form-control" id="reward_point" name="reward_point"
                                            placeholder="Reward Points" value="{{ $product->reward_point ?? 0 }}">
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>CATEGORY</label>

                                        <select class="ui search dropdown w-100" id="category_id" name="category_id">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ ($product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                {{ $category->category_title }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
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
                                        <select class="ui search dropdown w-100" id="brand_id" name="brand_id">
                                            <option value="">Select Roaster Brand</option>
                                            @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ ($product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>ROASTER TYPE</label>
                                        <select class="ui search dropdown w-100" id="type_id"
                                            name="type_id">
                                            <option value="">Select Roaster Type</option>
                                            @foreach ($types as $type)
                                            <option value="{{ $type->id }}"
                                                {{ ($product->type_id ?? '') == $type->id ? 'selected' : '' }}>
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
                                        <select class="ui search dropdown w-100" id="seller_id" name="seller_id">
                                            <option value="">Select Seller</option>
                                            @foreach ($sellers as $seller)
                                            <option value="{{ $seller->id }}"
                                                {{ ($product->seller_id ?? '') == $seller->id ? 'selected' : '' }}>
                                                {{ $seller->seller_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>PRODUCT COMMISSION</label>
                                        <input class="form-control" type="number" name="commission_fee"
                                            id="commission_fee" value="{{ $product->commission_fee ?? 0 }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>COMMISSION TYPE</label>
                                        <select name="commission_type" id="commission_type" class="form-control">
                                            <option value="percentage"
                                                {{ ($equipment->commission_type ?? '') == 'percentage' ? 'selected' : '' }}>
                                                Percentage
                                            </option>
                                            <option value="amount"
                                                {{ ($equipment->commission_type ?? '') == 'amount' ? 'selected' : '' }}>
                                                Fixed Amount</option>
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
                                {{-- @foreach ($product->images as $key => $image) --}}
                                @for($i = 0; $i < 3; $i++)
                                    @php
                                        $key = $i;
                                        $image=$product->images[$i] ?? [];
                                    if(empty($image) && request()->path() !== 'admin/products/create') {
                                        continue;
                                    }
                                    if($key > 0 && empty($image) && request()->path() === 'admin/products/create') {
                                        continue;
                                    }
                                    @endphp
                                    <div class="col-md-4  text-center border-right">
                                        <div class="form-group mb-0">
                                            <div class="add-new-banner-div">
                                                <div div class="enable-img d-flex align-items-center">
                                                    <input type="file" name="image_{{ $key }}" class="d-none"
                                                        accept="image/*" id="image_{{$key}}">
                                                    <img src="{{ asset($image->image_path ?? 'assets/images/product-uplode.png')}}"
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
                        <h4 class="card-title">PRODUCT ATTRIBUTES</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>ORIGIN</label>
                                                <select class="ui search dropdown w-100" id="origin_id"
                                                    name="origin_id">
                                                    <option value="">Select Product Origin</option>
                                                    @foreach ($origins as $origin)
                                                    <option value="{{ $origin->id }}"
                                                        {{ ($product->origin_id ?? '') == $origin->id ? 'selected' : '' }}>
                                                        {{ $origin->origin_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>VARIETAL</label>
                                                <input class="form-control" type="text" name="varietal" id="varietal"
                                                    value="{{ $product->varietal ?? '' }}" placeholder="Varietal">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>FLAVOR NOTES</label>
                                                <input class="form-control" type="text" name="flavor_note"
                                                    id="flavor_note" value="{{ $product->flavor_note ?? '' }}" placeholder="Flavor Note">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>CHARACTERISTICS</label>
                                                <select class="ui search dropdown w-100" id="characteristic_id"
                                                    name="characteristic_id">
                                                    <option value="">Select a Product Characteristic</option>
                                                    @foreach ($characteristics as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == ($product->characteristic_id ?? '') ? 'selected' : '' }}>
                                                        {{ $item->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>BEST FOR</label>
                                                <select class="ui search dropdown w-100" id="best_for_id"
                                                    name="best_for_id">
                                                    <option value="">Select a Best For Option</option>
                                                    @foreach ($bestFor as $best_for)
                                                    <option value="{{ $best_for->id }}"
                                                        {{ $best_for->id == ($product->best_for_id ?? '') ? 'selected' : '' }}>
                                                        {{ $best_for->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>ROAST LEVEL</label>
                                                <select class="ui search dropdown w-100" id="level_id" name="level_id">
                                                    <option value="">Select the Product Roast Level</option>
                                                    @foreach ($levels as $level)
                                                    <option value="{{ $level->id }}"
                                                        {{ $level->id == ($product->level_id ?? '') ? 'selected' : '' }}>
                                                        {{ $level->level_title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>ALTITUDE</label>
                                                <input type="text" name="altitude" id="altitude" class="form-control"
                                                    value="{{ $product->altitude ?? '' }}" placeholder="ALTITUDE">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>PROCESS</label>
                                                <select class="ui search dropdown w-100" id="process_id"
                                                    name="process_id">
                                                    <option value="">Select Product Process</option>
                                                    @foreach ($processes as $process)
                                                    <option value="{{ $process->id }}"
                                                        {{ $process->id == ($product->process_id ?? '') ? 'selected' : '' }}>
                                                        {{ $process->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>PRODUCT TYPE</label>
                                                <select class="ui search dropdown w-100" name="coffee_type_id[]" id="coffee_type_id" multiple>
                                                    <option value="">Select Product Type</option>
                                                    @foreach ($coffeeTypes as $type)
                                                    <option value="{{ $type->id }}"
                                                        {{ isset($product->coffee_type_id) && !empty($product->coffee_type_id) && (in_array($type->id, explode(',', $product->coffee_type_id))) ? 'selected' : '' }}>
                                                        {{ $type->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>SEARCH TAGS</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $product->tags ?? '' }}"
                                                    placeholder="List Search Tags (i.e aeropress, organic, decaf etc.)"
                                                    id="tags" name="tags">
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="overflow-hidden">
                        <div
                            class="card-header d-flex justify-content-between align-items-center pb-2 pt-2 border-bottom">
                            <h4 class="mb-0 text-bold-700">PRODUCT VARIANTS
                                <br><small class="font-weight-bold gray">{{ count($product->variants ?? []) }} VARIANT(S) ADDED</small></h4>
                            <a href="#" type="button"
                                class="btn custtam-btn square  waves-effect waves-light text-bold-700"
                                id="variants-btn">ADD VARIANTS</a>
                        </div>
                        <div class="card-content">
                            <div>
                                <div class="table-responsive pagenation-row">
                                    <table class="table  table-striped table-borderless" id="variants-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class="font-small-3 w-25 text-bold-700">GRIND</th>
                                                <th class="font-small-3 text-bold-700">SELL WEIGHT</th>
                                                <th class="font-small-3 text-bold-700 ">QUANTITY</th>
                                                <th class="font-small-3 text-bold-700">REWARD</th>
                                                <th class="font-small-3 text-bold-700">PRICE</th>
                                                {{-- <th class="font-small-3 text-bold-700">ENABLE/DISABLE</th> --}}
                                                <th class="w-5"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($product->variants))
                                            @foreach ($product->variants as $k => $variant)
                                            <tr>
                                                <td class="text-center font-small-3 text-bold-500">{{ $k + 1 }}</td>
                                                <td class="font-small-3 text-bold-500">
                                                        <p class="font-small-3 text-bold-700 mb-0">{{ $variant->grind_title }}</p>
                                                        <span class="font-small-1 text-bold-500 mb-0 gray">SKU: {{ $variant->sku }}</span>
                                                    </td>
                                                <td class="font-small-3 text-bold-500">
                                                    {{ $variant->weight->title ?? '' }}
                                                </td>
                                                {{-- <td class="font-small-3 text-bold-500">265g</td> --}}
                                                <td class="font-small-3 text-bold-500">{{ $variant->quantity }}</td>
                                                <td class="font-small-3 text-bold-500">{{ $variant->reward_point }}
                                                </td>
                                                <td class="font-small-3 text-bold-500">
                                                    {{ $app_settings['currency_code'] .' ' . number_format($variant->price,2) }}
                                                </td>
                                                {{-- <td>
                                                        <div
                                                            class="custom-control custom-switch custom-switch-success mr-2 mb-1 text-center">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="variant-status-{{ $variant->id }}"
                                                {{ $variant->status == 1 ? 'checked' : '' }}>
                                                <label class="custom-control-label"
                                                    for="variant-status-{{ $variant->id }}">
                                                    <span class="switch-text-left"></span>
                                                    <span class="switch-text-right"></span>
                                                </label>
                                </div>
                                </td> --}}
                                <td>
<a href="javascript:" class="edit-variants-btn" data-id="{{ $k }}" data-grind_id="{{ $variant->grind_id }}">
                                        <img src="{{ asset('assets/images/extra-icon-orange.svg')}}" width="7">
                                    </a>
                                </td>
                                </tr>
                                @endforeach
                                @endif
                                </tbody>
                                </table>
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
                    class="btn btn-primary font-weight-bold btn-lg w-100 waves-effect waves-light">SAVE</button>
            </div>
        </div>
    </form>
</section>
<!--Add New Service modal-->
<div class="modal fade text-left" id="add-variants" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ADD PRODUCT VARIANT</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" onsubmit="return false;" id="add-variant-form" name="add-variant-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id ?? '' }}">
                <input type="hidden" name="product_name" value="{{ $product->product_name ?? '' }}">
                <div class="modal-body">
                    <div id="variants-add">
                        <label>GRIND (SELECT ALL GRIND VARIANTS)</label>
                        <div class="form-group">
                            {{-- <div class="ui fluid selection dropdown"> --}}
                            {{-- <div class="ui fluid selection dropdown">
                            <input type="hidden" name="category">
                            <i class="dropdown icon"></i>
                            <div class="default text">Select Grind Variants</div>
                            <div class="menu">
                                <div class="item" data-value="electical">
                                    Select Grind Variants
                                </div>
                            </div>
                        </div> --}}
                            <select name="grind_ids[]" id="grind_ids" class="form-control" multiple>
                                <option value="">Select Grind Variants</option>
                                @foreach ($grinds as $grind)
                                    <option value="{{ $grind->id }}">{{ $grind->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label>WEIGHT (SELECT ALL WEIGHT VARIANTS)</label>
                        <div class="form-group">
                            {{-- <div class="ui fluid selection dropdown">
                            <input type="hidden" name="category">
                            <i class="dropdown icon"></i>
                            <div class="default text">Select Weight Variants</div>
                            <div class="menu">
                                <div class="item" data-value="electical">
                                    Select Weight Variants
                                </div>
                            </div>
                        </div> --}}
                            <select name="weight_ids[]" id="weight_ids" class="form-control" multiple>
                                <option value="">Select Weight Variants</option>
                                @foreach ($weights as $weight)
                                <option value="{{ $weight->id }}">{{ $weight->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="variants-price" style="display: none;">

                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:" type="button" class="btn btn-primary font-weight-bold btn-lg w-30"
                        onclick="displayWeights();" id="add_variant_nxt_btn">NEXT</a>
                    <a href="javascript:" type="button" id="add_variant_btn" class="btn btn-primary font-weight-bold btn-lg w-30" onclick="addVariant();" style="display: none;">Create</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Add New Service modal-->
<!--Add New Service modal-->
{{-- <div class="modal fade text-left" id="create-variants" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ADD PRODUCT VARIANT</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>PRICE: 250g</label>
                            <div class="form-group">
                                <fieldset>
                                    <div class="input-group variants-fild group-prepend">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-weight-bold" id="basic-addon1">AED</span>
                                        </div>
                                        <input type="text" class="form-control" placeholder=""
                                            aria-describedby="basic-addon1">
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>REWARD: 250g</label>
                            <div class="form-group">
                                <div class="ui fluid selection dropdown">
                                    <input type="hidden" name="category">
                                    <i class="dropdown icon"></i>
                                    <div class="default text"></div>
                                    <div class="menu">
                                        <div class="item" data-value="electical">
                                            1
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>SHIP WEIGHT</label>
                            <div class="form-group variants-fild group-append">
                                <fieldset>
                                    <div class="input-group">
                                        <input type="text" class="form-control" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <span class="input-group-text font-weight-bold" id="basic-addon2">g</span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>PRICE: 250g</label>
                            <div class="form-group">
                                <fieldset>
                                    <div class="input-group variants-fild group-prepend">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-weight-bold" id="basic-addon1">AED</span>
                                        </div>
                                        <input type="text" class="form-control" placeholder=""
                                            aria-describedby="basic-addon1">
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>REWARD: 250g</label>
                            <div class="form-group">
                                <div class="ui fluid selection dropdown">
                                    <input type="hidden" name="category">
                                    <i class="dropdown icon"></i>
                                    <div class="default text"></div>
                                    <div class="menu">
                                        <div class="item" data-value="electical">
                                            1
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>SHIP WEIGHT</label>
                            <div class="form-group variants-fild group-append">
                                <fieldset>
                                    <div class="input-group">
                                        <input type="text" class="form-control" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <span class="input-group-text font-weight-bold" id="basic-addon2">g</span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary font-weight-bold btn-lg w-30"
                        data-dismiss="modal">CREATE</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}
<!--End Add New Service modal-->
<!--EDIT PRODUCT VARIANT-->
<div class="modal fade text-left" id="edit-variants" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">EDIT PRODUCT VARIANT</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="edit-variant-form" id="edit-variant-form" name="edit-variant-form" onsubmit="return false;" method="post">
                @csrf
                <input type="hidden" name="variant_id" id="variant_id" value="">
<input type="hidden" name="grind_id" id="variant_grind_id" value="">
                <div class="modal-body">
                    <div class="row">
                        {{-- <div class="col-md-12">
                            <label>GRIND</label>
                            <div class="form-group">
                                <select name="grind_ids" id="grind_ids" class="form-control" multiple>
                                    <option value="">Select Grind Variants</option>
                                    @foreach ($grinds as $grind)
                                    <option value="{{ $grind->id }}">{{ $grind->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        {{-- <div class="col-md-6">
                            <label>SELL WEIGHT</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="Whole Beans" placeholder="250g">
                            </div>
                        </div> --}}
                        <div class="col-md-12">
                            <label>PRICE</label>
                            <div class="form-group">
                                <fieldset>
                                    <div class="input-group variants-fild group-prepend">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-weight-bold" id="basic-addon1">AED</span>
                                        </div>
                                        <input type="number" step="2" name="price" id="variant_price" class="form-control" placeholder=""
                                            aria-describedby="basic-addon1">
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>REWARD</label>
                            <div class="form-group">
                                {{-- <label for="">REWARD</label> --}}
                                <input type="number" id="variant_reward" name="reward_point" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>QUANTITY</label>
                            <div class="form-group">
                                {{-- <label for="">REWARD</label> --}}
                                <div>
                                    <label>
                                        <input type="radio" name="variant_quantity_type" value="add" checked /> Add
                                    </label>
                                    <label>
                                        <input type="radio" name="variant_quantity_type" value="subtract"/> Subtract
                                    </label>
                                </div>
                                <input type="number" id="variant_quantity" name="quantity" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
<button type="button" class="btn btn-outline-primary mr-1  waves-effect waves-light btn-lg font-weight-bold"
    onclick="deleteVariant()">DELETE</button>
                    <button type="button" class="btn btn-primary font-weight-bold btn-lg px-1" onclick="updateVariant()">UPDATE</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End EDIT PRODUCT VARIANT-->
@endsection

@section('scripts')
<script type="text/javascript">
let addVariantData = {};

let grinds = JSON.parse('@json($grinds ?? [])');
let weights = JSON.parse('@json($weights ?? [])');
let variants = JSON.parse('@json($product->variants ?? [])');


    $('#image_0').change(function(e) {
            var fileName = e.target.files[0].name;

            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("preview_image_0").src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        });
        $('#image_1').change(function(e) {
            var fileName = e.target.files[0].name;

            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("preview_image_1").src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        });
        $('#image_2').change(function(e) {
            var fileName = e.target.files[0].name;

            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("preview_image_2").src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        });
        $("#variants-btn").click(function(){
            $('#add-variants').modal('show');
        });
        $(".edit-variants-btn").click(function(){
            let info = variants[$(this).data('id')];
            $("#variant_id").val(info.id);
            $("#variant_price").val(info.price);
            $("#variant_quantity").val(info.quantity);
            $("#variant_reward").val(info.reward_point);
            $("#variant_grind_id").val($(this).data("grind_id"));
            $('#edit-variants').modal('show');
        });

        function displayWeights() {
            $('#variants-add').hide();
            $('#variants-price').show();
            $("#add_variant_nxt_btn").hide();
            $("#add_variant_btn").show();

            let weights = $("#weight_ids").val();
            let vals = [];$("#weight_ids option:selected").each(function(index, t) {
                vals.push(t.innerHTML);
            });

            $.each(weights, function(index, weight) {
                $("#variants-price").append('<div class="row">\
                    <div class="col-md-3">\
                        '+vals[index]+'\
                    </div>\
                    <div class="col-md-3">\
                        <div class="form-group">\
                            <label for="add_variant_price_'+weight+'">Price</label>\
                            <input class="form-control" type="number" name="add_variant['+weight+'][price]" id="variant_price_'+weight+'" min="0">\
                        </div>\
                    </div>\
                    <div class="col-md-3">\
                        <div class="form-group">\
                            <label for="variant_quantity_'+weight+'">Quantity</label>\
                            <input class="form-control" type="number" name="add_variant['+weight+'][quantity]" id="variant_quantity_'+weight+'" min="0">\
                        </div>\
                    </div>\
                    <div class="col-md-3">\
                        <div class="form-group">\
                            <label for="variant_reward_points_'+weight+'">REWARD</label>\
                            <input class="form-control" type="number" name="add_variant['+weight+'][reward_point]" id="variant_reward_points_'+weight+'" min="0">\
                        </div>\
                    </div>\
                </div>');
            });
        }

        function addVariant() {
            let product_id = '{{ $product->id ?? "" }}';
            if(product_id.toString().length === 0) {
                // let data = $("#add-variant-form").serializeArray();
                addVariantData.grind_ids = $("#grind_ids").val();
                addVariantData.weight_ids = $("#weight_ids").val();
                if(addVariantData.add_variant === undefined) {
                    addVariantData.add_variant = [];
                }
                $.each(addVariantData.weight_ids, function(index, weight_id) {
                    $.each(addVariantData.grind_ids, function(index, grind_id) {
                        addVariantData.add_variant[weight_id] = {};
                        addVariantData.add_variant[weight_id].price = $("#variant_price_" + weight_id).val();
                        addVariantData.add_variant[weight_id].quantity = $("#variant_quantity_" + weight_id).val();
                        addVariantData.add_variant[weight_id].reward_point = $("#variant_reward_points_" + weight_id).val();
                    });
                });
                $("#add_variant").val(JSON.stringify(addVariantData));
                if(addVariantData !== undefined && addVariantData.weight_ids !== undefined && addVariantData.weight_ids.length > 0) {
                    $("#variants-table tbody").html('');
                    let variant_index = 0;
                    $.each(addVariantData.weight_ids, function(weight_index, weight_id) {
                        $.each(addVariantData.grind_ids, function(grind_index, grind_id) {

                            let html = '<tr>\
                                    <td class="text-center font-small-3 text-bold-500">'+(parseInt(variant_index) + 1)+'</td>\
                                    <td class="font-small-3 text-bold-500">\
                                        <p class="font-small-3 text-bold-700 mb-0">GRIND_TITLE</p>\
                                    </td>\
                                    <td class="font-small-3 text-bold-500">\
                                        WEIGHT_TITLE\
                                    </td>\
                                    <td class="font-small-3 text-bold-500">QUANTITY</td>\
                                    <td class="font-small-3 text-bold-500">REWARD_POINT\
                                    </td>\
                                    <td class="font-small-3 text-bold-500">\
                                        CURRENCY_CODE VARIANT_PRICE\
                                    </td>\
                                    <td></td>\
                                </tr>';
                                /*
                                \
                                <span class="font-small-1 text-bold-500 mb-0 gray">SKU: SKU_CODE</span>\
                                <a href="javascript:" class="edit-variants-btn" data-id="VARIANT_WEIGHT_ID" data-grind_id="VARIANT_GRIND_ID">\
                                    <img src="SORT_ICON" width="7">\
                                </a>\ */

                            html = html.replace("SORT_ICON", '/public/assets/images/extra-icon-orange.svg');

                            grind_title = grinds.filter(e => e.id == grind_id);
                            if(grind_title !== undefined && grind_title.length > 0) {
                                grind_title = grind_title[0].title;
                            }
                            weight_title = weights.filter(e => e.id == weight_id);
                            if(weight_title !== undefined && weight_title.length > 0) {
                                weight_title = weight_title[0].title;
                            }

                            html = html.replace("GRIND_TITLE", grind_title);
                            // html = html.replace("SKU_CODE", '');
                            html = html.replace("WEIGHT_TITLE", weight_title);

                            html = html.replace("CURRENCY_CODE", '{{ $app_settings["currency_code"] ?? "" }}');
                            html = html.replace("QUANTITY", addVariantData.add_variant[weight_id].quantity);
                            html = html.replace("REWARD_POINT", addVariantData.add_variant[weight_id].reward_point);
                            html = html.replace("VARIANT_PRICE", addVariantData.add_variant[weight_id].price);

                            html = html.replace("VARIANT_WEIGHT_ID", weight_id);
                            html = html.replace("VARIANT_GRIND_ID", grind_id);

                            $("#variants-table tbody").append(html);
                            variant_index++;
                        });
                    });
                    $("#variants-table_info").html("Showing 1 to "+variant_index+" of "+variant_index+" entries");
                }
                $("#add-variant-form")[0].reset();
                $("#variants-price").html('');
                $("#variants-price").hide();
                $("#variants-add").show();
                $("#add-variants").modal('hide');
            }
            else {
                let formData = new FormData($("#add-variant-form")[0]);
                $.ajax({
                    url: BASE_URL + 'products/variants/create',
                    data: formData,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(response) {
                        if(response.status === true) {
                            $("#add-variants").modal('hide');
                            toastr.success(response.message, 'Success', toastrOptions);
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                        else {
                            toastr.error(response.message, 'Error', toastrOptions);
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }
        }

        function updateVariant() {
            let formData = new FormData($("#edit-variant-form")[0]);
            $.ajax({
                url: BASE_URL + 'products/variants/save',
                data: formData,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(response) {
                    if(response.status === true) {
                        $("#edit-variants").modal('hide');
                        toastr.success(response.message, 'Success', toastrOptions);
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                    else {
                        toastr.error(response.message, 'Error', toastrOptions);
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
function deleteVariant() {
let formData = new FormData($("#edit-variant-form")[0]);
$.ajax({
url: BASE_URL + 'products/variants/delete',
data: formData,
contentType: false,
processData: false,
type: 'POST',
success: function(response) {
if(response.status === true) {
$("#edit-variants").modal('hide');
toastr.success(response.message, 'Success', toastrOptions);
setTimeout(() => {
location.reload();
}, 2000);
}
else {
toastr.error(response.message, 'Error', toastrOptions);
}
},
error: function(err) {
console.log(err);
}
});
}
</script>
@endsection
