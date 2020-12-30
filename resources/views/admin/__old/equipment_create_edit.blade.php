@extends('layouts.app') 
@section('content') 
<style>
.help-block {
  color: red;
}
.lbl {
    margin-right:3%;
}
</style>
<div class="content-wrapper pt-1">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Equipments</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('admin') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript:">Masters</a>
                            </li>
                            <li class="breadcrumb-item">Equipments</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrum-right">
                <button class="btn-icon btn btn-primary btn-round btn-sm font-small-2 font-weight-bold" type="button" onclick="window.location='{{ url('admin/equipments') }}'">Show Equipments</button>
            </div>
        </div>
    </div>
</div>    
        <div class="modal-content container">            
        <form action="{{ url('admin/equipment_create_edit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addEditEquipmentModalTitle">@if($model->id == NULL) Add equipment @else Edit equipment @endif</h5>
                </div>
                <div class="modal-body">
                    <fieldset class="form-group">
                        <label class="lbl"> Status:</label><input data-id="{{$model->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" name="status" data-toggle="toggle" data-on="Active" data-off="Inactive" {{ $model->status ? 'checked' : '' }}>
                    </fieldset>
                    <input type="hidden" name="Equipment[id]" value="{{old('Equipment.id',$model->id)}}">
                    <input type="hidden" id="image_id" name="image_id" class="form-control round">

                    <fieldset class="form-group {{ !$errors->equip->first('Equipment.title')?'':'has-error' }}" >
                        <label for="title">Title</label>
                        <input type="text" id="input-title" name="Equipment[title]" value="{{ old('Equipment.title',$model->title) }}" class="form-control round" placeholder="Product name">
                        <span class="help-block">{{ $errors->equip->first('Equipment.title',' Title is required')}}</span>
                    </fieldset>
                    <fieldset class="form-group {{ !$errors->equip->first('Equipment.short_description')?'':'has-error' }}" >
                        <label for="short_description">Short Description</label>
                        <input type="text" id="input-short_description" name="Equipment[short_description]" value="{{ old('Equipment.short_description',$model->short_description) }}" class="form-control round" placeholder="Short description">
                        <span class="help-block">{{ $errors->equip->first('Equipment.short_description',' Short description is required')}}</span>
                    </fieldset>
                    <fieldset class="form-group {{ !$errors->equip->first('Equipment.description')?'':'has-error' }}" >
                        <label for="description">Description</label>
                        <input type="text" id="input-description" name="Equipment[description]" value="{{ old('Equipment.description',$model->description) }}" class="form-control round" placeholder="Description">
                        <span class="help-block">{{ $errors->equip->first('Equipment.description',' Description is required')}}</span>
                    </fieldset>
                    <fieldset class="form-group {{ !$errors->equip->first('Equipment.sku')?'':'has-error' }}" >
                        <label for="sku">Sku</label>
                        <input type="text" id="input-sku" name="Equipment[sku]" value="{{ old('Equipment.sku',$model->sku) }}" class="form-control round" placeholder="Sku">
                        <span class="help-block">{{ $errors->equip->first('Equipment.sku',' Description is required')}}</span>
                    </fieldset>
                    <fieldset class="form-group {{ !$errors->equip->first('Equipment.price')?'':'has-error' }}" >
                        <label for="name">Price</label>
                        <input type="number" id="input-price" name="Equipment[price]" value="{{ old('Equipment.price',$model->price) }}" class="form-control round" placeholder="Price">
                        <span class="help-block">{{ $errors->equip->first('Equipment.price',' Price is required')}}</span>
                    </fieldset>
                    <fieldset class="form-group {{ !$errors->equip->first('Equipment.reward_point')?'':'has-error' }}" >
                        <label for="reward_point">Reward point</label>
                        <select id="input-reward_point" name="Equipment[reward_point]" value="{{ old('Equipment[reward_point]',$model->reward_point) }}" class="form-control round" placeholder="Reward point">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <span class="help-block">{{ $errors->equip->first('Equipment.reward_point',' Reward point is required')}}</span>
                    </fieldset>
                    <fieldset class="form-group {{ !$errors->equip->first('Equipment.quantity')?'':'has-error' }}" >
                        <label for="name">Quantity</label>
                        <input type="number" id="input-quantity" name="Equipment[quantity]" value="{{ old('Equipment.quantity',$model->quantity) }}" class="form-control round" placeholder="Quantity">
                        <span class="help-block">{{ $errors->equip->first('Equipment.quantity',' Quantity is required')}}</span>
                    </fieldset>
                    <fieldset class="form-group {{ !$errors->equip->first('Equipment.weight')?'':'has-error' }}" >
                        <label for="name">Weight</label>
                        <input type="text" id="input-weight" name="Equipment[weight]" value="{{ old('Equipment.weight',$model->weight) }}" class="form-control round" placeholder="Weight">
                        <span class="help-block">{{ $errors->equip->first('Equipment.weight',' Weight is required')}}</span>
                    </fieldset>
                    <fieldset class="form-group {{ !$errors->equip->first('Equipment.brand_id')?'':'has-error' }}" >
                        <label for="brand_id">Brand</label>
                        <select id="input-brand_id" name="Equipment[brand_id]" class="form-control round">
                            <option value="">Select Brand</option>
                            @if(!empty($brands))
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="help-block">{{ $errors->equip->first('Equipment.brand_id',' Brand is required')}}</span>
                    </fieldset>
                    <fieldset class="form-group {{ !$errors->equip->first('Equipment.type_id')?'':'has-error' }}" >
                        <label for="type_id">Type</label>
                        <select id="input-type_id" name="Equipment[type_id]" class="form-control round">
                            <option value="">Select Type</option>
                            @if(!empty($types))
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->title }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="help-block">{{ $errors->equip->first('Equipment.type_id',' Type is required')}}</span>
                    </fieldset>
                    <fieldset class="form-group {{ !$errors->equip->first('Equipment.seller_id')?'':'has-error' }}" >
                        <label for="seller_id">Seller Name</label>
                        <select id="input-seller_id" name="Equipment[seller_id]" class="form-control round">
                            <option value="">Select Seller</option>
                            @if(!empty($sellers))
                                @foreach($sellers as $seller)
                                    <option value="{{ $seller->id }}">{{ $seller->seller_name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="help-block">{{ $errors->equip->first('Equipment.seller_id',' Seller Name is required')}}</span>
                    </fieldset>
                    <fieldset class="form-group {{ !$errors->equip->first('Equipment.tax_class_id')?'':'has-error' }}" >
                        <label for="tax_class_id">Tax class</label>
                        <select id="input-tax_class_id" name="Equipment[tax_class_id]" class="form-control round">
                            <option value="">Select Tax class</option>
                            @if(!empty($tax_classes))
                                @foreach($tax_classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->class }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="help-block">{{ $errors->equip->first('Equipment.tax_class_id',' Tax class is required')}}</span>
                    </fieldset>
                    <!-- For Images  -->
                    <fieldset class="form-group">
                    <input type="checkbox" id="myCheck"  onclick="addbox();"> Add Image (Optional)
                        <div id="area" style="display: none;" >                            
                            <input type="file" id="image_path" name="image_path[]" multiple class="form-control round">
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-round" onclick="addEditEquipment()">Confirm</button>
                </div>
            </form>
        </div>    
@endsection
@section('scripts')
<script type="text/javascript">
    document.getElementById("myCheck").addEventListener("click", function() {
    toggle('area');
    });
    function toggle(obj) {

        var el = document.getElementById(obj);

        el.style.display = (el.style.display != 'none' ? 'none' : '' );

    }
</script>
@endsection