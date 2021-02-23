@extends('layouts.app')
@section('content')
<section>
    @if($errors->any())
        <ul class="bg-danger p-1 pl-3" style="border-radius: 5px;">
            {!! implode('', $errors->all('<li class="text-white">:message</li>')) !!}
        </ul>
    @endif
    <form method="POST" action="{{ url('admin/delivery-areas/create') }}">
        @csrf
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
                                        <select name="country_name" id="country_name" class="form-control">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country }}">{{ $country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>CITY</label>
                                        <input type="text" class="form-control" name="city_name" id="city_name" placeholder="city" value="">
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
                        <h4 class="card-title">DELIVERY INFORMATION</h4>
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
                                                    aria-describedby="basic-addon1" value="">
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>DELIVERY TIME</label>
                                        <input type="text" class="form-control" name="delivery_time" id="delivery_time"
                                            placeholder="1-3 Business Days" value="">
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
