@extends('layouts.app')
@section('content')
<section>
    <form action="{{ url('admin/promo-offers/save') }}" method="post" id="promo-offer-form">
        @csrf
        <input type="hidden" name="promocode_id" id="promocode_id" value="{{ $promocode->id ?? '' }}">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pb-1 border-bottom">
                        <h4 class="card-title">PROMO DETAILS</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>PROMO TITLE</label>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Add a title for the promo"
                                            value="{{ $promocode->title ?? old('title') }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>PROMO CODE</label>
                                        <input type="text" class="form-control" name="promocode" id="promocode"
                                            placeholder="Enter a promo code"
                                            value="{{ $promocode->promocode ?? old('promocode') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>PROMO VALUE</label>
                                        <input type="number" class="form-control" name="discount_amount"
                                            id="discount_amount" placeholder="Value (#)"
                                            value="{{ $promocode->discount_amount ?? old('discount_amount') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>VALUE TYPE</label>
                                        <select class="ui search dropdown w-100" id="discount_type"
                                            name="discount_type">
                                            <option value="">Unit Type</option>
                                            <option value="percentage"
                                                {{ ($promocode->discount_type ?? '') == 'percentage' ? 'selected' : '' }}>
                                                Percentage</option>
                                            <option value="amount"
                                                {{ ($promocode->discount_type ?? '') == 'amount' ? 'selected' : '' }}>
                                                Amount</option>
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
                        <h4 class="card-title">PROMO DETAILS</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>START DATE</label>
                                        <div id="sandbox-container">
                                            <input type="text" class="form-control" placeholder="Start Date"
                                                id="start_date" name="start_date"
                                                value="{{ $promocode->start_date ?? old('start_date') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>END DATE</label>
                                        <div id="sandbox-container">
                                            <input type="text" class="form-control" placeholder="Start Date"
                                                id="end_date" name="end_date"
                                                value="{{ $promocode->end_date ?? old('end_date') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>START TIME</label>
                                        <div class="" id="timepicker">
                                            <input type="text" class="form-control input-small" placeholder="Start Time"
                                                id="start_time" name="start_time"
                                                value="{{ $promocode->start_time ?? old('start_time') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>END TIME</label>
                                        <div class="" id="timepicker">
                                            <input type="text" class="form-control input-small " placeholder="End Time"
                                                id="end_time" name="end_time"
                                                value="{{ $promocode->end_time ?? old('end_time') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>PROMO ENABLE/DISABLE</label>
                                        <div
                                            class="custom-control custom-switch custom-switch-primary mr-2 mb-1 text-left">
                                            <input type="checkbox" class="custom-control-input" id="status"
                                                name="status" value="1"
                                                {{ !empty($promocode) && $promocode->status == 1 ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="status">
                                                <span class="switch-text-left"></span>
                                                <span class="switch-text-right"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>ONE TIME USE PER USER</label>
                                        <div class="custom-control custom-switch custom-switch-primary mr-2 mb-1 text-left">
                                            <input type="checkbox" class="custom-control-input" id="one_time_user" name="one_time_user" value="1"
                                                {{ !empty($promocode) && $promocode->one_time_user == 1 ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="one_time_user">
                                                <span class="switch-text-left"></span>
                                                <span class="switch-text-right"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Used Limit</label>
                                        <input type="number" class="form-control" name="used_limit" id="used_limit"
                                            placeholder="Value (#)"
                                            value="{{ $promocode->used_limit ?? old('used_limit') }}">
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
                        <h4 class="card-title">PROMO ACCESS</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p class="font-small-3">PROMO/OFFER AVAILABLE TO ALL CUSTOMERS?</p>

                            <button type="button"
                                class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light {{ empty($promo_users) ? 'active' : '' }}"
                                id="users_btn_1"
                                onclick="$('#users_btn_2').removeClass('active');$(this).addClass('active');$('#users_list').hide();$('.user_ids').prop('checked', false)">YES</button>
                            <button type="button"
                                class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light {{ !empty($promo_users) ? 'active' : '' }}"
                                id="users_btn_2"
                                onclick="$('#users_btn_1').removeClass('active');$(this).addClass('active');$('#users_list').show();">NO</button>
                        </div>
                    </div>
                    <div id="users_list" style="display: {{ empty($promo_users) ? 'none' : '' }};">
                        <div class="card-header border-bottom">
                            <div class="card-search">
                                <h4 class="card-title">
                                    <b>SELECT USERS</b><br>
                                    <span
                                        class="gray">{{ \App\User::where('user_type', '!=', 'admin')->whereStatus(1)->count() }}
                                        REGISTERD USERS</span>
                                </h4>
                                <div id="ecommerce-searchbar">
                                    <div class="row mt-1 justify-content-between align-items-top">
                                        <div class="col-lg-9 col-md-6">

                                            <fieldset class="form-group position-relative has-icon-right mb-1 mr-0">
                                                <input type="text" class="form-control form-control-lg" id="searchbar"
                                                    placeholder="Search by first/last name, user no, phone number…">
                                                <div class="form-control-position">
                                                    <i class="feather icon-search px-1"></i>
                                                </div>
                                            </fieldset>

                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="d-flex justify-content-between align-items-top w-100">
                                                <button type="button"
                                                    class="btn btn-orange mr-1 mb-1 waves-effect waves-light btn-block btn-lg">SEARCH</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-content user-section last-row">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped">
                                    <thead>
                                        <tr>
                                            <th class="no_sorting_asc">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" value="1" id="check_all_users">
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </fieldset>
                                            </th>
                                            <th>USER NO.</th>
                                            <th class="no_sorting_asc">FIRST NAME</th>
                                            <th class="no_sorting_asc">LAST NAME</th>
                                            <th class="no_sorting_asc">EMAIL ADDRESS</th>
                                            <th class="no_sorting_asc">PHONE NUMBER</th>
                                            <th>REQUESTS</th>
                                            <th>REVENUE</th>
                                            <th>CREATED AT</th>
                                            <th class="no_sorting_asc"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $user)
                                        <tr>
                                            <td>
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" value="{{ $user->id }}" name="user_ids[]"
                                                            class="user_ids"
                                                            {{ !empty($promo_users) && in_array($user->id, $promo_users) ? 'checked' : '' }}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </fieldset>
                                            </td>
                                            <td>#{{ $user->id }}</td>
                                            <td>{{ $user->first_name }}</td>
                                            <td>{{ $user->last_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>{{ $user->total_completed_requests }}</td>
                                            <td>{{ $app_settings['currency_code'] . ' ' . $user->total_revenue }}</td>
                                            <td>
                                                {{ $user->created_at->timezone($app_settings['timezone'])->format('M d,Y') }}<br><span
                                                    class="time">{{ $user->created_at->timezone($app_settings['timezone'])->format('g:iA') }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ url('admin/users/' . $user->id) }}"><i
                                                        class="feather icon-eye"></i></a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No users found.</td>
                                        </tr>
                                        @endforelse
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
                <button type="submit" class="btn btn-primary font-weight-bold btn-lg w-100 waves-effect waves-light"
                    data-dismiss="modal">SAVE & REQUEST</button>
            </div>
        </div>
    </form>
</section>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $("#check_all_users").change(function() {
            $(".user_ids").prop("checked", this.checked);
        });
        $(".user_ids").change(function() {
            if ($(".user_ids").length === $(".user_ids:checked").length) {
                $("#check_all_users").prop("checked", true);
            } else {
                $("#check_all_users").prop("checked", false);
            }
        });
        $("#promo-offer-form").submit(function() {
            if ($("#users_btn_2").hasClass('active') && $(".user_ids:checked").length === 0) {
                toastr.error('Please select atleast one user.', 'Error', toastrOptions);
                return false;
            }
        });
    });
</script>

@endsection
