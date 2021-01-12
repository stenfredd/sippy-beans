@extends('layouts.app')
@section('content')
<section id="horizontal-vertical" class="user-section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-search">
                        <h4 class="card-title">
                            <b>CATEGORIES</b><br>
                            <span class="gray">{{ $total_categories }} CATEGORIES FOUND</span>
                            <div id="ecommerce-searchbar">
                                <div class="row mt-1 justify-content-between align-items-top">
                                    <div class="col-lg-7 col-md-6">
                                        <form>
                                            <fieldset class="form-group position-relative has-icon-right mb-1 mr-0">
                                                <input type="text" class="form-control form-control-lg"
                                                    id="search_category"
                                                    placeholder="Search by first/last name, user no, phone number…">
                                                <div class="form-control-position">
                                                    <i class="feather icon-search px-1"></i>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                    <div class="col-lg-5 col-md-6">
                                        <div class="d-flex justify-content-between align-items-top w-100">
                                            <button type="button"
                                                class="btn btn-orange mr-1 mb-1 waves-effect waves-light btn-block btn-lg"
                                                id="search_btn">SEARCH</button>
                                            <a href="{{ url('admin/categories/create') }}" type="button"
                                                class="btn btn-outline-orange mr-0 mb-1 waves-effect waves-light btn-block btn-lg mt-0">ADD
                                                NEW CATEGORY</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </h4>
                    </div>
                </div>
                <div class="card-content">
                    <div class="table-responsive pagenation-row">
                        <table class="table table-borderless table-striped" id="tblCategories">
                            <thead>
                                <th class="w-5"></th>
                                <th class="font-small-3 text-bold-700 w-12 text-center">SORT ORDER</th>
                                <th class="font-small-3 text-bold-700 text-center w-15">IMAGE</th>
                                <th class="font-small-3 text-bold-700">CATEGORY TITLE & DESCRIPTION</th>
                                <th class="font-small-3 text-bold-700 w-12">PRODUCTS</th>
                                <th class="font-small-3 text-bold-700 text-center w-15">ENABLED</th>
                                <th class="font-small-3 text-bold-700 w-5"></th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr id="1">
                                    <td class="text-center"><img src="{{ asset('assets/images/sort-icon.png')}}"
                                class="handle"></td>
                                <td class="product-name index text-center font-medium-4">1</td>
                                <td class="service-category-img text-center">
                                    <img src="{{ asset('assets/images/competition-beans.svg')}}" width="100"
                                        height="60">
                                </td>
                                <td class="font-small-3 text-bold-700">
                                    <p class="font-small-3 text-bold-700 mb-0">Competition Beans</p>
                                    <span class="font-small-3 text-bold-500 ">The top beans in town.</span>
                                </td>
                                <td class="font-small-3 text-bold-700">
                                    <p class="font-small-3 text-bold-700 mb-0">10</p>
                                </td>
                                <td>
                                    <div
                                        class="custom-control custom-switch custom-switch-success mr-2 mb-1 text-center">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch101">
                                        <label class="custom-control-label" for="customSwitch101">
                                            <span class="switch-text-left"></span>
                                            <span class="switch-text-right"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ url('admin/categories/1') }}">
                                        <img src="{{ asset('assets/images/extra-icon-orange.svg')}}" width="7">
                                    </a>
                                </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
            $("#search_category").keyup(function() {
                categoriesTable.ajax.reload();
            });
            $("#search_btn").click(function() {
                categoriesTable.ajax.reload();
            });
        })
        let categoriesTable = $('#tblCategories').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthChange": false,
            "pageLength": 30,
            "searching": false,
            "order": [],
            "ajax": {
                "url": BASE_URL + "categories",
                "type": "POST",
                "data": function(data) {
                    data._token = '{{ csrf_token() }}';
                    data.search = $("#search_category").val();
                }
            },
            "columns": [{
                    "data": "sort_image",
                    "class": "text-center"
                },
                {
                    "data": "display_order",
                    "class": "product-name index text-center"
                },
                {
                    "data": "image_url",
                    "class": "service-category-img text-center"
                },
                {
                    "data": "title_desc",
                    "class": "font-small-3 text-bold-700"
                },
                {
                    "data": "products_count",
                    "class": "font-small-3 text-bold-700"
                },
                {
                    "data": "status"
                },
                {
                    "data": "action",
                    orderable: false
                }
            ],
        createdRow: function (row, data, dataIndex) {
            $(row).attr('data-id', data.id);
        }
        });

        let sorting_categories = [];
    $(document).ready(function() {
        setTimeout(function() {
            $( "#tblCategories > tbody" ).sortable({
                placeholder: "ui-state-highlight",
                helper: 'clone',
                update: function( event, ui ) {
                    sorting_categories = [];
                    $(this).children().each(function(index) {
                        let category_id = $(this).data('id');
                        sorting_categories.push({
                            category_id: category_id,
                            sort_order: index + 1,
                        });
                    });
                    updateSortOrders();
                }
            });
            $( "#tblCategories > tbody" ).disableSelection();
        }, 2000);
    });


    function updateSortOrders() {
        // sorting_categories
        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('sorting_categories', JSON.stringify(sorting_categories));

        $.ajax({
            url: "{{ url('admin/categories/update-sort-orders') }}",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === true) {
                    categoriesTable.ajax.reload();
                    Swal.fire({
                        type: "success",
                        title: 'Success',
                        text: response.message,
                        confirmButtonClass: 'btn btn-success',
                    })
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
                // console.log(error);
            }
        });
    }

    function updateStatus(id, status) {
        let formData = new FormData();
        formData.append('category_id', id);
        formData.append('status', status);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ url('admin/categories/save') }}",
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

                    categoriesTable.ajax.reload();
                    $("#addEditBannerModal").modal('hide');
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
                        $("#addEditCategoryForm #" + field).parents(".form-group").append('<div class="help-block"><span class="text-danger">' + errorMsg + '</span></div>');
                        $("#addEditCategoryForm #" + field).parents(".form-group").addClass("error");
                    });
                }
            }
        });
    }

</script>
@endsection
