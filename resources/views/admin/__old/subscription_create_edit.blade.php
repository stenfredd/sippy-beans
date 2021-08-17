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
                    <h2 class="content-header-title float-left mb-0">Subscriptions</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('admin') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript:">Masters</a>
                            </li>
                            <li class="breadcrumb-item">Subscriptions</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrum-right">
                <button class="btn-icon btn btn-primary btn-round btn-sm font-small-2 font-weight-bold" type="button" onclick="window.location='{{ url('admin/subscription') }}'">Show Subscriptions</button>
            </div>
        </div>
    </div>
</div>    
        <div class="modal-content container">            
        <form action="{{ url('admin/subscription_create_edit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">@if($model->id == NULL) Add subscription @else Edit subscription @endif</h5>
                </div>
                <div class="modal-body">
                    <fieldset class="form-group">
                        <label class="lbl"> Status:</label><input data-id="{{$model->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" name="status" data-toggle="toggle" data-on="Active" data-off="Inactive" {{ $model->status ? 'checked' : '' }}>
                    </fieldset>
                    <input type="hidden" name="Subscription[id]" value="{{old('Subscription.id',$model->id)}}">
                    <input type="hidden" id="image_id" name="image_id" class="form-control round">

                    <fieldset class="form-group {{ !$errors->equip->first('Subscription.title')?'':'has-error' }}" >
                        <label for="title">Title</label>
                        <input type="text" id="input-title" name="Subscription[title]" value="{{ old('Subscription.title',$model->title) }}" class="form-control round" placeholder="Product name">
                        <span class="help-block">{{ $errors->equip->first('Subscription.title',' Title is required')}}</span>
                    </fieldset>
                    
                    <fieldset class="form-group {{ !$errors->equip->first('Subscription.description')?'':'has-error' }}" >
                        <label for="description">Description</label>
                        <input type="text" id="input-description" name="Subscription[description]" value="{{ old('Subscription.description',$model->description) }}" class="form-control round" placeholder="Description">
                        <span class="help-block">{{ $errors->equip->first('Subscription.description',' Description is required')}}</span>
                    </fieldset>
            
                    <fieldset class="form-group {{ !$errors->equip->first('Subscription.price')?'':'has-error' }}" >
                        <label for="name">Price</label>
                        <input type="number" id="input-price" name="Subscription[price]" value="{{ old('Subscription.price',$model->price) }}" class="form-control round" placeholder="Price">
                        <span class="help-block">{{ $errors->equip->first('Subscription.price',' Price is required')}}</span>
                    </fieldset>

                    <fieldset class="form-group {{ !$errors->equip->first('Subscription.grind')?'':'has-error' }}">
                        <label for="grind_ids">Grind</label>
                        <select id="input-grind_ids" multiple="true" name="Subscription[grind_ids]" class="form-control round">
                            <option value="">Select Grind</option>
                            @if(!empty($grinds))
                                @foreach($grinds as $grind)
                                    <option value="{{ $grind->id }}">{{ $grind->title }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="help-block">{{ $errors->equip->first('Subscription.grind_ids','Grind is required')}}</span>
                    </fieldset>

                    <fieldset class="form-group">
                    <input type="checkbox" id="myCheck"  onclick="addbox();"> Add Image (Optional)
                        <div id="area" style="display: none;" >                            
                            <input type="file" id="image_path" name="image_path[]" multiple class="form-control round">
                        </div>
                    </fieldset>
                    
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-dark btn-round" data-dismiss="modal">Cancel</button> -->
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