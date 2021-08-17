@extends('layouts.app')
@section('content')
<section>
    <form action="{{ url('admin/tax-charges') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-1 border-bottom">
                        <h4 class="card-title">TAXES & CHARGES</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="font-small-3 text-bold-700 w-100 mb-50">TAX</label>
                                    <div class="form-inline text-chages-fild">
                                        <div class="form-group mb-50">
                                            <label for="inputPassword6"
                                                class="font-medium-2 text-bold-700 text-primary mr-1 pb-0">VAT</label>
                                            <div class="input-group mb-0">
                                                <input type="text" class="form-control" placeholder="0.00" value="{{ number_format($app_settings['tax_charges'],2) ?? 0 }}" name="tax_charges">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="font-small-2 gray mb-1">Add the value percent tax to charge the customer
                                        on a service request.</p>
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
                        <h4 class="card-title">CASH PAYMENT</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="font-small-3 text-bold-700 w-100 mb-50">ENABLE/DISABLE CASH PAYMENT</label>
                                    <div class="form-inline text-chages-fild">
                                        <div class="form-group mb-50">
                                            <div class="input-group mb-0">
                                                <div class="custom-control custom-switch switch-lg custom-switch-success mr-1">
                                                    <input name="allow_cash_payment" type="checkbox" class="custom-control-input" id="order-status-1" {{ $app_settings['allow_cash_payment'] ? 'checked' : '' }} value="1" name="status">
                                                    <label class="custom-control-label" for="order-status-1"></label>
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
        </div>
        <div class="row justify-content-end">
            <div class="col-md-6">
                <button type="submit"
                    class="btn btn-primary font-weight-bold btn-lg w-100 waves-effect waves-light">SAVE & APPLY</button>
            </div>
        </div>
    </form>
</section>
@endsection
