@extends('layouts.app')
@section('content')
<section class="areas">
    <div class="card">
        <div class="card-header border-bottom pb-1">

            <h4 class="card-title">
                <b>DELIVERY AREAS</b><br>
                <span class="gray">{{ count($delivery_areas) }} CITY</span>
            </h4>

        </div>
        <div id="ecommerce-searchbar" class="pl-2 pr-2">
            <div class="row mt-1 justify-content-between align-items-top">
                <div class="col-lg-7 col-md-6">
                    <form onsubmit="return false;">
                        <fieldset class="form-group position-relative has-icon-right mb-1 mr-0">
                            <input type="text" class="form-control form-control-lg" id="search_area"
                                placeholder="Search by city/country name">
                            <div class="form-control-position">
                                <i class="feather icon-search px-1"></i>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="d-flex justify-content-between align-items-top w-100">
                        <button type="button"
                            class="btn btn-orange mr-1 mb-1 waves-effect waves-light btn-block btn-lg" id="search_btn">SEARCH</button>
                        <a href="{{ url('admin/delivery-areas/create')}}" type="button"
                            class="btn btn-outline-orange mr-0 mb-1 waves-effect waves-light btn-block btn-lg mt-0">ADD NEW AREA</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-content">
            <div class="table-responsive pagenation-row">
                <table class="table table-striped table-borderless" id="tblDeliveryAreas">
                    <thead>
                        <tr>
                            <th class="w-3"></th>
                            <th class="font-small-3 text-bold-700 w-12 text-center">SORT ORDER</th>
                            <th class="font-small-3 text-bold-700 text-center">IMAGE</th>
                            <th class="font-small-3 text-bold-700 ">COUNTRY</th>
                            <th class="font-small-3 text-bold-700">CITY</th>
                            <th class="font-small-3 text-bold-700">DELIVERY</th>
                            <th class="font-small-3 text-bold-700">DELIVERY TIME</th>
                            <th class="font-small-3 text-bold-700">ENABLED</th>
                            <th class="w-3"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($delivery_areas as $area)
                        <tr data-id="{{ $area->id }}">
                            <td class="text-center"><img src="{{ asset('assets/images/sort-icon.png') }}"
                                    class="handle"></td>
                            <td class="product-name index text-center font-medium-3">
                                {{ $area->display_order ?? '-' }}
                            </td>
                            <td class="uae-fleg text-center">
                                <img src="{{ asset($area->country->glag_image ?? 'assets/images/uae-flag.png') }}"
                                    width="100" height="60">
                            </td>
                            <td class="font-small-3 text-bold-500">
                                <p class="font-small-3 text-bold-500 mb-0">{{ $area->country->country_name ?? '-' }}
                                </p>
                            </td>
                            <td class="font-small-3 text-bold-500">{{ $area->name }}</td>
                            <td class="font-small-3 text-bold-500">{{ $area->country->currency ?? '-' }}
                                {{ $area->delivery_fee ?? '' }}</td>
                            <td class="font-small-3 text-bold-500">{{ $area->delivery_time ?? '-' }}</td>
                            {{-- <td class="font-small-3 text-bold-700">{{ $area->country->currency ?? '-' }}</td> --}}
                            <td>
                                <div class="custom-control custom-switch custom-switch-primary mr-2 mb-1 text-left">
                                    <input type="checkbox" class="custom-control-input" value="{{ $area->id }}"
                                        data-status="{{ $area->status == 1 ? '0' : '1' }}"
                                        {{ $area->status == 1 ? 'checked' : '' }} id="status-{{ $area->id }}"
                                        onchange="updateDeliveryArea(this)">
                                    <label class="custom-control-label" for="status-{{ $area->id }}">
                                        <span class="switch-text-left"></span>
                                        <span class="switch-text-right"></span>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <a href="{{ url('admin/delivery-areas/' .$area->id) }}">
                                    <img src="{{ asset('assets/images/extra-icon-orange.svg')}}" width="7">
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection


@section('scripts')
<script type="text/javascript">
    let sorting_areas = [];
    $(document).ready(function() {

        setTimeout(function() {
            $("#tblDeliveryAreas > tbody").sortable({
                placeholder: "ui-state-highlight",
                helper: 'clone',
                update: function(event, ui) {
                    sorting_areas = [];
                    $(this).children().each(function(index) {
                        let city_id = $(this).data('id');
                        sorting_areas.push({
                            city_id: city_id,
                            sort_order: index + 1,
                        });
                    });
                    updateSortOrders();
                }
            });
            $("#tblDeliveryAreas > tbody").disableSelection();
        }, 2000);

        $("#search_area").on("keyup", function() {
            searchAreas();
        });
        $("#search_btn").on("click", function() {
            searchAreas();
        });
    });

    function searchAreas() {
        let searchValue = $("#search_area").val().toLowerCase();
        $("#tblDeliveryAreas tbody tr").hide();
        $("#tblDeliveryAreas tbody tr.no-record").remove();
        $("#tblDeliveryAreas tbody tr").each(function(index, tr) {
            if($(tr).hasClass("no-record") === false) {
                let country = $(tr).find("td:nth-child(4)").text().toLowerCase();
                let city = $(tr).find("td:nth-child(5)").html().toLowerCase();
                if(country.indexOf(searchValue) > -1 || city.indexOf(searchValue) > -1) {
                    $(tr).show();
                }
            }
        });
        if($("#tblDeliveryAreas tbody tr:visible").length === 0) {
            $("#tblDeliveryAreas tbody").append("<tr class='no-record'><td colspan='9' class='text-center'>No record available.</td></tr>");
        }
    }

    function updateSortOrders() {
        // sorting_areas
        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('sorting_areas', JSON.stringify(sorting_areas));

        $.ajax({
            url: "{{ url('admin/delivery-areas/update-sort-orders') }}",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === true) {
                    Swal.fire({
                        type: "success",
                        title: 'Success',
                        text: response.message,
                        confirmButtonClass: 'btn btn-success',
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
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
                // console.log(error);
            }
        });
    }

    function updateDeliveryArea(t) {
        $("#addEditServiceForm").find('.help-block').remove();
        $("#addEditServiceForm").removeClass("error");

        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('city_id', t.value);
        formData.append('status', $(t).data('status'));

        $.ajax({
            url: "{{ url('admin/delivery-areas') }}",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === true) {
                    Swal.fire({
                        type: "success",
                        title: 'Success',
                        text: response.message,
                        confirmButtonClass: 'btn btn-success',
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    Swal.fire({
                        type: "error",
                        title: 'Error',
                        text: response.message,
                        confirmButtonClass: 'btn btn-danger',
                    });
                }
            },
            error: function(error) {
            }
        });
    }
</script>
@endsection
