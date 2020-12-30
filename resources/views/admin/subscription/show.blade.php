@extends('layouts.app')
@section('content')
<section>
    <form id="subscription-form" name="subscription-form" action="{{ url('admin/subscription/save') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="subscription_id" id="subscription_id" value="{{ $subscription->id ?? '' }}">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pb-1 border-bottom">
                        <h4 class="card-title">SUBSCRIPTION INFORMATION</h4>
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
                                                    id="subscription-status" name="status"
                                                    {{ $subscription->status == 1 ? 'checked' : '' }} value="1">
                                                <label class="custom-control-label" for="subscription-status">
                                                </label>
                                            </div>
                                            <label class="font-small-3 text-bold-700 pb-0">Enabled</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>SUBSCRIPTION NAME </label>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Proudct Name" value="{{ $subscription->title ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" class="form-control" id="description" name="description"
                                            value="{{ $subscription->description ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>PRICE</label>
                                        <fieldset>
                                            <div class="input-group variants-fild group-prepend">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text font-weight-bold bg-white"
                                                        id="basic-addon1">AED</span>
                                                </div>
                                                <input type="text" class="form-control" placeholder=""
                                                    aria-describedby="basic-addon1" id="price" name="price" value="{{ number_format($subscription->price,2) ?? 0 }}">
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>TYPE</label>
                                        <select class="ui search dropdown w-100" name="type" id="type">
                                            <option value="monthly" {{ $subscription->type == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                            <option value="yearly" {{ $subscription->type == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>GRIND TYPES</label>
                                        <select class="ui search dropdown w-100" id="grind_ids" name="grind_ids[]" multiple>
                                            <option value="">Select Grind Type</option>
                                            @foreach ($grinds as $grind)
                                                <option value="{{ $grind->id }}" {{ in_array($grind->id, explode(',', $subscription->grind_ids)) ? 'selected' : '' }}>{{ $grind->title }}</option>
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
                        <h4 class="card-title">SUBSCRIPTION IMAGES</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row d-flex align-items-center">
                                <div class="col-md-12  text-center pt-5">
                                    <div class="form-group mb-0">
                                        <div class="add-new-banner-div">
                                            <div div class="enable-img d-flex align-items-center">
                                                <input type="file" name="image_url"
                                                    class="file-alternate-image-three d-none" accept="image/*">
                                                <img src="{{ asset($subscription->image_url ?? 'assets/images/subscription-box.png')}}"
                                                    id="preview-alternate-image-three"
                                                    class="browse-alternate-image-three">
                                            </div>
                                        </div>
                                        <p class="font-medium-2 text-bold-700 text-center pt-1">PRIMARY IMAGE</p>
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
                <button type="submit" class="btn btn-primary font-weight-bold btn-lg w-100 waves-effect waves-light">SAVE</button>
            </div>
        </div>
    </form>
</section>
@endsection
