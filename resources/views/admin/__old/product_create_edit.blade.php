@extends('layouts.app')
@section('content')
    <style>
        .help-block {
            color: red;
        }

        .lbl {
            margin-right: 3%;
        }

    </style>
    <div class="content-wrapper pt-1">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Products</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('admin') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="javascript:">Masters</a>
                                </li>
                                <li class="breadcrumb-item">Products</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                <div class="form-group breadcrum-right">
                    <button class="btn-icon btn btn-primary btn-round btn-sm font-small-2 font-weight-bold" type="button"
                        onclick="window.location='{{ url('admin/products') }}'">Show Products</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="col-12">
            <form role="form" class="bg-white p-2" enctype="multipart/form-data" method="POST" action="{{ url('admin/products/store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addEditProductModalTitle">Add Product </h5>
                </div>
                <div class="box-body">
                    <fieldset class="form-group mt-2">
                        <label class="lbl"> Status:</label>
                        <input class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger"
                            name="status" data-toggle="toggle" data-on="Active" data-off="Inactive" style="cursor: pointer;">
                    </fieldset>

                    <fieldset class="form-group {{ $errors->first('product_name') ? 'has-error' : '' }}">
                        <label for="product_name">Product Name</label>
                        <input type="text" id="product_name" name="product_name" value="{{ old('product_name') }}"
                            class="form-control round" placeholder="Product name">
                        <span class="help-block">{{ $errors->first('product_name', 'Product name is required') }}</span>
                    </fieldset>
                    <fieldset class="form-group {{ $errors->first('description') ? 'has-error' : '' }}">
                        <label for="description">Description</label>
                        <input type="text" id="description" name="description" value="{{ old('description') }}"
                            class="form-control round" placeholder="Description">
                        <span class="help-block">{{ $errors->first('description', 'Description is required') }}</span>
                    </fieldset>
                    <fieldset class="form-group {{ $errors->first('varietal') ? 'has-error' : '' }}">
                        <label for="varietal">Varietal</label>
                        <input type="text" id="varietal" name="varietal" value="{{ old('varietal') }}"
                            class="form-control round" placeholder="Varietal">
                        <span class="help-block">{{ $errors->first('varietal', 'Vatietal is required') }}</span>
                    </fieldset>
                    <fieldset class="form-group {{ $errors->first('altitude') ? 'has-error' : '' }}">
                        <label for="altitude">Altitude</label>
                        <input type="text" id="altitude" name="altitude" value="{{ old('altitude') }}"
                            class="form-control round" placeholder="Altitude">
                        <span class="help-block">{{ $errors->first('altitude', 'altitude is required') }}</span>
                    </fieldset>
                    <fieldset class="form-group {{ $errors->first('sku') ? 'has-error' : '' }}">
                        <label for="sku">Sku</label>
                        <input type="text" id="sku" name="sku" value="{{ old('sku') }}" class="form-control round"
                            placeholder="Sku">
                        <span class="help-block">{{ $errors->first('sku', 'sku is required') }}</span>
                    </fieldset>
                    <fieldset class="form-group {{ $errors->first('reward_point') ? 'has-error' : '' }}">
                        <label for="reward_point">Reward point</label>
                        <select id="reward_point" name="reward_point" value="{{ old('reward_point') }}"
                            class="form-control round" placeholder="Reward point">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <span class="help-block">{{ $errors->first('reward_point', 'Reward point is required') }}</span>
                    </fieldset>
                    <fieldset class="form-group {{ $errors->first('quantity') ? 'has-error' : '' }}">
                        <label for="quantity">Quantity</label>
                        <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}"
                            class="form-control round" placeholder="Quantity">
                        <span class="help-block">{{ $errors->first('quantity', 'Quantity is required') }}</span>
                    </fieldset>
                    <fieldset class="form-group {{ $errors->first('flavor_note') ? 'has-error' : '' }}">
                        <label for="flavor_note">Flavor note</label>
                        <input type="text" id="flavor_note" name="flavor_note" value="{{ old('flavor_note') }}"
                            class="form-control round" placeholder="Flavor note">
                        <span class="help-block">{{ $errors->first('flavor_note', 'Flavor note is required') }}</span>
                    </fieldset>

                    <fieldset class="form-group {{ $errors->first('type_id') ? 'has-error' : '' }}">
                        <label for="type_id">Type</label>
                        <select id="type_id" name="type_id" class="form-control round">
                            <option value="">Select type</option>
                            @if (!empty($types))
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->title }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="help-block">{{ $errors->first('type_id', 'type is required') }}</span>
                    </fieldset>

                    <fieldset class="form-group {{ $errors->first('origin_id') ? 'has-error' : '' }}">
                        <label for="origin_id">Origin Name</label>
                        <select id="origin_id" name="origin_id" class="form-control round">
                            <option value="">Select Origin</option>
                            @if (!empty($origins))
                                @foreach ($origins as $origin)
                                    <option value="{{ $origin->id }}">{{ $origin->origin_name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="help-block">{{ $errors->first('origin_id', 'Origin is required') }}</span>
                    </fieldset>
                    <fieldset class="form-group {{ $errors->first('brand_id') ? 'has-error' : '' }}">
                        <label for="brand_id">Brand Name</label>
                        <select id="brand_id" name="brand_id" class="form-control round">
                            <option value="">Select Brand</option>
                            @if (!empty($brands))
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="help-block">{{ $errors->first('brand_id', 'Brand is required') }}</span>
                    </fieldset>
                    <fieldset class="form-group {{ $errors->first('brand_type_id') ? 'has-error' : '' }}">
                        <label for="brand_type_id">Brand Type</label>
                        <select id="brand_type_id" name="brand_type_id" class="form-control round">
                            <option value="">Select Brand type</option>
                            @if (!empty($brand_types))
                                @foreach ($brand_types as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="help-block">{{ $errors->first('brand_type_id', 'Brand type is required') }}</span>
                    </fieldset>
                    <fieldset class="form-group {{ $errors->first('characteristics_id') ? 'has-error' : '' }}">
                        <label for="type_id">Characteristics</label>
                        <select id="characteristic_id" name="characteristic_id" class="form-control round">
                            <option value="">Select Characteristics</option>
                            @if (!empty($characteristics))
                                @foreach ($characteristics as $characteristic)
                                    <option value="{{ $characteristic->id }}">{{ $characteristic->title }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span
                            class="help-block">{{ $errors->first('characteristic_id', 'Characteristic is required') }}</span>
                    </fieldset>
                    <fieldset class="form-group {{ $errors->first('best_for_id') ? 'has-error' : '' }}">
                        <label for="best_for_id">Best for</label>
                        <select id="best_for_id" name="best_for_id" class="form-control round">
                            <option value="">Select Best for</option>
                            @if (!empty($bestFor))
                                @foreach ($bestFor as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="help-block">{{ $errors->first('best_for_id', 'Best for is required') }}</span>
                    </fieldset>
                    <fieldset class="form-group {{ $errors->first('coffee_type_id') ? 'has-error' : '' }}">
                        <label for="coffee_type_id">Coffee type</label>
                        <select id="coffee_type_id" name="coffee_type_id" class="form-control round">
                            <option value="">Select Coffee Type</option>
                            @if (!empty($coffeeTypes))
                                @foreach ($coffeeTypes as $coffeeType)
                                    <option value="{{ $coffeeType->id }}">{{ $coffeeType->title }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="help-block">{{ $errors->first('coffee_type_id', 'Coffee type is required') }}</span>
                    </fieldset>
                    <fieldset class="form-group {{ $errors->first('level_id') ? 'has-error' : '' }}">
                        <label for="level_id">Level</label>
                        <select id="level_id" name="level_id" class="form-control round">
                            <option value="">Select Level</option>
                            @if (!empty($levels))
                                @foreach ($levels as $level)
                                    <option value="{{ $level->id }}">{{ $level->level_title }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="help-block">{{ $errors->first('level_id', 'Level is required') }}</span>
                    </fieldset>
                    <fieldset class="form-group {{ $errors->first('process_id') ? 'has-error' : '' }}">
                        <label for="process_id">Process</label>
                        <select id="process_id" name="process_id" class="form-control round">
                            <option value="">Select process</option>
                            @if (!empty($processes))
                                @foreach ($processes as $process)
                                    <option value="{{ $process->id }}">{{ $process->title }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="help-block">{{ $errors->first('process_id', 'Process is required') }}</span>
                    </fieldset>
                    <fieldset class="form-group {{ $errors->first('seller_id') ? 'has-error' : '' }}">
                        <label for="seller_id">Seller Name</label>
                        <select id="seller_id" name="seller_id" class="form-control round">
                            <option value="">Select Seller</option>
                            @if (!empty($sellers))
                                @foreach ($sellers as $seller)
                                    <option value="{{ $seller->id }}">{{ $seller->seller_name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="help-block">{{ $errors->first('seller_id', 'Seller name is required') }}</span>
                    </fieldset>
                    <fieldset class="form-group {{ $errors->first('tax_class') ? 'has-error' : '' }}">
                        <label for="tax_class_id">Tax class</label>
                        <select id="tax_class_id" name="tax_class_id" class="form-control round">
                            <option value="">Select Tax class</option>
                            @if (!empty($tax_classes))
                                @foreach ($tax_classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->class }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="help-block">{{ $errors->first('tax_class_id', 'Grind is required') }}</span>
                    </fieldset>
                    <!-- For Images  -->
                    <fieldset class="form-group">
                        <label for="">Add Image</label>
                        <input type="file" id="images" name="images[]" class="form-control round" multiple>
                    </fieldset>

                    <fieldset class="form-group {{ $errors->first('grind_id') ? 'has-error' : '' }}">
                        <label for="grind_id">Grind</label>
                        <select id="grind_id" name="grind_id[]" class="form-control round" multiple>
                            <option value="">Select Grind</option>
                            @if (!empty($grinds))
                                @foreach ($grinds as $grind)
                                    <option value="{{ $grind->id }}">{{ $grind->title }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="help-block">{{ $errors->first('grind_id', 'Grind is required') }}</span>
                    </fieldset>

                    <fieldset class="form-group {{ $errors->first('weight_id') ? 'has-error' : '' }}">
                        <label for="weight_id">Weight</label>
                        <select id="weight_id" name="weight_id[]" class="form-control round" multiple>
                            <option value="">Select Weight</option>
                            @if (!empty($weights))
                                @foreach ($weights as $weight)
                                    <option value="{{ $weight->id }}">{{ $weight->title }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="help-block">{{ $errors->first('weight_id', 'Weight is required') }}</span>
                    </fieldset>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-round">Confirm</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        function toggle(obj) {
            var el = document.getElementById(obj);
            el.style.display = (el.style.display != 'none' ? 'none' : '');
            el.style.cursor = 'pointer';
        }
    </script>
@endsection
