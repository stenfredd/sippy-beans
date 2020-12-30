@extends('layouts.app') @section('content')
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ui.css') }}">

<div class="content-wrapper pt-1">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Banners</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('admin') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript:">Masters</a>
                            </li>
                            <li class="breadcrumb-item">Banners</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrum-right">
                <button class="btn-icon btn btn-primary btn-round btn-sm font-small-2 font-weight-bold" type="button" onclick="showAddEditModal(this, false)">Add Banner</button>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section id="horizontal-vertical">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    <table class="table nowrap w-100" id="tblBanners">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="modal fade" id="addEditBannerModal" tabindex="-1" role="dialog" aria-labelledby="addEditBannerModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEditBannerModalTitle">Add Banner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addEditBannerForm" class="form-horizontal" action="#" onsubmit="return false;" novalidate>
                @csrf
                <div class="modal-body">
                    <fieldset class="form-group d-none">
                        <input type="hidden" id="banner_id" name="banner_id" class="form-control round">
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="image_url">Image</label>
                        <input type="file" id="image_url" name="image_url" class="form-control round">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control round" placeholder="Title">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="description">Description</label>
                        <input type="text" id="description" name="description" class="form-control round" placeholder="Description">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control round">
                            <option value="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-round" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-round" onclick="addEditBanner()">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/jquery-ui.js') }}"></script>
<script type="text/javascript">
    let bannersTable = $('#tblBanners').DataTable({
        "scrollY": 500,
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "{{ url('admin/banners') }}",
            "type": "GET",
            "data": {
                "_token": "{{ csrf_token() }}"
            }
        },
        "columns": [
            {
                "data": "DT_RowIndex",
                orderable: false,
                width: '5%'
            },
            {
                "data": "image_url",
                orderable: false,
                width: '25%'
            },
            {
                "data": "title",
                width: '15%'
            },
            {
                "data": "description",
                width: '40%'
            },
            {
                "render": function(meta, type, row) {
                    return (row.status === 1 ? 'Active' : 'Inactive');
                },
                width: '7%'
            },
            {
                "data": "action",
                orderable: false,
                width: '8%'
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

    function showAddEditModal(t, edit) {
        $('#addEditBannerModalTitle').text('Add Banner');
        $("#addEditBannerForm")[0].reset();
        $("#banner_id").val('');
        if (edit === true) {
            $('#addEditBannerModalTitle').text('Edit Banner');
            let bannerData = bannersTable.row($(t).parents('tr')).data();
            $("#addEditBannerForm #banner_id").val(bannerData.id);
            $("#addEditBannerForm #title").val(bannerData.title);
            $("#addEditBannerForm #description").val(bannerData.description);
            $("#addEditBannerForm #status").val(bannerData.status);status
        }
        $("#addEditBannerModal").modal('show');
    }

    function addEditBanner() {
        $("#addEditBannerForm").find('.help-block').remove();
        $("#addEditBannerForm").removeClass("error");
        let formData = new FormData($("#addEditBannerForm")[0]);
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

    function deleteBanner(t) {
        let banner_id = $(t).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to recover this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
        })
        .then(function(result) {
            if (result.value) {
                let formData = new FormData();
                formData.append('banner_id', banner_id);
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ url('admin/banners/delete') }}",
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === true) {
                            bannersTable.ajax.reload();
                            Swal.fire({
                                type: "success",
                                title: 'Deleted!',
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
        })
    }

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
</script>
@endsection
