@extends('layouts.app')
@section('content')
<section>
    <form method="POST" action="{{ url('admin/delivery-areas') }}">
        @csrf
        <input type="hidden" name="city_id" id="city_id" value="{{ $delivery_area->id }}">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pb-1 border-bottom">
                        <h4 class="card-title">SERVICE AREA INFORMATION</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>COUNTRY</label>
                                        <select name="country_id" id="country_id" class="form-control">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" {{ $delivery_area->country_id == $country->id ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>CITY</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="city" value="{{ $delivery_area->name }}">
                                    </div>
                                </div>
                                {{-- <div class="col-md-12">
                                    <div class="form-group">
                                        <label>DELIVERY TIME</label>
                                        <input type="text" class="form-control" name="delivery_time"
                                            placeholder="1-3 Business Days" disabled>
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
                        <h4 class="card-title">ROASTER &amp; SELLER INFORMATION</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>DELIVERY FEE</label>
                                        <fieldset>
                                            <div class="input-group variants-fild group-prepend">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text font-weight-bold bg-white"
                                                        id="basic-addon1">{{ $app_settings['currency_code'] }}</span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="" name="delivery_fee" id="delivery_fee"
                                                    aria-describedby="basic-addon1" value="{{ $delivery_area->delivery_fee }}">
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>DELIVERY TIME</label>
                                        <input type="text" class="form-control" name="delivery_time" id="delivery_time"
                                            placeholder="1-3 Business Days" value="{{ $delivery_area->delivery_time }}">
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
                <button type="submit" class="btn btn-primary font-weight-bold btn-lg w-100 waves-effect waves-light"
                    data-dismiss="modal">SAVE</button>
            </div>
        </div>
    </form>
</section>
@endsection
