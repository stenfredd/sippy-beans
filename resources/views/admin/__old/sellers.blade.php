@extends('layouts.app') @section('content')
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ui.css') }}">

<div class="content-wrapper pt-1">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Sellers</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('admin') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript:">Masters</a>
                            </li>
                            <li class="breadcrumb-item">Sellers</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrum-right">
                <button class="btn-icon btn btn-primary btn-round btn-sm font-small-2 font-weight-bold" type="button" onclick="showAddEditModal(this, false)">Add Seller</button>
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
                                    <table class="table nowrap w-100" id="tblSellers">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Information</th>
                                                <th>Address</th>
                                                <th>Phone</th>
                                                <th>Email</th>
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

<div class="modal fade" id="addEditSellerModal" tabindex="-1" role="dialog" aria-labelledby="addEditSellerModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEditSellerModalTitle">Add seller</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addEditSellerForm" class="form-horizontal" action="#" onsubmit="return false;" novalidate>
                @csrf
                <div class="modal-body">
                    <fieldset class="form-group">
                        <label for="seller_image">Image</label>
                        <input type="file" id="seller_image" name="seller_image" class="form-control round">
                    </fieldset>
                    <fieldset class="form-group d-none">
                        <input type="hidden" id="seller_id" name="seller_id" class="form-control round">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="seller_name">Name</label>
                        <input type="text" id="seller_name" name="seller_name" class="form-control round" placeholder="Seller Name">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="seller_info">Information</label>
                        <input type="text" id="seller_info" name="seller_info" class="form-control round" placeholder="Seller Information">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="seller_address">Address</label>
                        <input type="text" id="seller_address" name="seller_address" class="form-control round" placeholder="Seller Address">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="seller_phone">Phone</label>
                        <input type="text" id="seller_phone" name="seller_phone" class="form-control round" placeholder="Seller Phone">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="seller_email">Email</label>
                        <input type="text" id="seller_email" name="seller_email" class="form-control round" placeholder="Seller Email">
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
                    <button type="submit" class="btn btn-primary btn-round" onclick="addEditSeller()">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/jquery-ui.js') }}"></script>
<script type="text/javascript">
    let sellersTable = $('#tblSellers').DataTable({
        "scrollY": 500,
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "{{ url('admin/sellers') }}",
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
                "data": "seller_image",
                orderable: false,
                width: '25%'
            },
            {
                "data": "seller_name",
                width: '15%'
            },
            {
                "data": "seller_info",
                width: '15%'
            },
            {
                "data": "seller_address",
                width: '15%'
            },
            {
                "data": "seller_phone",
                width: '15%'
            },
            {
                "data": "seller_email",
                width: '15%'
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

    let sorting_sellers = [];
    $(document).ready(function() {
        setTimeout(function() {
            $( "#tblSellers > tbody" ).sortable({
                placeholder: "ui-state-highlight",
                helper: 'clone',
                update: function( event, ui ) {
                    sorting_sellers = [];
                    $(this).children().each(function(index) {
                        let seller_id = $(this).data('id');
                        sorting_sellers.push({
                            seller_id: seller_id,
                            sort_order: index + 1,
                        });
                    });
                    updateSortOrders();
                }
            });
            $( "#tblSellers > tbody" ).disableSelection();
        }, 2000);
    });

    function showAddEditModal(t, edit) {
        $('#addEditSellerModalTitle').text('Add seller')
        $("#addEditSellerForm")[0].reset();
        $("#seller_id").val('');
        if (edit === true) {
            $('#addEditSellerModalTitle').text('Edit seller')
            let sellerData = sellersTable.row($(t).parents('tr')).data();
            $("#addEditSellerForm #seller_id").val(sellerData.id);
            $("#addEditSellerForm #seller_name").val(sellerData.seller_name);
            $("#addEditSellerForm #seller_info").val(sellerData.seller_info);
            $("#addEditSellerForm #seller_address").val(sellerData.seller_address);
            $("#addEditSellerForm #seller_phone").val(sellerData.seller_phone);
            $("#addEditSellerForm #seller_email").val(sellerData.seller_email);
            $("#addEditSellerForm #status").val(sellerData.status);
        }
        $("#addEditSellerModal").modal('show');
    }

    function addEditSeller() {
        $("#addEditSellerForm").find('.help-block').remove();
        $("#addEditSellerForm").removeClass("error");

        let formData = new FormData($("#addEditSellerForm")[0]);
        $.ajax({
            url: "{{ url('admin/sellers/save') }}",
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

                    sellersTable.ajax.reload();
                    $("#addEditSellerModal").modal('hide');
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
                        $("#addEditSellerForm #" + field).parents(".form-group").append('<div class="help-block"><span class="text-danger">' + errorMsg + '</span></div>');
                        $("#addEditSellerForm #" + field).parents(".form-group").addClass("error");
                    });
                }
            }
        });
    }

    function deleteSeller(t) {
        let seller_id = $(t).data('id');

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
                formData.append('seller_id', seller_id);
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ url('admin/sellers/delete') }}",
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === true) {
                            sellersTable.ajax.reload();
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
        // sorting_sellers
        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('sorting_sellers', JSON.stringify(sorting_sellers));

        $.ajax({
            url: "{{ url('admin/sellers/update-sort-orders') }}",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === true) {
                    sellersTable.ajax.reload();
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
