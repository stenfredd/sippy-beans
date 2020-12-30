@extends('layouts.app') @section('content')
<div class="content-wrapper pt-1">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Settings</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('admin') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript:">Pages</a>
                            </li>
                            <li class="breadcrumb-item">Settings</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Settings</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" method="post" id="settingForm">
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="app_name">Application Name</label>
                                                    <input type="text" id="app_name" class="form-control" placeholder="Application Name" name="app_name" value="<?= $settings['app_name'] ?? env('APP_NAME') ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="timezone">Timezone</label>
                                                    <select name="timezone" id="timezone" class="form-control">
                                                        <option value="Asia/Kolkata" <?= ($settings['timezone'] ?? '') == 'Asia/Kolkata' ? 'selected' : null ?>>Asia/Kolkata</option>
                                                        <option value="Asia/Dubai" <?= ($settings['timezone'] ?? '') == 'Asia/Dubai' ? 'selected' : null ?>>Asia/Dubai</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tax_charges">Tax & Charges (%)</label>
                                                    <input type="number" id="tax_charges" class="form-control" placeholder="Visiting Fee" name="tax_charges" min="0" max="100" value="<?= $settings['tax_charges'] ?? '0' ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="currency_name">Currency Name</label>
                                                            <select name="currency_name" id="currency_name" class="form-control" onchange="setCurrency()">
                                                                <option value="Indian Rupees" data-code="INR" <?= ($settings['currency_name'] ?? '') == 'Indian Rupees' ? 'selected' : null ?>>Indian Rupees</option>
                                                                <option value="Arab Emirate Dhiram" data-code="AED" <?= ($settings['currency_name'] ?? '') == 'Arab Emirate Dhiram' ? 'selected' : null ?>>Arab Emirate Dhiram</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12">
                                                        <div class="form-group">
                                                            <label for="currency_code">Currency Code</label>
                                                            <select name="currency_code" id="currency_code" class="form-control" readonly disabled>
                                                                <option value="INR" <?= ($settings['currency_code'] ?? '') == 'INR' ? 'selected' : null ?>>INR</option>
                                                                <option value="AED" <?= ($settings['currency_code'] ?? '') == 'AED' ? 'selected' : null ?>>AED</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12">
                                                        <div class="form-group">
                                                            <label for="currency_symbol">Symbol</label>
                                                            <select name="currency_symbol" id="currency_symbol" class="form-control" readonly disabled>
                                                                <option value="₹" <?= ($settings['currency_symbol'] ?? '') == '₹' ? 'selected' : null ?>>₹</option>
                                                                <option value="د.إ" <?= ($settings['currency_symbol'] ?? '') == 'د.إ' ? 'selected' : null ?>>د.إ</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="delivery_fee">Delivery Fee</label>
                                                    <input type="number" id="delivery_fee" class="form-control" placeholder="Delivery Fee" name="delivery_fee" min="0" value="<?= $settings['delivery_fee'] ?? '0' ?>">
                                                </div>                                                
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    $(document).ready(function() {
        $("#settingForm").submit(function() {
            $("#currency_code").removeAttr('disabled');
            $("#currency_symbol").removeAttr('disabled');
        });
    })
    function saveSettings() {
        $("#addEditSettingForm").find('.help-block').remove();
        $("#addEditSettingForm").removeClass("error");

        let formData = new FormData($("#addEditSettingForm")[0]);
        $.ajax({
            url: "{{ url('admin/settings/save') }}",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                if (response.status === true) {
                    toastr.success(response.message, 'Success', {
                        "closeButton": true,
                        "progressBar": true,
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        "timeOut": 2000
                    });
                }
                else {
                    toastr.error(response.message, 'Error', {
                        "closeButton": true,
                        "progressBar": true,
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        "timeOut": 2000
                    });
                }
            },
            error: function(error) {
                if (error.status === 422) {
                    $.each(error.responseJSON.errors, function(field, errorMsg) {
                        $("#addEditSettingForm #" + field).parents(".form-group").append('<div class="help-block"><span class="text-danger">' + errorMsg + '</span></div>');
                        $("#addEditSettingForm #" + field).parents(".form-group").addClass("error");
                    });
                }
            }
        });
    }

    function setCurrency() {
        let currency_code = $("#currency_name option:selected").data("code");
        $("#currency_code").val(currency_code);
        $("#currency_symbol").val(currency_code === "INR" ? '₹' : 'د.إ');
    }
</script>
@endsection
