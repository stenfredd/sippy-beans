@extends('layouts.app')
@section('content')
<section class="banners">
    <div class="card">
        <div class="card-header">
            <div class="card-search">
                <h4 class="card-title">
                    <b>BANNERS</b><br>
                    <span class="gray">{{ $banners }} BANNERS FOUND</span>
                    <div id="ecommerce-searchbar">
                        <div class="row mt-1 justify-content-between align-items-top">
                            <div class="col-lg-7 col-md-6">
                                <form>
                                    <fieldset class="form-group position-relative has-icon-right mb-1 mr-0">
                                        <input type="text" class="form-control form-control-lg" id="search_banner"
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
                                        class="btn btn-orange mr-1 mb-1 waves-effect waves-light btn-block btn-lg">SEARCH</button>
                                    <a href="{{ url('admin/banners/create')}}" type="button"
                                        class="btn btn-outline-orange mr-0 mb-1 waves-effect waves-light btn-block btn-lg mt-0"
                                        id="search_btn">ADD NEW BANNER</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </h4>
            </div>
        </div>
        <div class="card-content">
            <div class="table-responsive">
                <table class="table service-category-list" id="tblBanners">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="font-small-3 text-bold-700 w-13 text-center">SORT ORDER</th>
                            <th class="font-small-3 text-bold-700 text-center w-18">IMAGE</th>
                            <th class="font-small-3 text-bold-700 w-15">BANNER TITLE</th>
                            <th class="font-small-3 text-bold-700 w-12">LINK</th>
                            <th class="font-small-3 text-bold-700 w-17">DISPLAY ON</th>
                            <th class="font-small-3 text-bold-700 w-12 text-center">ENABLED</th>
                            <th class="font-small-3 text-bold-700 w-15">DATE CREATED</th>
                            <th class="font-small-3 text-bold-700 w-5"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
            $("#search_banner").keyup(function() {
                bannersTable.ajax.reload();
            });
            $("#search_btn").click(function() {
                bannersTable.ajax.reload();
            });
        })
        let bannersTable = $('#tblBanners').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthChange": false,
            "pageLength": 30,
            "searching": false,
            "order": [],
            "ajax": {
                "url": BASE_URL + "banners",
                "type": "POST",
                "data": function(data) {
                    data._token = '{{ csrf_token() }}';
                    data.search = $("#search_banner").val();
                }
            },
            "columns": [{
                    "data": "sort_image",
                    "class": "text-center"
                },
                {
                    "data": "display_order",
                    "class": "product-name index text-center font-small-3"
                },
                {
                    "data": "image_url",
                    "class": "service-category-img text-center"
                },
                {
                    "data": "title",
                    "class": "font-small-3 text-bold-700"
                },
                {
                    "data": "url",
                    "class": "font-small-3 text-bold-700"
                },
                {
                    "render": function() {
                        return "In App";
                    },
                    "class": "font-small-3 text-bold-700"
                },
                {
                    "data": "status"
                },
                {
                    "data": "created_at",
                    "class": "font-small-3 text-bold-700"
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

        let sorting_banners = [];
    $(document).ready(function() {
        setTimeout(function() {
            $( "#tblBanners > tbody" ).sortable({
                placeholder: "ui-state-highlight",
                helper: 'clone',
                update: function( event, ui ) {
                    sorting_banners = [];
                    $(this).children().each(function(index) {
                        let banner_id = $(this).data('id');
                        sorting_banners.push({
                            banner_id: banner_id,
                            sort_order: index + 1,
                        });
                    });
                    updateSortOrders();
                }
            });
            $( "#tblBanners > tbody" ).disableSelection();
        }, 2000);
    });


    function updateSortOrders() {
        // sorting_banners
        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('sorting_banners', JSON.stringify(sorting_banners));

        $.ajax({
            url: "{{ url('admin/banners/update-sort-orders') }}",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === true) {
                    bannersTable.ajax.reload();
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
        formData.append('banner_id', id);
        formData.append('status', status);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ url('admin/banners/save') }}",
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

                    bannersTable.ajax.reload();
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
                        $("#addEditBannerForm #" + field).parents(".form-group").append('<div class="help-block"><span class="text-danger">' + errorMsg + '</span></div>');
                        $("#addEditBannerForm #" + field).parents(".form-group").addClass("error");
                    });
                }
            }
        });
    }

</script>
@endsection
